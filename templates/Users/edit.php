<?php
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('ユーザー削除'),
                ['action' => 'delete'],
                ['confirm' => __('ユーザーを削除してよろしいですか？　登録キャラクターも全て削除されます。'), 'class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('パスワード変更') ?></legend>
                <?php
                    echo $this->Form->control('oldpassword', ['label' => '旧パスワード', 'type' => 'password',]);
                    echo $this->Form->control('newpassword', ['label' => '新パスワード', 'type' => 'password',]);
                    echo $this->Form->control('repassword', ['label' => '新パスワード再入力', 'type' => 'password', ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('変更')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
