<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatCharacter $chatCharacter
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Chat Character'), ['action' => 'edit', $chatCharacter->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Chat Character'), ['action' => 'delete', $chatCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatCharacter->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Chat Characters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Chat Character'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters view content">
            <h3><?= h($chatCharacter->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $chatCharacter->has('user') ? $this->Html->link($chatCharacter->user->id, ['controller' => 'Users', 'action' => 'view', $chatCharacter->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Fullname') ?></th>
                    <td><?= h($chatCharacter->fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sex') ?></th>
                    <td><?= h($chatCharacter->sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($chatCharacter->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Backgroundcolor') ?></th>
                    <td><?= h($chatCharacter->backgroundcolor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= h($chatCharacter->tag) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($chatCharacter->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Battle Character Status') ?></th>
                    <td><?= $chatCharacter->has('battle_character_status') ? $this->Html->link($chatCharacter->battle_character_status->id, ['controller' => 'BattleCharacterStatuses', 'action' => 'view', $chatCharacter->battle_character_status->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Entry') ?></th>
                    <td><?= $chatCharacter->has('chat_entry') ? $this->Html->link($chatCharacter->chat_entry->id, ['controller' => 'ChatEntries', 'action' => 'view', $chatCharacter->chat_entry->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($chatCharacter->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($chatCharacter->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($chatCharacter->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Detail') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($chatCharacter->detail)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Battle Characters') ?></h4>
                <?php if (!empty($chatCharacter->battle_characters)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Battle Turn Id') ?></th>
                            <th><?= __('Chat Character Id') ?></th>
                            <th><?= __('Strength') ?></th>
                            <th><?= __('Dexterity') ?></th>
                            <th><?= __('Stamina') ?></th>
                            <th><?= __('Spirit') ?></th>
                            <th><?= __('Hp') ?></th>
                            <th><?= __('Sp') ?></th>
                            <th><?= __('Combo') ?></th>
                            <th><?= __('Continuous Turn Count') ?></th>
                            <th><?= __('Is Limit') ?></th>
                            <th><?= __('Limit Skill Code') ?></th>
                            <th><?= __('Permanent Strength') ?></th>
                            <th><?= __('Temporary Strength') ?></th>
                            <th><?= __('Permanent Hit Rate') ?></th>
                            <th><?= __('Temporary Hit Rate') ?></th>
                            <th><?= __('Permanent Dodge Rate') ?></th>
                            <th><?= __('Temporary Dodge Rate') ?></th>
                            <th><?= __('Defense Skill Code') ?></th>
                            <th><?= __('Defense Skill Attribute') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($chatCharacter->battle_characters as $battleCharacters) : ?>
                        <tr>
                            <td><?= h($battleCharacters->id) ?></td>
                            <td><?= h($battleCharacters->battle_turn_id) ?></td>
                            <td><?= h($battleCharacters->chat_character_id) ?></td>
                            <td><?= h($battleCharacters->strength) ?></td>
                            <td><?= h($battleCharacters->dexterity) ?></td>
                            <td><?= h($battleCharacters->stamina) ?></td>
                            <td><?= h($battleCharacters->spirit) ?></td>
                            <td><?= h($battleCharacters->hp) ?></td>
                            <td><?= h($battleCharacters->sp) ?></td>
                            <td><?= h($battleCharacters->combo) ?></td>
                            <td><?= h($battleCharacters->continuous_turn_count) ?></td>
                            <td><?= h($battleCharacters->is_limit) ?></td>
                            <td><?= h($battleCharacters->limit_skill_code) ?></td>
                            <td><?= h($battleCharacters->permanent_strength) ?></td>
                            <td><?= h($battleCharacters->temporary_strength) ?></td>
                            <td><?= h($battleCharacters->permanent_hit_rate) ?></td>
                            <td><?= h($battleCharacters->temporary_hit_rate) ?></td>
                            <td><?= h($battleCharacters->permanent_dodge_rate) ?></td>
                            <td><?= h($battleCharacters->temporary_dodge_rate) ?></td>
                            <td><?= h($battleCharacters->defense_skill_code) ?></td>
                            <td><?= h($battleCharacters->defense_skill_attribute) ?></td>
                            <td><?= h($battleCharacters->modified) ?></td>
                            <td><?= h($battleCharacters->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'BattleCharacters', 'action' => 'view', $battleCharacters->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'BattleCharacters', 'action' => 'edit', $battleCharacters->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'BattleCharacters', 'action' => 'delete', $battleCharacters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacters->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Battle Save Skills') ?></h4>
                <?php if (!empty($chatCharacter->battle_save_skills)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Battle Turn Id') ?></th>
                            <th><?= __('Chat Character Id') ?></th>
                            <th><?= __('Enemy Chat Character Key') ?></th>
                            <th><?= __('Limit Skill Code') ?></th>
                            <th><?= __('Passive Skill Code') ?></th>
                            <th><?= __('Battle Skill1 Code') ?></th>
                            <th><?= __('Battle Skill2 Code') ?></th>
                            <th><?= __('Battle Skill3 Code') ?></th>
                            <th><?= __('Battle Skill4 Code') ?></th>
                            <th><?= __('Battle Skill5 Code') ?></th>
                            <th><?= __('Battle Skill6 Code') ?></th>
                            <th><?= __('Battle Skill7 Code') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($chatCharacter->battle_save_skills as $battleSaveSkills) : ?>
                        <tr>
                            <td><?= h($battleSaveSkills->id) ?></td>
                            <td><?= h($battleSaveSkills->battle_turn_id) ?></td>
                            <td><?= h($battleSaveSkills->chat_character_id) ?></td>
                            <td><?= h($battleSaveSkills->enemy_chat_character_key) ?></td>
                            <td><?= h($battleSaveSkills->limit_skill_code) ?></td>
                            <td><?= h($battleSaveSkills->passive_skill_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill1_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill2_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill3_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill4_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill5_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill6_code) ?></td>
                            <td><?= h($battleSaveSkills->battle_skill7_code) ?></td>
                            <td><?= h($battleSaveSkills->modified) ?></td>
                            <td><?= h($battleSaveSkills->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'BattleSaveSkills', 'action' => 'view', $battleSaveSkills->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'BattleSaveSkills', 'action' => 'edit', $battleSaveSkills->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'BattleSaveSkills', 'action' => 'delete', $battleSaveSkills->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleSaveSkills->id)]) ?>
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
