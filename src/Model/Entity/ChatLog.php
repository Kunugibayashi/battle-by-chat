<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatLog Entity
 *
 * @property int $id
 * @property string $entry_key
 * @property int $chat_room_key
 * @property string $chat_room_title
 * @property string $chat_room_information
 * @property string $color
 * @property string $backgroundcolor
 * @property int $chat_character_key
 * @property string|null $fullname
 * @property string|null $note
 * @property string|null $message
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\BattleLog $battle_log
 */
class ChatLog extends Entity
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
        'entry_key' => true,
        'chat_room_key' => true,
        'chat_room_title' => true,
        'chat_room_information' => true,
        'color' => true,
        'backgroundcolor' => true,
        'chat_character_key' => true,
        'fullname' => true,
        'note' => true,
        'message' => true,
        'modified' => true,
        'created' => true,
        'battle_log' => true,
    ];
}
