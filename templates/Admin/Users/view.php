<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($user->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Chat Characters') ?></h4>
                <?php if (!empty($user->chat_characters)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Fullname') ?></th>
                            <th><?= __('Sex') ?></th>
                            <th><?= __('Color') ?></th>
                            <th><?= __('Backgroundcolor') ?></th>
                            <th><?= __('Tag') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Detail') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->chat_characters as $chatCharacters) : ?>
                        <tr>
                            <td><?= h($chatCharacters->id) ?></td>
                            <td><?= h($chatCharacters->user_id) ?></td>
                            <td><?= h($chatCharacters->fullname) ?></td>
                            <td><?= h($chatCharacters->sex) ?></td>
                            <td><?= h($chatCharacters->color) ?></td>
                            <td><?= h($chatCharacters->backgroundcolor) ?></td>
                            <td><?= h($chatCharacters->tag) ?></td>
                            <td><?= h($chatCharacters->url) ?></td>
                            <td><?= h($chatCharacters->modified) ?></td>
                            <td><?= h($chatCharacters->created) ?></td>
                            <td><?= h($chatCharacters->detail) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ChatCharacters', 'action' => 'view', $chatCharacters->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ChatCharacters', 'action' => 'edit', $chatCharacters->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ChatCharacters', 'action' => 'delete', $chatCharacters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatCharacters->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Chat Entries') ?></h4>
                <?php if (!empty($user->chat_entries)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Chat Room Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Chat Character Id') ?></th>
                            <th><?= __('Entry Key') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->chat_entries as $chatEntries) : ?>
                        <tr>
                            <td><?= h($chatEntries->id) ?></td>
                            <td><?= h($chatEntries->chat_room_id) ?></td>
                            <td><?= h($chatEntries->user_id) ?></td>
                            <td><?= h($chatEntries->chat_character_id) ?></td>
                            <td><?= h($chatEntries->entry_key) ?></td>
                            <td><?= h($chatEntries->modified) ?></td>
                            <td><?= h($chatEntries->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ChatEntries', 'action' => 'view', $chatEntries->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ChatEntries', 'action' => 'edit', $chatEntries->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ChatEntries', 'action' => 'delete', $chatEntries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatEntries->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Received Messages') ?></h4>
                <?php if (!empty($user->received_messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Chat Character Key') ?></th>
                            <th><?= __('Chat Character Fullname') ?></th>
                            <th><?= __('From Chat Character Key') ?></th>
                            <th><?= __('From Chat Character Fullname') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->received_messages as $receivedMessages) : ?>
                        <tr>
                            <td><?= h($receivedMessages->id) ?></td>
                            <td><?= h($receivedMessages->user_id) ?></td>
                            <td><?= h($receivedMessages->chat_character_key) ?></td>
                            <td><?= h($receivedMessages->chat_character_fullname) ?></td>
                            <td><?= h($receivedMessages->from_chat_character_key) ?></td>
                            <td><?= h($receivedMessages->from_chat_character_fullname) ?></td>
                            <td><?= h($receivedMessages->title) ?></td>
                            <td><?= h($receivedMessages->message) ?></td>
                            <td><?= h($receivedMessages->modified) ?></td>
                            <td><?= h($receivedMessages->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ReceivedMessages', 'action' => 'view', $receivedMessages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ReceivedMessages', 'action' => 'edit', $receivedMessages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReceivedMessages', 'action' => 'delete', $receivedMessages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receivedMessages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Send Messages') ?></h4>
                <?php if (!empty($user->send_messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Chat Character Key') ?></th>
                            <th><?= __('Chat Character Fullname') ?></th>
                            <th><?= __('To Chat Character Key') ?></th>
                            <th><?= __('To Chat Character Fullname') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->send_messages as $sendMessages) : ?>
                        <tr>
                            <td><?= h($sendMessages->id) ?></td>
                            <td><?= h($sendMessages->user_id) ?></td>
                            <td><?= h($sendMessages->chat_character_key) ?></td>
                            <td><?= h($sendMessages->chat_character_fullname) ?></td>
                            <td><?= h($sendMessages->to_chat_character_key) ?></td>
                            <td><?= h($sendMessages->to_chat_character_fullname) ?></td>
                            <td><?= h($sendMessages->title) ?></td>
                            <td><?= h($sendMessages->message) ?></td>
                            <td><?= h($sendMessages->modified) ?></td>
                            <td><?= h($sendMessages->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SendMessages', 'action' => 'view', $sendMessages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SendMessages', 'action' => 'edit', $sendMessages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SendMessages', 'action' => 'delete', $sendMessages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sendMessages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
