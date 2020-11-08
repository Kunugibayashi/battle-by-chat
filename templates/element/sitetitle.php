<?php
if ($isAdmin) {
    echo $this->Html->link(
        $siteTitle . ' : ' . __('管理画面'),
        '/admin/',
    );
} else {
    echo $this->Html->link(
        $siteTitle,
        '/',
    );
}
