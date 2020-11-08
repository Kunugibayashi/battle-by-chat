<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatCharacter[]|\Cake\Collection\CollectionInterface $chatCharacters
 */
?>
<div class="chatCharacters index content">
    <?= $this->Html->link(__('New Chat Character'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Chat Characters') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('fullname') ?></th>
                    <th><?= $this->Paginator->sort('sex') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('backgroundcolor') ?></th>
                    <th><?= $this->Paginator->sort('tag') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chatCharacters as $chatCharacter): ?>
                <tr>
                    <td><?= $this->Number->format($chatCharacter->id) ?></td>
                    <td><?= $chatCharacter->has('user') ? $this->Html->link($chatCharacter->user->id, ['controller' => 'Users', 'action' => 'view', $chatCharacter->user->id]) : '' ?></td>
                    <td><?= h($chatCharacter->fullname) ?></td>
                    <td><?= h($chatCharacter->sex) ?></td>
                    <td><?= h($chatCharacter->color) ?></td>
                    <td><?= h($chatCharacter->backgroundcolor) ?></td>
                    <td><?= h($chatCharacter->tag) ?></td>
                    <td><?= h($chatCharacter->url) ?></td>
                    <td><?= h($chatCharacter->modified) ?></td>
                    <td><?= h($chatCharacter->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $chatCharacter->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatCharacter->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatCharacter->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
