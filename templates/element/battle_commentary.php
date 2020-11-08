<div class="battlecommentary" id="id-battlecommentary">
    <!-- 他画面から呼ぶためにリロードボタンを定義 -->
    <button id="id-battlecommentary-reload" class="button-hidden" type="button"></button>
    <div id="id-battlecommentary-data">
    </div>
</div>
<script>
jQuery(function(){
    var getBattleCommentary = function() {
        var getBattleCommentaryTimerObj;
        jQuery.ajax({
            url: '<?php echo $this->Url->build([
                            'controller' => 'Battle',
                            'action' => 'commentary',
                            $chatRoomId,
                            "?" => ['battle_id' => $battleTurn->id ],
                        ]); ?>',
            type: 'GET',
            dataType: 'html',
        }).done(function (data, status, jqXHR) {
            jQuery('#id-battlecommentary-data').html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(error);
        }).always(() => {
            console.log('getBattleCommentary');
            clearInterval(this.getBattleCommentaryTimerObj);
            this.getBattleCommentaryTimerObj = setInterval(function() {
                getBattleCommentary();
            }, 20 * 1000);
        });
    }
    getBattleCommentary();
    jQuery('#id-battlecommentary-reload').on('click', function(){
        getBattleCommentary();
        return false;
    });
});
</script>
