<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleLog $battleLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Battle Log'), ['action' => 'edit', $battleLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Battle Log'), ['action' => 'delete', $battleLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Battle Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Battle Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleLogs view content">
            <h3><?= h($battleLog->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Chat Log') ?></th>
                    <td><?= $battleLog->has('chat_log') ? $this->Html->link($battleLog->chat_log->id, ['controller' => 'ChatLogs', 'action' => 'view', $battleLog->chat_log->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($battleLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Log Id') ?></th>
                    <td><?= $this->Number->format($battleLog->chat_log_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($battleLog->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($battleLog->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Status') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($battleLog->status)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Narration') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($battleLog->narration)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Memo') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($battleLog->memo)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
