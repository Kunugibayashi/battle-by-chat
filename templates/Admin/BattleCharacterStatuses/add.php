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
            <?= $this->Html->link(__('List Battle Character Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleCharacterStatuses form content">
            <?= $this->Form->create($battleCharacterStatus) ?>
            <fieldset>
                <legend><?= __('Add Battle Character Status') ?></legend>
                <?php
                    echo $this->Form->control('chat_character_id');
                    echo $this->Form->control('level');
                    echo $this->Form->control('strength');
                    echo $this->Form->control('dexterity');
                    echo $this->Form->control('stamina');
                    echo $this->Form->control('spirit');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
