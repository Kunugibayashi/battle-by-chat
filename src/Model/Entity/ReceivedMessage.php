<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReceivedMessage Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $chat_character_key
 * @property string $chat_character_fullname
 * @property int $from_chat_character_key
 * @property string $from_chat_character_fullname
 * @property string $title
 * @property string $message
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 */
class ReceivedMessage extends Entity
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
        'user_id' => true,
        'chat_character_key' => true,
        'chat_character_fullname' => true,
        'from_chat_character_key' => true,
        'from_chat_character_fullname' => true,
        'title' => true,
        'message' => true,
        'modified' => true,
        'created' => true,
        'user' => true,
    ];
}
