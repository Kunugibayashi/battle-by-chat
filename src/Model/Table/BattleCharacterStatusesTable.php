<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BattleCharacterStatuses Model
 *
 * @property \App\Model\Table\ChatCharactersTable&\Cake\ORM\Association\BelongsTo $ChatCharacters
 *
 * @method \App\Model\Entity\BattleCharacterStatus newEmptyEntity()
 * @method \App\Model\Entity\BattleCharacterStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BattleCharacterStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BattleCharacterStatusesTable extends Table
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

        $this->setTable('battle_character_statuses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasOne('ChatCharacters', [
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
            ->nonNegativeInteger('level')
            ->notEmptyString('level');

        $validator
            ->nonNegativeInteger('strength')
            ->notEmptyString('strength');

        $validator
            ->nonNegativeInteger('dexterity')
            ->notEmptyString('dexterity');

        $validator
            ->nonNegativeInteger('stamina')
            ->notEmptyString('stamina');

        $validator
            ->nonNegativeInteger('spirit')
            ->notEmptyString('spirit');

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
        $rules->add($rules->existsIn(['chat_character_id'], 'ChatCharacters'));

        return $rules;
    }
}
