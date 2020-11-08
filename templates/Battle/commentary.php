<?php
if (!$battleTurn || $battleTurn->battle_status == BT_ST_KETYAKU) {
?>
    <div class="commentary-comment">
        <?php echo __('戦闘は終了しています。発言を行う場合は終了ボタンを押してください。'); ?>
    </div>
    <div class="button-container">
    <?php
        echo $this->Form->button(__('戦闘終了'), [
            'type' => 'submit',
            'class' => 'warning',
            'formaction' => $this->Url->build([
                'controller' => 'Chat',
                'action' => 'room',
                $chatRoomId,
            ]),
        ]);
    ?>
    </div>
<?php
    return;
}
?>
<div class="commentary-comment">
    <?php
    if ($battleTurn->battle_status == BT_ST_TYUDAN) {
        echo __('戦闘は中断されています');
        return;
    }
    if (!$attackBattleCharacter || !$defenseBattleCharacter) {
        echo __('宣戦布告の受諾を待機中');
        return;
    }
    if (!$defenseBattleCharacter->defense_skill_code) {
        echo __('{0}の防御スキルセットを待機中', $defenseChatCharacter->fullname);
        if ($defenseChatCharacter->id == $beforeChatCharacter->id) {
            $isBeforTurn = 1;
            $isAfterTurn = 0;
        } else {
            $isBeforTurn = 0;
            $isAfterTurn = 1;
        }
    } else  {
        echo __('{0}の攻撃スキルセットを待機中', $attackChatCharacter->fullname);
        if ($attackChatCharacter->id == $beforeChatCharacter->id) {
            $isBeforTurn = 1;
            $isAfterTurn = 0;
        } else {
            $isBeforTurn = 0;
            $isAfterTurn = 1;
        }
    }
    ?>
</div>
<table>
    <tbody>
        <tr>
            <th></th>
            <th>名前</th>
            <th>HP</th>
            <th>SP</th>
            <th>攻撃力</th>
            <th>命中率</th>
            <th>コンボ</th>
            <th>覚醒</th>
        </tr>
        <tr>
            <th><?= ($isBeforTurn) ? '▷' : '' ?></th>
            <td><?= h($beforeChatCharacter->fullname) ?></td>
            <td><?= h($beforeBattleCharacter->hp) ?></td>
            <td><?= h($beforeBattleCharacter->sp) ?></td>
            <td><?= (5 + $beforeBattleCharacter->strength) ?>+<?php
                $permanent = $beforeBattleCharacter->permanent_strength;
                $permanent += $beforeBattleCharacter->temporary_strength;
                echo $permanent; ?>
            </td>
            <td><?= (20 + $beforeBattleCharacter->dexterity * 10) ?><?php
                $permanent = $beforeBattleCharacter->permanent_hit_rate;
                $permanent += $beforeBattleCharacter->temporary_hit_rate;
                $permanent -= $afterBattleCharacter->permanent_dodge_rate;
                $permanent -= $afterBattleCharacter->temporary_dodge_rate;
                if($permanent >= 0) {
                    echo '+' .$permanent;
                } else {
                    echo $permanent;
                } ?>
            </td>
            <td>×<?= h($beforeBattleCharacter->combo) ?></td>
            <?php if ($beforeBattleCharacter->is_limit) {?>
                <td><?= h($limitSkills[$beforeBattleCharacter->limit_skill_code]) ?></td>
            <?php } else {?>
                <td>—</td>
            <?php } ?>
        </tr>
        <tr>
            <th><?= ($isAfterTurn) ? '▷' : '' ?></th>
            <td><?= h($afterChatCharacter->fullname) ?></td>
            <td><?= h($afterBattleCharacter->hp) ?></td>
            <td><?= h($afterBattleCharacter->sp) ?></td>
            <td><?= (5 + $afterBattleCharacter->strength) ?>+<?php
                $permanent = $afterBattleCharacter->permanent_strength;
                $permanent += $afterBattleCharacter->temporary_strength;
                echo $permanent; ?>
            </td>
            <td><?= (20 + $afterBattleCharacter->dexterity * 10) ?><?php
                $permanent = $afterBattleCharacter->permanent_hit_rate;
                $permanent += $afterBattleCharacter->temporary_hit_rate;
                $permanent -= $beforeBattleCharacter->permanent_dodge_rate;
                $permanent -= $beforeBattleCharacter->temporary_dodge_rate;
                if($permanent >= 0) {
                    echo '+' .$permanent;
                } else {
                    echo $permanent;
                } ?>
            </td>
            <td>×<?= h($afterBattleCharacter->combo) ?></td>
            <?php if ($afterBattleCharacter->is_limit) {?>
                <td><?= h($limitSkills[$afterBattleCharacter->limit_skill_code]) ?></td>
            <?php } else {?>
                <td>—</td>
            <?php } ?>
        </tr>
    </tbody>
</table>
