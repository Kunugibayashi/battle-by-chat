<?= $this->Form->create(null, [
    'id' => 'id-chatentry-form',
    'url' => [
        'action' => 'enter',
        $chatRoomId,
    ]
]); ?>
<?= $this->Form->control('chat_character_id', ['label' => 'キャラクター名', 'options' => $chatCharacters]); ?>
<div class="button-container">
    <?= $this->Form->button(__('入室')) ?>
    <?= $this->Form->button(__('リロード'), [
            'type' => 'button',
            'id' => 'id-reload-log-button',
        ]) ?>
</div>
<?= $this->Form->end() ?>
<script>
jQuery(function(){
    jQuery('#id-reload-log-button').on('click', function(){
        jQuery('#id-chatentrieslist-reload').trigger('click');
        jQuery('#id-chatlog-reload').trigger('click');
    });
});
</script>
