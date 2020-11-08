<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Site Controller
 *
 * @method \App\Model\Entity\Site[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SiteController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // ログインアクションを認証を必要としないように設定することで、
        // 無限リダイレクトループの問題を防ぐことができます
        $this->Authentication->addUnauthenticatedActions(['about', 'world', 'qa', ]);
    }

    public function about()
    {
    }

    public function world()
    {
    }

    public function qa()
    {
    }
}
