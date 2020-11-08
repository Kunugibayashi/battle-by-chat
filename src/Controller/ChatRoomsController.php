<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ChatRooms Controller
 *
 * @property \App\Model\Table\ChatRoomsTable $ChatRooms
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatRoomsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('FormatTopList');

        $this->loadModel('ChatRooms');
        $this->loadModel('ChatEntries');
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Room id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatRoom = $this->ChatRooms->find()
            ->where(['id' => $chatRoomId])
            ->where(['readonly !=' => 1])
            ->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // 入室者がいる場合は更新しない
            $chatEntries = $this->ChatEntries->find()
                ->where(['chat_room_id' => $chatRoomId])
                ->first();
            if ($chatEntries) {
                $this->Flash->error(__('すでに入室者がいます。'));
                $this->set(compact('chatRoom'));
                return;
            }

            $chatRoom = $this->ChatRooms->patchEntity($chatRoom, $this->request->getData());
            if ($this->ChatRooms->save($chatRoom)) {
                $this->Flash->success(__('部屋設定を保存しました。'));

                return $this->redirect(['action' => 'edit', $chatRoomId]);
            }
            $this->Flash->error(__('部屋設定の保存に失敗しました。もう一度お試しください。'));
        }
        $this->set(compact('chatRoom'));
    }

    public function topListTable()
    {
        $this->viewBuilder()->setLayout('none');

        $chatRooms = $this->ChatRooms
            ->find()
            ->contain(['ChatEntries' => function ($q) {
                return $q
                    ->contain(['ChatCharacters' => function ($q) {
                        return $q->select(['id', 'fullname', 'color', 'backgroundcolor']);
                    }])
                    ->select(['id', 'chat_room_id', 'chat_character_id']);
            }])
            ->where(['published' => 1]) // 公開のみ
            ->select([
                'id',
                'title',
                'displayno',
                'readonly',
            ])
            ->order(['displayno' => 'ASC'])
            ->toArray();

        $chatRooms = $this->FormatTopList->formatChatRooms($chatRooms);

        $this->set(compact('chatRooms'));

        return $this->render();
    }
}
