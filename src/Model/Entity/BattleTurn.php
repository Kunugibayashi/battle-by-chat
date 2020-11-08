<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BattleTurn Entity
 *
 * @property int $id
 * @property int $vs_fukoku_key
 * @property int $vs_before_key
 * @property int $vs_after_key
 * @property int $battle_status
 * @property int $battle_turn_count
 * @property int $attack_chat_character_key
 * @property int $defense_chat_character_key
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\BattleCharacter[] $battle_characters
 * @property \App\Model\Entity\BattleSaveSkill[] $battle_save_skills
 */
class BattleTurn extends Entity
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
        'vs_fukoku_key' => true,
        'vs_before_key' => true,
        'vs_after_key' => true,
        'battle_status' => true,
        'battle_turn_count' => true,
        'attack_chat_character_key' => true,
        'defense_chat_character_key' => true,
        'modified' => true,
        'created' => true,
        'battle_characters' => true,
        'battle_save_skills' => true,
    ];
}
