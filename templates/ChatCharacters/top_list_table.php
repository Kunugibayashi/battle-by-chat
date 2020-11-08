<table>
    <tbody>
        <?php foreach ($chatCharacters as $key => $chatCharacter) { ?>
        <tr>
            <td class="table-column-date"><?= h($chatCharacter->timeModified) ?></td>
            <td><?php echo $this->Html->link($chatCharacter->fullname, [
                'controller' => 'ChatCharacters', 'action' => 'view', $chatCharacter->id]);
                 ?>
            </td>
            <td><?= h($chatCharacter->detailString) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
