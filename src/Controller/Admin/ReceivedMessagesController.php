<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ReceivedMessages Controller
 *
 * @property \App\Model\Table\ReceivedMessagesTable $ReceivedMessages
 * @method \App\Model\Entity\ReceivedMessage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReceivedMessagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $receivedMessages = $this->paginate($this->ReceivedMessages);

        $this->set(compact('receivedMessages'));
    }

    /**
     * View method
     *
     * @param string|null $id Received Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receivedMessage = $this->ReceivedMessages->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('receivedMessage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receivedMessage = $this->ReceivedMessages->newEmptyEntity();
        if ($this->request->is('post')) {
            $receivedMessage = $this->ReceivedMessages->patchEntity($receivedMessage, $this->request->getData());
            if ($this->ReceivedMessages->save($receivedMessage)) {
                $this->Flash->success(__('The received message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The received message could not be saved. Please, try again.'));
        }
        $users = $this->ReceivedMessages->Users->find('list', ['limit' => 200]);
        $this->set(compact('receivedMessage', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Received Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receivedMessage = $this->ReceivedMessages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receivedMessage = $this->ReceivedMessages->patchEntity($receivedMessage, $this->request->getData());
            if ($this->ReceivedMessages->save($receivedMessage)) {
                $this->Flash->success(__('The received message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The received message could not be saved. Please, try again.'));
        }
        $users = $this->ReceivedMessages->Users->find('list', ['limit' => 200]);
        $this->set(compact('receivedMessage', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Received Message id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receivedMessage = $this->ReceivedMessages->get($id);
        if ($this->ReceivedMessages->delete($receivedMessage)) {
            $this->Flash->success(__('The received message has been deleted.'));
        } else {
            $this->Flash->error(__('The received message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
