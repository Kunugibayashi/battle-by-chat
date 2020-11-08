<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatCharacter[]|\Cake\Collection\CollectionInterface $chatCharacters
 */
?>
<div class="row">
    <aside class="column">
        <?= $this->Form->create($searchForm, []) ?>
            <?php echo $this->Form->control('keyword', ['label' => '検索キーワード']); ?>
            <?= $this->Form->button(__('検索'), [
                    'type' => 'submit',
            ]) ?>
        <?= $this->Form->end() ?>
        <?= $this->Html->link(__('名簿一覧'), ['action' => 'search'], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('登録キャラクター編集'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </aside>
    <div class="column-responsive column-80">
        <div class="content">
            <h3><?= __('名簿') ?></h3>
            <div class="table-responsive">
                <table class="namelist-table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('fullname', ['label' => '名前']) ?></th>
                            <th><?= $this->Paginator->sort('sex', ['label' => '性別']) ?></th>
                            <th><?= $this->Paginator->sort('tag', ['label' => 'タグ']) ?></th>
                            <th><?= $this->Paginator->sort('url', ['label' => 'URL']) ?></th>
                            <th><?= __('レベル') ?></th>
                            <th><?= __('ステータス') ?></th>
                            <th><?= $this->Paginator->sort('modified', ['label' => '更新日']) ?></th>
                            <th><?= $this->Paginator->sort('created', ['label' => '作成日']) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chatCharacters as $chatCharacter): ?>
                        <tr>
                            <td><?= $this->Html->link(
                                    h($chatCharacter->fullname), [
                                        'action' => 'view',
                                        $chatCharacter->id
                                    ]) ?></td>
                            <td><?= h($chatCharacter->sex) ?></td>
                            <td><?= h($chatCharacter->tag) ?></td>
                            <td>
                            <?php if (isset($chatCharacter->url) && !empty($chatCharacter->url)) {?>
                                <a href="<?= h($chatCharacter->url) ?>">■</a>
                            <?php } ?>
                            </td>
                            <td><?= h($chatCharacter->battle_character_status->level) ?></td>
                            <td><?php
                                echo h($chatCharacter->battle_character_status->strength);
                                echo h($chatCharacter->battle_character_status->dexterity);
                                echo h($chatCharacter->battle_character_status->stamina);
                                echo h($chatCharacter->battle_character_status->spirit);
                            ?>
                            </td>
                            <td><?= h($chatCharacter->modified) ?></td>
                            <td><?= h($chatCharacter->created) ?></td>
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
    </div>
</div>
