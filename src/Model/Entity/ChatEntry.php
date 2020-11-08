<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatEntry Entity
 *
 * @property int $id
 * @property int $chat_room_id
 * @property int $user_id
 * @property int $chat_character_id
 * @property string $entry_key
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\ChatRoom $chat_room
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ChatCharacter $chat_character
 */
class ChatEntry extends Entity
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
        'chat_room_id' => true,
        'user_id' => true,
        'chat_character_id' => true,
        'entry_key' => true,
        'modified' => true,
        'created' => true,
        'chat_room' => true,
        'user' => true,
        'chat_character' => true,
    ];
}
