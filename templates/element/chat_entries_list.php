<?php
/*
 * 個別呼び出しの際、独立して動かせるようにするため、スタイルを記載する
 */
?>
<style>
.namelist-name {
    display: inline-block;
    padding: 0.5rem;
    margin: 0 0.5rem;
    border-radius: 0.5rem;
}
#id-chatentrieslist {
    border-bottom: inset 1px;
    padding-bottom: 1rem;
    margin: 0.5rem 0;
}
#id-chatentrieslist-characters {
    display: inline-block;
}
</style>
<div id="id-chatentrieslist">
    <!-- 他画面から呼ぶためにリロードボタンを定義 -->
    <button id="id-chatentrieslist-reload" class="button-hidden" type="button"></button>
    参加者：<div id="id-chatentrieslist-characters"></div>
</div>
<script>
jQuery(function(){
    var getChatEntrieslist = function() {
        var getChatEntrieslistTimerObj;
        jQuery.ajax({
            url: '<?php echo $this->Url->build([
                    'controller' => 'chatEntries',
                    'action' => 'topList',
                    $chatRoomId,
                ]); ?>',
            type: 'GET',
            dataType: 'html',
        }).done(function (data, status, jqXHR) {
            jQuery('#id-chatentrieslist-characters').html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(error);
        }).always(() => {
            console.log('getChatEntrieslist');
            clearInterval(this.getChatEntrieslistTimerObj);
            this.getChatEntrieslistTimerObj = setInterval(function() {
                getChatEntrieslist();
            }, 20 * 1000);
        });
    }
    getChatEntrieslist();
    jQuery('#id-chatentrieslist-reload').on('click', function(){
        getChatEntrieslist();
        return false;
    });
});
</script>
