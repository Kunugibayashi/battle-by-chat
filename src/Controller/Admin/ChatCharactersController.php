<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ChatCharacters Controller
 *
 * @property \App\Model\Table\ChatCharactersTable $ChatCharacters
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatCharactersController extends AppController
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
        $chatCharacters = $this->paginate($this->ChatCharacters);

        $this->set(compact('chatCharacters'));
    }

    /**
     * View method
     *
     * @param string|null $id Chat Character id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatCharacter = $this->ChatCharacters->get($id, [
            'contain' => ['Users', 'BattleCharacterStatuses', 'ChatEntries', 'BattleCharacters', 'BattleSaveSkills'],
        ]);

        $this->set(compact('chatCharacter'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatCharacter = $this->ChatCharacters->newEmptyEntity();
        if ($this->request->is('post')) {
            $chatCharacter = $this->ChatCharacters->patchEntity($chatCharacter, $this->request->getData());
            if ($this->ChatCharacters->save($chatCharacter)) {
                $this->Flash->success(__('The chat character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat character could not be saved. Please, try again.'));
        }
        $users = $this->ChatCharacters->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatCharacter', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Character id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatCharacter = $this->ChatCharacters->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatCharacter = $this->ChatCharacters->patchEntity($chatCharacter, $this->request->getData());
            if ($this->ChatCharacters->save($chatCharacter)) {
                $this->Flash->success(__('The chat character has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat character could not be saved. Please, try again.'));
        }
        $users = $this->ChatCharacters->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatCharacter', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Character id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatCharacter = $this->ChatCharacters->get($id);
        if ($this->ChatCharacters->delete($chatCharacter)) {
            $this->Flash->success(__('The chat character has been deleted.'));
        } else {
            $this->Flash->error(__('The chat character could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
