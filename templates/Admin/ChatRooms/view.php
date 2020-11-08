<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatRoom $chatRoom
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Chat Room'), ['action' => 'edit', $chatRoom->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chat Room'), ['action' => 'delete', $chatRoom->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatRoom->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chat Rooms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chat Room'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatRooms view content">
            <h3><?= h($chatRoom->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($chatRoom->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Information') ?></th>
                    <td><?= h($chatRoom->information) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chatRoom->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Published') ?></th>
                    <td><?= $this->Number->format($chatRoom->published) ?></td>
                </tr>
                <tr>
                    <th><?= __('Readonly') ?></th>
                    <td><?= $this->Number->format($chatRoom->readonly) ?></td>
                </tr>
                <tr>
                    <th><?= __('Displayno') ?></th>
                    <td><?= $this->Number->format($chatRoom->displayno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($chatRoom->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($chatRoom->created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Chat Entries') ?></h4>
                <?php if (!empty($chatRoom->chat_entries)) : ?>
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
                        <?php foreach ($chatRoom->chat_entries as $chatEntries) : ?>
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
        </div>
    </div>
</div>
