<?php
if (!$battleTurn || $battleTurn->battle_status == BT_ST_KETYAKU) {
    return;
}
?>
<fieldset>
    <div class="battleform-fieldset-container">
        <div><?php echo $limitSkills[$battleSaveSkill->limit_skill_code]; ?></div>
        <div><?php echo $passiveSkills[$battleSaveSkill->passive_skill_code]; ?></div>
    </div>
    <div class="battleform-fieldset-container">
        <h4><?= __('攻撃スキル') ?></h4>
        <div>
            <ul class="battleform-attribute-container">
                <li><label for="attk-BT_ATTR_04">水</label></li>
                <li><input type="radio" id="attk-BT_ATTR_04" name="attack_skill_attribute" value="<?= BT_ATTR_04 ?>"></li>
                <li>→</li>
                <li><input type="radio" id="attk-BT_ATTR_01" name="attack_skill_attribute" value="<?= BT_ATTR_01 ?>" checked></li>
                <li><label for="attk-BT_ATTR_01">火</label></li>
                <li></li>
                <li>↑</li>
                <li></li>
                <li>↓</li>
                <li></li>
                <li><label for="attk-BT_ATTR_03">風</label></li>
                <li><input type="radio" id="attk-BT_ATTR_03" name="attack_skill_attribute" value="<?= BT_ATTR_03 ?>"></li>
                <li>←</li>
                <li><input type="radio" id="attk-BT_ATTR_02" name="attack_skill_attribute" value="<?= BT_ATTR_02 ?>"></li>
                <li><label for="attk-BT_ATTR_02">木</label></li>
            </ul>
        </div>
        <?php echo $this->Form->control('attack_kill', ['label' => false, 'options' => [
            '0' => '通常攻撃',
            '2' => '必殺技（小）',
            '3' => '必殺技（中）',
            '4' => '必殺技（大）',
        ], ]); ?>
        <?php echo $this->Form->control('attack_skill_code', ['label' => false, 'options' => $attackSkillCodes, ]); ?>
        <?php echo $this->Form->control('attack_technique_name', ['label' => '技名', ]); ?>
        <label id="is-attack-label">
            <?php echo $this->Form->checkbox('is_attack', [
                'id' => 'id-is-attack']); ?> <?= __('攻撃スキルセット') ?>
        </label>
    </div>
    <div class="battleform-fieldset-container">
        <h4><?= __('防御スキル') ?></h4>
        <div>
            <ul class="battleform-attribute-container">
                <li><label for="def-BT_ATTR_04">水</label></li>
                <li><input type="radio" id="def-BT_ATTR_04" name="defense_skill_attribute" value="<?= BT_ATTR_04 ?>"></li>
                <li>→</li>
                <li><input type="radio" id="def-BT_ATTR_01" name="defense_skill_attribute" value="<?= BT_ATTR_01 ?>" checked></li>
                <li><label for="def-BT_ATTR_01">火</label></li>
                <li></li>
                <li>↑</li>
                <li></li>
                <li>↓</li>
                <li></li>
                <li><label for="def-BT_ATTR_03">風</label></li>
                <li><input type="radio" id="def-BT_ATTR_03" name="defense_skill_attribute" value="<?= BT_ATTR_03 ?>"></li>
                <li>←</li>
                <li><input type="radio" id="def-BT_ATTR_02" name="defense_skill_attribute" value="<?= BT_ATTR_02 ?>"></li>
                <li><label for="def-BT_ATTR_02">木</label></li>
            </ul>
        </div>
        <?php echo $this->Form->control('defense_skill_code', ['label' => false, 'options' => $defenseSkillCodes, ]); ?>
        <?= $this->Form->button(__('防御スキルセット'), [
            'type' => 'button',
            'id' => 'id-defense-set-button',
        ]) ?>
    </div>
</fieldset>
