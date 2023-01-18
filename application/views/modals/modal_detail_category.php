<div class="col-md-12 well">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;"><i class="fa fa-briefcase"></i> List Ruangan (Category: <b><?php echo $category->nama; ?></b>)</h3>

  <div class="box box-body">
      <table id="tabel-detail" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Asal gereja</th>
          </tr>
        </thead>
        <tbody id="data-ruangan">
          <?php
            foreach ($dataCategory as $ruangan) {
              ?>
              <tr>
                <td style="min-width:230px;"><?php echo $ruangan->ruangan; ?></td>
                <td><?php echo $ruangan->gereja; ?></td>
              </tr>
              <?php
            }
          ?>
        </tbody>
      </table>
  </div>

  <div class="text-right">
    <button class="btn btn-danger" data-dismiss="modal"> Close</button>
  </div>
</div>