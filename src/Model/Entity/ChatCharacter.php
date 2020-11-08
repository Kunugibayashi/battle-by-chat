<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatCharacter Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $fullname
 * @property string $sex
 * @property string $color
 * @property string $backgroundcolor
 * @property string|null $tag
 * @property string|null $url
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property string|null $detail
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\BattleCharacterStatus $battle_character_status
 * @property \App\Model\Entity\BattleCharacter[] $battle_characters
 * @property \App\Model\Entity\BattleSaveSkill[] $battle_save_skills
 * @property \App\Model\Entity\ChatEntry $chat_entry
 * @property \App\Model\Entity\Message[] $messages
 */
class ChatCharacter extends Entity
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
        'fullname' => true,
        'sex' => true,
        'color' => true,
        'backgroundcolor' => true,
        'tag' => true,
        'url' => true,
        'modified' => true,
        'created' => true,
        'detail' => true,
        'user' => true,
        'battle_character_status' => true,
        'battle_characters' => true,
        'battle_save_skills' => true,
        'chat_entry' => true,
        'messages' => true,
    ];
}
