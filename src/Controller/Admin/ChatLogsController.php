<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ChatLogs Controller
 *
 * @property \App\Model\Table\ChatLogsTable $ChatLogs
 * @method \App\Model\Entity\ChatLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $chatLogs = $this->paginate($this->ChatLogs);

        $this->set(compact('chatLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Chat Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatLog = $this->ChatLogs->get($id, [
            'contain' => ['BattleLogs'],
        ]);

        $this->set(compact('chatLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatLog = $this->ChatLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $chatLog = $this->ChatLogs->patchEntity($chatLog, $this->request->getData());
            if ($this->ChatLogs->save($chatLog)) {
                $this->Flash->success(__('The chat log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat log could not be saved. Please, try again.'));
        }
        $this->set(compact('chatLog'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatLog = $this->ChatLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatLog = $this->ChatLogs->patchEntity($chatLog, $this->request->getData());
            if ($this->ChatLogs->save($chatLog)) {
                $this->Flash->success(__('The chat log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat log could not be saved. Please, try again.'));
        }
        $this->set(compact('chatLog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatLog = $this->ChatLogs->get($id);
        if ($this->ChatLogs->delete($chatLog)) {
            $this->Flash->success(__('The chat log has been deleted.'));
        } else {
            $this->Flash->error(__('The chat log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
