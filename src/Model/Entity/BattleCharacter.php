<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BattleCharacter Entity
 *
 * @property int $id
 * @property int $battle_turn_id
 * @property int $chat_character_id
 * @property int $strength
 * @property int $dexterity
 * @property int $stamina
 * @property int $spirit
 * @property int $hp
 * @property int $sp
 * @property int $combo
 * @property int $continuous_turn_count
 * @property int $is_limit
 * @property int $limit_skill_code
 * @property int $permanent_strength
 * @property int $temporary_strength
 * @property int $permanent_hit_rate
 * @property int $temporary_hit_rate
 * @property int $permanent_dodge_rate
 * @property int $temporary_dodge_rate
 * @property int $defense_skill_code
 * @property int $defense_skill_attribute
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\BattleTurn $battle_turn
 * @property \App\Model\Entity\ChatCharacter $chat_character
 */
class BattleCharacter extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'battle_turn_id' => true,
        'chat_character_id' => true,
        'strength' => true,
        'dexterity' => true,
        'stamina' => true,
        'spirit' => true,
        'hp' => true,
        'sp' => true,
        'combo' => true,
        'continuous_turn_count' => true,
        'is_limit' => true,
        'limit_skill_code' => true,
        'permanent_strength' => true,
        'temporary_strength' => true,
        'permanent_hit_rate' => true,
        'temporary_hit_rate' => true,
        'permanent_dodge_rate' => true,
        'temporary_dodge_rate' => true,
        'defense_skill_code' => true,
        'defense_skill_attribute' => true,
        'modified' => true,
        'created' => true,
        'battle_turn' => true,
        'chat_character' => true,
    ];
}
