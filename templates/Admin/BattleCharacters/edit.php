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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $battleCharacter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $battleCharacter->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Battle Characters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleCharacters form content">
            <?= $this->Form->create($battleCharacter) ?>
            <fieldset>
                <legend><?= __('Edit Battle Character') ?></legend>
                <?php
                    echo $this->Form->control('battle_turn_id', ['options' => $battleTurns]);
                    echo $this->Form->control('chat_character_id', ['options' => $chatCharacters]);
                    echo $this->Form->control('strength');
                    echo $this->Form->control('dexterity');
                    echo $this->Form->control('stamina');
                    echo $this->Form->control('spirit');
                    echo $this->Form->control('hp');
                    echo $this->Form->control('sp');
                    echo $this->Form->control('combo');
                    echo $this->Form->control('continuous_turn_count');
                    echo $this->Form->control('is_limit');
                    echo $this->Form->control('limit_skill_code');
                    echo $this->Form->control('permanent_strength');
                    echo $this->Form->control('temporary_strength');
                    echo $this->Form->control('permanent_hit_rate');
                    echo $this->Form->control('temporary_hit_rate');
                    echo $this->Form->control('permanent_dodge_rate');
                    echo $this->Form->control('temporary_dodge_rate');
                    echo $this->Form->control('defense_skill_code');
                    echo $this->Form->control('defense_skill_attribute');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
