<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChatCharacters Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BattleCharacterStatusesTable&\Cake\ORM\Association\HasMany $BattleCharacterStatuses
 * @property \App\Model\Table\BattleCharactersTable&\Cake\ORM\Association\HasMany $BattleCharacters
 * @property \App\Model\Table\BattleSaveSkillsTable&\Cake\ORM\Association\HasMany $BattleSaveSkills
 * @property \App\Model\Table\ChatEntriesTable&\Cake\ORM\Association\HasMany $ChatEntries
 *
 * @method \App\Model\Entity\ChatCharacter newEmptyEntity()
 * @method \App\Model\Entity\ChatCharacter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChatCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChatCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChatCharacter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChatCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChatCharacter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChatCharacter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatCharacter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChatCharactersTable extends Table
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

        $this->setTable('chat_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('BattleCharacterStatuses', [
            'foreignKey' => 'chat_character_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('BattleCharacters', [
            'foreignKey' => 'chat_character_id',
        ]);
        $this->hasMany('BattleSaveSkills', [
            'foreignKey' => 'chat_character_id',
        ]);
        $this->hasOne('ChatEntries', [
            'foreignKey' => 'chat_character_id',
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
            ->scalar('fullname')
            ->maxLength('fullname', 50)
            ->requirePresence('fullname', 'create')
            ->notEmptyString('fullname');

        $validator
            ->scalar('sex')
            ->maxLength('sex', 7)
            ->requirePresence('sex', 'create')
            ->notEmptyString('sex');

        $validator
            ->scalar('color')
            ->maxLength('color', 7)
            ->notEmptyString('color');

        $validator
            ->scalar('backgroundcolor')
            ->maxLength('backgroundcolor', 7)
            ->notEmptyString('backgroundcolor');

        $validator
            ->scalar('tag')
            ->maxLength('tag', 255)
            ->allowEmptyString('tag');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('detail')
            ->allowEmptyString('detail');

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
