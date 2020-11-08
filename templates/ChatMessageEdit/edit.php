<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatCharacter $chatCharacter
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('メニュー') ?></h4>
            <?= $this->Html->link(__('発言一覧'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters form content">
            <?php if(isset($chatLog)) { ?>
                <?= $this->Form->create($chatLog) ?>
                <fieldset>
                    <legend><?= __('発言編集') ?></legend>
                    <?php
                        echo $this->Form->control('message', ['label' => '発言']);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('編集')) ?>
                <?= $this->Form->end() ?>
            <?php } else { ?>
                退室した場合は編集できません。
            <?php } ?>
        </div>
    </div>
</div>
