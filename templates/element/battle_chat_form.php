<?php
if (!$battleTurn || $battleTurn->battle_status == BT_ST_KETYAKU) {
    return;
}
?>
<fieldset>
    <legend><?php echo h($chatCharacter->fullname); ?></legend>
    <?php
        echo $this->Form->control('message', [
            'label' => '発言',
            'maxlength' => '3000',
            'placeholder' => 'Ctrl + Enter で 発言',
            'v-on:keydown.ctrl.enter' => 'sendBattleMessage',
        ]);
        echo $this->Html->link(__('使用可能タグ一覧'), ['controller' => 'Chat', 'action' => 'htmlTagList'], ['target' => '_blank']);
        echo $this->Form->control('note', ['label' => '備考',]);

        echo $this->Form->hidden('entry_key');
        echo $this->Form->hidden('chat_room_key');
        echo $this->Form->hidden('chat_character_key');
    ?>
    <div id="id-send-error-message"></div>
</fieldset>
<div class="button-container">
    <?= $this->Form->button(__('送信'), [
            'id' => 'id-send-battle-message-button',
            'type' => 'button',
            'v-on:click' => 'sendBattleMessage',
        ]) ?>
    <?= $this->Form->button(__('リロード'), [
            'type' => 'button',
            'id' => 'id-reload-log-button',
        ]) ?>
    <?= $this->Form->button(__('別ウィンドウでログを表示する'), [
            'type' => 'button',
            'id' => 'id-open-log-window-button',
        ]) ?>
    <?= $this->Form->button(__('戦闘中断'), [
            'type' => 'submit',
            'class' => 'warning',
            'formaction' => $this->Url->build([
                        'controller' => 'Battle',
                        'action' => 'suspend',
                        $chatRoomId,
                    ]),
        ]) ?>
</div>
<script>
jQuery(function(){
    jQuery('#id-open-log-window-button').on('click', function(){
        jQuery('#id-open-log-window').trigger('click');
    });
});
</script>
