<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SendMessage $sendMessage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Send Message'), ['action' => 'edit', $sendMessage->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Send Message'), ['action' => 'delete', $sendMessage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sendMessage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Send Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Send Message'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sendMessages view content">
            <h3><?= h($sendMessage->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $sendMessage->has('user') ? $this->Html->link($sendMessage->user->id, ['controller' => 'Users', 'action' => 'view', $sendMessage->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Fullname') ?></th>
                    <td><?= h($sendMessage->chat_character_fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('To Chat Character Fullname') ?></th>
                    <td><?= h($sendMessage->to_chat_character_fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($sendMessage->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sendMessage->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Key') ?></th>
                    <td><?= $this->Number->format($sendMessage->chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('To Chat Character Key') ?></th>
                    <td><?= $this->Number->format($sendMessage->to_chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($sendMessage->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($sendMessage->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($sendMessage->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
