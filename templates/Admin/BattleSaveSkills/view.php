<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleSaveSkill $battleSaveSkill
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Battle Save Skill'), ['action' => 'edit', $battleSaveSkill->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Battle Save Skill'), ['action' => 'delete', $battleSaveSkill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleSaveSkill->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Battle Save Skills'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Battle Save Skill'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleSaveSkills view content">
            <h3><?= h($battleSaveSkill->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Battle Turn') ?></th>
                    <td><?= $battleSaveSkill->has('battle_turn') ? $this->Html->link($battleSaveSkill->battle_turn->id, ['controller' => 'BattleTurns', 'action' => 'view', $battleSaveSkill->battle_turn->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character') ?></th>
                    <td><?= $battleSaveSkill->has('chat_character') ? $this->Html->link($battleSaveSkill->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $battleSaveSkill->chat_character->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Enemy Chat Character Key') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->enemy_chat_character_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Limit Skill Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->limit_skill_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Passive Skill Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->passive_skill_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill1 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill1_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill2 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill2_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill3 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill3_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill4 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill4_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill5 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill5_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill6 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill6_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Skill7 Code') ?></th>
                    <td><?= $this->Number->format($battleSaveSkill->battle_skill7_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($battleSaveSkill->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($battleSaveSkill->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
