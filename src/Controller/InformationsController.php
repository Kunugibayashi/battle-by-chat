<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Informations Controller
 *
 * @property \App\Model\Table\InformationsTable $Informations
 * @method \App\Model\Entity\Information[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InformationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $informations = $this->Informations->find()
            ->order(['id' => 'DESC']);
        $informations = $this->paginate($informations);

        $this->set(compact('informations'));
    }

    /**
     * View method
     *
     * @param string|null $id Information id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $information = $this->Informations->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('information'));
    }

    public function topListTable()
    {
        $informations = $this->Informations->find()
            ->order(['id' => 'DESC'])
            ->limit(3);
        $this->set(compact('informations'));
    }
}
