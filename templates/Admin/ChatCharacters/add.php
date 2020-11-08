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
            <?= $this->Html->link(__('List Chat Characters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters form content">
            <?= $this->Form->create($chatCharacter) ?>
            <fieldset>
                <legend><?= __('Add Chat Character') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('fullname');
                    echo $this->Form->control('sex');
                    echo $this->Form->control('color');
                    echo $this->Form->control('backgroundcolor');
                    echo $this->Form->control('tag');
                    echo $this->Form->control('url');
                    echo $this->Form->control('detail');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
