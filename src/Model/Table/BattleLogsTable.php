<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BattleLogs Model
 *
 * @property \App\Model\Table\ChatLogsTable&\Cake\ORM\Association\BelongsTo $ChatLogs
 *
 * @method \App\Model\Entity\BattleLog newEmptyEntity()
 * @method \App\Model\Entity\BattleLog newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BattleLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BattleLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\BattleLog findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BattleLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BattleLog[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BattleLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleLog[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleLog[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleLog[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleLog[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BattleLogsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('battle_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('ChatLogs', [
            'foreignKey' => 'chat_log_id',
            'joinType' => 'LEFT',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('narration')
            ->allowEmptyString('narration');

        $validator
            ->scalar('memo')
            ->allowEmptyString('memo');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['chat_log_id'], 'ChatLogs'));

        return $rules;
    }
}
