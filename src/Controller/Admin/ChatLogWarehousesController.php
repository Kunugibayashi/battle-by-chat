<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ChatLogWarehouses Controller
 *
 * @property \App\Model\Table\ChatLogWarehousesTable $ChatLogWarehouses
 * @method \App\Model\Entity\ChatLogWarehouse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatLogWarehousesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $chatLogWarehouses = $this->paginate($this->ChatLogWarehouses);

        $this->set(compact('chatLogWarehouses'));
    }

    /**
     * View method
     *
     * @param string|null $id Chat Log Warehouse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatLogWarehouse = $this->ChatLogWarehouses->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('chatLogWarehouse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatLogWarehouse = $this->ChatLogWarehouses->newEmptyEntity();
        if ($this->request->is('post')) {
            $chatLogWarehouse = $this->ChatLogWarehouses->patchEntity($chatLogWarehouse, $this->request->getData());
            if ($this->ChatLogWarehouses->save($chatLogWarehouse)) {
                $this->Flash->success(__('The chat log warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat log warehouse could not be saved. Please, try again.'));
        }
        $this->set(compact('chatLogWarehouse'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Log Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatLogWarehouse = $this->ChatLogWarehouses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatLogWarehouse = $this->ChatLogWarehouses->patchEntity($chatLogWarehouse, $this->request->getData());
            if ($this->ChatLogWarehouses->save($chatLogWarehouse)) {
                $this->Flash->success(__('The chat log warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat log warehouse could not be saved. Please, try again.'));
        }
        $this->set(compact('chatLogWarehouse'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Log Warehouse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatLogWarehouse = $this->ChatLogWarehouses->get($id);
        if ($this->ChatLogWarehouses->delete($chatLogWarehouse)) {
            $this->Flash->success(__('The chat log warehouse has been deleted.'));
        } else {
            $this->Flash->error(__('The chat log warehouse could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
