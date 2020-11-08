<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleLog[]|\Cake\Collection\CollectionInterface $battleLogs
 */
?>
<div class="battleLogs index content">
    <?= $this->Html->link(__('New Battle Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Battle Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('chat_log_id') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($battleLogs as $battleLog): ?>
                <tr>
                    <td><?= $this->Number->format($battleLog->id) ?></td>
                    <td><?= $this->Number->format($battleLog->chat_log_id) ?></td>
                    <td><?= h($battleLog->modified) ?></td>
                    <td><?= h($battleLog->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $battleLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $battleLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $battleLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleLog->id)]) ?>
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
