<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReceivedMessage $receivedMessage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Received Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="receivedMessages form content">
            <?= $this->Form->create($receivedMessage) ?>
            <fieldset>
                <legend><?= __('Add Received Message') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('chat_character_key');
                    echo $this->Form->control('chat_character_fullname');
                    echo $this->Form->control('from_chat_character_key');
                    echo $this->Form->control('from_chat_character_fullname');
                    echo $this->Form->control('title');
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
