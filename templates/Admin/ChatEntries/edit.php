<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatEntry $chatEntry
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chatEntry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chatEntry->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Chat Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatEntries form content">
            <?= $this->Form->create($chatEntry) ?>
            <fieldset>
                <legend><?= __('Edit Chat Entry') ?></legend>
                <?php
                    echo $this->Form->control('chat_room_id', ['options' => $chatRooms]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('chat_character_id', ['options' => $chatCharacters]);
                    echo $this->Form->control('entry_key');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
