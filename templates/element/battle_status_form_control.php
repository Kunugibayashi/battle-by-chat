<h4><?= __('戦闘ステータス') ?></h4>
<div class="battle-character-statuses">
<?php
    echo $this->Form->control('battle_character_status.level', [
        'label' => 'レベル',
        'options' => [ 0, 1, 2, 3, ]
    ]);
    echo $this->Form->control('battle_character_status.strength', [
        'label' => '腕力',
        'options' => [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
    ]);
    echo $this->Form->control('battle_character_status.dexterity', [
        'label' => '敏捷',
        'options' => [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
    ]);
    echo $this->Form->control('battle_character_status.stamina', [
        'label' => '体力',
        'options' => [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
    ]);
    echo $this->Form->control('battle_character_status.spirit', [
        'label' => '精神',
        'options' => [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
    ]);
    ?>
</div>
<div>
    <ul>
        <li>レベル0：すべての能力値が0</li>
        <li>レベル1：能力値合計が4</li>
        <li>レベル2：能力値合計が8、(腕力+敏捷) は6以内、(体力+精神) は6以内</li>
        <li>レベル3：能力値合計が12、(腕力+敏捷) は6以内、(体力+精神) は6以内</li>
        <li>能力向上薬使用時：制限なし、最大9/9/9/9可</li>
    </ul>
</div>
