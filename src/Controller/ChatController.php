<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Xml;

/**
 * Chat Controller
 *
 * @method \App\Model\Entity\Chat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('CheckFile');
        $this->loadComponent('FormatTopList');
        $this->loadComponent('CheckChat');
        $this->loadComponent('ActionLog');
        $this->loadComponent('ChatSession');
        $this->loadComponent('Dice');

        $this->loadModel('ChatRooms');
        $this->loadModel('ChatCharacters');
        $this->loadModel('ChatEntries');
        $this->loadModel('ChatLogs');
        $this->loadModel('ChatLogWarehouses');
        $this->loadModel('Sessions');

        $this->loadModel('BattleSaveSkills');

        $this->session = $this->getRequest()->getSession();
        $this->ChatSession->set($this->session);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->Authentication->getIdentityData('id');
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        //チャットルーム一覧
        $chatRooms = $this->ChatRooms
            ->find()
            ->where(['published' => 1]) // 公開のみ
            ->order(['displayno' => 'ASC']);
        $activeChatRooms = $this->ChatRooms->get($chatRoomId);

        // キャラクター一覧
        $chatCharacters = $this->ChatCharacters
            ->find()
            ->where(['user_id' => $userId])
            ->order(['id' => 'ASC'])
            ->toArray();
        $chatCharacters = $this->FormatTopList->formatChatCharacters($chatCharacters);

        $chatRoomCss = $this->CheckFile->findChatRoomCss($chatRoomId);

        $this->set(compact('chatCharacters'));
        $this->set(compact('activeChatRooms'));
        $this->set(compact('chatRooms'));
        $this->set(compact('chatRoomId'));
        $this->set(compact('chatRoomCss'));
    }

    public function enter()
    {
        if (!$this->request->is('post')) {
            return $this->redirect();
        }

        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_id');
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        // 入室済の場合は入室した部屋にリダイレクト
        $enteredChatRoomId = $this->CheckChat->enteredChatRoomId($userId, $chatCharacterId);
        if($enteredChatRoomId) {
            $this->Flash->success(__('すでに入室しています。入室画面に移動します。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'room',
                $enteredChatRoomId,
            ]);
        }

        $connection = ConnectionManager::get('default');
        $connection->begin();

        // 入室状態の追加
        $entryKey = $this->CheckChat->findEntryKey($chatRoomId);
        $chatEntry = $this->ChatEntries->newEmptyEntity();
        $chatEntry->set('chat_room_id', $chatRoomId);
        $chatEntry->set('user_id', $userId);
        $chatEntry->set('chat_character_id', $chatCharacterId);
        $chatEntry->set('entry_key', $entryKey);
        if (!$this->ChatEntries->save($chatEntry)) {
            $connection->rollback();
            $this->Flash->error(__('入室に失敗しました。もう一度お試しください。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'index',
                $chatRoomId,
            ]);
        }

        // 入室メッセージ追加
        $chatLog = $this->ActionLog->setEntryMessage($chatEntry);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->Flash->error(__('入室に失敗しました。もう一度お試しください。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'index',
                $chatRoomId,
            ]);
        }

        $connection->commit();

        // 発言画面にリダイレクト
        return $this->redirect([
            'controller' => 'Chat',
            'action' => 'room',
            $chatRoomId,
        ]);
    }


    public function exit()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key');
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

        $connection = ConnectionManager::get('default');
        $connection->begin();

        // 退室メッセージ追加
        $chatLog = $this->ActionLog->setExitMessage($chatEntry);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->Flash->error(__('退出に失敗しました。もう一度お試しください。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'room',
                $chatRoomId,
            ]);
        }

        // 入室状態からの削除
        $entry_key = $chatEntry->entry_key; // 保持
        if (!$this->ChatEntries->delete($chatEntry)) {
            $connection->rollback();
            $this->Flash->error(__('退出に失敗しました。もう一度お試しください。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'room',
                $chatRoomId,
            ]);
        }

        // 入室者がいなくなった場合、ログ出力する
        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->first();
        if (!$chatEntry) {
            $this->outputChatLog($chatRoomId, $entry_key);
        }

        // MAX以上のログは削除する
        $logMax = Configure::read('Site.logmax');
        $maxLog = $this->ChatLogs->find()
            ->order(['id' => 'DESC'])
            ->limit($logMax)
            ->last();
        if (!$this->ChatLogs->deleteAll(['id <' => $maxLog->id])) {
            // 失敗した場合は警告のみ
            $maxId = $maxLog->id;
            $this->log(__CLASS__.":".__FUNCTION__.":" ."Error delete log. maxId = $maxId", 'warning');
        }

        $connection->commit();

        // チャットで使用していたセッションを削除
        $this->ChatSession->delete();
        $this->Flash->success(__('退出しました。'));

        // 発言画面にリダイレクト
        return $this->redirect([
            'controller' => 'Chat',
            'action' => 'index',
            $chatRoomId,
        ]);
    }

    public function outputChatLog($chatRoomId, $chatEntryKey) {
        $chatRoom = $this->ChatRooms->get($chatRoomId);

        $logs = $this->chatLog($chatRoomId, $chatEntryKey);

        $characters = $this->ChatLogs->find()
            ->where(['chat_room_key' => $chatRoomId])
            ->where(['entry_key' => $chatEntryKey])
            ->group('fullname')
            ->select(['fullname'])
            ->toArray();
        $characters = array_column($characters, 'fullname');
        $charactersString = join('...', $characters);

        $chatLogWarehouse = $this->ChatLogWarehouses->newEmptyEntity();
        $chatLogWarehouse->set('entry_key', $chatEntryKey);
        $chatLogWarehouse->set('chat_room_title', $chatRoom->title);
        $chatLogWarehouse->set('logs', $logs);
        $chatLogWarehouse->set('characters', $charactersString);

        if (!$this->ChatLogWarehouses->save($chatLogWarehouse)) {
            // 保存に失敗してもエラーログのみ表示
            $this->log(__CLASS__.":".__FUNCTION__.":" ."Error out put log. chatEntryKey = $chatEntryKey", 'error');
        }
    }

    public function room()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->ChatSession->getChatCharacterId();
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatCharacter = $this->ChatCharacters
            ->get($chatCharacterId);

        $chatRoomCss = $this->CheckFile->findChatRoomCss($chatRoomId);
        $entryKey = $this->CheckChat->findEntryKey($chatRoomId);

        $chatLog = $this->ChatLogs->newEmptyEntity();
        $chatLog->set('entry_key', $entryKey);
        $chatLog->set('chat_room_key', $chatRoomId);
        $chatLog->set('color', $chatCharacter->color);
        $chatLog->set('backgroundcolor', $chatCharacter->backgroundcolor);
        $chatLog->set('fullname', $chatCharacter->fullname);
        $chatLog->set('chat_character_key', $chatCharacterId);
        $chatLog->set('note', $this->ChatSession->getChatNote());

        // 戦闘用
        $battleSaveSkill = $this->ChatSession->getBattleSaveSkill();
        if (!$battleSaveSkill) {
            // 初期表示用
            $battleSaveSkill = $this->BattleSaveSkills->newEmptyEntity();
            $battleSaveSkill->set('chat_character_id', $chatCharacterId);
        }

        // 敵
        $enemies = $this->ChatCharacters->find()
            ->innerJoinWith('ChatEntries', function ($q) use ($chatRoomId) {
                return $q->select(['chat_room_id', 'chat_character_id'])
                    ->where(['chat_room_id' => $chatRoomId]);
            })
            ->where(['ChatCharacters.id !=' => $chatCharacterId])
            ->select(['ChatCharacters.id', 'ChatCharacters.fullname'])
            ->toArray();
        if ($enemies) {
            $enemies = array_column($enemies, 'fullname', 'id');
        }

        $battleSkills = Configure::read('Battle.battleSkills');
        $limitSkills = Configure::read('Battle.limitSkills');
        $passiveSkills = Configure::read('Battle.passiveSkills');

        $this->set(compact('battleSkills'));
        $this->set(compact('limitSkills'));
        $this->set(compact('passiveSkills'));
        $this->set(compact('battleSaveSkill'));
        $this->set(compact('enemies'));
        // 上記はバトル専用

        // 別窓にログを表示するか
        $openLogWindow = $this->ChatSession->getOpenLogWindow();

        $this->set(compact('openLogWindow'));
        $this->set(compact('chatCharacter'));
        $this->set(compact('chatRoomCss'));
        $this->set(compact('chatRoomId'));
        $this->set(compact('chatLog'));
        $this->set(compact('chatCharacterId'));
    }

    public function say()
    {
        $this->autoRender = false;

        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); // ここは key
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $this->log(__CLASS__.":".__FUNCTION__.":" ."userId = $userId, chatCharacterId = $chatCharacterId", 'debug');
        $this->log(__CLASS__.":".__FUNCTION__.":" ."chatRoomId = $chatRoomId", 'debug');

        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

        $note = $this->request->getData('note');
        $this->ChatSession->setChatNote($note);

        // タグチェック
        $message = $this->request->getData('message');
        try {
            $xmltext = '<?xml version="1.0"?><root><child>' .$message .'</child></root>';
            $xmlObject = Xml::build($xmltext);
        } catch (\Cake\Utility\Exception\XmlException $e) {
            $this->log(__CLASS__.":".__FUNCTION__.":" ."It is not in XML format.", 'warning');

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500', 'message' => 'タグが正しくありません。']));
            return $response;
        }

        // 前回の発言と同発言かのチェック
        // 通信エラーと荒らし対策のため
        $message = $this->request->getData('message');
        $lastChatLog = $this->ChatLogs->find()
            ->where(['chat_character_key' => $chatEntry->chat_character_id])
            ->order(['id' => 'DESC'])
            ->first();
        if($lastChatLog->message == $message) {
            $this->log(__CLASS__.":".__FUNCTION__.":" ."The remarks are repeated.", 'warning');

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500', 'message' => '同じ発言を繰り返すことはできません。']));
            return $response;
        }

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $chatLog = $this->ActionLog->setSayMessage($chatEntry, $this->request);
        if(!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->log(__CLASS__.":".__FUNCTION__.":" ."ChatLogs save failed.", 'warning');

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500']));
            return $response;
        }

        $connection->commit();

        $response = $this->response;
        $response = $response->withType('application/json')
            ->withStringBody(json_encode(['code' => '200']));
        return $response;
    }

    public function chatLogWindow($chatRoomId, $openLogWindow)
    {
        $chatRoomCss = $this->CheckFile->findChatRoomCss($chatRoomId);
        $isChatLogWindow = 1; // 別窓表示

        $this->ChatSession->setOpenLogWindow($openLogWindow);

        $openLogWindow = $this->ChatSession->getOpenLogWindow();
        $this->log(__CLASS__.":".__FUNCTION__.": openLogWindow=" .$openLogWindow, 'debug');

        $this->set(compact('chatRoomCss'));
        $this->set(compact('openLogWindow'));
        $this->set(compact('isChatLogWindow'));
        return $this->chatLog($chatRoomId);
    }

    public function chatLog($chatRoomId = null, $chatEntryKey = null, $chatLoglimit = 10000)
    {
        // 引数はRoutesにて、正規表現で数値制限済み
        // 他から呼び出すため getParam を使用しない
        $this->viewBuilder()->setLayout('chatlog');

        // GETの指定がある場合はGETを優先
        if ($this->request->is('get')){
            // GETの場合は入れ子を想定
            $this->viewBuilder()->setLayout('none');

            $chatLoglimit = $this->request->getQuery('limit');
            if (!$chatLoglimit || $chatLoglimit < 0 || 2000 < $chatLoglimit) {
                // 極端な数字は除く
                $chatLoglimit = 25;
            }
        }

        $chatLogs = $this->ChatLogs->find();
        if ($chatEntryKey != null && $chatEntryKey != "") {
            $chatLogs = $chatLogs
                ->where(['entry_key' => $chatEntryKey]);
        }
        $chatLogs = $chatLogs
            ->contain(['BattleLogs'])
            ->where(['chat_room_key' => $chatRoomId])
            ->order(['ChatLogs.id' => 'DESC'])
            ->limit($chatLoglimit)
            ->toArray();

        // toArray()を挟まないとこのIF文は機能しないので注意
        $chatRoom = [];
        if ($chatLogs) {
            // ルーム情報は最新のレコードから取得
            // 紐付けを行っておらず、部屋が削除されたあともログを出力するため
            // first() は絞り込まれてしまうため使えない
            $chatRoom = $chatLogs[0];
        }

        $colorCodes = Configure::read('ColorCodes');

        $this->set(compact('chatLogs'));
        $this->set(compact('chatRoom'));
        $this->set(compact('chatRoomId'));
        $this->set(compact('chatEntryKey'));
        $this->set(compact('colorCodes'));

        return $this->render('chatLog');
    }

    public function topListTable()
    {
        $chatLogs = $this->ChatLogs->find()
            ->where(['chat_character_key' => 0]) // システム
            ->order(['id' => 'DESC'])
            ->limit(3);
        $this->set(compact('chatLogs'));
    }

    public function viewCount()
    {
        $now = date('Y-m-d H:i:s');
        $target = date('Y-m-d H:i:s', strtotime('-60 second'));
        $cnt = $this->Sessions->find()
            ->where([
                'modified BETWEEN :start AND :end'
            ])
            ->bind(':start', $target, 'date')
            ->bind(':end', $now, 'date')
            ->count();

        $response = $this->response;
        $response = $response->withType('application/json')
            ->withStringBody(json_encode(['code' => '200', 'views' => $cnt]));
        return $response;
    }

    public function dice()
    {
        $this->autoRender = false;

        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); // ここは key
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatRoom = $this->ChatRooms->get($chatRoomId);
        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();
        $chatCharacter = $this->ChatCharacters
            ->get($chatCharacterId);

        $diceString = $this->request->getData('dice');

        if (!$this->Dice->isDiceFormat($diceString)) {
            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '400', 'message' => 'ダイス形式がフォーマットにあっていません']));
            return $response;
        }

        list($rollDiceString, $surfaces, $sum) = $this->Dice->roll($diceString);

        $connection = ConnectionManager::get('default');
        $connection->begin();

        // ダイス
        $format = Configure::read('Room.dice');
        $message = __($format, [
            $chatCharacter->fullname,
            $rollDiceString,
            '( ' .join(' + ', $surfaces) .' )',
            $sum,
        ]);
        $chatLog = $this->ActionLog->setSystemMessage($message, $chatEntry, $chatRoom);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500']));
            return $response;
        }

        $connection->commit();

        $response = $this->response;
        $response = $response->withType('application/json')
            ->withStringBody(json_encode(['code' => '200', 'message' => '正常終了']));
        return $response;
    }

    public function htmlTagList()
    {
        $colorCodes = Configure::read('ColorCodes');
        $this->set(compact('colorCodes'));
    }
}
