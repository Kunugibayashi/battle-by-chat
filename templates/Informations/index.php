<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Information[]|\Cake\Collection\CollectionInterface $informations
 */
?>
<div class="informations index content">
    <h3><?= __('お知らせ') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="table-column-date"><?= $this->Paginator->sort('created', ['label' => '作成日', ]) ?></th>
                    <th><?= $this->Paginator->sort('title', ['label' => '件名', ]) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($informations as $information): ?>
                <tr>
                    <td><?= h($information->created) ?></td>
                    <td><?= $this->Html->link(
                            h($information->title), [
                                'action' => 'view',
                                $information->id
                            ])
                        ?>
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
