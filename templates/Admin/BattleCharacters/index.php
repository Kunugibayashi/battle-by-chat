<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleCharacter[]|\Cake\Collection\CollectionInterface $battleCharacters
 */
?>
<div class="battleCharacters index content">
    <?= $this->Html->link(__('New Battle Character'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Battle Characters') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('battle_turn_id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_id') ?></th>
                    <th><?= $this->Paginator->sort('strength') ?></th>
                    <th><?= $this->Paginator->sort('dexterity') ?></th>
                    <th><?= $this->Paginator->sort('stamina') ?></th>
                    <th><?= $this->Paginator->sort('spirit') ?></th>
                    <th><?= $this->Paginator->sort('hp') ?></th>
                    <th><?= $this->Paginator->sort('sp') ?></th>
                    <th><?= $this->Paginator->sort('combo') ?></th>
                    <th><?= $this->Paginator->sort('continuous_turn_count') ?></th>
                    <th><?= $this->Paginator->sort('is_limit') ?></th>
                    <th><?= $this->Paginator->sort('limit_skill_code') ?></th>
                    <th><?= $this->Paginator->sort('permanent_strength') ?></th>
                    <th><?= $this->Paginator->sort('temporary_strength') ?></th>
                    <th><?= $this->Paginator->sort('permanent_hit_rate') ?></th>
                    <th><?= $this->Paginator->sort('temporary_hit_rate') ?></th>
                    <th><?= $this->Paginator->sort('permanent_dodge_rate') ?></th>
                    <th><?= $this->Paginator->sort('temporary_dodge_rate') ?></th>
                    <th><?= $this->Paginator->sort('defense_skill_code') ?></th>
                    <th><?= $this->Paginator->sort('defense_skill_attribute') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($battleCharacters as $battleCharacter): ?>
                <tr>
                    <td><?= $this->Number->format($battleCharacter->id) ?></td>
                    <td><?= $battleCharacter->has('battle_turn') ? $this->Html->link($battleCharacter->battle_turn->id, ['controller' => 'BattleTurns', 'action' => 'view', $battleCharacter->battle_turn->id]) : '' ?></td>
                    <td><?= $battleCharacter->has('chat_character') ? $this->Html->link($battleCharacter->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $battleCharacter->chat_character->id]) : '' ?></td>
                    <td><?= $this->Number->format($battleCharacter->strength) ?></td>
                    <td><?= $this->Number->format($battleCharacter->dexterity) ?></td>
                    <td><?= $this->Number->format($battleCharacter->stamina) ?></td>
                    <td><?= $this->Number->format($battleCharacter->spirit) ?></td>
                    <td><?= $this->Number->format($battleCharacter->hp) ?></td>
                    <td><?= $this->Number->format($battleCharacter->sp) ?></td>
                    <td><?= $this->Number->format($battleCharacter->combo) ?></td>
                    <td><?= $this->Number->format($battleCharacter->continuous_turn_count) ?></td>
                    <td><?= $this->Number->format($battleCharacter->is_limit) ?></td>
                    <td><?= $this->Number->format($battleCharacter->limit_skill_code) ?></td>
                    <td><?= $this->Number->format($battleCharacter->permanent_strength) ?></td>
                    <td><?= $this->Number->format($battleCharacter->temporary_strength) ?></td>
                    <td><?= $this->Number->format($battleCharacter->permanent_hit_rate) ?></td>
                    <td><?= $this->Number->format($battleCharacter->temporary_hit_rate) ?></td>
                    <td><?= $this->Number->format($battleCharacter->permanent_dodge_rate) ?></td>
                    <td><?= $this->Number->format($battleCharacter->temporary_dodge_rate) ?></td>
                    <td><?= $this->Number->format($battleCharacter->defense_skill_code) ?></td>
                    <td><?= $this->Number->format($battleCharacter->defense_skill_attribute) ?></td>
                    <td><?= h($battleCharacter->modified) ?></td>
                    <td><?= h($battleCharacter->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $battleCharacter->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $battleCharacter->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $battleCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacter->id)]) ?>
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
