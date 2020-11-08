<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChatRooms Model
 *
 * @property \App\Model\Table\ChatEntriesTable&\Cake\ORM\Association\HasMany $ChatEntries
 *
 * @method \App\Model\Entity\ChatRoom newEmptyEntity()
 * @method \App\Model\Entity\ChatRoom newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChatRoom[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChatRoom get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChatRoom findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChatRoom patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChatRoom[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChatRoom|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatRoom saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChatRoomsTable extends Table
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

        $this->setTable('chat_rooms');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ChatEntries', [
            'foreignKey' => 'chat_room_id',
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
            ->scalar('title')
            ->maxLength('title', 15)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('information')
            ->maxLength('information', 1023)
            ->requirePresence('information', 'create')
            ->notEmptyString('information');

        $validator
            ->nonNegativeInteger('published')
            ->notEmptyString('published');

        $validator
            ->nonNegativeInteger('readonly')
            ->notEmptyString('readonly');

        $validator
            ->nonNegativeInteger('displayno')
            ->notEmptyString('displayno');

        return $validator;
    }
}
