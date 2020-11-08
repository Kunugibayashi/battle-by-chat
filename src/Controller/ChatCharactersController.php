<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use App\Form\SearchForm;
use Cake\Core\Configure;

/**
 * ChatCharacters Controller
 *
 * @property \App\Model\Table\ChatCharactersTable $ChatCharacters
 * @method \App\Model\Entity\ChatCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatCharactersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('BattleCharacterStatuses');
    }

    public function search()
    {
        $searchForm = new SearchForm();

        if ($this->request->is('post')) {
            $keyword = $this->request->getData('keyword');
            $query = $this->ChatCharacters->find('all',[
                'conditions' => [
                    'OR' => [
                        'fullname LIKE' => '%' .$keyword .'%',
                        'sex LIKE' => '%' .$keyword .'%',
                        'tag LIKE' => '%' .$keyword .'%',
                        'detail LIKE' => '%' .$keyword .'%',
                    ]
                ]
            ]);
        } else {
            // 全件表示
            $query = $this->ChatCharacters->find();
        }

        $query->contain(['BattleCharacterStatuses'])
            ->order(['modified' => 'DESC']);

        $chatCharacters = $this->paginate($query);

        $this->set(compact('searchForm'));
        $this->set(compact('chatCharacters'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->Authentication->getIdentityData('id');

        $query = $this->ChatCharacters->find()
            ->contain(['BattleCharacterStatuses'])
            ->where(['user_id' => $userId]);
        $chatCharacters = $this->paginate($query);

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
        // 参照は誰でも可能なため user_id による絞り込みはしない
        $chatCharacter = $this->ChatCharacters
            ->find()
            ->contain(['BattleCharacterStatuses'])
            ->where(['ChatCharacters.id' => $id])
            ->first();
        if (!$chatCharacter) {
            // キャラクターが見つからない場合はエラー
            $this->Flash->error(__('指定キャラクターは存在しません。'));
            $this->redirect(['action' => 'index']);
        }

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

        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacter->set('user_id', $userId);

        if ($this->request->is('post')) {

            $connection = ConnectionManager::get('default');
            $connection->begin();

            $chatCharacter = $this->ChatCharacters->patchEntity(
                $chatCharacter,
                $this->request->getData()
            );
            $cSave = $this->ChatCharacters->save($chatCharacter);

            if ($cSave) {
                $connection->commit();
                $this->Flash->success(__('キャラクターを登録しました。'));

                return $this->redirect(['action' => 'index']);
            }

            $connection->rollback();
            $this->Flash->error(__('キャラクターの登録に失敗しました。もう一度お試しください。'));
        }
        $colorCodes = Configure::read('ColorCodes');

        $this->set(compact('chatCharacter'));
        $this->set(compact('colorCodes'));
    }

    public function getEditCharacter($id = null)
    {
        $userId = $this->Authentication->getIdentityData('id');

        $chatCharacter = $this->ChatCharacters
            ->find()
            ->contain(['BattleCharacterStatuses'])
            ->where(['user_id' => $userId])
            ->where(['ChatCharacters.id' => $id])
            ->order(['ChatCharacters.id'])
            ->first();
        if (!$chatCharacter) {
            // キャラクターが見つからない場合はエラー
            $this->Flash->error(__('指定キャラクターは存在しません。'));
            $this->redirect(['action' => 'index']);
        }

        return $chatCharacter;
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
        $chatCharacter = $this->getEditCharacter($id);
        $battleCharacterStatus = $this->BattleCharacterStatuses->find()
            ->where(['chat_character_id' => $id,])
            ->first();
        if ($this->request->is(['patch', 'post', 'put'])) {

            $connection = ConnectionManager::get('default');
            $connection->begin();

            $chatCharacter = $this->ChatCharacters->patchEntity(
                $chatCharacter,
                $this->request->getData()
            );
            $cSave = $this->ChatCharacters->save($chatCharacter);

            $battleCharacterStatus = $this->BattleCharacterStatuses->patchEntity(
                $battleCharacterStatus,
                $this->request->getData('battle_character_status')
            );
            $bSave = $this->BattleCharacterStatuses->save($battleCharacterStatus);

            if ($cSave && $bSave) {
                $connection->commit();
                $this->Flash->success(__('キャラクターを登録しました。'));

                return $this->redirect(['action' => 'index']);
            }

            $connection->rollback();
            $this->Flash->error(__('キャラクター登録に失敗しました。もう一度お試しください。'));
        }
        $colorCodes = Configure::read('ColorCodes');

        $this->set(compact('chatCharacter'));
        $this->set(compact('colorCodes'));
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
        $chatCharacter = $this->getEditCharacter($id);
        if ($this->ChatCharacters->delete($chatCharacter)) {
            $this->Flash->success(__('キャラクターの登録を削除しました。'));
        } else {
            $this->Flash->error(__('キャラクターの登録の削除に失敗しました。もう一度お試しください。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function topListTable()
    {
        $this->viewBuilder()->setLayout('none');

        $chatCharacters = $this->ChatCharacters
            ->find();
        $time = $chatCharacters->func()->date_format([
            'modified' => 'identifier',
            "'%Y-%m-%d %H:%i:%s'" => 'literal',
        ]);
        $string = $chatCharacters->func()->left([
            'detail' => 'identifier',
            "32" => 'literal',
        ]);
        $chatCharacters
            ->select([
                'id',
                'fullname',
                'timeModified' => $time,
                'detailString' => $string,
            ])
            ->limit(3)
            ->order(['modified' => 'DESC'])
            ->toArray();

        $this->set(compact('chatCharacters'));

        return $this->render();
    }
}
