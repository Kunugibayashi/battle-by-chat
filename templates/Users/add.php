<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('ログイン'), ['action' => 'login'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('ユーザー登録') ?></legend>
                <?php
                    echo $this->Form->control('username', ['label' => 'ユーザー名']);
                    echo $this->Form->control('password', ['label' => 'パスワード']);
                    echo $this->Form->control('repassword', ['label' => 'パスワード再入力', 'type' => 'password', ]);
                    echo $this->Form->control('role', ['label' => '権限',
                        'options' => [
                        'author' => __('一般ユーザ'),
                        'admin' => __('管理ユーザ'),
                    ]]);
                ?>
                ※管理者以外は一般ユーザーを選択してください。
            </fieldset>
            <?= $this->Form->button(__('登録')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
