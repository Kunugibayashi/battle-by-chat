<h4 class="heading"><?= __('戦闘') ?></h4>
<?= $this->Form->create($battleSaveSkill, [
    'id' => 'id-battle-entry-form', // vue.js の指定で使用
    'url' => ['controller' => 'Battle', 'action' => 'start', $chatRoomId, ],
]) ?>
<fieldset>
    <?php echo $this->Form->hidden('chat_character_id'); ?>
    <?php echo $this->Form->control('enemy_chat_character_key',
        ['label' => '対戦相手', 'options' => $enemies, 'empty' => '索敵してください'],
    ); ?>
    <div class="button-container">
        <?php echo $this->Form->button(__('索敵'), [
            'type' => 'submit',
            'formaction' => $this->Url->build([
                        'controller' => 'Chat',
                        'action' => 'room',
                        $chatRoomId,
                    ]),
        ]) ?>
        <?= $this->Form->button(__('戦闘再開'), [
                'type' => 'submit',
                'class' => 'warning',
                'formaction' => $this->Url->build([
                            'controller' => 'Battle',
                            'action' => 'restart',
                            $chatRoomId,
                        ]),
        ]) ?>
    </div>
    <?php echo $this->Form->control('limit_skill_code', ['label' => '覚醒スキル', 'options' => $limitSkills, ]); ?>
    <?php echo $this->Form->control('passive_skill_code', ['label' => 'パッシブスキル', 'options' => $passiveSkills, ]); ?>
    <label><?= __('戦闘スキル') ?></label>
    <?php echo $this->Form->control('battle_skill1_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill2_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill3_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill4_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill5_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill6_code', ['label' => false, 'options' => $battleSkills, ]); ?>
    <?php echo $this->Form->control('battle_skill7_code', ['label' => false, 'options' => $battleSkills, ]); ?>

</fieldset>
<div class="button-container">
    <?= $this->Form->button(__('宣戦布告'), [
        'class' => 'warning',
    ]) ?>
</div>
<?= $this->Form->end() ?>
