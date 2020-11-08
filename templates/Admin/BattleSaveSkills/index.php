<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleSaveSkill[]|\Cake\Collection\CollectionInterface $battleSaveSkills
 */
?>
<div class="battleSaveSkills index content">
    <?= $this->Html->link(__('New Battle Save Skill'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Battle Save Skills') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('battle_turn_id') ?></th>
                    <th><?= $this->Paginator->sort('chat_character_id') ?></th>
                    <th><?= $this->Paginator->sort('enemy_chat_character_key') ?></th>
                    <th><?= $this->Paginator->sort('limit_skill_code') ?></th>
                    <th><?= $this->Paginator->sort('passive_skill_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill1_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill2_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill3_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill4_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill5_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill6_code') ?></th>
                    <th><?= $this->Paginator->sort('battle_skill7_code') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($battleSaveSkills as $battleSaveSkill): ?>
                <tr>
                    <td><?= $this->Number->format($battleSaveSkill->id) ?></td>
                    <td><?= $battleSaveSkill->has('battle_turn') ? $this->Html->link($battleSaveSkill->battle_turn->id, ['controller' => 'BattleTurns', 'action' => 'view', $battleSaveSkill->battle_turn->id]) : '' ?></td>
                    <td><?= $battleSaveSkill->has('chat_character') ? $this->Html->link($battleSaveSkill->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $battleSaveSkill->chat_character->id]) : '' ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->enemy_chat_character_key) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->limit_skill_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->passive_skill_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill1_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill2_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill3_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill4_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill5_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill6_code) ?></td>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill7_code) ?></td>
                    <td><?= h($battleSaveSkill->modified) ?></td>
                    <td><?= h($battleSaveSkill->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $battleSaveSkill->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $battleSaveSkill->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $battleSaveSkill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleSaveSkill->id)]) ?>
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
