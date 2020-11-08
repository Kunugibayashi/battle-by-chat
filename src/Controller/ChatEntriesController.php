<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ChatEntries Controller
 *
 * @property \App\Model\Table\ChatEntriesTable $ChatEntries
 * @method \App\Model\Entity\ChatEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatEntriesController extends AppController
{
    public function topList()
    {
        $this->viewBuilder()->setLayout('none');

        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatEntries = $this->ChatEntries
            ->find()
            ->contain(['ChatCharacters' => function ($q) {
                return $q->select(['id', 'fullname', 'color', 'backgroundcolor']);
            }])
            ->where(['chat_room_id' => $chatRoomId])
            ->order(['ChatEntries.modified' => 'DESC']);

        $this->set(compact('chatEntries'));
        $this->set(compact('chatRoomId'));

        return $this->render();
    }
}
