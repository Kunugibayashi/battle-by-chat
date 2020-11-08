<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatRoom Entity
 *
 * @property int $id
 * @property string $title
 * @property string $information
 * @property int $published
 * @property int $readonly
 * @property int $displayno
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\ChatEntry[] $chat_entries
 */
class ChatRoom extends Entity
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
        'title' => true,
        'information' => true,
        'published' => true,
        'readonly' => true,
        'displayno' => true,
        'modified' => true,
        'created' => true,
        'chat_entries' => true,
    ];
}
