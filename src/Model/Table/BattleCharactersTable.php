<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BattleCharacters Model
 *
 * @property \App\Model\Table\BattleTurnsTable&\Cake\ORM\Association\BelongsTo $BattleTurns
 * @property \App\Model\Table\ChatCharactersTable&\Cake\ORM\Association\BelongsTo $ChatCharacters
 *
 * @method \App\Model\Entity\BattleCharacter newEmptyEntity()
 * @method \App\Model\Entity\BattleCharacter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacter get($primaryKey, $options = [])
 * @method \App\Model\Entity\BattleCharacter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BattleCharacter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleCharacter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleCharacter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BattleCharactersTable extends Table
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

        $this->setTable('battle_characters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('BattleTurns', [
            'foreignKey' => 'battle_turn_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChatCharacters', [
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
            ->nonNegativeInteger('strength')
            ->requirePresence('strength', 'create')
            ->notEmptyString('strength');

        $validator
            ->nonNegativeInteger('dexterity')
            ->requirePresence('dexterity', 'create')
            ->notEmptyString('dexterity');

        $validator
            ->nonNegativeInteger('stamina')
            ->requirePresence('stamina', 'create')
            ->notEmptyString('stamina');

        $validator
            ->nonNegativeInteger('spirit')
            ->requirePresence('spirit', 'create')
            ->notEmptyString('spirit');

        $validator
            ->integer('hp')
            ->requirePresence('hp', 'create')
            ->notEmptyString('hp');

        $validator
            ->integer('sp')
            ->requirePresence('sp', 'create')
            ->notEmptyString('sp');

        $validator
            ->integer('combo')
            ->notEmptyString('combo');

        $validator
            ->nonNegativeInteger('continuous_turn_count')
            ->notEmptyString('continuous_turn_count');

        $validator
            ->integer('is_limit')
            ->notEmptyString('is_limit');

        $validator
            ->nonNegativeInteger('limit_skill_code')
            ->notEmptyString('limit_skill_code');

        $validator
            ->nonNegativeInteger('permanent_strength')
            ->notEmptyString('permanent_strength');

        $validator
            ->nonNegativeInteger('temporary_strength')
            ->notEmptyString('temporary_strength');

        $validator
            ->nonNegativeInteger('permanent_hit_rate')
            ->notEmptyString('permanent_hit_rate');

        $validator
            ->nonNegativeInteger('temporary_hit_rate')
            ->notEmptyString('temporary_hit_rate');

        $validator
            ->nonNegativeInteger('permanent_dodge_rate')
            ->notEmptyString('permanent_dodge_rate');

        $validator
            ->nonNegativeInteger('temporary_dodge_rate')
            ->notEmptyString('temporary_dodge_rate');

        $validator
            ->nonNegativeInteger('defense_skill_code')
            ->notEmptyString('defense_skill_code');

        $validator
            ->nonNegativeInteger('defense_skill_attribute')
            ->notEmptyString('defense_skill_attribute');

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
        $rules->add($rules->existsIn(['battle_turn_id'], 'BattleTurns'));
        $rules->add($rules->existsIn(['chat_character_id'], 'ChatCharacters'));

        return $rules;
    }
}
