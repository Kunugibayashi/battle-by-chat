<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * BattleCharacterStatuses Controller
 *
 * @property \App\Model\Table\BattleCharacterStatusesTable $BattleCharacterStatuses
 * @method \App\Model\Entity\BattleCharacterStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BattleCharacterStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $battleCharacterStatuses = $this->paginate($this->BattleCharacterStatuses);

        $this->set(compact('battleCharacterStatuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Battle Character Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $battleCharacterStatus = $this->BattleCharacterStatuses->get($id, [
            'contain' => ['ChatCharacters'],
        ]);

        $this->set(compact('battleCharacterStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $battleCharacterStatus = $this->BattleCharacterStatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $battleCharacterStatus = $this->BattleCharacterStatuses->patchEntity($battleCharacterStatus, $this->request->getData());
            if ($this->BattleCharacterStatuses->save($battleCharacterStatus)) {
                $this->Flash->success(__('The battle character status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle character status could not be saved. Please, try again.'));
        }
        $this->set(compact('battleCharacterStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Battle Character Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $battleCharacterStatus = $this->BattleCharacterStatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $battleCharacterStatus = $this->BattleCharacterStatuses->patchEntity($battleCharacterStatus, $this->request->getData());
            if ($this->BattleCharacterStatuses->save($battleCharacterStatus)) {
                $this->Flash->success(__('The battle character status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle character status could not be saved. Please, try again.'));
        }
        $this->set(compact('battleCharacterStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Battle Character Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $battleCharacterStatus = $this->BattleCharacterStatuses->get($id);
        if ($this->BattleCharacterStatuses->delete($battleCharacterStatus)) {
            $this->Flash->success(__('The battle character status has been deleted.'));
        } else {
            $this->Flash->error(__('The battle character status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
