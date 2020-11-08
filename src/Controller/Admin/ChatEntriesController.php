<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ChatEntries Controller
 *
 * @property \App\Model\Table\ChatEntriesTable $ChatEntries
 * @method \App\Model\Entity\ChatEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatEntriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ChatRooms', 'Users', 'ChatCharacters'],
        ];
        $chatEntries = $this->paginate($this->ChatEntries);

        $this->set(compact('chatEntries'));
    }

    /**
     * View method
     *
     * @param string|null $id Chat Entry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatEntry = $this->ChatEntries->get($id, [
            'contain' => ['ChatRooms', 'Users', 'ChatCharacters'],
        ]);

        $this->set(compact('chatEntry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatEntry = $this->ChatEntries->newEmptyEntity();
        if ($this->request->is('post')) {
            $chatEntry = $this->ChatEntries->patchEntity($chatEntry, $this->request->getData());
            if ($this->ChatEntries->save($chatEntry)) {
                $this->Flash->success(__('The chat entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat entry could not be saved. Please, try again.'));
        }
        $chatRooms = $this->ChatEntries->ChatRooms->find('list', ['limit' => 200]);
        $users = $this->ChatEntries->Users->find('list', ['limit' => 200]);
        $chatCharacters = $this->ChatEntries->ChatCharacters->find('list', ['limit' => 200]);
        $this->set(compact('chatEntry', 'chatRooms', 'users', 'chatCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Entry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatEntry = $this->ChatEntries->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatEntry = $this->ChatEntries->patchEntity($chatEntry, $this->request->getData());
            if ($this->ChatEntries->save($chatEntry)) {
                $this->Flash->success(__('The chat entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat entry could not be saved. Please, try again.'));
        }
        $chatRooms = $this->ChatEntries->ChatRooms->find('list', ['limit' => 200]);
        $users = $this->ChatEntries->Users->find('list', ['limit' => 200]);
        $chatCharacters = $this->ChatEntries->ChatCharacters->find('list', ['limit' => 200]);
        $this->set(compact('chatEntry', 'chatRooms', 'users', 'chatCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Entry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatEntry = $this->ChatEntries->get($id);
        if ($this->ChatEntries->delete($chatEntry)) {
            $this->Flash->success(__('The chat entry has been deleted.'));
        } else {
            $this->Flash->error(__('The chat entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
