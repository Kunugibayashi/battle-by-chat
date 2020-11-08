<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatLogWarehouse Entity
 *
 * @property int $id
 * @property string $entry_key
 * @property string $chat_room_title
 * @property string|null $characters
 * @property string|null $logs
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 */
class ChatLogWarehouse extends Entity
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
        'chat_room_title' => true,
        'characters' => true,
        'logs' => true,
        'modified' => true,
        'created' => true,
    ];
}
