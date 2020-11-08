<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleCharacterStatus $battleCharacterStatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Battle Character Status'), ['action' => 'edit', $battleCharacterStatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Battle Character Status'), ['action' => 'delete', $battleCharacterStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacterStatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Battle Character Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Battle Character Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleCharacterStatuses view content">
            <h3><?= h($battleCharacterStatus->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Chat Character') ?></th>
                    <td><?= $battleCharacterStatus->has('chat_character') ? $this->Html->link($battleCharacterStatus->chat_character->id, ['controller' => 'ChatCharacters', 'action' => 'view', $battleCharacterStatus->chat_character->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chat Character Id') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->chat_character_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Strength') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->strength) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dexterity') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->dexterity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stamina') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->stamina) ?></td>
                </tr>
                <tr>
                    <th><?= __('Spirit') ?></th>
                    <td><?= $this->Number->format($battleCharacterStatus->spirit) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
