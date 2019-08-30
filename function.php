<?php

$link = mysqli_connect("localhost", "root", "1", "buku_agus_nurwanto");
if (!$link) {
    die('Not connected : ' . mysqli_error());
}

/**
 * fungsi select_data untuk menampilkan data dari database
 * $link adalah variable koneksi dengan database
 * $type adalah variable untuk menentukan mau menampilkan data dari tabel apa, pilihan (buku, kategori)
 * $cari adalah variable kata kunci pencarian untuk melihat data
 */
function select_data($link, $type, $cari = ''){
	if($type=='buku'){
		$where = '';
		if(!empty($cari)){
			$where = ' where JUDUL like \'%'.mysqli_real_escape_string($link, $cari).'%\'';
		}
		$query = "select * from daftar_buku_dan_kategori_all $where";
		if($result = mysqli_query($link, $query)){
	    	if(mysqli_num_rows($result) > 0){
	    		echo "<table>";
		            echo "<tr>";
		                echo "<th>id_buku</th>";
		                echo "<th>judul</th>";
		                echo "<th>kategori</th>";
		                echo "<th>isbn</th>";
		                echo "<th>penerbit</th>";
		                echo "<th>penulis</th>";
		                echo "<th>aksi</th>";
		            echo "</tr>";
		        while($row = mysqli_fetch_array($result)){
		            echo "<tr>";
		                echo "<td>" . $row['ID_BUKU'] . "</td>";
		                echo "<td>" . $row['JUDUL'] . "</td>";
		                echo "<td data-id='".$row['ID_KATEGORI']."'>" . $row['KATEGORI'] . "</td>";
		                echo "<td>" . $row['ISBN'] . "</td>";
		                echo "<td>" . $row['PENERBIT'] . "</td>";
		                echo "<td>" . $row['PENULIS'] . "</td>";
		                echo "<td><button onclick='edit_buku(this); return false;'>EDIT</button> || <td><button onclick='hapus_buku(this); return false;'>HAPUS</button></td>";
		            echo "</tr>";
		        }
		        echo "</table>";
		        mysqli_free_result($result);
	    	}else{
		        echo "No records matching your query were found.";
		    }
	    }else{
		    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
	}else{
		$query = "select * from kategori";
		if($result = mysqli_query($link, $query)){
	    	if(mysqli_num_rows($result) > 0){
	    		echo "<table>";
		            echo "<tr>";
		                echo "<th>id_kategori</th>";
		                echo "<th>kategori</th>";
		                echo "<th>aksi</th>";
		            echo "</tr>";
		        while($row = mysqli_fetch_array($result)){
		            echo "<tr>";
		                echo "<td>" . $row['id_kategori'] . "</td>";
		                echo "<td>" . $row['kategori'] . "</td>";
		                echo "<td><button onclick='edit_kategori(this); return false;'>EDIT</button> || <td><button onclick='hapus_kategori(this); return false;'>HAPUS</button></td>";
		            echo "</tr>";
		        }
		        echo "</table>";
		        // Free result set
		        mysqli_free_result($result);
	    	}else{
		        echo "No records matching your query were found.";
		    }
	    }else{
		    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
	}
}

/**
 * fungsi simpan_data untuk menyimpan data ke database
 * $link adalah variable koneksi dengan database
 * $type adalah variable untuk menentukan mau menampilkan data dari tabel apa, pilihan (buku, kategori)
 * $data adalah bertipe array berisi data yang akan disimpan
 */
function simpan_data($link, $type, $data){
	$result = false;
	if($type == 'buku'){
		$query = "call TambahBuku(".mysqli_real_escape_string($link, $data['kategori']).", '".mysqli_real_escape_string($link, $data['judul'])."', '".mysqli_real_escape_string($link, $data['isbn'])."', '".mysqli_real_escape_string($link, $data['penerbit'])."', '".mysqli_real_escape_string($link, $data['penulis'])."');";
		$result = mysqli_query($link, $query);
	}else if($type == 'kategori'){
		$query = "call TambahKategori('".mysqli_real_escape_string($link, $data['kategori2'])."');";
		$result = mysqli_query($link, $query);
	}
	return $result;
}

/**
 * fungsi update_data untuk update data di database
 * $link adalah variable koneksi dengan database
 * $type adalah variable untuk menentukan mau menampilkan data dari tabel apa, pilihan (buku, kategori)
 * $data adalah bertipe array berisi data yang akan disimpan
 */
function update_data($link, $type, $data){
	$result = false;
	if($type == 'buku'){
		$result = mysqli_query($link, "update buku set judul='".mysqli_real_escape_string($link, $data['judul'])."', id_kategori='".mysqli_real_escape_string($link, $data['kategori'])."', isbn='".mysqli_real_escape_string($link, $data['isbn'])."', penerbit='".mysqli_real_escape_string($link, $data['penerbit'])."', penulis='".mysqli_real_escape_string($link, $data['penulis'])."' where id_buku=".mysqli_real_escape_string($link, $data['update_buku']));
	}else if($type == 'kategori'){
		$result = mysqli_query($link, "update kategori set kategori='".mysqli_real_escape_string($link, $data['kategori2'])."' where id_kategori=".mysqli_real_escape_string($link, $data['update_kategori']));
	}
	return $result;
}

/**
 * fungsi hapus_data untuk menghapus data di database
 * $link adalah variable koneksi dengan database
 * $type adalah variable untuk menentukan mau menampilkan data dari tabel apa, pilihan (buku, kategori)
 * $data adalah bertipe array berisi data id baris yang akan dihapus
 */
function hapus_data($link, $type, $data){
	$result = false;
	if($type == 'buku'){
		$result = mysqli_query($link, "delete from buku where id_buku=".mysqli_real_escape_string($link, $data['id_buku']));
	}else if($type == 'kategori'){
		$result = mysqli_query($link, "delete from kategori where id_kategori=".mysqli_real_escape_string($link, $data['id_kategori']));
	}
	return $result;
}

/**
 * contoh array 2 dimensi
 */
$data = array(
	array('1'),
	array('2'),
	array('3'),
	array('4')
);
?>