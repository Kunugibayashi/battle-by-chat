<?php
?>
<div class="chatCharacters index content">
    <h3><?= __('発言編集') ?></h3>
    <p>入室中にのみ編集可能です。ログ倉庫に格納されたログは編集できません。</p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>発言</th>
                    <th class="table-column-date">発言日</th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($chatLogs)) { ?>
                <?php foreach ($chatLogs as $chatLog): ?>
                <tr>
                    <td><?= $this->Number->format($chatLog->id) ?></td>
                    <td><?= h($chatLog->fullname) ?></td>
                    <td><?= h($chatLog->messageLeft) ?></td>
                    <td><?= h($chatLog->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $chatLog->id]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if(isset($chatLogs)) { ?>
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
    <?php } ?>
</div>
