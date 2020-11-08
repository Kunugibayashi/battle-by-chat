<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleCharacter $battleCharacter
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Battle Character'), ['action' => 'edit', $battleCharacter->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Battle Character'), ['action' => 'delete', $battleCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacter->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Battle Characters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Battle Character'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleCharacters view content">
            <h3><?= h($battleCharacter->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Battle Turn') ?></th>
                    <td><?= $battleCharacter->has('battle_turn') ? $this->Html->link($battleCharacter->battle_turn->id, ['controller' => 'BattleTurns', 'action' => 'view', $battleCharacter->battle_turn->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character') ?></th>
                    <td><?= $battleCharacter->has('chat_character') ? $this->Html->link($battleCharacter->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $battleCharacter->chat_character->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($battleCharacter->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Strength') ?></th>
                    <td><?= $this->Number->format($battleCharacter->strength) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dexterity') ?></th>
                    <td><?= $this->Number->format($battleCharacter->dexterity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stamina') ?></th>
                    <td><?= $this->Number->format($battleCharacter->stamina) ?></td>
                </tr>
                <tr>
                    <th><?= __('Spirit') ?></th>
                    <td><?= $this->Number->format($battleCharacter->spirit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hp') ?></th>
                    <td><?= $this->Number->format($battleCharacter->hp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sp') ?></th>
                    <td><?= $this->Number->format($battleCharacter->sp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Combo') ?></th>
                    <td><?= $this->Number->format($battleCharacter->combo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Continuous Turn Count') ?></th>
                    <td><?= $this->Number->format($battleCharacter->continuous_turn_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Limit') ?></th>
                    <td><?= $this->Number->format($battleCharacter->is_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Limit Skill Code') ?></th>
                    <td><?= $this->Number->format($battleCharacter->limit_skill_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Permanent Strength') ?></th>
                    <td><?= $this->Number->format($battleCharacter->permanent_strength) ?></td>
                </tr>
                <tr>
                    <th><?= __('Temporary Strength') ?></th>
                    <td><?= $this->Number->format($battleCharacter->temporary_strength) ?></td>
                </tr>
                <tr>
                    <th><?= __('Permanent Hit Rate') ?></th>
                    <td><?= $this->Number->format($battleCharacter->permanent_hit_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Temporary Hit Rate') ?></th>
                    <td><?= $this->Number->format($battleCharacter->temporary_hit_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Permanent Dodge Rate') ?></th>
                    <td><?= $this->Number->format($battleCharacter->permanent_dodge_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Temporary Dodge Rate') ?></th>
                    <td><?= $this->Number->format($battleCharacter->temporary_dodge_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Defense Skill Code') ?></th>
                    <td><?= $this->Number->format($battleCharacter->defense_skill_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Defense Skill Attribute') ?></th>
                    <td><?= $this->Number->format($battleCharacter->defense_skill_attribute) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($battleCharacter->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($battleCharacter->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
