<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
 */
?>
<div class="content">
この私書は個人に割り当てられています。他の参加者には公開されません。
</div>
<div class="messages index content">
    <h3><?= __('受信BOX') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="table-column-date"><?= __('受信日') ?></th>
                    <th><?= __('宛先') ?></th>
                    <th><?= __('差出人') ?></th>
                    <th><?= __('件名') ?></th>
                    <th><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($receivedMessages)) { ?>
                <?php foreach ($receivedMessages as $message): ?>
                <tr>
                    <td><?= $message->created ?></td>
                    <td><?= $message->chat_character_fullname ?></td>
                    <td><?= $message->from_chat_character_fullname ?></td>
                    <td><?= $this->Html->link(h($message->title), [
                            'controller' => 'Messages', 'action' => 'viewReceivedMessage', $message->id]
                        ); ?>
                    </td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('削除'), [
                            'controller' => 'Messages', 'action' => 'receivedDelete', $message->id
                        ], ['confirm' => __('メッセージを削除してよろしいですか？')]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
<div class="messages index content">
    <h3><?= __('送信BOX') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="table-column-date"><?= __('送信日') ?></th>
                    <th><?= __('宛先') ?></th>
                    <th><?= __('差出人') ?></th>
                    <th><?= __('件名') ?></th>
                    <th><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($sendMessages)) { ?>
                <?php foreach ($sendMessages as $message): ?>
                <tr>
                    <td><?= $message->created ?></td>
                    <td><?= $message->to_chat_character_fullname ?></td>
                    <td><?= $message->chat_character_fullname ?></td>
                    <td><?= $this->Html->link(h($message->title), [
                            'controller' => 'Messages', 'action' => 'viewSendMessage', $message->id]
                        ); ?>
                    </td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('削除'), [
                            'controller' => 'Messages', 'action' => 'sendDelete', $message->id
                        ], ['confirm' => __('メッセージを削除してよろしいですか？')]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
