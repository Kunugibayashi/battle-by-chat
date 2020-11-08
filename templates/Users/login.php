<div class="users form content">
    初めての方は、ユーザー登録をしてログインしてください。
</div>
<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content">
    <?= $this->Flash->render() ?>
    <h3><?= __('ログイン') ?></h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('ユーザー名とパスワードを入力してください。') ?></legend>
        <?= $this->Form->control('username', ['label' => 'ユーザー名']) ?>
        <?= $this->Form->control('password', ['label' => 'パスワード']) ?>
    </fieldset>
    <div class="button-container">
        <?= $this->Form->button(__('ログイン'), [
                'type' => 'submit',
            ]) ?>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add', ]) ?>">アカウントがない場合、こちらからユーザー登録してください。</a>
    </div>
    <?= $this->Form->end() ?>
</div>
