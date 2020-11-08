<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * BattleSaveSkills Controller
 *
 * @property \App\Model\Table\BattleSaveSkillsTable $BattleSaveSkills
 * @method \App\Model\Entity\BattleSaveSkill[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BattleSaveSkillsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BattleTurns', 'ChatCharacters'],
        ];
        $battleSaveSkills = $this->paginate($this->BattleSaveSkills);

        $this->set(compact('battleSaveSkills'));
    }

    /**
     * View method
     *
     * @param string|null $id Battle Save Skill id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $battleSaveSkill = $this->BattleSaveSkills->get($id, [
            'contain' => ['BattleTurns', 'ChatCharacters'],
        ]);

        $this->set(compact('battleSaveSkill'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $battleSaveSkill = $this->BattleSaveSkills->newEmptyEntity();
        if ($this->request->is('post')) {
            $battleSaveSkill = $this->BattleSaveSkills->patchEntity($battleSaveSkill, $this->request->getData());
            if ($this->BattleSaveSkills->save($battleSaveSkill)) {
                $this->Flash->success(__('The battle save skill has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle save skill could not be saved. Please, try again.'));
        }
        $battleTurns = $this->BattleSaveSkills->BattleTurns->find('list', ['limit' => 200]);
        $chatCharacters = $this->BattleSaveSkills->ChatCharacters->find('list', ['limit' => 200]);
        $this->set(compact('battleSaveSkill', 'battleTurns', 'chatCharacters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Battle Save Skill id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $battleSaveSkill = $this->BattleSaveSkills->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $battleSaveSkill = $this->BattleSaveSkills->patchEntity($battleSaveSkill, $this->request->getData());
            if ($this->BattleSaveSkills->save($battleSaveSkill)) {
                $this->Flash->success(__('The battle save skill has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The battle save skill could not be saved. Please, try again.'));
        }
        $battleTurns = $this->BattleSaveSkills->BattleTurns->find('list', ['limit' => 200]);
        $chatCharacters = $this->BattleSaveSkills->ChatCharacters->find('list', ['limit' => 200]);
        $this->set(compact('battleSaveSkill', 'battleTurns', 'chatCharacters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Battle Save Skill id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $battleSaveSkill = $this->BattleSaveSkills->get($id);
        if ($this->BattleSaveSkills->delete($battleSaveSkill)) {
            $this->Flash->success(__('The battle save skill has been deleted.'));
        } else {
            $this->Flash->error(__('The battle save skill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
