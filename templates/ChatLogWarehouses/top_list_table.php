<?php
?>
 <table>
     <tbody>
         <?php foreach ($chatLogWarehouses as $key => $chatLogWarehouse) { ?>
         <tr>
             <td class="table-column-date"><?= $chatLogWarehouse->created ?></td>
             <td><?= h($chatLogWarehouse->chat_room_title) ?></td>
             <td><?= h($chatLogWarehouse->characters) ?></td>
         </tr>
         <?php } ?>
     </tbody>
 </table>
