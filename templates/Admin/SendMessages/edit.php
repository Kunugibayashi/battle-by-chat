<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SendMessage $sendMessage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sendMessage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sendMessage->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Send Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sendMessages form content">
            <?= $this->Form->create($sendMessage) ?>
            <fieldset>
                <legend><?= __('Edit Send Message') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('chat_character_key');
                    echo $this->Form->control('chat_character_fullname');
                    echo $this->Form->control('to_chat_character_key');
                    echo $this->Form->control('to_chat_character_fullname');
                    echo $this->Form->control('title');
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
