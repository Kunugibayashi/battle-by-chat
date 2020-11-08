<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('メニュー') ?></h4>
            <?= $this->Html->link(__('メッセージ一覧'), ['controller' => 'Messages', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="messages form content">
            <?= $this->Form->create($receivedMessage) ?>
            <fieldset>
                <legend><?= __('メッセージ送信') ?></legend>
                <?php
                    echo $this->Form->hidden('chat_character_key');
                    echo $this->Form->control('chat_character_fullname', ['label' => '宛先', 'readonly' => true]);
                    echo $this->Form->control('from_chat_character_key', ['label' => '差出人', 'options' => $fromCharacters]);
                    echo $this->Form->control('title', ['label' => '件名', ]);
                    echo $this->Form->control('message', ['label' => '本文', ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('送信')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
