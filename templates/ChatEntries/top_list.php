<?php //var_dump($chatEntries) ?>
<?php foreach ($chatEntries as $key => $chatEntry) { ?>
    <a target="_blank" href="<?php echo $this->Url->build([
                'controller' => 'ChatCharacters',
                'action' => 'view',
                $chatEntry->chat_character->id,
            ]); ?>"><div class="chatroomlist-name"
         style="<?php echo $this->Html->style([
                'color' => $chatEntry->chat_character->color,
                'background-color' => $chatEntry->chat_character->backgroundcolor,
    ]); ?>"><?php echo h($chatEntry->chat_character->fullname); ?></div></a>
<?php } ?>
