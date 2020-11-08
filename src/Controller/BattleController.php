<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\DetermineBattleComponent;
use Cake\Utility\Xml;

/**
 * Battle Controller
 *
 * @method \App\Model\Entity\Chat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BattleController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('CheckChat');
        $this->loadComponent('PreparationBattle');
        $this->loadComponent('ChatSession');
        $this->loadComponent('CheckFile');
        $this->loadComponent('DetermineBattle');
        $this->loadComponent('ActionLog');

        $this->loadModel('ChatEntries');
        $this->loadModel('ChatCharacters');
        $this->loadModel('ChatLogs');
        $this->loadModel('ChatRooms');

        $this->loadModel('BattleTurns');
        $this->loadModel('BattleSaveSkills');
        $this->loadModel('BattleCharacters');
        $this->loadModel('BattleCharacterStatuses');
        $this->loadModel('BattleLogs');

        $this->session = $this->getRequest()->getSession();
        $this->ChatSession->set($this->session);
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
        $chatLog->set('chat_character_key', $chatCharacter->id);
        $chatLog->set('note', $this->ChatSession->getChatNote());

        // 戦闘用
        $battleTurn = $this->ChatSession->getBattleTurn();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        $battleSaveSkill = $this->ChatSession->getBattleSaveSkill();

        $battleSkills = Configure::read('Battle.battleSkills');
        $limitSkills = Configure::read('Battle.limitSkills');
        $passiveSkills = Configure::read('Battle.passiveSkills');

        $attackSkillCodes = $this->PreparationBattle->organizeAttackSkills($battleSaveSkill, $battleSkills);
        $defenseSkillCodes = $this->PreparationBattle->organizeDefenseSkills($battleSaveSkill, $battleSkills);;

        $this->set(compact('battleTurn'));
        $this->set(compact('battleSaveSkill'));
        $this->set(compact('limitSkills'));
        $this->set(compact('passiveSkills'));
        $this->set(compact('attackSkillCodes'));
        $this->set(compact('defenseSkillCodes'));
        // 戦闘用ここまで

        // 別窓にログを表示するか
        $openLogWindow = $this->ChatSession->getOpenLogWindow();

        $this->set(compact('openLogWindow'));
        $this->set(compact('chatCharacter'));
        $this->set(compact('chatRoomCss'));
        $this->set(compact('chatRoomId'));
        $this->set(compact('chatLog'));
        $this->set(compact('chatCharacterId'));
    }

    public function suspend()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); //ここはkey
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $battleTurn = $this->ChatSession->getBattleTurn();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->Flash->success(__('戦闘は、すでに中断されているか、終了しています。'));
            return $this->redirect(['controller' => 'Chat', 'action' => 'room', $chatRoomId,]);
        }
        // 進行中でない場合はここで終える
        if ($battleTurn->battle_status != BT_ST_SINKOU) {
            $this->Flash->success(__('戦闘は、すでに中断されているか、終了しています。'));
            return $this->redirect(['controller' => 'Chat', 'action' => 'room', $chatRoomId,]);
        }

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $battleTurn->set('battle_status', BT_ST_TYUDAN);
        if (!$this->BattleTurns->save($battleTurn)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗ました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        $connection->commit();

        $this->Flash->success(__('中断しました。'));
        return $this->redirect(['controller' => 'Chat', 'action' => 'room', $chatRoomId,]);
    }

    public function restart()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_id');
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $enemyChatCharacterKey = $this->request->getData('enemy_chat_character_key');

        $vsBeforeKey = $this->PreparationBattle->vsBeforeKey($chatCharacterId, $enemyChatCharacterKey);
        $vsAfterKey = $this->PreparationBattle->vsAfterKey($chatCharacterId, $enemyChatCharacterKey);
        $battleTurn = $this->BattleTurns->find()
            ->where(['vs_before_key' => $vsBeforeKey])
            ->where(['vs_after_key' => $vsAfterKey])
            ->where(['battle_status IN ' => [BT_ST_SINKOU, BT_ST_TYUDAN]])
            ->first();

        $this->log(__CLASS__.":".__FUNCTION__.":" ."restart vsBeforeKey = $vsBeforeKey", 'debug');
        $this->log(__CLASS__.":".__FUNCTION__.":" ."restart vsAfterKey = $vsAfterKey", 'debug');
        $this->log("$battleTurn", 'debug');

        if (!$battleTurn) {
            $this->log(__CLASS__.":".__FUNCTION__.":" .'battleTurn not found.', 'warning');
            $this->Flash->error(__('再開する戦闘記録がありません。'));
            return $this->redirect(['controller' => 'Chat', 'action' => 'room', $chatRoomId,]);
        }

        // ステータスが中断の場合は再開のナレーションを入れる
        if ($battleTurn->battle_status == BT_ST_TYUDAN) {
            $connection = ConnectionManager::get('default');
            $connection->begin();

            $battleTurn->set('battle_status', BT_ST_SINKOU);
            if (!$this->BattleTurns->save($battleTurn)) {
                $connection->rollback();
                $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
                return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
            }

            $chatEntry = $this->ChatEntries->find()
                ->where(['chat_room_id' => $chatRoomId])
                ->where(['user_id' => $userId])
                ->where(['chat_character_id' => $chatCharacterId])
                ->first();
            $chatRoom = $this->ChatRooms->get($chatRoomId);
            $beforeCharacter = $this->ChatCharacters->get($vsBeforeKey);
            $afterCharacter = $this->ChatCharacters->get($vsAfterKey);

            $format = Configure::read('Battle.narration.NARR_BATTLE_RESTART');
            $message = __($format, [
                $beforeCharacter->fullname,
                $afterCharacter->fullname,
            ]);
            $chatLog = $this->ActionLog->setSystemMessage($message, $chatEntry, $chatRoom);
            if (!$this->ChatLogs->save($chatLog)) {
                $connection->rollback();
                $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
                return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
            }

            $connection->commit();
        }

        $battleSaveSkill = $this->BattleSaveSkills->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

        if (!$battleSaveSkill) {
            $this->Flash->error(__('再開する戦闘記録がありません。'));
            return $this->redirect([
                'controller' => 'Chat',
                'action' => 'room',
                $chatRoomId,
            ]);
        }

        $this->ChatSession->setBattleTurn($battleTurn);
        $this->ChatSession->setBattleSaveSkill($battleSaveSkill);

        // 発言画面にリダイレクト
        return $this->redirect([
            'controller' => 'Battle',
            'action' => 'room',
            $chatRoomId,
        ]);
    }

    public function receive()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_id');
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();
        $chatRoom = $this->ChatRooms->get($chatRoomId);

        // 戦闘準備
        $battleTurn = $this->ChatSession->getBattleTurn();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        $battleSaveSkill = $this->ChatSession->getBattleSaveSkill();
        $battleCharacterStatus = $this->BattleCharacterStatuses->find()
            ->where(['chat_character_id' => $battleSaveSkill->chat_character_id])
            ->first();
        $enemyBattleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $battleSaveSkill->enemy_chat_character_key])
            ->first();

        $connection = ConnectionManager::get('default');
        $connection->begin();

        // バトルキャラクター保存
        $battleCharacter = $this->BattleCharacters->newEmptyEntity();
        $battleCharacter = $this->PreparationBattle->preparationBattleCharacters(
            $battleCharacter, $battleTurn, $battleSaveSkill, $battleCharacterStatus
        );
        if (!$this->BattleCharacters->save($battleCharacter)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // 先攻、後攻を決定
        [$attackBattleCharacter, $defenseBattleCharacter]
            = $this->PreparationBattle->determineAttackOrDeffence($battleCharacter, $enemyBattleCharacter);
        $battleTurn->set('attack_chat_character_key', $attackBattleCharacter->chat_character_id);
        $battleTurn->set('defense_chat_character_key', $defenseBattleCharacter->chat_character_id);
        $battleTurn->set('battle_status', BT_ST_SINKOU);
        if (!$this->BattleTurns->save($battleTurn)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // バトルキスキル保存
        $battleSaveSkill->set('battle_turn_id', $battleTurn->id);
        if (!$this->BattleSaveSkills->save($battleSaveSkill)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }
        $this->ChatSession->setBattleSaveSkill($battleSaveSkill);

        $attackChatCharacter = $this->ChatCharacters->get($attackBattleCharacter->chat_character_id);
        $defenseChatCharacter = $this->ChatCharacters->get($defenseBattleCharacter->chat_character_id);

        // 宣戦布告を受諾するメッセージの追加
        $format = Configure::read('Battle.narration.NARR_BATTLE_START');
        $message = __($format, [
            $attackChatCharacter->fullname,
            $defenseChatCharacter->fullname,
        ]);
        $chatLog = $this->ActionLog->setSystemMessage($message, $chatEntry, $chatRoom);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        $connection->commit();

        // 発言画面にリダイレクト
        return $this->redirect([
            'controller' => 'Battle',
            'action' => 'room',
            $chatRoomId,
        ]);
    }

    public function start()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_id');
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();
        $chatRoom = $this->ChatRooms->get($chatRoomId);
        $chatCharacter = $this->ChatCharacters->get($chatCharacterId);

        $battleSaveSkill = $this->BattleSaveSkills->newEmptyEntity();
        $battleSaveSkill = $this->BattleSaveSkills->patchEntity($battleSaveSkill, $this->request->getData());
        $this->ChatSession->setBattleSaveSkill($battleSaveSkill);

        $result = $this->PreparationBattle->validate($this->request, $this->Flash);
        if (!$result) {
            // エラーの場合はチャット画面に返却、エラーメッセージは関数内で指定
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // 宣戦布告されている場合は受諾処理
        $vsBeforeKey = $this->PreparationBattle->vsBeforeKey($chatCharacterId, $battleSaveSkill->enemy_chat_character_key);
        $vsAfterKey = $this->PreparationBattle->vsAfterKey($chatCharacterId, $battleSaveSkill->enemy_chat_character_key);
        $battleTurn = $this->BattleTurns->find()
            ->where(['vs_before_key' => $vsBeforeKey])
            ->where(['vs_after_key' => $vsAfterKey])
            ->where(['vs_fukoku_key != ' => $chatCharacterId])
            ->where(['battle_status IN ' => [BT_ST_FUKOKU, ]])
            ->order('id')
            ->first();

        if ($battleTurn) {
            // 宣戦布告を受諾
            $this->ChatSession->setBattleTurn($battleTurn);
            $this->ChatSession->setBattleSaveSkill($battleSaveSkill);
            return $this->receive();
        }

        // 宣戦布告処理
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $enemyChatCharacterKey = $battleSaveSkill->enemy_chat_character_key;
        $vsBeforeKey = $this->PreparationBattle->vsBeforeKey($chatCharacterId, $enemyChatCharacterKey);
        $vsAfterKey = $this->PreparationBattle->vsAfterKey($chatCharacterId, $enemyChatCharacterKey);
        $enemyChatCharacter = $this->ChatCharacters->get($enemyChatCharacterKey);

        $battleCharacterStatus = $this->BattleCharacterStatuses->find()
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

        // 同一のバトルターンがある場合は削除
        $delBattleTurns = $this->BattleTurns->find()
            ->where(['vs_before_key' => $vsBeforeKey])
            ->where(['vs_after_key' => $vsAfterKey]);
        foreach ($delBattleTurns as $key => $delBattleTurn) {
            $this->BattleTurns->delete($delBattleTurn);
        }
        // DB整理のため、同じキャラクターIDで終了したものがある場合は削除
        $delBattleTurns = $this->BattleTurns->find()
            ->where([
                'OR' => [
                    ['vs_before_key' => $chatCharacterId],
                    ['vs_after_key' => $chatCharacterId]
                ],
            ])
            ->where(['battle_status IN ' => [BT_ST_KETYAKU, ]]);
        foreach ($delBattleTurns as $key => $delBattleTurn) {
            $this->BattleTurns->delete($delBattleTurn);
        }

        // バトルターン保存
        $battleTurn = $this->BattleTurns->newEmptyEntity();
        $battleTurn->set('vs_fukoku_key', $chatCharacterId);
        $battleTurn->set('vs_before_key', $vsBeforeKey);
        $battleTurn->set('vs_after_key', $vsAfterKey);
        $battleTurn->set('battle_status', BT_ST_FUKOKU);
        if (!$this->BattleTurns->save($battleTurn)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // バトル選択スキル保存
        $battleSaveSkill->set('battle_turn_id', $battleTurn->id);
        if (!$this->BattleSaveSkills->save($battleSaveSkill)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // バトルキャラクター保存
        $battleCharacter = $this->BattleCharacters->newEmptyEntity();
        $battleCharacter = $this->PreparationBattle->preparationBattleCharacters(
            $battleCharacter, $battleTurn, $battleSaveSkill, $battleCharacterStatus
        );
        if (!$this->BattleCharacters->save($battleCharacter)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        // 宣戦布告メッセージの追加
        $format = Configure::read('Battle.narration.NARR_BATTLE_DECLARATION');
        $message = __($format, [
            $chatCharacter->fullname,
            $enemyChatCharacter->fullname,
        ]);
        $chatLog = $this->ActionLog->setSystemMessage($message, $chatEntry, $chatRoom);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->Flash->error(__('戦闘開始に失敗しました。もう一度お試しください。'));
            return $this->redirect([ 'controller' => 'Chat', 'action' => 'room', $chatRoomId, ]);
        }

        $connection->commit();

        $this->ChatSession->setBattleTurn($battleTurn);
        $this->ChatSession->setBattleSaveSkill($battleSaveSkill);

        // 戦闘発言画面にリダイレクト
        return $this->redirect([
            'controller' => 'Battle',
            'action' => 'room',
            $chatRoomId,
        ]);
    }

    public function commentary()
    {
        $this->viewBuilder()->setLayout('none');

        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $battleId = $this->request->getQuery('battle_id');
        if (!$battleId) {
            $battleId = 0;
        }

        $battleTurn = $this->BattleTurns->find()
            ->where(['id' => $battleId])
            ->first();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        $beforeBattleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleId])
            ->where(['chat_character_id' => $battleTurn->vs_before_key])
            ->first();
        $beforeChatCharacter = $this->ChatCharacters->find()
            ->where(['id' => $battleTurn->vs_before_key])
            ->first();
        $afterBattleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleId])
            ->where(['chat_character_id' => $battleTurn->vs_after_key])
            ->first();
        $afterChatCharacter = $this->ChatCharacters->find()
            ->where(['id' => $battleTurn->vs_after_key])
            ->first();

        if ($battleTurn && $beforeBattleCharacter
            && $battleTurn->attack_chat_character_key == $beforeBattleCharacter->chat_character_id) {
            $attackBattleCharacter = $beforeBattleCharacter;
            $attackChatCharacter = $beforeChatCharacter;
            $defenseBattleCharacter = $afterBattleCharacter;
            $defenseChatCharacter = $afterChatCharacter;
        } else {
            $attackBattleCharacter = $afterBattleCharacter;
            $attackChatCharacter = $afterChatCharacter;
            $defenseBattleCharacter = $beforeBattleCharacter;
            $defenseChatCharacter = $beforeChatCharacter;
        }

        $limitSkills = Configure::read('Battle.limitSkills');
        $passiveSkills = Configure::read('Battle.passiveSkills');

        $this->set(compact('battleTurn'));
        $this->set(compact('chatRoomId'));
        $this->set(compact('limitSkills'));
        $this->set(compact('passiveSkills'));

        $this->set(compact('beforeBattleCharacter'));
        $this->set(compact('beforeChatCharacter'));
        $this->set(compact('afterBattleCharacter'));
        $this->set(compact('afterChatCharacter'));
        $this->set(compact('attackBattleCharacter'));
        $this->set(compact('attackChatCharacter'));
        $this->set(compact('defenseBattleCharacter'));
        $this->set(compact('defenseChatCharacter'));

        return $this->render();
    }

    public function defenseSet()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); // ここはkey
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $this->log(__CLASS__.":".__FUNCTION__.":" ."userId = $userId, chatCharacterId = $chatCharacterId", 'debug');
        $this->log(__CLASS__.":".__FUNCTION__.":" ."chatRoomId = $chatRoomId", 'debug');

        $defenseSkillCode = $this->request->getData('defense_skill_code');
        $defenseSkillAttribute = $this->request->getData('defense_skill_attribute');

        $battleTurn = $this->ChatSession->getBattleTurn();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->log(__CLASS__.":".__FUNCTION__.":" .'battleTurn not found.', 'warning');
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        // 防御セット
        $battleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();
        $battleCharacter->set('defense_skill_code', $defenseSkillCode);
        $battleCharacter->set('defense_skill_attribute', $defenseSkillAttribute);

        if (!$this->BattleCharacters->save($battleCharacter)) {
            $this->log(__CLASS__.":".__FUNCTION__.":" .'BattleCharacters save failed.', 'warning');
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        $response = $this->response;
        $response = $response->withType('application/json')
            ->withStringBody(json_encode(['code' => '200']));
        return $response;
    }

    public function say()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); // ここはkey
        $chatCharacterId = $this->CheckChat->userCharacterId($userId, $chatCharacterId);
        $this->ChatSession->setChatCharacterId($chatCharacterId);
        // Routesにて、正規表現で数値制限済み
        $chatRoomId = $this->request->getParam('chatRoomId');

        $battleTurn = $this->ChatSession->getBattleTurn();
        if (!$battleTurn) {
            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '201']));
            return $response;
        }

        $chatCharacter = $this->ChatCharacters->get($chatCharacterId);
        $battleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

        $this->log(__CLASS__.":".__FUNCTION__.":" ."userId = $userId, chatCharacterId = $chatCharacterId", 'debug');
        $this->log(__CLASS__.":".__FUNCTION__.":" ."chatRoomId = $chatRoomId", 'debug');

        $chatEntry = $this->ChatEntries->find()
            ->where(['chat_room_id' => $chatRoomId])
            ->where(['user_id' => $userId])
            ->where(['chat_character_id' => $chatCharacterId])
            ->first();

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
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->log(__CLASS__.":".__FUNCTION__.":" .'ChatLogs save failed.', 'warning');

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500']));
            return $response;
        }

        $this->DetermineBattle = new DetermineBattleComponent(new ComponentRegistry());
        $this->DetermineBattle->set($this->request, $battleTurn, $chatCharacterId,
            $battleCharacter, $chatCharacter, NULL, NULL); // 文字列だけが欲しいので特殊なset
        $statusString = $this->DetermineBattle->createBattleStatusString();

        $battleLog = $this->BattleLogs->newEmptyEntity();
        $battleLog->set('chat_log_id', $chatLog->id);
        $battleLog->set('status', $statusString);

        if (!$this->BattleLogs->save($battleLog)) {
            $connection->rollback();
            $this->log(__CLASS__.":".__FUNCTION__.":" .'BattleLogs save failed.', 'warning');

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

    public function attackSet()
    {
        $userId = $this->Authentication->getIdentityData('id');
        $chatCharacterId = $this->request->getData('chat_character_key'); // ここはkey
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

        $battleTurn = $this->ChatSession->getBattleTurn();
        // 終了した場合は消えるため、ここで終える
        if (!$battleTurn) {
            $this->set(compact('battleTurn'));
            $this->set(compact('chatRoomId'));
            return;
        }

        $isAttack = $this->request->getData('is_attack'); // 攻撃チェック

        // 進行中でない場合は発言のみ
        if ($battleTurn->battle_status != BT_ST_SINKOU) {
            $status = $battleTurn->battle_status;
            $this->log(__CLASS__.":".__FUNCTION__.":" ."battle_status = $status", 'debug');
            return $this->say();
        }
        // 攻撃チェックがない場合は発言のみ
        if (!$isAttack) {
            $this->log(__CLASS__.":".__FUNCTION__.":" ."isAttack = $isAttack", 'debug');
            return $this->say();
        }
        // 宣戦布告時のみの場合はNULLになるので発言のみ
        if (!$battleTurn->defense_chat_character_key) {
            $key = $battleTurn->defense_chat_character_key;
            $this->log(__CLASS__.":".__FUNCTION__.":" ."defense_chat_character_key = $key", 'debug');
            return $this->say();
        }
        // 防御がセットされていない場合は発言のみ
        $defenseBattleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $battleTurn->defense_chat_character_key])
            ->first();
        if ($defenseBattleCharacter && !$defenseBattleCharacter->defense_skill_code) {
            $id = $battleTurn->id;
            $key = $battleTurn->defense_chat_character_key;
            $code = $defenseBattleCharacter->defense_skill_code;
            $this->log(__CLASS__.":".__FUNCTION__.":" ."battleTurn->id=$id", 'debug');
            $this->log(__CLASS__.":".__FUNCTION__.":" ."key=$key defense_skill_code = $code", 'debug');
            return $this->say();
        }
        // 攻撃ターンでない場合は発言のみ
        if ($battleTurn->attack_chat_character_key != $chatCharacterId) {
            $this->log(__CLASS__.":".__FUNCTION__.":" ."Not attack_chat_character_key = $chatCharacterId", 'debug');
            return $this->say();
        }

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

        $defenseChatCharacter = $this->ChatCharacters->get($battleTurn->defense_chat_character_key);

        $attackBattleCharacter = $this->BattleCharacters->find()
            ->where(['battle_turn_id' => $battleTurn->id])
            ->where(['chat_character_id' => $battleTurn->attack_chat_character_key])
            ->first();
        $attackChatCharacter = $this->ChatCharacters->get($battleTurn->attack_chat_character_key);

        $this->DetermineBattle = new DetermineBattleComponent(new ComponentRegistry());
        $this->DetermineBattle->set($this->request, $battleTurn, $chatCharacterId,
            $defenseBattleCharacter, $defenseChatCharacter,
            $attackBattleCharacter, $attackChatCharacter);
        $this->DetermineBattle->determine();
        $this->DetermineBattle->debugLog();

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $chatLog = $this->ActionLog->setSayMessage($chatEntry, $this->request);
        if (!$this->ChatLogs->save($chatLog)) {
            $connection->rollback();
            $this->log(__CLASS__.":".__FUNCTION__.":" .'ChatLogs save failed.', 'warning');

            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode(['code' => '500']));
            return $response;
        }

        $battleLog = $this->DetermineBattle->createBattleLog();
        $battleLog->set('chat_log_id', $chatLog->id);

        if (!$this->BattleLogs->save($battleLog)) {
            $connection->rollback();
            $this->log(__CLASS__.":".__FUNCTION__.":" .'BattleLogs save failed.', 'warning');

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
}
