<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * SendMessages Controller
 *
 * @property \App\Model\Table\SendMessagesTable $SendMessages
 * @method \App\Model\Entity\SendMessage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SendMessagesController extends AppController
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
        $sendMessages = $this->paginate($this->SendMessages);

        $this->set(compact('sendMessages'));
    }

    /**
     * View method
     *
     * @param string|null $id Send Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sendMessage = $this->SendMessages->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('sendMessage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sendMessage = $this->SendMessages->newEmptyEntity();
        if ($this->request->is('post')) {
            $sendMessage = $this->SendMessages->patchEntity($sendMessage, $this->request->getData());
            if ($this->SendMessages->save($sendMessage)) {
                $this->Flash->success(__('The send message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The send message could not be saved. Please, try again.'));
        }
        $users = $this->SendMessages->Users->find('list', ['limit' => 200]);
        $this->set(compact('sendMessage', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Send Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sendMessage = $this->SendMessages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sendMessage = $this->SendMessages->patchEntity($sendMessage, $this->request->getData());
            if ($this->SendMessages->save($sendMessage)) {
                $this->Flash->success(__('The send message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The send message could not be saved. Please, try again.'));
        }
        $users = $this->SendMessages->Users->find('list', ['limit' => 200]);
        $this->set(compact('sendMessage', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Send Message id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sendMessage = $this->SendMessages->get($id);
        if ($this->SendMessages->delete($sendMessage)) {
            $this->Flash->success(__('The send message has been deleted.'));
        } else {
            $this->Flash->error(__('The send message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
