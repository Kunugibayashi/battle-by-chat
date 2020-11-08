<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLog[]|\Cake\Collection\CollectionInterface $chatLogs
 */
?>
<div class="chatLogs index content">
    <?= $this->Html->link(__('New Chat Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Chat Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('entry_key') ?></th>
                    <th><?= $this->Paginator->sort('chat_room_key') ?></th>
                    <th><?= $this->Paginator->sort('chat_room_title') ?></th>
                    <th><?= $this->Paginator->sort('chat_room_information') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('backgroundcolor') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('fullname') ?></th>
                    <th><?= $this->Paginator->sort('note') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatLogs as $chatLog): ?>
                <tr>
                    <td><?= $this->Number->format($chatLog->id) ?></td>
                    <td><?= h($chatLog->entry_key) ?></td>
                    <td><?= $this->Number->format($chatLog->chat_room_key) ?></td>
                    <td><?= h($chatLog->chat_room_title) ?></td>
                    <td><?= h($chatLog->chat_room_information) ?></td>
                    <td><?= h($chatLog->color) ?></td>
                    <td><?= h($chatLog->backgroundcolor) ?></td>
                    <td><?= $this->Number->format($chatLog->chat_character_key) ?></td>
                    <td><?= h($chatLog->fullname) ?></td>
                    <td><?= h($chatLog->note) ?></td>
                    <td><?= h($chatLog->modified) ?></td>
                    <td><?= h($chatLog->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $chatLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatLog->id)]) ?>
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
