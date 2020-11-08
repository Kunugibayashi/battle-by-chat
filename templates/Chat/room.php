<?php
if ($chatRoomCss) {
    $this->Html->css($chatRoomCss, ['block' => true]);
}
?>
<div class="row">
    <aside class="column">
        <div class="form content" >
            <?php echo $this->element('battle_entry_form'); ?>
        </div>
    </aside>
    <div class="column-responsive column-75" >
        <div class="form content" >
            <?php echo $this->element('chat_form'); ?>
        </div>
        <div class="form content" >
            <?php echo $this->element('chat_dice_form'); ?>
        </div>
        <?php echo $this->element('chat_entries_list'); ?>
        <?php echo $this->element('chat_log'); ?>
    </div>
</div>
