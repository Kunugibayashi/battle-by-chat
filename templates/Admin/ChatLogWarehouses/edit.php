<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLogWarehouse $chatLogWarehouse
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chatLogWarehouse->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chatLogWarehouse->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Chat Log Warehouses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatLogWarehouses form content">
            <?= $this->Form->create($chatLogWarehouse) ?>
            <fieldset>
                <legend><?= __('Edit Chat Log Warehouse') ?></legend>
                <?php
                    echo $this->Form->control('entry_key');
                    echo $this->Form->control('chat_room_title');
                    echo $this->Form->control('characters');
                    echo $this->Form->control('logs');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
