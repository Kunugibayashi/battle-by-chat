<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // ログインアクションを認証を必要としないように設定することで、
        // 無限リダイレクトループの問題を防ぐことができます
        $this->Authentication->addUnauthenticatedActions(['login', 'logout', 'add']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $password = $this->request->getData('password');
            $repassword = $this->request->getData('repassword');
            if ($password !== $repassword) {
                $this->Flash->error(__('入力パスワードが一致しません。'));
                $this->set(compact('user'));
                return;
            }

            if ($user->role == 'admin') {
                // 許可人数以上の管理者は登録できない
                $number = Configure::read('Site.admin');
                $users = $this->Users->find()
                    ->where(['role' => 'admin'])
                    ->count();
                if ($users >= $number) {
                    $this->Flash->error(__('管理ユーザーは既に登録されています。'));
                    $this->set(compact('user'));
                    return;
                }
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザーを登録しました。'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('ユーザーの登録に失敗しました。'));
        }

        $this->set(compact('user'));
    }

    public function delete()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $user = $this->Users->get($userId);

        $this->request->allowMethod(['post', 'delete']);
        if (!$this->Users->delete($user)) {
            $this->Flash->error(__('ユーザーの削除に失敗しました。もう一度お試しください。'));
            return;
        }
        $this->Flash->success(__('ユーザーを削除しました。'));

        // ログアウト
        $result = $this->Authentication->getResult();
        $this->Authentication->logout();

        $this->redirect([
            'controller' => 'Users',
            'action' => 'login',
        ]);
    }

    public function edit()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $user = $this->Users->get($userId);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $oldpassword = $this->request->getData('oldpassword');
            if (!password_verify($oldpassword, $user->password)) {
                $this->Flash->error(__('旧パスワードが異なります。'));
                $this->set(compact('user'));
                return;
            }

            $newpassword = $this->request->getData('newpassword');
            $repassword = $this->request->getData('repassword');
            if ($newpassword !== $repassword) {
                $this->Flash->error(__('入力パスワードが一致しません。'));
                $this->set(compact('user'));
                return;
            }
            $user->set('password', $newpassword);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザー情報を変更しました。'));
            } else {
                $this->Flash->error(__('ユーザー情報の更新に失敗しました。もう一度お試しください。'));
            }
        }
        $user->set('password', '');
        $this->set(compact('user'));
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // POSTやGETに関係なく、ユーザーがログインしていればリダイレクトします
        if ($result->isValid()) {
            // ログイン成功後に /index にリダイレクトします
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // ユーザーの送信と認証に失敗した場合にエラーを表示します
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('ユーザー名かパスワードが異なります。'));
        }
    }

    public function logout()
    {
        $this->autoRender = false;

        $result = $this->Authentication->getResult();
        // POSTやGETに関係なく、ユーザーがログインしていればリダイレクトします
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('ログアウトしました。'));
        }
        $this->redirect([
            'controller' => 'Users',
            'action' => 'login',
        ]);
    }
}
