<?php
  foreach ($dataRuangan as $ruangan) {
    ?>
    <tr>
      <td style="min-width:230px;"><?php echo $ruangan->ruangan; ?></td>
      <td><?php echo $ruangan->gereja; ?></td>
      <td><?php echo $ruangan->category; ?></td>
      <td class="text-center" style="min-width:230px;">
        <button class="btn btn-warning update-dataRuangan" data-id="<?php echo $ruangan->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
        <button class="btn btn-danger konfirmasiHapus-ruangan" data-id="<?php echo $ruangan->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
      </td>
    </tr>
    <?php
  }
?>