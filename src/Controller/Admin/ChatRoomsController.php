<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ChatRooms Controller
 *
 * @property \App\Model\Table\ChatRoomsTable $ChatRooms
 * @method \App\Model\Entity\ChatRoom[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatRoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $chatRooms = $this->paginate($this->ChatRooms);

        $this->set(compact('chatRooms'));
    }

    /**
     * View method
     *
     * @param string|null $id Chat Room id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatRoom = $this->ChatRooms->get($id, [
            'contain' => ['ChatEntries'],
        ]);

        $this->set(compact('chatRoom'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatRoom = $this->ChatRooms->newEmptyEntity();
        if ($this->request->is('post')) {
            $chatRoom = $this->ChatRooms->patchEntity($chatRoom, $this->request->getData());
            if ($this->ChatRooms->save($chatRoom)) {
                $this->Flash->success(__('The chat room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat room could not be saved. Please, try again.'));
        }
        $this->set(compact('chatRoom'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Room id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatRoom = $this->ChatRooms->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatRoom = $this->ChatRooms->patchEntity($chatRoom, $this->request->getData());
            if ($this->ChatRooms->save($chatRoom)) {
                $this->Flash->success(__('The chat room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat room could not be saved. Please, try again.'));
        }
        $this->set(compact('chatRoom'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Room id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatRoom = $this->ChatRooms->get($id);
        if ($this->ChatRooms->delete($chatRoom)) {
            $this->Flash->success(__('The chat room has been deleted.'));
        } else {
            $this->Flash->error(__('The chat room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
