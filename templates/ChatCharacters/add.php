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
            <?= $this->Html->link(__('名簿'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters form content">
            <?= $this->Form->create($chatCharacter) ?>
            <fieldset>
                <legend><?= __('キャラクター追加') ?></legend>
                <?php
                    echo $this->Form->hidden('user_id');
                    echo $this->Form->control('fullname', ['label' => '名前', ]);
                    echo $this->Form->control('sex', ['label' => '性別', ]);
                    echo $this->element('colorpreview');
                    echo $this->Form->control('tag', ['label' => 'タグ', ]);
                    echo $this->Form->control('url', ['label' => 'URL', ]);
                    echo $this->element('battle_status_form_control');
                    echo $this->Form->control('detail', [
                        'label' => '詳細',
                        'maxlength' => '10000',
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
