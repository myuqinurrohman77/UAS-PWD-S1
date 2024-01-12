<?php

session_start();

if(!($_SESSION['role'] == "2")){
	header("Location: ../pages/login.php");
}

require_once "../koneksi/koneksi.php";

$idKategori = $_GET['id_kategori'];

$sql = "DELETE FROM tbl_kategori WHERE id_kategori=$idKategori";
$hapus = $koneksi->prepare($sql);
$hasilHapus = $hapus->execute();

$gantiNULL = "SELECT * FROM tbl_produk";
$ganti = $koneksi->prepare($gantiNULL);
$ganti->execute();
$dataProduk = $ganti->fetchAll(PDO::FETCH_ASSOC);

foreach($dataProduk as $dt){

	if($dt['id_kategori'] == NULL){
		$pindahkan = "UPDATE tbl_produk SET id_kategori = 11 WHERE id_produk = {$dt['id_produk']} ";
		$pindah = $koneksi->prepare($pindahkan);
		$pindah->execute();
	}
}

header("Location: kategori.php");