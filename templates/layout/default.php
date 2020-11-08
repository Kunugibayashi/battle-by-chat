<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $siteTitle ?>：<?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

    <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('modal.css') ?>

    <?= $this->Html->script('vue.min.js') ?>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <?php echo $this->element('sitetitle'); ?>
        </div>
        <?php if (!$isAdmin) { ?>
            <div class="top-menu-links">
                <?= $this->Html->link(__('はじめに'), ['controller' => 'Site', 'action' => 'about', ]) ?>
            </div>
            <div class="top-menu-links">
                <?= $this->Html->link(__('世界観'), ['controller' => 'Site', 'action' => 'world', ]) ?>
            </div>
            <div class="top-menu-links">
                <?= $this->Html->link(__('システム説明'), ['controller' => 'Manual', 'action' => 'index', ]) ?>
            </div>
            <div class="top-menu-links">
                <?= $this->Html->link(__('Q&A'), ['controller' => 'Site', 'action' => 'qa', ]) ?>
            </div>
        <?php } ?>
        <div class="top-nav-links">
            <?php if ($loginUsername) { ?>
            <div>
                <?php echo __('Hello, {0}.', [$loginUsername, ]); ?>
            </div>
            <?php echo $this->element('settings'); ?>
            <?php } ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer class="site-footer">
        <div class="historyback">
            <a href="javascript:history.back();">≪ <?= __('back') ?></a>
            ・
            <?php echo $this->Html->link(
                __('top'),
                '/',
            ); ?>
        </div>
        <div class="copyright">
            Copyright (c) 2020 Kunugibayashi<br>
            Released under the MIT license<br>
            <a href="https://opensource.org/licenses/mit-license.php">
                https://opensource.org/licenses/mit-license.php
            </a>
        </div>
    </footer>
<?php echo $this->element('vue/modaltemplate'); ?>
<script>

</script>
</body>
</html>
