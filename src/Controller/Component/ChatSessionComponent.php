<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;

class ChatSessionComponent extends Component
{
    use ModelAwareTrait;

    private $session;
    private $chatCharacterId;

    public function initialize($config): void
    {
        parent::initialize($config);

        $this->loadModel('BattleTurns');
    }

    public function set($session)
    {
        $this->session = $session;
    }

    public function delete()
    {
        $this->session->delete('Tmp');
        $key = __('ChatController.{0}', $this->chatCharacterId);
        $this->session->delete('ChatController');
        $key = __('BattleController.{0}', $this->chatCharacterId);
        $this->session->delete('BattleController');
    }

    public function setChatCharacterId($value)
    {
        $this->session->write('Tmp.chat_character_id', $value);
        $this->chatCharacterId = $value;
    }
    public function getChatCharacterId()
    {
        return $this->session->read('Tmp.chat_character_id');
    }

    public function setOpenLogWindow($value)
    {
        $this->session->write('Tmp.OpenLogWindow', $value);
    }
    public function getOpenLogWindow()
    {
        return $this->session->read('Tmp.OpenLogWindow');
    }

    public function setChatNote($value)
    {
        $key = __('ChatController.{0}.Note', $this->chatCharacterId);
        $this->session->write($key, $value);
    }
    public function getChatNote()
    {
        $key = __('ChatController.{0}.Note', $this->chatCharacterId);
        return $this->session->read($key);
    }

    public function setBattleSaveSkill($value)
    {
        $key = __('BattleController.{0}.BattleSaveSkill', $this->chatCharacterId);
        $this->session->write($key, $value);
    }
    public function getBattleSaveSkill()
    {
        $key = __('BattleController.{0}.BattleSaveSkill', $this->chatCharacterId);
        return $this->session->read($key);
    }

    public function setBattleTurn($value)
    {
        $key = __('BattleController.{0}.BattleTurn', $this->chatCharacterId);
        $this->session->write($key, $value);
    }
    public function getBattleTurn()
    {
        $key = __('BattleController.{0}.BattleTurn', $this->chatCharacterId);
        $value = $this->session->read($key);
        if (!$value) return $value;

        $battleTurn = $this->BattleTurns->find() // バトルターンは常に最新にする
            ->where(['id' => $value->id])
            ->first();
        $this->session->write($key, $battleTurn);
        return $battleTurn;
    }
}
