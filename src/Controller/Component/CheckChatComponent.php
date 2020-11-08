<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Text;

class CheckChatComponent extends Component
{
    use ModelAwareTrait;

    public function initialize($config): void
    {
        parent::initialize($config);

        $this->loadModel('ChatEntries');
        $this->loadModel('ChatCharacters');
    }

    /**
     * 最初に入室したキャラクターにユニーク キーを割り振る
     * 退出時に、このキーを元に検索し、ログを出力する
     */
    public function findEntryKey($chatRoomId)
    {
        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->order(['id' => 'ASC'])
            ->first();

        if ($chatEntry) {
            return $chatEntry->entry_key;
        }
        return Text::uuid();
    }

    public function enteredChatRoomId($userId, $characterId)
    {
        $chatEntry = $this->ChatEntries->find()
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $characterId])
            ->first();

        if ($chatEntry) {
            return $chatEntry->chat_room_id;
        }
        return 0;
    }

    /*
     * リクエストから取得したキャラクターIDがユーザーIDに紐づいているか
     */
    public function userCharacterId($userId, $characterId)
    {
        $chatCharacter = $this->ChatCharacters->find()
            ->where(['user_id' => $userId])
            ->where(['id' => $characterId])
            ->first();

        return $chatCharacter->id;
    }
}
