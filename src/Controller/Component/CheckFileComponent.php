<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Filesystem\Folder;

class CheckFileComponent extends Component
{
    public function findChatRoomCss($chatRoomId)
    {
        $cssPath = WWW_ROOT . 'css/room/';
        $cssdir = new Folder(WWW_ROOT . 'css/room/');
        $chatRoomCss = $cssdir->find($chatRoomId . '\.css');
        if ($chatRoomCss) {
            return "room/" . $chatRoomId;
        }
        return "";
    }
}
