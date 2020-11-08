<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLogWarehouse[]|\Cake\Collection\CollectionInterface $chatLogWarehouses
 */
?>
<div class="chatLogWarehouses index content">
    <?= $this->Html->link(__('New Chat Log Warehouse'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Chat Log Warehouses') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('entry_key') ?></th>
                    <th><?= $this->Paginator->sort('chat_room_title') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatLogWarehouses as $chatLogWarehouse): ?>
                <tr>
                    <td><?= $this->Number->format($chatLogWarehouse->id) ?></td>
                    <td><?= h($chatLogWarehouse->entry_key) ?></td>
                    <td><?= h($chatLogWarehouse->chat_room_title) ?></td>
                    <td><?= h($chatLogWarehouse->modified) ?></td>
                    <td><?= h($chatLogWarehouse->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $chatLogWarehouse->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatLogWarehouse->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatLogWarehouse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatLogWarehouse->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
