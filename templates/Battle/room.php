<?php
if ($chatRoomCss) {
    $this->Html->css($chatRoomCss, ['block' => true]);
}
?>
<?= $this->Form->create($chatLog, ['id' => "id-battleform", 'class'=> 'row']) ?>
<aside class="column">
    <div class="form content" >
        <?php echo $this->element('battle_form'); ?>
    </div>
</aside>
<div class="column-responsive column-75" >
    <div class="form content" >
        <?php echo $this->element('battle_chat_form'); ?>
    </div>
    <div class="content" >
        <?php echo $this->element('battle_commentary'); ?>
    </div>
    <?php echo $this->element('chat_entries_list'); ?>
    <?php echo $this->element('chat_log'); ?>
</div>
<?= $this->Form->end() ?>
<script>
jQuery(function(){
    jQuery('#id-defense-set-button').on('click', function(){
        var sendData = jQuery('#id-battleform').serializeArray();
        jQuery.ajax({
            data: sendData,
            url: '<?php echo $this->Url->build([
                        'controller' => 'Battle',
                        'action' => 'defenseSet',
                        $chatRoomId,
                    ]); ?>',
            type: 'POST',
        }).done(function (data, status, jqXHR) {
            jQuery('#id-reload-log-button').trigger('click');
        }).fail(function (jqXHR, status, error) {
            console.log(error);
        }).always(() => {
            console.log('defenseSet');
        });
    });
    jQuery('#is-attack-label').on('click', function(){
        console.log('is_attack');
        var checkbox = jQuery('#id-is-attack');
        var button = jQuery('#id-send-battle-message-button');
        if (checkbox.prop('checked')){
            button.addClass('warning');
            button.text('攻撃実行');
        } else {
            button.removeClass('warning');
            button.text('送信');
        }
    });
    jQuery('#id-reload-log-button').on('click', function(){
        jQuery('#id-chatentrieslist-reload').trigger('click');
        jQuery('#id-chatlog-reload').trigger('click');
        jQuery('#id-battlecommentary-reload').trigger('click');
        return false;
    });
});
var battleform = new Vue({
    el: '#id-battleform',
    data: {
    },
    methods: {
        sendBattleMessage: function (event) {
            var self = this;
            console.log('send');
            var mesObj = jQuery('#message');
            var message = mesObj.val();
            message = jQuery.trim(message);
            if (!message) return;
            mesObj.val(message);

            var errObj = jQuery('#id-send-error-message');

            var sendData = jQuery('#id-battleform').serializeArray();
            jQuery.ajax({
                data: sendData,
                url: '<?php echo $this->Url->build([
                            'controller' => 'Battle',
                            'action' => 'attackSet',
                            $chatRoomId,
                        ]); ?>',
                type: 'post',
                dataType: 'json',
            }).done(function (data, status, jqXHR) {
                if (data['code'] != 200) {
                    errMessage = "";
                    if (jQuery.inArray('message', data)) errMessage = data['message'];
                    errObj.text(errMessage);
                    return;
                }

                // チェックボックスのリセット
                var checkbox = jQuery('#id-is-attack');
                var button = jQuery('#id-send-battle-message-button');
                if (checkbox.prop('checked')) {
                    checkbox.removeAttr('checked').prop('checked', false).change();
                    button.removeClass('warning');
                    button.text('送信');
                }

                mesObj.val('');
                errObj.text('');
                self.reloadLog();
            }).fail(function (jqXHR, status, error) {
                console.log(error);
            }).always(() => {
            });
        },
        reloadLog: function () {
            jQuery('#id-reload-log-button').trigger('click');
        }
    },
});
</script>
