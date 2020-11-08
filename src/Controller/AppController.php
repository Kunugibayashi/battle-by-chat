<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

        // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // このアプリケーションのすべてのコントローラのために、
        // インデックスとビューのアクションを公開し、認証チェックをスキップします
        //$this->Authentication->addUnauthenticatedActions(['index', 'view']);
        // サイトの定数設定
        $this->set('siteTitle', Configure::read('Site.title'));
        // 管理ページか？
        $isAdmin = $this->request->getParam('prefix') === 'Admin' ? 1 : 0;
        $this->set('isAdmin', $isAdmin);
        // 管理ページの場合、管理者か？
        if ($isAdmin) {
            $role = $this->Authentication->getIdentityData('role');
            if ($role !== 'admin') {
                $this->Flash->error(__('You do not have access.'));

                $this->redirect('/');
            }
        }
        // ログインしているか？
        if ($this->Authentication->getIdentity()) {
            $loginUsername = $this->Authentication->getIdentityData('username');
        } else {
            $loginUsername = 0;
        }
        $this->set('loginUsername', $loginUsername);
    }
}
