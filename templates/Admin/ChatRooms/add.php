<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatRoom $chatRoom
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Chat Rooms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatRooms form content">
            <?= $this->Form->create($chatRoom) ?>
            <fieldset>
                <legend><?= __('Add Chat Room') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('information', ['type' => 'textarea']);
                    echo $this->Form->control('published');
                    echo $this->Form->control('readonly');
                    echo $this->Form->control('displayno');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
