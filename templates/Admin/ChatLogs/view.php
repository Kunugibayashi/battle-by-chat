<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLog $chatLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Chat Log'), ['action' => 'edit', $chatLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chat Log'), ['action' => 'delete', $chatLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chat Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chat Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatLogs view content">
            <h3><?= h($chatLog->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Entry Key') ?></th>
                    <td><?= h($chatLog->entry_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Room Title') ?></th>
                    <td><?= h($chatLog->chat_room_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Room Information') ?></th>
                    <td><?= h($chatLog->chat_room_information) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($chatLog->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Backgroundcolor') ?></th>
                    <td><?= h($chatLog->backgroundcolor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fullname') ?></th>
                    <td><?= h($chatLog->fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Note') ?></th>
                    <td><?= h($chatLog->note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Log') ?></th>
                    <td><?= $chatLog->has('battle_log') ? $this->Html->link($chatLog->battle_log->id, ['controller' => 'BattleLogs', 'action' => 'view', $chatLog->battle_log->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chatLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Room Key') ?></th>
                    <td><?= $this->Number->format($chatLog->chat_room_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Key') ?></th>
                    <td><?= $this->Number->format($chatLog->chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($chatLog->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($chatLog->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($chatLog->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
