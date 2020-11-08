<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Datasource\ModelAwareTrait;
use Cake\Datasource\ConnectionManager;

class DetermineBattleComponent extends Component
{
    use ModelAwareTrait;

    private $request;
    private $battleTurn;
    private $defenseBattleCharacter;
    private $defenseChatCharacter;
    private $attackBattleCharacter;
    private $attackChatCharacter;

    private $battleCharacter;
    private $chatCharacter;
    private $enemyBattleCharacter;
    private $enemyChatCharacter;

    private $attack_skill_attribute;
    private $attack_kill;
    private $attack_skill_code;
    private $attack_technique_name;

    private $useCombo = 0; // 使用コンボ
    private $compatibility = 0; // 攻撃の勢い（有利、不利、拮抗）
    private $isHit = 0; // ヒットしたか？
    private $momentum = 0; // 攻撃が外れた場合の対処法（防御、回避、相殺）
    private $isHitString = ''; // 拮抗時、ダイスをふった場合の文字列
    private $useKillSp = 0; // 必殺用SP
    private $damage = 0; // ダメージ
    private $damageString = ''; // ダメージ計算式
    private $comboUp = 0; // 攻撃ヒットによるコンボ増加
    private $recoveryHp = 0; // 戦意高揚によるHP回復
    private $recoverySp = 0; // 精神統一によるSP回復
    private $isContinuous = 0; // 連続攻撃したか？
    private $isContinuousString = ''; // 連続攻撃、ダイスをふった場合の文字列
    private $isKo = 0; // 戦闘不能になったか
    private $isResurrection = 0; // 底力が発動したか
    private $isResurrectionString = ''; // 底力、ダイスをふった場合の文字列
    private $isLimit = 0; // 相手の覚醒スキルが発動したか？
    private $isCounter = 0; // 相手のカウンターが発動したか？
    private $isKoubouittai = 0; // 相手の攻防一体が発動したか？
    private $isDetermineScratch = 0; // 半減ダメージの判定をするか
    private $isDetermineScratchString = 0; // 半減ダメージ、ダイスをふった場合の文字列
    private $isScratch = 0; // 半減ダメージか？

    public function initialize($config): void
    {
        parent::initialize($config);

        $this->loadModel('BattleLogs');
        $this->loadModel('BattleTurns');
        $this->loadModel('BattleCharacters');

        $this->limitSkills = Configure::read('Battle.limitSkills');
        $this->passiveSkills = Configure::read('Battle.passiveSkills');
        $this->attributes = Configure::read('Battle.attributes');
        $this->momentums = Configure::read('Battle.momentums');
        $this->compatibilitys = Configure::read('Battle.compatibilitys');
        $this->tokills = Configure::read('Battle.tokills');

        $battleSkills = Configure::read('Battle.battleSkills');
        $this->battleSkills = $battleSkills['攻撃スキル'] + $battleSkills['特殊スキル'] + $battleSkills['防御スキル'];
        $this->battleSkills += [BT_AT_NASHI => '無し'];
        $this->battleSkills += [BT_DF_NASHI => '無し'];

        //$this->log(print_r($this->battleSkills,true), "debug");
        //$this->log(print_r($this->limitSkills,true), "debug");
    }

    public function createBattleLog() {
        $memo = [];
        $narration = [];

        // VS
        $format = Configure::read('Battle.narration.NARR_BATTLE_SKILL');
        $narration[] = __($format,
            $this->attackChatCharacter->fullname,
            $this->battleSkills[$this->attack_skill_code],
            $this->attributes[$this->attack_skill_attribute],
            $this->defenseChatCharacter->fullname,
            $this->battleSkills[$this->defense_skill_code],
            $this->attributes[$this->defense_skill_attribute],
        );

        $line1 = [];
        if ($this->attack_skill_code == BT_AT_SENI) {
            // 戦意高揚
            if ($this->recoveryHp > 0) {
                // 発動
                $format = Configure::read('Battle.narration.NARR_SENI_UP');
                $line1[] = __($format,
                    $this->attackChatCharacter->fullname,
                    $this->attack_technique_name,
                    $this->recoveryHp,
                );
            } else {
                // 不発
                $format = Configure::read('Battle.narration.NARR_SENI_FUHATSU');
                $line1[] = __($format,
                    $this->attackChatCharacter->fullname,
                    $this->attack_technique_name,
                );
            }
        } elseif ($this->attack_skill_code == BT_AT_SEISIN) {
            // 精神統一
            if ($this->recoverySp > 0) {
                // 発動
                $format = Configure::read('Battle.narration.NARR_SEISHIN_UP');
                $line1[] = __($format,
                    $this->attackChatCharacter->fullname,
                    $this->attack_technique_name,
                    $this->recoverySp,
                );
            } else {
                // 不発
                $format = Configure::read('Battle.narration.NARR_SEISHIN_FUHATSU');
                $line1[] = __($format,
                    $this->attackChatCharacter->fullname,
                    $this->attack_technique_name,
                );
            }
        }
        if ($this->isHit == 1 && $this->isScratch != 1) {
            // 命中していること
            // かすり傷でないこと
            $format = Configure::read('Battle.narration.NARR_MEITYU');
            $line1[] = __($format,
                $this->attackChatCharacter->fullname,
                $this->attack_technique_name,
                $this->defenseChatCharacter->fullname,
                $this->damage,
                $this->tokills[$this->useKillSp],
            );
        }
        if ($this->isHit == 0 || $this->isScratch == 1) {
            // 外れの場合
            // かすり傷でもナレーションを入れる
            $format = Configure::read('Battle.narration.NARR_HAZURE');
            $line1[] = __($format,
                $this->defenseChatCharacter->fullname,
                $this->attackChatCharacter->fullname,
                $this->attack_technique_name,
                $this->momentums[$this->momentum],
            );
        }
        if ($this->isScratch == 1) {
            // かすり傷
            $format = Configure::read('Battle.narration.NARR_KASURI');
            $line1[] = __($format,
                $this->momentums[$this->momentum],
                $this->damage,
            );
        }
        // コンビネーション
        if ($this->useCombo == 0 && $this->attack_skill_code == BT_AT_KONBI) {
            // 不発
            $format = Configure::read('Battle.narration.NARR_KONBI_FUHATSU');
            $line1[] = __($format);
        } elseif ($this->useCombo != 0 && $this->attack_skill_code == BT_AT_KONBI
            && $this->isHit == 1
        ) {
            // 命中した時だけ表示
            $format = Configure::read('Battle.narration.NARR_KONBI');
            $line1[] = __($format,
                $this->useCombo,
            );
        }
        if ($this->isContinuous != 0) {
            // 連続攻撃
            $format = Configure::read('Battle.narration.NARR_RENXOKU_HATSUDOU');
            $line1[] = __($format);
        }
        $narration[] = implode('', $line1);

        if ($this->isKo != 0) {
            // 戦闘不能
            $format = Configure::read('Battle.narration.NARR_KO');
            $narration[] = __($format,
                $this->defenseChatCharacter->fullname,
            );
        }

        if ($this->isResurrection != 0) {
            // 底力
            $format = Configure::read('Battle.narration.NARR_SOKOJIKARA');
            $narration[] = __($format,
                $this->defenseChatCharacter->fullname,
            );
        }

        if ($this->isLimit != 0) {
            // 覚醒スキル
            $format = Configure::read('Battle.narration.NARR_KAKUSEI');
            $narration[] = __($format,
                $this->defenseChatCharacter->fullname,
                $this->limitSkills[$this->defenseBattleCharacter->limit_skill_code],
            );
        }

        if ($this->isCounter == 1 || $this->isKoubouittai == 1) {
            // カウンター、攻防一体
            $format = Configure::read('Battle.narration.NARR_HATUDOU');
            $narration[] = __($format,
                $this->defenseChatCharacter->fullname,
                $this->battleSkills[$this->defenseBattleCharacter->defense_skill_code],
            );
        }

        // 属性
        $memo[] = '属性'.$this->compatibilitys[$this->compatibility];
        // 命中ダイス
        if ($this->isHitString) {
            $memo[] = $this->isHitString;
        }
        // かすり傷ダイス
        if ($this->isDetermineScratchString) {
            $memo[] = $this->isDetermineScratchString;
        }
        // ダメージ計算式
        if ($this->isHit && $this->damageString) {
            $memo[] = $this->damageString;
        }
        // 連続攻撃計算式
        if ($this->isContinuousString) {
            $memo[] = $this->isContinuousString;
        }
        // 底力計算式
        if ($this->isResurrectionString) {
            $memo[] = $this->isResurrectionString;
        }

        $memoString = implode("\n", $memo);
        $narrationString = implode("\n", $narration);

        $battleLog = $this->BattleLogs->newEmptyEntity();
        $battleLog->set('status', $this->createBattleStatusString());
        $battleLog->set('narration', $narrationString);
        $battleLog->set('memo', $memoString);

        return $battleLog;
    }

    public function debugLog() {
        $param = [
            'battleTurn' => $this->battleTurn,
            'defenseBattleCharacter' => $this->defenseBattleCharacter,
            'attackBattleCharacter' => $this->attackBattleCharacter,
            'attack_skill_attribute' => $this->attack_skill_attribute,
            'attack_kill' => $this->attack_kill,
            'attack_skill_code' => $this->attack_skill_code,
            'attack_technique_name' => $this->attack_technique_name,
            'useCombo' => $this->useCombo,
            'compatibility' => $this->compatibility,
            'isHit' => $this->isHit,
            'momentum' => $this->momentum,
            'isHitString' => $this->isHitString,
            'useKillSp' => $this->useKillSp,
            'damage' => $this->damage,
            'damageString' => $this->damageString,
            'comboUp' => $this->comboUp,
            'recoveryHp' => $this->recoveryHp,
            'recoverySp' => $this->recoverySp,
            'isContinuous' => $this->isContinuous,
            'isContinuousString' => $this->isContinuousString,
            'isKo' => $this->isKo,
            'isResurrection' => $this->isResurrection,
            'isResurrectionString' => $this->isResurrectionString,
            'isLimit' => $this->isLimit,
            'isCounter' => $this->isCounter,
            'isKoubouittai' => $this->isKoubouittai,
            'isDetermineScratch' => $this->isDetermineScratch,
            'isDetermineScratchString' => $this->isDetermineScratchString,
            'isScratch' => $this->isScratch,
        ];
        $this->log(__CLASS__.":".__FUNCTION__.":". print_r($param, true), 'debug');
    }

    public function set($request, $battleTurn, $chatCharacterId,
        $defenseBattleCharacter, $defenseChatCharacter,
        $attackBattleCharacter, $attackChatCharacter)
    {
        $this->request = $request;
        $this->battleTurn = $battleTurn;

        $this->defenseBattleCharacter = $defenseBattleCharacter;
        $this->defenseChatCharacter = $defenseChatCharacter;
        $this->attackBattleCharacter = $attackBattleCharacter;
        $this->attackChatCharacter = $attackChatCharacter;

        if ($defenseBattleCharacter
            && $defenseBattleCharacter->chat_character_id == $chatCharacterId
        ) {
            $this->battleCharacter = $defenseBattleCharacter;
            $this->chatCharacter = $defenseChatCharacter;
            $this->enemyBattleCharacter = $attackBattleCharacter;
            $this->enemyChatCharacter = $attackChatCharacter;
        }
        if ($attackBattleCharacter
            && $attackBattleCharacter->chat_character_id == $chatCharacterId
        ) {
            $this->battleCharacter = $attackBattleCharacter;
            $this->chatCharacter = $attackChatCharacter;
            $this->enemyBattleCharacter = $defenseBattleCharacter;
            $this->enemyChatCharacter = $defenseChatCharacter;
        }

        $this->attack_skill_attribute = $this->request->getData('attack_skill_attribute');
        $this->attack_kill = $this->request->getData('attack_kill');
        $this->attack_skill_code = $this->request->getData('attack_skill_code');
        $this->attack_technique_name = $this->request->getData('attack_technique_name');

        // ナレーションのための保持
        $this->defense_skill_code = $this->defenseBattleCharacter->defense_skill_code;
        $this->defense_skill_attribute = $this->defenseBattleCharacter->defense_skill_attribute;

        if (!$this->attack_technique_name) {
            $this->attack_technique_name = '';
        }
    }

    public function createBattleStatusString() {
        $hit_rate = $this->battleCharacter->permanent_hit_rate;
        $hit_rate += $this->battleCharacter->temporary_hit_rate;
        if ($this->enemyBattleCharacter) {
            $hit_rate -= $this->enemyBattleCharacter->permanent_dodge_rate;
            $hit_rate -= $this->enemyBattleCharacter->temporary_dodge_rate;
        }
        if ($hit_rate > 0) {
            $hit_rate = '+'. $hit_rate;
        }
        $limit = '—';
        if ($this->battleCharacter->is_limit) {
            $limit = $this->limitSkills[$this->battleCharacter->limit_skill_code];
        }
        $format = Configure::read('Battle.narration.NARR_BATTLE_STATUS');
        $result = __($format,
            $this->battleCharacter->hp,
            $this->battleCharacter->sp,
            $this->battleCharacter->combo,
            ($this->battleCharacter->permanent_strength + $this->battleCharacter->temporary_strength),
            $hit_rate,
            $limit,
        );
        return $result;
    }

    public function determine() {
        $this->determineUseCommbo(); // 使用コンボの判定
        $this->determineCombinationUp(); // コンビネーションの補正判定
        $this->determineRecoveryHp(); // 特殊スキル、HP回復判定
        $this->determineRecoverySp(); // 特殊スキル、SP回復判定
        $this->determineMomentum(); // 有利不利の判定
        $this->determineVsSkill(); // 攻撃のヒット判定
        $this->determineScratch(); // 外れた場合の半減判定
        $this->determineKill(); // 必殺判定
        $this->calculateDamage(); // ダメージ計算
        $this->determineComboUp(); // 攻撃ヒットによる、コンボ増加判定
        $this->determineDualDrive(); // 連撃判定
        $this->determineKo(); // 相手側、戦闘不能判定
        $this->determineResurrection(); // 相手側、底力判定
        $this->determineLimitSkill(); // 相手側、覚醒スキル判定
        $this->determineDefenseSkillUp(); // 相手側、一時的ステータス増加判定
        $this->updateBattle(); // 各値の更新
    }

    public function updateBattle()
    {
        $turnCnt = $this->battleTurn->battle_turn_count + 1;
        $this->battleTurn->set('battle_turn_count', $turnCnt);

        if (!$this->isContinuous) {
            // 連続攻撃でない場合は入れ替える
            $tmp = $this->battleTurn->attack_chat_character_key;
            $this->battleTurn->set('attack_chat_character_key', $this->battleTurn->defense_chat_character_key);
            $this->battleTurn->set('defense_chat_character_key', $tmp);
        }
        // 戦闘不能の場合はステータスを決着に
        if ($this->isKo) {
            $this->battleTurn->set('battle_status', BT_ST_KETYAKU);
        }

        // 攻撃した側
        $this->attackBattleCharacter->set('combo', ($this->attackBattleCharacter->combo - $this->useCombo + $this->comboUp));
        $this->attackBattleCharacter->set('sp', ($this->attackBattleCharacter->sp - $this->useKillSp));
        $this->attackBattleCharacter->set('hp', ($this->attackBattleCharacter->hp + $this->recoveryHp));
        $this->attackBattleCharacter->set('sp', ($this->attackBattleCharacter->sp + $this->recoverySp));
        $this->attackBattleCharacter->set('temporary_strength', 0);
        $this->attackBattleCharacter->set('temporary_hit_rate', 0);
        $this->attackBattleCharacter->set('temporary_dodge_rate', 0);
        $this->attackBattleCharacter->set('defense_skill_code', 0);
        $this->attackBattleCharacter->set('defense_skill_attribute', 0);
        if ($this->attackBattleCharacter->continuous_turn_count > 0) {
            // 連続攻撃をリセット
            $this->attackBattleCharacter->set('continuous_turn_count', 0);
        } elseif ($this->isContinuous) {
            $this->attackBattleCharacter->set('continuous_turn_count',
                ($this->attackBattleCharacter->continuous_turn_count + 1)
            );
        }

        // 防御した側
        if ($this->isLimit) {
            $this->defenseBattleCharacter->set('is_limit', 1);
        }
        if ($this->isCounter) {
            // カウンター
            $this->defenseBattleCharacter->set('temporary_strength',
                ($this->defenseBattleCharacter->temporary_strength + 1)
            );
        }
        if ($this->isKoubouittai) {
            // 攻防一体
            $this->defenseBattleCharacter->set('temporary_strength',
                ($this->defenseBattleCharacter->temporary_strength + 2)
            );
        }
        if ($this->isLimit
            && $this->defenseBattleCharacter->limit_skill_code == BT_LIMIT_01
        ) {
            // リミットブレイク
            $this->defenseBattleCharacter->set('permanent_strength',
                ($this->defenseBattleCharacter->permanent_strength + 5)
            );
        } elseif ($this->isLimit
            && $this->defenseBattleCharacter->limit_skill_code == BT_LIMIT_02
        ) {
            // コンセントレイト
            $this->defenseBattleCharacter->set('sp',
                ($this->defenseBattleCharacter->sp + 4)
            );
            $this->defenseBattleCharacter->set('permanent_hit_rate',
                ($this->defenseBattleCharacter->permanent_hit_rate + 20)
            );
            $this->defenseBattleCharacter->set('permanent_dodge_rate',
                ($this->defenseBattleCharacter->permanent_dodge_rate + 20)
            );
        }
        if ($this->isContinuous) {
            // 連続攻撃の場合は、防御側の防御コードを再セットしてもらうためにリセット
            $this->defenseBattleCharacter->set('defense_skill_code', 0);
            $this->defenseBattleCharacter->set('defense_skill_attribute', 0);
        }

        if ($this->isKo) {
            // KOの場合はHPをゼロに、マイナスにならないように最後に判定
            $this->defenseBattleCharacter->set('hp', 0);
        } elseif ($this->isResurrection) {
            // 底力が発動した場合はHPを１、SPとコンボは0にする
            $this->defenseBattleCharacter->set('hp', 1);
            $this->defenseBattleCharacter->set('sp', 0);
            $this->defenseBattleCharacter->set('combo', 0);
        } else {
            $this->defenseBattleCharacter->set('hp', ($this->defenseBattleCharacter->hp - $this->damage));
        }

        $connection = ConnectionManager::get('default');
        $connection->begin();

        if (!$this->BattleTurns->save($this->battleTurn)) {
            $connection->rollback();
            $this->log('The BattleTurns could not be saved.', 'error');
            $this->Flash->error(__('The BattleTurns could not be saved. Please, try again.'));
            return;
        }
        if (!$this->BattleCharacters->save($this->defenseBattleCharacter)) {
            $connection->rollback();
            $this->log('The defenseBattleCharacter could not be saved.', 'error');
            $this->Flash->error(__('The defenseBattleCharacter could not be saved. Please, try again.'));
            return;
        }
        if (!$this->BattleCharacters->save($this->attackBattleCharacter)) {
            $connection->rollback();
            $this->log('The attackBattleCharacter could not be saved.', 'error');
            $this->Flash->error(__('The attackBattleCharacter could not be saved. Please, try again.'));
            return;
        }

        $connection->commit();
    }

    public function determineDefenseSkillUp()
    {
        // 攻撃が当たっている場合は処理しない
        // かすり傷の場合は発動する
        if ($this->isHit == 1 && $this->isScratch != 1) {
            return;
        }
        if ($this->defenseBattleCharacter->defense_skill_code == BT_DF_KAUNTA
            && $this->momentum == BT_DF_ATTR_KAI
            && $this->attack_skill_code != BT_AT_HOMI
        ) {
            // カウンター
            $this->isCounter = 1;
            return;
        }
        if ($this->defenseBattleCharacter->defense_skill_code == BT_DF_KOUBOU
            && $this->momentum == BT_DF_ATTR_BOU
            && $this->attack_skill_code != BT_AT_GADO
        ) {
            // 攻防一体
            $this->isKoubouittai = 1;
            return;
        }
    }

    public function determineLimitSkill()
    {
        // 攻撃が当たっていない場合は処理しない
        // かすり傷の場合は処理する
        if ($this->isHit != 1) {
            return;
        }
        // 戦闘不能の場合は処理しない
        if ($this->isKo == 1) {
            return;
        }
        // すでに発動している場合は処理しない
        if ($this->defenseBattleCharacter->is_limit == 1) {
            return;
        }

        $borderline = round($this->attackBattleCharacter->hp / 2);
        $hp = ($this->defenseBattleCharacter->hp - $this->damage);

        // 発動しない場合は処理しない
        if ($borderline < $hp) {
            return;
        }
        // 発動
        $this->isLimit = 1;
    }

    public function determineResurrection()
    {
        // 戦闘不能でない場合は処理しない
        if ($this->isKo == 0) {
            return;
        }
        // 攻撃が当たっていない場合は処理しない
        if ($this->isHit != 1) {
            return;
        }

        // 底力確率 SP + (コンボ * 2)
        [$spot, $diseString] = $this->dice();
        $borderline = ($this->defenseBattleCharacter->sp);
        $borderline += ($this->defenseBattleCharacter->combo * 2);
        if ($spot <= $borderline) {
            $this->isResurrection = 1;
            $this->isKo = 0;
        }

        $format = Configure::read('Battle.narration.NARR_BATTLE_SOKOJIKARA');
        $this->isResurrectionString = __($format,
           $this->defenseBattleCharacter->sp,
           $this->defenseBattleCharacter->combo,
           $borderline,
           $diseString,
           ($this->isResurrection) ? '成功' : '失敗',
        );
    }

    public function determineKo()
    {
        $hp = ($this->defenseBattleCharacter->hp - $this->damage);
        if ($hp <= 0) {
            $this->isKo = 1;
            return;
        }
    }

    public function determineDualDrive()
    {
        // 覚醒スキルが発動していない場合は処理しない
        if ($this->attackBattleCharacter->is_limit != 1) {
            return;
        }
        // 覚醒スキルがデュアルドライブでない場合は処理しない
        if ($this->attackBattleCharacter->limit_skill_code != BT_LIMIT_03) {
            return;
        }
        // すでに連続攻撃していた場合は処理しない
        if ($this->attackBattleCharacter->continuous_turn_count > 0) {
            return;
        }

        // 攻撃が当たっていたら確定で連続、半減の場合は確定にしない
        if ($this->isHit == 1 && $this->isScratch != 1) {
            $this->isContinuous = 1;
            return;
        }
        // 特殊技だった場合は確定で連続
        if ($this->attack_skill_code == BT_AT_SENI
            || $this->attack_skill_code == BT_AT_SEISIN
        ) {
            $this->isContinuous = 1;
            return;
        }

        // 当たっていなかったら確率で連続 (20+dexterity*10)
        [$spot, $diseString] = $this->dice();
        $borderline = (20 + $this->attackBattleCharacter->dexterity * 10);
        if ($spot <= $borderline) {
            $this->isContinuous = 1;
        }

        $format = Configure::read('Battle.narration.NARR_BATTLE_RENZOKU');
        $this->isContinuousString = __($format,
            $this->attackBattleCharacter->dexterity,
            $borderline,
            $diseString,
            ($this->isContinuous) ? '成功' : '失敗',
        );
    }

    public function determineRecoverySp()
    {
        // 精神統一以外は処理しない
        if ($this->attack_skill_code != BT_AT_SEISIN) {
            return;
        }
        if($this->attackBattleCharacter->combo <= 0){
            // 不発
            return;
        }
        $this->useCombo = $this->attackBattleCharacter->combo;

        // 回復 コンボ数＊２+1
        $this->recoverySp = $this->useCombo * 2;
    }

    public function determineRecoveryHp()
    {
        // 戦意高揚以外は処理をしない
        if ($this->attack_skill_code != BT_AT_SENI) {
            return;
        }
        if($this->attackBattleCharacter->combo <= 0){
            // 不発
            return;
        }
        $this->useCombo = $this->attackBattleCharacter->combo;

        // 回復 コンボ数×4+2
        $this->recoveryHp = $this->useCombo * 4;
    }

    public function determineComboUp()
    {
        // 特殊技の場合は処理しない
        // コンビネーションの場合は処理しない
        if ($this->attack_skill_code == BT_AT_SENI
            || $this->attack_skill_code == BT_AT_SEISIN
            || $this->attack_skill_code == BT_AT_KONBI
        ) {
            return;
        }
        // 通常攻撃でなければ処理しない
        if ($this->useKillSp != 0) {
            return;
        }
        // 命中しなければ処理しない
        if ($this->isHit != 1) {
            return;
        }
        // かすり傷の場合は処理しない
        if ($this->isScratch == 1) {
            return;
        }

        $this->comboUp = 1;
    }

    public function calculateDamage()
    {
        $attackSkillCode = $this->attack_skill_code;
        $attackSkillAttribute = $this->attack_skill_attribute;
        $defenseSkillCode = $this->defenseBattleCharacter->defense_skill_code;

        // 特殊スキルの時にはダメージ計算をしない
        if ($attackSkillCode == BT_AT_SENI || $attackSkillCode == BT_AT_SEISIN) {
            return;
        }
        // 攻撃が当たっていない場合は処理しない
        // かすり傷は処理
        if ($this->isHit != 1) {
            return;
        }

        // 攻撃スキル補正
        $correctionASkill = 0;
        if(($attackSkillCode == BT_AT_BUI_01 && $attackSkillAttribute == BT_ATTR_01)
            || ($attackSkillCode == BT_AT_BUI_02 && $attackSkillAttribute == BT_ATTR_02)
            || ($attackSkillCode == BT_AT_BUI_03 && $attackSkillAttribute == BT_ATTR_03)
            || ($attackSkillCode == BT_AT_BUI_04 && $attackSkillAttribute == BT_ATTR_04)
        ) {
            $correctionASkill = 2;
        }

        // 必殺補正
        $killRate = 1;
        if ($this->useKillSp == 2) {
            $killRate = 1.25;
        } elseif ($this->useKillSp == 3) {
            $killRate = 2;
        } elseif ($this->useKillSp == 4) {
            $killRate = 2.5;
        }

        // 明鏡覚悟
        $meikyouKakugo = 1;
        if($this->useKillSp > 0 && $attackSkillCode == BT_AT_MEIKYO && $defenseSkillCode == BT_DF_KAKUGO) {
            $meikyouKakugo = 2;
        } elseif ($this->useKillSp > 0 && $attackSkillCode == BT_AT_MEIKYO) {
            $meikyouKakugo = 0.75;
        } elseif ($this->useKillSp > 0 && $defenseSkillCode == BT_DF_KAKUGO) {
            $meikyouKakugo = 0.5;
        }

        // かすり傷
        $scratch = 1;
        if ($this->isScratch) {
            $scratch = 0.5;
        }

        // {(5+strength)+(攻撃スキル補正)+(恒久補正+一時補正)}*(必殺掛け率)*(明鏡覚悟)*（かすり傷）
        $damage = (5 + $this->attackBattleCharacter->strength);
        $damage += $correctionASkill;
        $damage += $this->attackBattleCharacter->permanent_strength;
        $damage += $this->attackBattleCharacter->temporary_strength;
        $damage = $damage * $killRate;
        $damage = $damage * $meikyouKakugo;
        $damage = $damage * $scratch;
        $damage = round($damage);

        $format = Configure::read('Battle.narration.NARR_BATTLE_DMG');
        $damageString = __($format,
            $this->attackBattleCharacter->strength,
            $correctionASkill,
            $this->attackBattleCharacter->permanent_strength,
            $this->attackBattleCharacter->temporary_strength,
            $killRate,
            $meikyouKakugo,
            $scratch,
            $damage,
        );
        $this->damage = $damage;
        $this->damageString = $damageString;
    }

    public function determineKill()
    {
        // 通常の場合は処理しない
        if ($this->attack_kill == 0) {
            return;
        }
        // 特殊技の場合は処理しない
        if ($this->attack_skill_code == BT_AT_SENI
            || $this->attack_skill_code == BT_AT_SEISIN
        ) {
            return;
        }

        $useKillSp = ($this->attackBattleCharacter->sp) - ($this->attack_kill);
        if ($useKillSp < 0) {
            // SP が足りない場合は通常
            $this->useKillSp = 0;
            return;
        }
        $this->useKillSp = $this->attack_kill;
    }

    public function determineScratch() {
        // フラグが立っていない場合は処理しない
        if ($this->isDetermineScratch != 1) {
            return;
        }
        // 攻撃が外れている場合のみ処理
        if ($this->isHit != 0) {
            return;
        }

        // かすり傷
        // (20+dexterity*10)
        $borderline = (20 + $this->attackBattleCharacter->dexterity * 10);
        [$spot, $diseString] = $this->dice();
        $result = 0;
        if ($spot <= $borderline) {
            $result = 1;
        }

        // 命中率
        // (20+dexterity*10)
        $format = Configure::read('Battle.narration.NARR_BATTLE_KASURI');
        $resultString = __($format,
            $this->attackBattleCharacter->dexterity,
            $borderline,
            $diseString,
            ($result ? '成功' : '失敗')
        );
        $this->isDetermineScratchString = $resultString;

        $this->isScratch = $result;
        $this->isHit = $result;
    }


    /*
     * 戦闘用なので1d100で固定実装
     */
    public function dice() {
        $spot = rand(1, 100);
        $diseString = __('[Dice]1d100...{0}', $spot);

        return [$spot, $diseString];
    }

    public function determineVsSkill()
    {
        $attackSkillCode = $this->attack_skill_code;
        $defenseSkillCode = $this->defenseBattleCharacter->defense_skill_code;
        $attackSkillAttribute = $this->attack_skill_attribute;
        $defenseSkillAttribute = $this->defenseBattleCharacter->defense_skill_attribute;

        // 戦意高揚 (4/4 : 0 : 0) = (当たり ： ダイス ： 外れ)
        // 精神統一 (4/4 : 0 : 0) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_SENI
            || $attackSkillCode == BT_AT_SEISIN
        ) {
            $this->isHit = -1;
            $this->momentum = "";
            return;
        }
        // ホーミング vs 乱数回避 (4/4 : 0 : 0) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_HOMI && $defenseSkillCode == BT_DF_RAN) {
            $this->isHit = 1;
            $this->momentum = "";
            return;
        }
        // ガードブレイク vs 防御専念 (3/4 : 0 : 1/4) = (当たり ： ダイス ： 外れ)
        // ホーミング vs 回避専念 (3/4 : 0 : 1/4) = (当たり ： ダイス ： 外れ)
        if( ($attackSkillCode == BT_AT_GADO && $defenseSkillCode == BT_DF_BOU)
            || ($attackSkillCode == BT_AT_HOMI && $defenseSkillCode == BT_DF_KAI)
        ) {
            if($this->compatibility == BT_COM_FURI) {
                $this->isHit = 1;
                $this->momentum = "";
            } elseif ($this->compatibility == BT_COM_YUURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_SOUSAI;
            } else {
                $this->isHit = 1;
                $this->momentum = "";
            }
            return;
        }
        // ガードブレイク vs 回避専念 (1/4 : 0 : 3/4) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_GADO && $defenseSkillCode == BT_DF_KAI) {
            if($this->compatibility == BT_COM_FURI) {
                $this->isHit = 1;
                $this->momentum = "";
            } elseif ($this->compatibility == BT_COM_YUURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_KAI;
            } else {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_KAI;
            }
            return;
        }
        // ホーミング vs 防御専念 (1/4 : 0 : 3/4) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_HOMI && $defenseSkillCode == BT_DF_BOU) {
            if($this->compatibility == BT_COM_FURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_BOU;
            } elseif ($this->compatibility == BT_COM_YUURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_BOU;
            } else {
                if($attackSkillAttribute == $defenseSkillAttribute) {
                    $this->isHit = 1;
                    $this->momentum = "";
                } else {
                    $this->isHit = 0;
                    $this->momentum = BT_DF_ATTR_BOU;
                }
            }
            return;
        }
        // 乱数回避
        if ($defenseSkillCode == BT_DF_RAN) {
            $this->isHit = $this->determineHit();
            $this->momentum = BT_DF_ATTR_KAI;
            $this->isDetermineScratch = 1;
            return;
        }
        // ガードブレイク vs XX (1/4 : 2/4 : 1/4) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_GADO) {
            if($this->compatibility == BT_COM_FURI) {
                $this->isHit = 1;
                $this->momentum = "";
            } elseif ($this->compatibility == BT_COM_YUURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_SOUSAI;
            } else {
                $this->isHit = $this->determineHit();
                $this->momentum = BT_DF_ATTR_KAI;
                $this->isDetermineScratch = 1;
            }
            return;
        }
        // ホーミング vs XX (1/4 : 1/4 : 2/4) = (当たり ： ダイス ： 外れ)
        if($attackSkillCode == BT_AT_HOMI) {
            if($this->compatibility == BT_COM_FURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_BOU;
            } elseif ($this->compatibility == BT_COM_YUURI) {
                $this->isHit = 0;
                $this->momentum = BT_DF_ATTR_BOU;
            } else {
                if($attackSkillAttribute == $defenseSkillAttribute) {
                    $this->isHit = 1;
                    $this->momentum = "";
                } else {
                    $this->isHit = $this->determineHit();
                    $this->momentum = BT_DF_ATTR_SOUSAI;
                    $this->isDetermineScratch = 1;
                }
            }
            return;
        }
        // 通常 (1/4 : 2/4 : 1/4) = (当たり ： ダイス ： 外れ)
        if($this->compatibility == BT_COM_FURI) {
            $this->isHit = 0;
            $this->momentum = BT_DF_ATTR_BOU;
            return;
        } elseif ($this->compatibility == BT_COM_YUURI) {
            $this->isHit = 1;
            $this->momentum = "";
            return;
        } else {
            $this->isHit = $this->determineHit();
            $this->momentum = BT_DF_ATTR_KAI;
            $this->isDetermineScratch = 1;
            return;
        }
    }

    public function determineHit() {
        $attackSkillCode = $this->attack_skill_code;
        $defenseSkillCode = $this->defenseBattleCharacter->defense_skill_code;
        $attackSkillAttribute = $this->attack_skill_attribute;
        $defenseSkillAttribute = $this->defenseBattleCharacter->defense_skill_attribute;

        // 攻撃スキル補正
        $correctionASkill = 0;
        if(($attackSkillCode == BT_AT_SEI_01 && $attackSkillAttribute == BT_ATTR_01)
            || ($attackSkillCode == BT_AT_SEI_02 && $attackSkillAttribute == BT_ATTR_02)
            || ($attackSkillCode == BT_AT_SEI_03 && $attackSkillAttribute == BT_ATTR_03)
            || ($attackSkillCode == BT_AT_SEI_04 && $attackSkillAttribute == BT_ATTR_04)
        ) {
            $correctionASkill = 35;
        }

        // 防御スキル補正
        $correctionDSkill = 0;
        if($defenseSkillCode == BT_DF_BOU || $defenseSkillCode == BT_DF_KAI
        ) {
            $correctionDSkill = 25;
        }
        if($defenseSkillCode == BT_DF_RAN) {
            $correctionDSkill = 15;
        }
        if($defenseSkillCode == BT_DF_KAUNTA) {
            $correctionDSkill = 15;
        }

        // 判定
        $borderline = (20 + $this->attackBattleCharacter->dexterity * 10);
        $borderline += $correctionASkill;
        $borderline += $this->attackBattleCharacter->permanent_hit_rate;
        $borderline += $this->attackBattleCharacter->temporary_hit_rate;
        $borderline -= $correctionDSkill;
        $borderline -= $this->defenseBattleCharacter->permanent_dodge_rate;
        $borderline -= $this->defenseBattleCharacter->temporary_dodge_rate;

        [$spot, $diseString] = $this->dice();
        $result = 0;
        if ($spot <= $borderline) {
            $result = 1;
        }

        // 命中率
        // (20+dexterity*10)+(攻撃スキル補正)+(恒久補正+一時補正)
        //  -（防御スキル補正+防御恒久補正+防御一時補正） = (命中率)%/ダイス/結果
        $format = Configure::read('Battle.narration.NARR_BATTLE_MEITYU');
        $resultString = __($format,
            $this->attackBattleCharacter->dexterity,
            $correctionASkill,
            $this->attackBattleCharacter->permanent_hit_rate,
            $this->attackBattleCharacter->temporary_hit_rate,
            $correctionDSkill,
            $this->defenseBattleCharacter->permanent_dodge_rate,
            $this->defenseBattleCharacter->temporary_dodge_rate,
            $borderline,
            $diseString,
            ($result ? '成功' : '失敗')
        );
        $this->isHitString = $resultString;

        return $result;
    }

    public function determineMomentum()
    {
        $attackSkillAttribute = $this->attack_skill_attribute;
        $defenseSkillAttribute = $this->defenseBattleCharacter->defense_skill_attribute;

        // 不利
        if ( ($attackSkillAttribute == BT_ATTR_01 && $defenseSkillAttribute == BT_ATTR_04)
            || ($attackSkillAttribute == BT_ATTR_04 && $defenseSkillAttribute == BT_ATTR_03)
            || ($attackSkillAttribute == BT_ATTR_03 && $defenseSkillAttribute == BT_ATTR_02)
            || ($attackSkillAttribute == BT_ATTR_02 && $defenseSkillAttribute == BT_ATTR_01)
        ) {
            $this->compatibility = BT_COM_FURI;
            return;
        }
        // 有利
        if ( ($attackSkillAttribute == BT_ATTR_01 && $defenseSkillAttribute == BT_ATTR_02)
            || ($attackSkillAttribute == BT_ATTR_02 && $defenseSkillAttribute == BT_ATTR_03)
            || ($attackSkillAttribute == BT_ATTR_03 && $defenseSkillAttribute == BT_ATTR_04)
            || ($attackSkillAttribute == BT_ATTR_04 && $defenseSkillAttribute == BT_ATTR_01)
        ) {
            $this->compatibility = BT_COM_YUURI;
            return;
        }
        // 拮抗
        $this->compatibility = BT_COM_KIKKOU;
    }

    public function determineUseCommbo()
    {
        // コンボを使用しないスキルは判定しない
        if ($this->attack_skill_code != BT_AT_KONBI
            && $this->attack_skill_code != BT_AT_SENI
            && $this->attack_skill_code != BT_AT_SEISIN
        ) {
            return;
        }
        if($this->attackBattleCharacter->combo <= 0){
            // 不発
            $this->useCombo = 0;
            return;
        }
        // 当たらなくてもコンボは減らす
        $this->useCombo = $this->attackBattleCharacter->combo;
    }

    public function determineCombinationUp()
    {
        // コンビネーションでない場合は判定しない
        if ($this->attack_skill_code != BT_AT_KONBI
        ) {
            return;
        }
        // コンボを使用しないならば判定しない
        if($this->useCombo <= 0){
            return;
        }
        $this->attackBattleCharacter->temporary_strength += $this->useCombo + 1;
        $this->attackBattleCharacter->temporary_hit_rate += $this->useCombo * 10;
    }

}
