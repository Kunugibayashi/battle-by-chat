<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * BattleTurns Controller
 *
 * @property \App\Model\Table\BattleTurnsTable $BattleTurns
 * @method \App\Model\Entity\BattleTurn[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BattleTurnsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $battleTurns = $this->paginate($this->BattleTurns);

        $this->set(compact('battleTurns'));
    }

    /**
     * View method
     *
     * @param string|null $id Battle Turn id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $battleTurn = $this->BattleTurns->get($id, [
            'contain' => ['BattleCharacters', 'BattleSaveSkills'],
        ]);

        $this->set(compact('battleTurn'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $battleTurn = $this->BattleTurns->newEmptyEntity();
        if ($this->request->is('post')) {
            $battleTurn = $this->BattleTurns->patchEntity($battleTurn, $this->request->getData());
            if ($this->BattleTurns->save($battleTurn)) {
                $this->Flash->success(__('The battle turn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle turn could not be saved. Please, try again.'));
        }
        $this->set(compact('battleTurn'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Battle Turn id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $battleTurn = $this->BattleTurns->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $battleTurn = $this->BattleTurns->patchEntity($battleTurn, $this->request->getData());
            if ($this->BattleTurns->save($battleTurn)) {
                $this->Flash->success(__('The battle turn has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle turn could not be saved. Please, try again.'));
        }
        $this->set(compact('battleTurn'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Battle Turn id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $battleTurn = $this->BattleTurns->get($id);
        if ($this->BattleTurns->delete($battleTurn)) {
            $this->Flash->success(__('The battle turn has been deleted.'));
        } else {
            $this->Flash->error(__('The battle turn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
