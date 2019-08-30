<?php
include 'function.php';
$cari = '';
$judul = '';
$kategori = '';
$kategori2 = '';
$update_kategori = '';
$isbn = '';
$penerbit = '';
$penulis = '';
$msg = '';
$update_buku =  '';
if(!empty($_POST)){
	if(!empty($_POST['cari'])){
		$cari = $_POST['cari'];
	}
	if(!empty($_POST['tambah'])){
		if($_POST['tambah'] == 'buku'){
			$judul =  $_POST['judul'];
			$kategori =  $_POST['kategori'];
			$isbn =  $_POST['isbn'];
			$penerbit =  $_POST['penerbit'];
			$penulis =  $_POST['penulis'];
			if(!empty($_POST['update_buku'])){
				$update_buku =  $_POST['update_buku'];
				$ret = update_data($link, 'buku', $_POST);
				if(empty($ret)){
					$msg = 'Ada kesalahan!';
				}else{
					$msg = 'Berhasil edit buku!';
				}
			}else{
				$ret = simpan_data($link, 'buku', $_POST);
				if(empty($ret)){
					$msg = 'Ada kesalahan input data!';
				}else{
					$msg = 'Berhasil simpan buku baru!';
				}
			}
		}else if($_POST['tambah'] == 'kategori'){
			$kategori2 =  $_POST['kategori'];
			if(!empty($_POST['update_kategori'])){
				$update_kategori =  $_POST['update_kategori'];
				$ret = update_data($link, 'kategori', $_POST);
				if(empty($ret)){
					$msg = 'Ada kesalahan!';
				}else{
					$msg = 'Berhasil edit kategori!';
				}
			}else{
				$ret = simpan_data($link, 'kategori', $_POST);
				if(empty($ret)){
					$msg = 'Ada kesalahan input data!';
				}else{
					$msg = 'Berhasil simpan kategori baru!';
				}
			}
		}
	}
	if(!empty($_POST['hapus'])){
		if(!empty($_POST['id_buku'])){
			$ret = hapus_data($link, 'buku', $_POST);
			if(empty($ret)){
				$msg = 'Ada kesalahan!';
			}else{
				$msg = 'Berhasil hapus buku!';
			}
		}else if(!empty($_POST['id_kategori'])){
			$ret = hapus_data($link, 'kategori', $_POST);
			if(empty($ret)){
				$msg = 'Ada kesalahan!';
			}else{
				$msg = 'Berhasil hapus kategori!';
			}
		}
		die($msg);
	}
}
if(!empty($msg)){
	$msg = 'alert(\''.$msg.'\');';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>BUKU</title>
	<script type="text/javascript">
		<?php echo $msg; ?>
	</script>
</head>
<body>
	<h2>FILTER BUKU</h2>
	<form method="POST" target="">
		<label>Judul Buku</label>
		<input type="text" name="cari" value="<?php echo $cari; ?>">
		<button type="submit">CARI</button>
		<button onclick="window.location=''; return false;">RESET</button>
	</form>

	<h2>DAFTAR BUKU</h2>
	<?php
		select_data($link, 'buku', $cari);
	?>

	<h2>DAFTAR KATEGORI</h2>
	<?php
		select_data($link, 'kategori');
	?>

	<h2>TAMBAH BUKU</h2>
	<form method="POST" target="">
		<label>Judul</label>
		<input type="text" name="judul" value="<?php echo $judul; ?>">
		<br>
		<label>Kategori</label>
		<input type="text" name="kategori" value="<?php echo $kategori; ?>">
		<br>
		<label>ISBN</label>
		<input type="text" name="isbn" value="<?php echo $isbn; ?>">
		<br>
		<label>Penerbit</label>
		<input type="text" name="penerbit" value="<?php echo $penerbit; ?>">
		<br>
		<label>Penulis</label>
		<input type="text" name="penulis" value="<?php echo $penulis; ?>">
		<br>
		<input type="hidden" name="tambah" value="buku">
		<input type="hidden" name="update_buku" value="<?php echo $update_buku; ?>">
		<button type="submit">TAMBAH</button>
	</form>

	<h2>TAMBAH KATEGORI</h2>
	<form method="POST" target="">
		<label>KATEGORI</label>
		<input type="text" name="kategori2" value="<?php echo $kategori2; ?>">
		<br>
		<input type="hidden" name="tambah" value="kategori">
		<input type="hidden" name="update_kategori" value="<?php echo $update_kategori; ?>">
		<button type="submit">TAMBAH</button>
	</form>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">
		/**
		 * fungsi edit_buku untuk mengambil value dan menset value ke form edit
		 * $that adalah variable yang berisi data HTML baris data yang akan diedit
		 */
		function edit_buku(that) {
			var tr = jQuery(that).closest('tr');
			var id_buku = tr.find('td').eq(0).text();
			var judul = tr.find('td').eq(1).text();
			var kategori = tr.find('td').eq(2).text();
			var id_kategori = tr.find('td').eq(2).attr('data-id');
			var isbn = tr.find('td').eq(3).text();
			var penerbit = tr.find('td').eq(4).text();
			var penulis = tr.find('td').eq(5).text();
			jQuery('input[name="judul"]').val(judul);
			jQuery('input[name="isbn"]').val(isbn);
			jQuery('input[name="kategori"]').val(id_kategori);
			jQuery('input[name="update_buku"]').val(id_buku);
			jQuery('input[name="penerbit"]').val(penerbit);
			jQuery('input[name="penulis"]').val(penulis);
		}
		function edit_kategori(that) {
			var tr = jQuery(that).closest('tr');
			var id_kategori = tr.find('td').eq(0).text();
			var kategori = tr.find('td').eq(1).text();
			jQuery('input[name="kategori2"]').val(kategori);
			jQuery('input[name="update_kategori"]').val(id_kategori);
		}
		function hapus_buku(that) {
			var tr = jQuery(that).closest('tr');
			var id_buku = tr.find('td').eq(0).text();
			if(confirm('Apakah anda yakin akan menghapus buku ini?')){
				jQuery.ajax({
					url: '',
					type: 'post',
					data: {
						id_buku: id_buku,
						hapus: 1
					},
					success: function(ret) {
						alert(ret);
						window.location = '';
					}
				})
			}
		}
		function hapus_kategori(that) {
			var tr = jQuery(that).closest('tr');
			var id_kategori = tr.find('td').eq(0).text();
			if(confirm('Apakah anda yakin akan menghapus kategori ini?')){
				jQuery.ajax({
					url: '',
					type: 'post',
					data: {
						id_kategori: id_kategori,
						hapus: 1
					},
					success: function(ret) {
						alert(ret);
						window.location = '';
					}
				})
			}
		}
	</script>
</body>
</html>
