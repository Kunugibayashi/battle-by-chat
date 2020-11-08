<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatEntry[]|\Cake\Collection\CollectionInterface $chatEntries
 */
?>
<div class="chatEntries index content">
    <?= $this->Html->link(__('New Chat Entry'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Chat Entries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('chat_room_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_id') ?></th>
                    <th><?= $this->Paginator->sort('entry_key') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatEntries as $chatEntry): ?>
                <tr>
                    <td><?= $this->Number->format($chatEntry->id) ?></td>
                    <td><?= $chatEntry->has('chat_room') ? $this->Html->link($chatEntry->chat_room->title, ['controller' => 'ChatRooms', 'action' => 'view', $chatEntry->chat_room->id]) : '' ?></td>
                    <td><?= $chatEntry->has('user') ? $this->Html->link($chatEntry->user->id, ['controller' => 'Users', 'action' => 'view', $chatEntry->user->id]) : '' ?></td>
                    <td><?= $chatEntry->has('chat_character') ? $this->Html->link($chatEntry->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $chatEntry->chat_character->id]) : '' ?></td>
                    <td><?= h($chatEntry->entry_key) ?></td>
                    <td><?= h($chatEntry->modified) ?></td>
                    <td><?= h($chatEntry->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $chatEntry->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatEntry->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatEntry->id)]) ?>
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
