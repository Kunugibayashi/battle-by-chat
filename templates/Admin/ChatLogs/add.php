<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLog $chatLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Chat Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatLogs form content">
            <?= $this->Form->create($chatLog) ?>
            <fieldset>
                <legend><?= __('Add Chat Log') ?></legend>
                <?php
                    echo $this->Form->control('entry_key');
                    echo $this->Form->control('chat_room_key');
                    echo $this->Form->control('chat_room_title');
                    echo $this->Form->control('chat_room_information');
                    echo $this->Form->control('color');
                    echo $this->Form->control('backgroundcolor');
                    echo $this->Form->control('chat_character_key');
                    echo $this->Form->control('fullname');
                    echo $this->Form->control('note');
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
