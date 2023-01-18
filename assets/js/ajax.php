<script type="text/javascript">
	var MyTable = $('#list-data').dataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false
		});

	window.onload = function() {
		tampilRuangan();
		tampilCategory();
		tampilGereja();
		<?php
			if ($this->session->flashdata('msg') != '') {
				echo "effect_msg();";
			}
		?>
	}

	function refresh() {
		MyTable = $('#list-data').dataTable();
	}

	function effect_msg_form() {
		// $('.form-msg').hide();
		$('.form-msg').show(1000);
		setTimeout(function() { $('.form-msg').fadeOut(1000); }, 3000);
	}

	function effect_msg() {
		// $('.msg').hide();
		$('.msg').show(1000);
		setTimeout(function() { $('.msg').fadeOut(1000); }, 3000);
	}

	function tampilRuangan() {
		$.get('<?php echo base_url('Ruangan/tampil'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-ruangan').html(data);
			refresh();
		});
	}

	var id_ruangan;
	$(document).on("click", ".konfirmasiHapus-ruangan", function() {
		id_ruangan = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataRuangan", function() {
		var id = id_ruangan;
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Ruangan/delete'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#konfirmasiHapus').modal('hide');
			tampilRuangan();
			$('.msg').html(data);
			effect_msg();
		})
	})

	$(document).on("click", ".update-dataRuangan", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Ruangan/update'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#update-ruangan').modal('show');
		})
	})

	$('#form-tambah-ruangan').submit(function(e) {
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Ruangan/prosesTambah'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilRuangan();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-tambah-ruangan").reset();
				$('#tambah-ruangan').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$(document).on('submit', '#form-update-ruangan', function(e){
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Ruangan/prosesUpdate'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilRuangan();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-update-ruangan").reset();
				$('#update-ruangan').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#tambah-ruangan').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$('#update-ruangan').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	//Gereja
	function tampilGereja() {
		$.get('<?php echo base_url('Gereja/tampil'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-gereja').html(data);
			refresh();
		});
	}

	var id_gereja;
	$(document).on("click", ".konfirmasiHapus-gereja", function() {
		id_gereja = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataGereja", function() {
		var id = id_gereja;
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Gereja/delete'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#konfirmasiHapus').modal('hide');
			tampilGereja();
			$('.msg').html(data);
			effect_msg();
		})
	})

	$(document).on("click", ".update-dataGereja", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Gereja/update'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#update-gereja').modal('show');
		})
	})

	$(document).on("click", ".detail-dataGereja", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Gereja/detail'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#tabel-detail').dataTable({
				  "paging": true,
				  "lengthChange": false,
				  "searching": true,
				  "ordering": true,
				  "info": true,
				  "autoWidth": false
				});
			$('#detail-gereja').modal('show');
		})
	})

	$('#form-tambah-gereja').submit(function(e) {
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Gereja/prosesTambah'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilGereja();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-tambah-gereja").reset();
				$('#tambah-gereja').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$(document).on('submit', '#form-update-gereja', function(e){
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Gereja/prosesUpdate'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilGereja();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-update-gereja").reset();
				$('#update-gereja').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#tambah-gereja').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$('#update-gereja').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	//Category
	function tampilCategory() {
		$.get('<?php echo base_url('Category/tampil'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-category').html(data);
			refresh();
		});
	}

	var id_category;
	$(document).on("click", ".konfirmasiHapus-category", function() {
		id_category = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataCategory", function() {
		var id = id_category;
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Category/delete'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#konfirmasiHapus').modal('hide');
			tampilCategory();
			$('.msg').html(data);
			effect_msg();
		})
	})

	$(document).on("click", ".update-dataCategory", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Category/update'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#update-category').modal('show');
		})
	})

	$(document).on("click", ".detail-dataCategory", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('Category/detail'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#tabel-detail').dataTable({
				  "paging": true,
				  "lengthChange": false,
				  "searching": true,
				  "ordering": true,
				  "info": true,
				  "autoWidth": false
				});
			$('#detail-category').modal('show');
		})
	})

	$('#form-tambah-category').submit(function(e) {
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Category/prosesTambah'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilCategory();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-tambah-category").reset();
				$('#tambah-category').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$(document).on('submit', '#form-update-category', function(e){
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('Category/prosesUpdate'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilCategory();
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-update-category").reset();
				$('#update-category').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#tambah-category').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$('#update-category').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})
</script>