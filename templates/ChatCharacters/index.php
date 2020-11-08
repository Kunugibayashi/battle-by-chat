<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatCharacter[]|\Cake\Collection\CollectionInterface $chatCharacters
 */
?>
<div class="chatCharacters index content">
    <?= $this->Html->link(__('キャラクター登録'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('登録キャラクター編集') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                    <th><?= $this->Paginator->sort('fullname', ['label' => '名前']) ?></th>
                    <th><?= $this->Paginator->sort('sex', ['label' => '性別']) ?></th>
                    <th><?= $this->Paginator->sort('color', ['label' => '色']) ?></th>
                    <th><?= $this->Paginator->sort('backgroundcolor', ['label' => '背景色']) ?></th>
                    <th><?= $this->Paginator->sort('tag', ['label' => 'タグ']) ?></th>
                    <th><?= $this->Paginator->sort('url', ['label' => 'URL']) ?></th>

                    <th><?= __('レベル') ?></th>
                    <th><?= __('ステータス') ?></th>

                    <th class="table-column-date"><?= $this->Paginator->sort('modified', ['label' => '更新日']) ?></th>
                    <th class="table-column-date"><?= $this->Paginator->sort('created', ['label' => '作成日']) ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatCharacters as $chatCharacter): ?>
                <tr>
                    <td><?= $this->Number->format($chatCharacter->id) ?></td>
                    <td><?= h($chatCharacter->fullname) ?></td>
                    <td><?= h($chatCharacter->sex) ?></td>
                    <td><span style="color:<?= $chatCharacter->color ?>"><?= h($chatCharacter->color) ?></span></td>
                    <td><span style="color:<?= $chatCharacter->backgroundcolor ?>"><?= h($chatCharacter->backgroundcolor) ?></span></td>
                    <td><?= h($chatCharacter->tag) ?></td>
                    <td><?= h($chatCharacter->url) ?></td>

                    <?php if ($chatCharacter->battle_character_status) { ?>
                        <td>
                            <?= h($chatCharacter->battle_character_status->level); ?>
                        </td>
                        <td>
                            <?php
                                echo h($chatCharacter->battle_character_status->strength);
                                echo h($chatCharacter->battle_character_status->dexterity);
                                echo h($chatCharacter->battle_character_status->stamina);
                                echo h($chatCharacter->battle_character_status->spirit);
                            ?>
                        </td>
                    <?php } else { ?>
                        <td>-</td>
                        <td>----</td>
                    <?php } ?>

                    <td><?= h($chatCharacter->modified) ?></td>
                    <td><?= h($chatCharacter->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('表示'), ['action' => 'view', $chatCharacter->id]) ?>
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $chatCharacter->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $chatCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatCharacter->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初へ')) ?>
            <?= $this->Paginator->prev('< ' . __('前へ')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次へ') . ' >') ?>
            <?= $this->Paginator->last(__('最後へ') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('{{page}}/{{pages}}ページ, {{current}}/{{count}}件')) ?></p>
    </div>
</div>
