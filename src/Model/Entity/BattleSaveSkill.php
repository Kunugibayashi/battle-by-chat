<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BattleSaveSkill Entity
 *
 * @property int $id
 * @property int $battle_turn_id
 * @property int $chat_character_id
 * @property int|null $enemy_chat_character_key
 * @property int $limit_skill_code
 * @property int $passive_skill_code
 * @property int $battle_skill1_code
 * @property int $battle_skill2_code
 * @property int $battle_skill3_code
 * @property int $battle_skill4_code
 * @property int $battle_skill5_code
 * @property int $battle_skill6_code
 * @property int $battle_skill7_code
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\BattleTurn $battle_turn
 * @property \App\Model\Entity\ChatCharacter $chat_character
 */
class BattleSaveSkill extends Entity
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
        'enemy_chat_character_key' => true,
        'limit_skill_code' => true,
        'passive_skill_code' => true,
        'battle_skill1_code' => true,
        'battle_skill2_code' => true,
        'battle_skill3_code' => true,
        'battle_skill4_code' => true,
        'battle_skill5_code' => true,
        'battle_skill6_code' => true,
        'battle_skill7_code' => true,
        'modified' => true,
        'created' => true,
        'battle_turn' => true,
        'chat_character' => true,
    ];
}
