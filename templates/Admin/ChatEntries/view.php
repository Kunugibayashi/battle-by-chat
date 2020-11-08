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
            <?= $this->Html->link(__('Edit Chat Entry'), ['action' => 'edit', $chatEntry->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chat Entry'), ['action' => 'delete', $chatEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatEntry->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chat Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chat Entry'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatEntries view content">
            <h3><?= h($chatEntry->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Chat Room') ?></th>
                    <td><?= $chatEntry->has('chat_room') ? $this->Html->link($chatEntry->chat_room->title, ['controller' => 'ChatRooms', 'action' => 'view', $chatEntry->chat_room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $chatEntry->has('user') ? $this->Html->link($chatEntry->user->id, ['controller' => 'Users', 'action' => 'view', $chatEntry->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character') ?></th>
                    <td><?= $chatEntry->has('chat_character') ? $this->Html->link($chatEntry->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $chatEntry->chat_character->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Entry Key') ?></th>
                    <td><?= h($chatEntry->entry_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chatEntry->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($chatEntry->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($chatEntry->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
