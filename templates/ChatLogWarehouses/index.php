<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatLogWarehouse[]|\Cake\Collection\CollectionInterface $chatLogWarehouses
 */
?>
<div class="chatLogWarehouses index content">
    <h3><?= __('ログ倉庫') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('created', ['label' => '作成日', ]) ?></th>
                    <th><?= $this->Paginator->sort('chat_room_title', ['label' => 'ルーム名', ]) ?></th>
                    <th><?= $this->Paginator->sort('characters', ['label' => '参加者', ]) ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatLogWarehouses as $chatLogWarehouse): ?>
                <tr>
                    <td><?= h($chatLogWarehouse->created) ?></td>
                    <td><?= h($chatLogWarehouse->chat_room_title) ?></td>
                    <td><?= h($chatLogWarehouse->characters) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('DL'), ['action' => 'dl', $chatLogWarehouse->id]) ?>
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
