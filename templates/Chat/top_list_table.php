<table>
    <tbody>
        <?php foreach ($chatLogs as $key => $chatLog) { ?>
        <tr>
            <td class="table-column-date"><?= $chatLog->created ?></td>
            <td><?= $chatLog->chat_room_title ?></td>
            <td><?= $chatLog->message ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
