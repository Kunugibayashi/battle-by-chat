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
            <?= $this->Html->link(__('名簿一覧'), ['action' => 'search'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('登録キャラクター編集'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('私書送信'), [
                    'controller' => 'Messages',
                    'action' => 'send',
                    $chatCharacter->id,
                ], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chatCharacters view content">
            <h3><?= h($chatCharacter->fullname) ?></h3>
            <table>
                <tr>
                    <th><?= __('名前') ?></th>
                    <td><?= h($chatCharacter->fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('性別') ?></th>
                    <td><?= h($chatCharacter->sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('色') ?></th>
                    <td><span style="color:<?= $chatCharacter->color ?>"><?= h($chatCharacter->color) ?></span></td>
                </tr>
                <tr>
                    <th><?= __('背景色') ?></th>
                    <td><span style="color:<?= $chatCharacter->backgroundcolor ?>"><?= h($chatCharacter->backgroundcolor) ?></span></td>
                </tr>
                <tr>
                    <th><?= __('タグ') ?></th>
                    <td><?= h($chatCharacter->tag) ?></td>
                </tr>
                <tr>
                    <th><?= __('URL') ?></th>
                    <td>
                        <?php
                        if (isset($chatCharacter->url) && !empty($chatCharacter->url)) {
                            echo $this->Html->link('■', h($chatCharacter->url), ['target' => '_blank']);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('レベル') ?></th>
                    <td><?= h($chatCharacter->battle_character_status->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('腕力') ?></th>
                    <td><?= h($chatCharacter->battle_character_status->strength) ?></td>
                </tr>
                <tr>
                    <th><?= __('敏捷') ?></th>
                    <td><?= h($chatCharacter->battle_character_status->dexterity) ?></td>
                </tr>
                <tr>
                    <th><?= __('体力') ?></th>
                    <td><?= h($chatCharacter->battle_character_status->stamina) ?></td>
                </tr>
                <tr>
                    <th><?= __('精神') ?></th>
                    <td><?= h($chatCharacter->battle_character_status->spirit) ?></td>
                </tr>
                <tr>
                    <th><?= __('更新日') ?></th>
                    <td><?= h($chatCharacter->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('作成日') ?></th>
                    <td><?= h($chatCharacter->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('詳細') ?></strong>
                <blockquote>
                    <?php echo nl2br(h($chatCharacter->detail)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
