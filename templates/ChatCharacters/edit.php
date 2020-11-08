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
            <?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $chatCharacter->id],
                ['confirm' => __('キャラクターを削除してよろしいですか # {0}?', $chatCharacter->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('登録キャラクター編集'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters form content">
            <?= $this->Form->create($chatCharacter) ?>
            <fieldset>
                <legend><?= __('キャラクター編集') ?></legend>
                <?php
                    echo $this->Form->hidden('user_id');
                    echo $this->Form->control('fullname', ['label' => '名前']);
                    echo $this->Form->control('sex', ['label' => '性別']);
                    echo $this->element('colorpreview');
                    echo $this->Form->control('tag', ['label' => 'タグ']);
                    echo $this->Form->control('url', ['label' => 'URL']);
                    echo $this->element('battle_status_form_control');
                    echo $this->Form->control('detail', ['label' => '詳細']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('編集')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
