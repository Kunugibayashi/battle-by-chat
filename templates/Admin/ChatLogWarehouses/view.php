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
            <?= $this->Html->link(__('Edit Chat Log Warehouse'), ['action' => 'edit', $chatLogWarehouse->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chat Log Warehouse'), ['action' => 'delete', $chatLogWarehouse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatLogWarehouse->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chat Log Warehouses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chat Log Warehouse'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatLogWarehouses view content">
            <h3><?= h($chatLogWarehouse->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Entry Key') ?></th>
                    <td><?= h($chatLogWarehouse->entry_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Room Title') ?></th>
                    <td><?= h($chatLogWarehouse->chat_room_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chatLogWarehouse->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($chatLogWarehouse->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($chatLogWarehouse->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Characters') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($chatLogWarehouse->characters)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Logs') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($chatLogWarehouse->logs)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
