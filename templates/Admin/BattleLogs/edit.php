<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BattleLog $battleLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $battleLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $battleLog->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Battle Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="battleLogs form content">
            <?= $this->Form->create($battleLog) ?>
            <fieldset>
                <legend><?= __('Edit Battle Log') ?></legend>
                <?php
                    echo $this->Form->control('chat_log_id');
                    echo $this->Form->control('status');
                    echo $this->Form->control('narration');
                    echo $this->Form->control('memo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
