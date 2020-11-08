<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleTurn[]|\Cake\Collection\CollectionInterface $battleTurns
 */
?>
<div class="battleTurns index content">
    <?= $this->Html->link(__('New Battle Turn'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Battle Turns') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('vs_fukoku_key') ?></th>
                    <th><?= $this->Paginator->sort('vs_before_key') ?></th>
                    <th><?= $this->Paginator->sort('vs_after_key') ?></th>
                    <th><?= $this->Paginator->sort('battle_status') ?></th>
                    <th><?= $this->Paginator->sort('battle_turn_count') ?></th>
                    <th><?= $this->Paginator->sort('attack_chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('defense_chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($battleTurns as $battleTurn): ?>
                <tr>
                    <td><?= $this->Number->format($battleTurn->id) ?></td>
                    <td><?= $this->Number->format($battleTurn->vs_fukoku_key) ?></td>
                    <td><?= $this->Number->format($battleTurn->vs_before_key) ?></td>
                    <td><?= $this->Number->format($battleTurn->vs_after_key) ?></td>
                    <td><?= $this->Number->format($battleTurn->battle_status) ?></td>
                    <td><?= $this->Number->format($battleTurn->battle_turn_count) ?></td>
                    <td><?= $this->Number->format($battleTurn->attack_chat_character_key) ?></td>
                    <td><?= $this->Number->format($battleTurn->defense_chat_character_key) ?></td>
                    <td><?= h($battleTurn->modified) ?></td>
                    <td><?= h($battleTurn->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $battleTurn->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $battleTurn->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $battleTurn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleTurn->id)]) ?>
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
