<table>
    <tbody>
        <?php foreach ($informations as $key => $information) { ?>
        <tr>
            <td class="table-column-date"><?= $information->created ?></td>
            <td><?php echo $this->Html->link($information->title, [
                'controller' => 'Informations', 'action' => 'view', $information->id]);
                 ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
