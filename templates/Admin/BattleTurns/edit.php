<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleTurn $battleTurn
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $battleTurn->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $battleTurn->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Battle Turns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleTurns form content">
            <?= $this->Form->create($battleTurn) ?>
            <fieldset>
                <legend><?= __('Edit Battle Turn') ?></legend>
                <?php
                    echo $this->Form->control('vs_fukoku_key');
                    echo $this->Form->control('vs_before_key');
                    echo $this->Form->control('vs_after_key');
                    echo $this->Form->control('battle_status');
                    echo $this->Form->control('battle_turn_count');
                    echo $this->Form->control('attack_chat_character_key');
                    echo $this->Form->control('defense_chat_character_key');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
