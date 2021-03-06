<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Database\Dialect;

use Cake\Database\Expression\FunctionExpression;
use Cake\Database\Expression\OrderByExpression;
use Cake\Database\Expression\UnaryExpression;
use Cake\Database\ExpressionInterface;
use Cake\Database\Query;
use Cake\Database\QueryCompiler;
use Cake\Database\Schema\BaseSchema;
use Cake\Database\Schema\SqlserverSchema;
use Cake\Database\SqlDialectTrait;
use Cake\Database\SqlserverCompiler;
use Cake\Database\ValueBinder;
use PDO;

/**
 * Contains functions that encapsulates the SQL dialect used by SQLServer,
 * including query translators and schema introspection.
 *
 * @internal
 */
trait SqlserverDialectTrait
{
    use SqlDialectTrait;
    use TupleComparisonTranslatorTrait;

    /**
     * String used to start a database identifier quoting to make it safe
     *
     * @var string
     */
    protected $_startQuote = '[';

    /**
     * String used to end a database identifier quoting to make it safe
     *
     * @var string
     */
    protected $_endQuote = ']';

    /**
     * Modify the limit/offset to TSQL
     *
     * @param \Cake\Database\Query $query The query to translate
     * @return \Cake\Database\Query The modified query
     */
    protected function _selectQueryTranslator(Query $query): Query
    {
        $limit = $query->clause('limit');
        $offset = $query->clause('offset');

        if ($limit && $offset === null) {
            $query->modifier(['_auto_top_' => sprintf('TOP %d', $limit)]);
        }

        if ($offset !== null && !$query->clause('order')) {
            $query->order($query->newExpr()->add('(SELECT NULL)'));
        }

        if ($this->version() < 11 && $offset !== null) {
            return $this->_pagingSubquery($query, $limit, $offset);
        }

        return $this->_transformDistinct($query);
    }

    /**
     * Get the version of SQLserver we are connected to.
     *
     * @return string
     */
    protected function version(): string
    {
        $this->connect();

        return $this->_connection->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    /**
     * Generate a paging subquery for older versions of SQLserver.
     *
     * Prior to SQLServer 2012 there was no equivalent to LIMIT OFFSET, so a subquery must
     * be used.
     *
     * @param \Cake\Database\Query $original The query to wrap in a subquery.
     * @param int|null $limit The number of rows to fetch.
     * @param int|null $offset The number of rows to offset.
     * @return \Cake\Database\Query Modified query object.
     */
    protected function _pagingSubquery(Query $original, ?int $limit, ?int $offset): Query
    {
        $field = '_cake_paging_._cake_page_rownum_';

        if ($original->clause('order')) {
            // SQL server does not support column aliases in OVER clauses.  But
            // the only practical way to specify the use of calculated columns
            // is with their alias.  So substitute the select SQL in place of
            // any column aliases for those entries in the order clause.
            $select = $original->clause('select');
            $order = new OrderByExpression();
            $original
                ->clause('order')
                ->iterateParts(function ($direction, $orderBy) use ($select, $order) {
                    $key = $orderBy;
                    if (
                        isset($select[$orderBy]) &&
                        $select[$orderBy] instanceof ExpressionInterface
                    ) {
                        $key = $select[$orderBy]->sql(new ValueBinder());
                    }
                    $order->add([$key => $direction]);

                    // Leave original order clause unchanged.
                    return $orderBy;
                });
        } else {
            $order = new OrderByExpression('(SELECT NULL)');
        }

        $query = clone $original;
        $query->select([
                '_cake_page_rownum_' => new UnaryExpression('ROW_NUMBER() OVER', $order),
            ])->limit(null)
            ->offset(null)
            ->order([], true);

        $outer = new Query($query->getConnection());
        $outer->select('*')
            ->from(['_cake_paging_' => $query]);

        if ($offset) {
            $outer->where(["$field > " . (int)$offset]);
        }
        if ($limit) {
            $value = (int)$offset + (int)$limit;
            $outer->where(["$field <= $value"]);
        }

        // Decorate the original query as that is what the
        // end developer will be calling execute() on originally.
        $original->decorateResults(function ($row) {
            if (isset($row['_cake_page_rownum_'])) {
                unset($row['_cake_page_rownum_']);
            }

            return $row;
        });

        return $outer;
    }

    /**
     * Returns the passed query after rewriting the DISTINCT clause, so that drivers
     * that do not support the "ON" part can provide the actual way it should be done
     *
     * @param \Cake\Database\Query $original The query to be transformed
     * @return \Cake\Database\Query
     */
    protected function _transformDistinct(Query $original): Query
    {
        if (!is_array($original->clause('distinct'))) {
            return $original;
        }

        $query = clone $original;
        $distinct = $query->clause('distinct');
        $query->distinct(false);

        $order = new OrderByExpression($distinct);
        $query
            ->select(function ($q) use ($distinct, $order) {
                $over = $q->newExpr('ROW_NUMBER() OVER')
                    ->add('(PARTITION BY')
                    ->add($q->newExpr()->add($distinct)->setConjunction(','))
                    ->add($order)
                    ->add(')')
                    ->setConjunction(' ');

                return [
                    '_cake_distinct_pivot_' => $over,
                ];
            })
            ->limit(null)
            ->offset(null)
            ->order([], true);

        $outer = new Query($query->getConnection());
        $outer->select('*')
            ->from(['_cake_distinct_' => $query])
            ->where(['_cake_distinct_pivot_' => 1]);

        // Decorate the original query as that is what the
        // end developer will be calling execute() on originally.
        $original->decorateResults(function ($row) {
            if (isset($row['_cake_distinct_pivot_'])) {
                unset($row['_cake_distinct_pivot_']);
            }

            return $row;
        });

        return $outer;
    }

    /**
     * Returns a dictionary of expressions to be transformed when compiling a Query
     * to SQL. Array keys are method names to be called in this class
     *
     * @return array
     */
    protected function _expressionTranslators(): array
    {
        $namespace = 'Cake\Database\Expression';

        return [
            $namespace . '\FunctionExpression' => '_transformFunctionExpression',
            $namespace . '\TupleComparison' => '_transformTupleComparison',
        ];
    }

    /**
     * Receives a FunctionExpression and changes it so that it conforms to this
     * SQL dialect.
     *
     * @param \Cake\Database\Expression\FunctionExpression $expression The function expression to convert to TSQL.
     * @return void
     */
    protected function _transformFunctionExpression(FunctionExpression $expression): void
    {
        switch ($expression->getName()) {
            case 'CONCAT':
                // CONCAT function is expressed as exp1 + exp2
                $expression->setName('')->setConjunction(' +');
                break;
            case 'DATEDIFF':
                /** @var bool $hasDay */
                $hasDay = false;
                $visitor = function ($value) use (&$hasDay) {
                    if ($value === 'day') {
                        $hasDay = true;
                    }

                    return $value;
                };
                $expression->iterateParts($visitor);

                if (!$hasDay) {
                    $expression->add(['day' => 'literal'], [], true);
                }
                break;
            case 'CURRENT_DATE':
                $time = new FunctionExpression('GETUTCDATE');
                $expression->setName('CONVERT')->add(['date' => 'literal', $time]);
                break;
            case 'CURRENT_TIME':
                $time = new FunctionExpression('GETUTCDATE');
                $expression->setName('CONVERT')->add(['time' => 'literal', $time]);
                break;
            case 'NOW':
                $expression->setName('GETUTCDATE');
                break;
            case 'EXTRACT':
                $expression->setName('DATEPART')->setConjunction(' ,');
                break;
            case 'DATE_ADD':
                $params = [];
                $visitor = function ($p, $key) use (&$params) {
                    if ($key === 0) {
                        $params[2] = $p;
                    } else {
                        $valueUnit = explode(' ', $p);
                        $params[0] = rtrim($valueUnit[1], 's');
                        $params[1] = $valueUnit[0];
                    }

                    return $p;
                };
                $manipulator = function ($p, $key) use (&$params) {
                    return $params[$key];
                };

                $expression
                    ->setName('DATEADD')
                    ->setConjunction(',')
                    ->iterateParts($visitor)
                    ->iterateParts($manipulator)
                    ->add([$params[2] => 'literal']);
                break;
            case 'DAYOFWEEK':
                $expression
                    ->setName('DATEPART')
                    ->setConjunction(' ')
                    ->add(['weekday, ' => 'literal'], [], true);
                break;
            case 'SUBSTR':
                $expression->setName('SUBSTRING');
                if (count($expression) < 4) {
                    $params = [];
                    $expression
                        ->iterateParts(function ($p) use (&$params) {
                            return $params[] = $p;
                        })
                        ->add([new FunctionExpression('LEN', [$params[0]]), ['string']]);
                }

                break;
        }
    }

    /**
     * Get the schema dialect.
     *
     * Used by Cake\Schema package to reflect schema and
     * generate schema.
     *
     * @return \Cake\Database\Schema\BaseSchema
     */
    public function schemaDialect(): BaseSchema
    {
        return new SqlserverSchema($this);
    }

    /**
     * Returns a SQL snippet for creating a new transaction savepoint
     *
     * @param string|int $name save point name
     * @return string
     */
    public function savePointSQL($name): string
    {
        return 'SAVE TRANSACTION t' . $name;
    }

    /**
     * Returns a SQL snippet for releasing a previously created save point
     *
     * @param string|int $name save point name
     * @return string
     */
    public function releaseSavePointSQL($name): string
    {
        return 'COMMIT TRANSACTION t' . $name;
    }

    /**
     * Returns a SQL snippet for rollbacking a previously created save point
     *
     * @param string|int $name save point name
     * @return string
     */
    public function rollbackSavePointSQL($name): string
    {
        return 'ROLLBACK TRANSACTION t' . $name;
    }

    /**
     * {@inheritDoc}
     *
     * @return \Cake\Database\SqlserverCompiler
     */
    public function newCompiler(): QueryCompiler
    {
        return new SqlserverCompiler();
    }

    /**
     * @inheritDoc
     */
    public function disableForeignKeySQL(): string
    {
        return 'EXEC sp_MSforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all"';
    }

    /**
     * @inheritDoc
     */
    public function enableForeignKeySQL(): string
    {
        return 'EXEC sp_MSforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all"';
    }
}
