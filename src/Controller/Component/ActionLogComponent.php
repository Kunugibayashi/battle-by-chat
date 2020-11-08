<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Text;
use Cake\Core\Configure;

class ActionLogComponent extends Component
{
    use ModelAwareTrait;

    public function initialize($config): void
    {
        parent::initialize($config);

        $this->loadModel('ChatLogs');
        $this->loadModel('ChatRooms');
        $this->loadModel('ChatCharacters');
    }

    /**
     * システムメッセージをインサート
     */
    public function setSystemMessage($message, $chatEntry, $chatRoom)
    {
        $chatLog = $this->ChatLogs->newEmptyEntity();
        $chatLog->set('message', $message);
        $chatLog->set('chat_character_key', 0); // システム
        $chatLog->set('entry_key', $chatEntry->entry_key);
        $chatLog->set('chat_room_key', $chatRoom->id);
        $chatLog->set('chat_room_title', $chatRoom->title);
        $chatLog->set('chat_room_information', $chatRoom->information);
        return $chatLog;
    }

    /**
     * 入室メッセージをインサート
     */
    public function setEntryMessage($chatEntry)
    {
        $chatRoomId = $chatEntry->chat_room_id;
        $chatCharacterId = $chatEntry->chat_character_id;
        $chatRoom = $this->ChatRooms->get($chatRoomId);
        $chatCharacter = $this->ChatCharacters->get($chatCharacterId);

        $enterMessage = Configure::read('Room.entering');
        $message = __($enterMessage, [
            $chatRoom->title,
            $chatCharacter->fullname,
        ]);

        $chatLog = $this->setSystemMessage($message, $chatEntry, $chatRoom);
        return $chatLog;
    }

    /**
     * 退室メッセージをインサート
     */
    public function setExitMessage($chatEntry)
    {
        $chatRoomId = $chatEntry->chat_room_id;
        $chatCharacterId = $chatEntry->chat_character_id;
        $chatRoom = $this->ChatRooms->get($chatRoomId);
        $chatCharacter = $this->ChatCharacters->get($chatCharacterId);

        $exitMessage = Configure::read('Room.exiting');
        $message = __($exitMessage, [
            $chatRoom->title,
            $chatCharacter->fullname,
        ]);

        $chatLog = $this->setSystemMessage($message, $chatEntry, $chatRoom);
        return $chatLog;
    }

    /**
     * メッセージをインサート
     */
    public function setSayMessage($chatEntry, $request)
    {
        $chatRoomId = $chatEntry->chat_room_id;
        $chatCharacterId = $chatEntry->chat_character_id;
        $chatRoom = $this->ChatRooms->get($chatRoomId);
        $chatCharacter = $this->ChatCharacters->get($chatCharacterId);

        $chatLog = $this->ChatLogs->newEmptyEntity();

        $message = $request->getData('message');
        if(!$message || !trim($message)) {
            return $chatLog;
        }
        $message = trim($message);
        $message = mb_strimwidth($message, 0, 10000, "...", 'UTF-8');
        $note = $request->getData('note');

        $chatLog->set('message', $message);
        $chatLog->set('entry_key', $chatEntry->entry_key);
        $chatLog->set('chat_room_key', $chatRoom->id);
        $chatLog->set('chat_room_title', $chatRoom->title);
        $chatLog->set('chat_room_information', $chatRoom->information);
        $chatLog->set('chat_character_key', $chatCharacterId); //
        $chatLog->set('fullname', $chatCharacter->fullname);
        $chatLog->set('color', $chatCharacter->color);
        $chatLog->set('backgroundcolor', $chatCharacter->backgroundcolor);
        $chatLog->set('note', $note);

        return $chatLog;
    }

}
