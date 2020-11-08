<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChatLogWarehouses Model
 *
 * @method \App\Model\Entity\ChatLogWarehouse newEmptyEntity()
 * @method \App\Model\Entity\ChatLogWarehouse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatLogWarehouse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChatLogWarehousesTable extends Table
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

        $this->setTable('chat_log_warehouses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('entry_key')
            ->maxLength('entry_key', 40)
            ->requirePresence('entry_key', 'create')
            ->notEmptyString('entry_key');

        $validator
            ->scalar('chat_room_title')
            ->maxLength('chat_room_title', 15)
            ->requirePresence('chat_room_title', 'create')
            ->notEmptyString('chat_room_title');

        $validator
            ->scalar('characters')
            ->allowEmptyString('characters');

        $validator
            ->scalar('logs')
            ->allowEmptyString('logs');

        return $validator;
    }
}
