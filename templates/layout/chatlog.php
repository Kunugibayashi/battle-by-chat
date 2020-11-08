<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $siteTitle ?>：<?= $chatRoom->chat_room_title ?>
    </title>
</head>
<body>
    <main class="main">
        <div class="container">
            <?= $this->fetch('content') ?>
        </div>
    </main>
</body>
</html>
