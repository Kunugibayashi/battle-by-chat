<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SendMessage[]|\Cake\Collection\CollectionInterface $sendMessages
 */
?>
<div class="sendMessages index content">
    <?= $this->Html->link(__('New Send Message'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Send Messages') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_fullname') ?></th>
                    <th><?= $this->Paginator->sort('to_chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('to_chat_character_fullname') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sendMessages as $sendMessage): ?>
                <tr>
                    <td><?= $this->Number->format($sendMessage->id) ?></td>
                    <td><?= $sendMessage->has('user') ? $this->Html->link($sendMessage->user->id, ['controller' => 'Users', 'action' => 'view', $sendMessage->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($sendMessage->chat_character_key) ?></td>
                    <td><?= h($sendMessage->chat_character_fullname) ?></td>
                    <td><?= $this->Number->format($sendMessage->to_chat_character_key) ?></td>
                    <td><?= h($sendMessage->to_chat_character_fullname) ?></td>
                    <td><?= h($sendMessage->title) ?></td>
                    <td><?= h($sendMessage->modified) ?></td>
                    <td><?= h($sendMessage->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $sendMessage->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sendMessage->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sendMessage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sendMessage->id)]) ?>
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
