<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SendMessages Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\SendMessage newEmptyEntity()
 * @method \App\Model\Entity\SendMessage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SendMessage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SendMessage get($primaryKey, $options = [])
 * @method \App\Model\Entity\SendMessage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SendMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SendMessage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SendMessage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SendMessage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SendMessage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SendMessage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SendMessage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SendMessage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SendMessagesTable extends Table
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

        $this->setTable('send_messages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('chat_character_key')
            ->requirePresence('chat_character_key', 'create')
            ->notEmptyString('chat_character_key');

        $validator
            ->scalar('chat_character_fullname')
            ->maxLength('chat_character_fullname', 50)
            ->requirePresence('chat_character_fullname', 'create')
            ->notEmptyString('chat_character_fullname');

        $validator
            ->nonNegativeInteger('to_chat_character_key')
            ->requirePresence('to_chat_character_key', 'create')
            ->notEmptyString('to_chat_character_key');

        $validator
            ->scalar('to_chat_character_fullname')
            ->maxLength('to_chat_character_fullname', 50)
            ->requirePresence('to_chat_character_fullname', 'create')
            ->notEmptyString('to_chat_character_fullname');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
