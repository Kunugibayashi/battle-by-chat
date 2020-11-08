<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReceivedMessage[]|\Cake\Collection\CollectionInterface $receivedMessages
 */
?>
<div class="receivedMessages index content">
    <?= $this->Html->link(__('New Received Message'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Received Messages') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_fullname') ?></th>
                    <th><?= $this->Paginator->sort('from_chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('from_chat_character_fullname') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receivedMessages as $receivedMessage): ?>
                <tr>
                    <td><?= $this->Number->format($receivedMessage->id) ?></td>
                    <td><?= $receivedMessage->has('user') ? $this->Html->link($receivedMessage->user->id, ['controller' => 'Users', 'action' => 'view', $receivedMessage->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($receivedMessage->chat_character_key) ?></td>
                    <td><?= h($receivedMessage->chat_character_fullname) ?></td>
                    <td><?= $this->Number->format($receivedMessage->from_chat_character_key) ?></td>
                    <td><?= h($receivedMessage->from_chat_character_fullname) ?></td>
                    <td><?= h($receivedMessage->title) ?></td>
                    <td><?= h($receivedMessage->modified) ?></td>
                    <td><?= h($receivedMessage->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $receivedMessage->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $receivedMessage->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $receivedMessage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receivedMessage->id)]) ?>
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
