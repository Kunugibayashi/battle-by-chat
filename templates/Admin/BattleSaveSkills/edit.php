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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $battleSaveSkill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $battleSaveSkill->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Battle Save Skills'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleSaveSkills form content">
            <?= $this->Form->create($battleSaveSkill) ?>
            <fieldset>
                <legend><?= __('Edit Battle Save Skill') ?></legend>
                <?php
                    echo $this->Form->control('battle_turn_id', ['options' => $battleTurns]);
                    echo $this->Form->control('chat_character_id', ['options' => $chatCharacters]);
                    echo $this->Form->control('enemy_chat_character_key');
                    echo $this->Form->control('limit_skill_code');
                    echo $this->Form->control('passive_skill_code');
                    echo $this->Form->control('battle_skill1_code');
                    echo $this->Form->control('battle_skill2_code');
                    echo $this->Form->control('battle_skill3_code');
                    echo $this->Form->control('battle_skill4_code');
                    echo $this->Form->control('battle_skill5_code');
                    echo $this->Form->control('battle_skill6_code');
                    echo $this->Form->control('battle_skill7_code');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
