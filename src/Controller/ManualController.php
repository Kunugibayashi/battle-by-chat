<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Manual Controller
 *
 * @method \App\Model\Entity\Manual[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ManualController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'setting', 'chatSystem', 'battleSystem', 'setup', ]);
    }

    public function index()
    {
    }

    public function setting()
    {
    }

    public function chatSystem()
    {
    }

    public function battleSystem()
    {
    }

    public function setup()
    {
    }

}
