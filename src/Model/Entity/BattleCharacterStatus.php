<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BattleCharacterStatus Entity
 *
 * @property int $id
 * @property int $chat_character_id
 * @property int $level
 * @property int $strength
 * @property int $dexterity
 * @property int $stamina
 * @property int $spirit
 *
 * @property \App\Model\Entity\ChatCharacter $chat_character
 */
class BattleCharacterStatus extends Entity
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
        'chat_character_id' => true,
        'level' => true,
        'strength' => true,
        'dexterity' => true,
        'stamina' => true,
        'spirit' => true,
        'chat_character' => true,
    ];
}
