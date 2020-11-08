<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChatRoom $chatRoom
 */
?>
<div class="row">
    <div class="column-responsive column">
        <div class="chatRooms form content">
            <?= $this->Form->create($chatRoom) ?>
            <fieldset>
                <legend><?= __('部屋設定') ?></legend>
                <?php
                    echo $this->Form->control('title', ['label' => 'ルーム名']);
                    echo $this->Form->control('information', [
                        'label' => 'ルーム説明',
                        'type' => 'textarea',
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('変更')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
