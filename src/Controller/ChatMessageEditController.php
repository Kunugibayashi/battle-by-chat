<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * ChatMessageEdit Controller
 *
 * @method \App\Model\Entity\ChatMessageEdit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatMessageEditController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('ChatEntries');
        $this->loadModel('ChatLogs');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->Authentication->getIdentityData('id');

        $chatEntries = $this->ChatEntries->find()
            ->where(['user_id' => $userId])
            ->order(['id' => 'DESC'])
            ->last();

        if ($chatEntries) {
            $chatRoomId = $chatEntries->chat_room_id;
            $chatCharacterId = $chatEntries->chat_character_id;
            $chatEntryKey = $chatEntries->entry_key;

            $chatLogs = $this->ChatLogs->find();
            $string = $chatLogs->func()->left([
                'message' => 'identifier',
                '16' => 'literal',
            ]);
            $chatLogs
                ->select([
                    'id',
                    'fullname',
                    'messageLeft' => $string,
                    'created',
                ])
                ->where(['chat_room_key' => $chatRoomId])
                ->where(['chat_character_key' => $chatCharacterId])
                ->where(['entry_key' => $chatEntryKey])
                ->order(['id' => 'DESC']);

            $chatCharacters = $this->paginate($chatLogs);
            $this->set(compact('chatLogs'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Message Edit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $chatEntries = $this->ChatEntries->find()
            ->where(['user_id' => $userId])
            ->order(['id' => 'DESC'])
            ->last();
        if ($chatEntries) {
            $chatRoomId = $chatEntries->chat_room_id;
            $chatCharacterId = $chatEntries->chat_character_id;
            $chatEntryKey = $chatEntries->entry_key;

            $chatLog = $this->ChatLogs->find()
                ->where(['id' => $id])
                ->where(['chat_room_key' => $chatRoomId])
                ->where(['chat_character_key' => $chatCharacterId])
                ->where(['entry_key' => $chatEntryKey])
                ->first();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $chatLog = $this->ChatLogs->patchEntity(
                    $chatLog,
                    $this->request->getData()
                );

                $connection = ConnectionManager::get('default');
                $connection->begin();

                if ($this->ChatLogs->save($chatLog)) {
                    $connection->commit();
                    $this->Flash->success(__('発言を編集しました'));

                    return $this->redirect(['action' => 'index']);
                }

                $connection->rollback();
                $this->Flash->error(__('発言編集に失敗しました。もう一度お試しください。'));
            }
            $this->set(compact('chatLog'));
        }
    }
}
