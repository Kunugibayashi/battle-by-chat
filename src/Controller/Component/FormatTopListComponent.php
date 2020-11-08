<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class FormatTopListComponent extends Component
{
    public function formatChatCharacters($chatCharacters)
    {
        $result = array_column($chatCharacters, 'fullname', 'id');
        return $result;
    }

    public function formatChatRooms($chatRooms)
    {
        // 一度に整形できないため、やや冗長
        $result = [];
        $displayno = [];
        // 箱作り
        foreach ($chatRooms as $key => $chatRoom) {
            $result[$chatRoom->id]['id'] = $chatRoom->id;
            $result[$chatRoom->id]['title'] = $chatRoom->title;
            $result[$chatRoom->id]['displayno'] = $chatRoom->displayno;
            $result[$chatRoom->id]['readonly'] = $chatRoom->readonly;
            $result[$chatRoom->id]['chat_entries'] = [];
            // ソート用
            $displayno[$chatRoom->id] = $chatRoom->displayno;
        }
        // 参加者整備
        foreach ($chatRooms as $key => $chatRoom) {
            foreach ($chatRoom->chat_entries as $ekey => $chat_entry) {
                if (isset($chat_entry->chat_character)) {
                    // 変数に入れると参照が変わるためこの書き方
                    array_push(
                        $result[$chatRoom->id]['chat_entries'],
                        $chat_entry->chat_character,
                    );
                }
            }
        }
        // 部屋順でソート
        array_multisort($displayno, SORT_ASC, $result);

        return $result;
    }
}
