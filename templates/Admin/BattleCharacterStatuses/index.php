<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleCharacterStatus[]|\Cake\Collection\CollectionInterface $battleCharacterStatuses
 */
?>
<div class="battleCharacterStatuses index content">
    <?= $this->Html->link(__('New Battle Character Status'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Battle Character Statuses') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_id') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('strength') ?></th>
                    <th><?= $this->Paginator->sort('dexterity') ?></th>
                    <th><?= $this->Paginator->sort('stamina') ?></th>
                    <th><?= $this->Paginator->sort('spirit') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($battleCharacterStatuses as $battleCharacterStatus): ?>
                <tr>
                    <td><?= $this->Number->format($battleCharacterStatus->id) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->chat_character_id) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->level) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->strength) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->dexterity) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->stamina) ?></td>
                    <td><?= $this->Number->format($battleCharacterStatus->spirit) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $battleCharacterStatus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $battleCharacterStatus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $battleCharacterStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacterStatus->id)]) ?>
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
