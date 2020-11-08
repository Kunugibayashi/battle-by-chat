<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('ChatCharacters');
        $this->loadModel('ReceivedMessages');
        $this->loadModel('SendMessages');
    }

    public function isCharacters()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacters = $this->ChatCharacters->find()
            ->where(['user_id' => $userId]);
        if (!$chatCharacters) {
            return false;
        }
        return true;
    }

    public function getCharacterIds()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacters = $this->ChatCharacters->find()
            ->where(['user_id' => $userId]);
        $chatCharacters = $chatCharacters->toArray();
        $chatCharacterIds = array_column($chatCharacters, 'id');
        return $chatCharacterIds;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->Authentication->getIdentityData('id');

        // 登録キャラがいない場合は表示しない
        if (!$this->isCharacters()) {
            $this->Flash->error(__('指定キャラクターが見つかりません。'));
            return $this->redirect(['action' => 'index']);
        }
        $chatCharacterIds = $this->getCharacterIds();

        $receivedMessages = $this->ReceivedMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['chat_character_key IN ' =>  $chatCharacterIds])
            ->order(['ReceivedMessages.id' => 'DESC']);

        $sendMessages = $this->SendMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['chat_character_key IN ' =>  $chatCharacterIds])
            ->order(['SendMessages.id' => 'DESC']);

        $this->set(compact('receivedMessages'));
        $this->set(compact('sendMessages'));
    }

    public function receivedDelete($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $this->request->allowMethod(['post', 'delete']);
        $receivedMessage  = $this->ReceivedMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['ReceivedMessages.id' => $id])
            ->first();
        if ($this->ReceivedMessages->delete($receivedMessage)) {
            $this->Flash->success(__('メッセージを削除しました。'));
        } else {
            $this->Flash->error(__('メッセージの削除に失敗しました。もう一度お試しください。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function sendDelete($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $this->request->allowMethod(['post', 'delete']);
        $sendMessage = $this->SendMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['SendMessages.id' => $id])
            ->first();
        if ($this->SendMessages->delete($sendMessage)) {
            $this->Flash->success(__('メッセージを削除しました。'));
        } else {
            $this->Flash->error(__('メッセージの削除に失敗しました。もう一度お試しください。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function viewReceivedMessage($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $receivedMessages = $this->ReceivedMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['ReceivedMessages.id' => $id])
            ->first();

        $this->set('message', $receivedMessages);
        return $this->render('view');
    }

    public function viewSendMessage($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $sendMessage = $this->SendMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['SendMessages.id' => $id])
            ->first();

        $this->set('message', $sendMessage);
        return $this->render('view');
    }

    public function send($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        // 登録キャラがいない場合は表示しない
        if (!$this->isCharacters()) {
            $this->Flash->error(__('指定キャラクターが存在しません。'));
            return $this->redirect(['action' => 'index']);
        }
        $chatCharacterIds = $this->getCharacterIds();

        $receivedMessage = $this->ReceivedMessages->newEmptyEntity();

        // 受信履歴
        $toCharacter = $this->ChatCharacters->get($id);
        $receivedMessage->set('chat_character_key', $toCharacter->id);
        $receivedMessage->set('chat_character_fullname', $toCharacter->fullname);

        if ($this->request->is('post')) {
            $fromCharacterId = $this->request->getData('from_chat_character_key');
            $fromCharacter = $this->ChatCharacters->find()
                ->where(['user_id' => $userId])
                ->where(['id' => $fromCharacterId])
                ->first();

            $receivedMessage->set('user_id', $toCharacter->user_id);
            $receivedMessage->set('from_chat_character_key', $fromCharacter->id);
            $receivedMessage->set('from_chat_character_fullname', $fromCharacter->fullname);
            $receivedMessage->set('title', $this->request->getData('title'));
            $receivedMessage->set('message', $this->request->getData('message'));

            // 送信履歴
            $sendMessage = $this->SendMessages->newEmptyEntity();
            $sendMessage->set('user_id', $userId);
            $sendMessage->set('chat_character_key', $receivedMessage->from_chat_character_key);
            $sendMessage->set('chat_character_fullname', $receivedMessage->from_chat_character_fullname);
            $sendMessage->set('to_chat_character_key', $receivedMessage->chat_character_key);
            $sendMessage->set('to_chat_character_fullname', $receivedMessage->chat_character_fullname);
            $sendMessage->set('title', $receivedMessage->title);
            $sendMessage->set('message', $receivedMessage->message);

            $connection = ConnectionManager::get('default');
            $connection->begin();

            $received = $this->ReceivedMessages->save($receivedMessage);
            $send = $this->SendMessages->save($sendMessage);

            if ($received && $send) {
                $connection->commit();
                $this->Flash->success(__('メッセージを送信しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $connection->rollback();
            $this->Flash->error(__('メッセージの送信に失敗しました。もう一度お試しください。'));
        }

        $chatCharacters = $this->ChatCharacters->find()
            ->where(['user_id' => $userId])
            ->toArray();
        $fromCharacters = array_column($chatCharacters, 'fullname', 'id');

        $this->set(compact('receivedMessage'));
        $this->set(compact('toCharacter'));
        $this->set(compact('fromCharacters'));
    }

    public function topListTable()
    {
        $userId = $this->Authentication->getIdentityData('id');

        // 登録キャラがいない場合は表示しない
        if (!$this->isCharacters()) {
            return;
        }
        $chatCharacterIds = $this->getCharacterIds();

        $receivedMessages = $this->ReceivedMessages->find()
            ->contain(['Users'])
            ->where(['user_id' =>  $userId])
            ->where(['chat_character_key IN ' =>  $chatCharacterIds])
            ->order(['ReceivedMessages.id' => 'DESC'])
            ->limit(3);

        $this->set(compact('receivedMessages'));
    }

}
