<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReceivedMessage $receivedMessage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Received Message'), ['action' => 'edit', $receivedMessage->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Received Message'), ['action' => 'delete', $receivedMessage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receivedMessage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Received Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Received Message'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="receivedMessages view content">
            <h3><?= h($receivedMessage->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $receivedMessage->has('user') ? $this->Html->link($receivedMessage->user->id, ['controller' => 'Users', 'action' => 'view', $receivedMessage->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Fullname') ?></th>
                    <td><?= h($receivedMessage->chat_character_fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('From Chat Character Fullname') ?></th>
                    <td><?= h($receivedMessage->from_chat_character_fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($receivedMessage->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($receivedMessage->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Key') ?></th>
                    <td><?= $this->Number->format($receivedMessage->chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('From Chat Character Key') ?></th>
                    <td><?= $this->Number->format($receivedMessage->from_chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($receivedMessage->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($receivedMessage->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($receivedMessage->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
