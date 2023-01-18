<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Update Data Ruangan</h3>
      <form method="POST" id="form-update-ruangan">
        <input type="hidden" name="id" value="<?php echo $dataRuangan->id_ruangan; ?>">
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Nama" name="nama" aria-describedby="sizing-addon2" value="<?php echo $dataRuangan->nama_ruangan; ?>">
        </div>
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-home"></i>
          </span>
          <select name="gereja" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataGereja as $gereja) {
              ?>
              <option value="<?php echo $gereja->id; ?>" <?php if($gereja->id == $dataRuangan->id_gereja){echo "selected='selected'";} ?>><?php echo $gereja->nama; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-briefcase"></i>
          </span>
          <select name="category" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataCategory as $category) {
              ?>
              <option value="<?php echo $category->id; ?>" <?php if($category->id == $dataRuangan->id_category){echo "selected='selected'";} ?>><?php echo $category->nama; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <div class="col-md-12">
              <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Update Data</button>
          </div>
        </div>
      </form>
</div>

<script type="text/javascript">
$(function () {
    $(".select2").select2();

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
});
</script>