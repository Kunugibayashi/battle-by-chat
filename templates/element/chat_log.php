<div class="chatlog" id="id-chatlog">
    <!-- 他画面から呼ぶためにリロードボタンを定義 -->
    <button id="id-chatlog-reload" class="button-hidden" type="button"></button>
    <button id="id-open-log-window" class="button-hidden" type="button"></button>
<?php if (isset($openLogWindow)) {?>
    <input id="id-open-log-window-value" type="hidden" value="<?= $openLogWindow ?>"></input>
<?php } ?>
    <div id="id-chatlog-data">
    </div>
</div>
<script>
jQuery(function(){
    var childLogWindow;
    function openLogWindow () {
        var windowName = '<?php echo "room" .$chatRoomId; ?>';
        var url = '<?php echo $this->Url->build([
                    'controller' => 'Chat',
                    'action' => 'chatLogWindow',
                    $chatRoomId,
                    1,
                ]); ?>';
        childLogWindow = window.open(url, windowName, );
        jQuery('#id-open-log-window-value').val(1);
    };
    jQuery('#id-open-log-window').on('click', function(){
        openLogWindow();
    });
    var getChatLogList = function() {
        var getChatLogListTimerObj;
        jQuery.ajax({
            url: '<?php echo $this->Url->build([
                        'controller' => 'Chat',
                        'action' => 'chatLog',
                        $chatRoomId,
                        "?" => ['limit' => 25],
                    ]); ?>',
            type: 'GET',
            dataType: 'html',
        }).done(function (data, status, jqXHR) {
            jQuery('#id-chatlog-data').html(data);

            if (childLogWindow) {
                // 別窓が表示されていたら更新
                jQuery('#id-chat-log-content', childLogWindow.document).html(data);
            } else {
                // 別窓が表示されておらず、別窓表示の場合はウィンドウ更新する
                var isOpenLogWindow = jQuery('#id-open-log-window-value').val();
                if (isOpenLogWindow == 1) {
                    openLogWindow();
                }
            }
        }).fail(function (jqXHR, status, error) {
            console.log(error);
        }).always(() => {
            console.log('getChatLogList');
            clearInterval(this.getChatLogListTimerObj);
            this.getChatLogListTimerObj = setInterval(function() {
                getChatLogList();
            }, 20 * 1000);
        });
    }
    getChatLogList();
    jQuery('#id-chatlog-reload').on('click', function(){
        getChatLogList();
        return false;
    });
});
</script>
