<?php
  $no = 1;
  foreach ($dataGereja as $gereja) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $gereja->nama; ?></td>
      <td class="text-center" style="min-width:230px;">
          <button class="btn btn-warning update-dataGereja" data-id="<?php echo $gereja->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
          <button class="btn btn-danger konfirmasiHapus-gereja" data-id="<?php echo $gereja->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
          <button class="btn btn-info detail-dataGereja" data-id="<?php echo $gereja->id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Detail</button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>