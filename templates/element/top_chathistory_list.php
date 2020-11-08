<div class="content" id="id-chathistory">
    <header class="content-header">
        <h3><?= __('履歴') ?></h3>
    </header>
    <div class="table-responsive" id="id-chathistory-table">
    </div>
</div>
<script>
jQuery(function(){
    var getChatHistory = function() {
        var getChatHistoryTimerObj;
        jQuery.ajax({
            url: '<?php echo $this->Url->build(['controller' => 'Chat', 'action' => 'topListTable',]); ?>',
            type: 'GET',
            dataType: 'html',
        }).done(function (data, status, jqXHR) {
            jQuery('#id-chathistory-table').html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(error);
        }).always(() => {
            console.log('getChatHistory');
            clearInterval(this.getChatHistoryTimerObj);
            this.getChatHistoryTimerObj = setInterval(function() {
                getChatHistory();
            }, 20 * 1000);
        });
    }
    getChatHistory();
});
</script>
