<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * BattleLogs Controller
 *
 * @property \App\Model\Table\BattleLogsTable $BattleLogs
 * @method \App\Model\Entity\BattleLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BattleLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $battleLogs = $this->paginate($this->BattleLogs);

        $this->set(compact('battleLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Battle Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $battleLog = $this->BattleLogs->get($id, [
            'contain' => ['ChatLogs'],
        ]);

        $this->set(compact('battleLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $battleLog = $this->BattleLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $battleLog = $this->BattleLogs->patchEntity($battleLog, $this->request->getData());
            if ($this->BattleLogs->save($battleLog)) {
                $this->Flash->success(__('The battle log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle log could not be saved. Please, try again.'));
        }
        $this->set(compact('battleLog'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Battle Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $battleLog = $this->BattleLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $battleLog = $this->BattleLogs->patchEntity($battleLog, $this->request->getData());
            if ($this->BattleLogs->save($battleLog)) {
                $this->Flash->success(__('The battle log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle log could not be saved. Please, try again.'));
        }
        $this->set(compact('battleLog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Battle Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $battleLog = $this->BattleLogs->get($id);
        if ($this->BattleLogs->delete($battleLog)) {
            $this->Flash->success(__('The battle log has been deleted.'));
        } else {
            $this->Flash->error(__('The battle log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
