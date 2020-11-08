<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BattleSaveSkills Model
 *
 * @property \App\Model\Table\BattleTurnsTable&\Cake\ORM\Association\BelongsTo $BattleTurns
 * @property \App\Model\Table\ChatCharactersTable&\Cake\ORM\Association\BelongsTo $ChatCharacters
 *
 * @method \App\Model\Entity\BattleSaveSkill newEmptyEntity()
 * @method \App\Model\Entity\BattleSaveSkill newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BattleSaveSkill get($primaryKey, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BattleSaveSkill|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleSaveSkill[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BattleSaveSkillsTable extends Table
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

        $this->setTable('battle_save_skills');
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
            ->nonNegativeInteger('enemy_chat_character_key')
            ->allowEmptyString('enemy_chat_character_key');

        $validator
            ->nonNegativeInteger('limit_skill_code')
            ->requirePresence('limit_skill_code', 'create')
            ->notEmptyString('limit_skill_code');

        $validator
            ->nonNegativeInteger('passive_skill_code')
            ->requirePresence('passive_skill_code', 'create')
            ->notEmptyString('passive_skill_code');

        $validator
            ->nonNegativeInteger('battle_skill1_code')
            ->requirePresence('battle_skill1_code', 'create')
            ->notEmptyString('battle_skill1_code');

        $validator
            ->nonNegativeInteger('battle_skill2_code')
            ->requirePresence('battle_skill2_code', 'create')
            ->notEmptyString('battle_skill2_code');

        $validator
            ->nonNegativeInteger('battle_skill3_code')
            ->requirePresence('battle_skill3_code', 'create')
            ->notEmptyString('battle_skill3_code');

        $validator
            ->nonNegativeInteger('battle_skill4_code')
            ->requirePresence('battle_skill4_code', 'create')
            ->notEmptyString('battle_skill4_code');

        $validator
            ->nonNegativeInteger('battle_skill5_code')
            ->requirePresence('battle_skill5_code', 'create')
            ->notEmptyString('battle_skill5_code');

        $validator
            ->nonNegativeInteger('battle_skill6_code')
            ->requirePresence('battle_skill6_code', 'create')
            ->notEmptyString('battle_skill6_code');

        $validator
            ->nonNegativeInteger('battle_skill7_code')
            ->requirePresence('battle_skill7_code', 'create')
            ->notEmptyString('battle_skill7_code');

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
