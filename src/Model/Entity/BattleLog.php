<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BattleLog Entity
 *
 * @property int $id
 * @property int $chat_log_id
 * @property string|null $status
 * @property string|null $narration
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\ChatLog $chat_log
 */
class BattleLog extends Entity
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
        'chat_log_id' => true,
        'status' => true,
        'narration' => true,
        'memo' => true,
        'modified' => true,
        'created' => true,
        'chat_log' => true,
    ];
}
