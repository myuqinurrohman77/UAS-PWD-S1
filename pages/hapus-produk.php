<?php

require_once "../koneksi/koneksi.php";

session_start();

if($_SESSION['role'] === "2"){
	$idProduk = $_GET['id_produk'];

	$sqlAmbil = "SELECT * FROM tbl_produk WHERE id_produk=$idProduk";
	$ambil = $koneksi->prepare($sqlAmbil);
	$ambil->execute();
	$dataProduk = $ambil->fetch(PDO::FETCH_ASSOC);
	
	if(file_exists("../assets/foto-produk/".$dataProduk['gambar_produk'])){
		unlink("../assets/foto-produk/".$dataProduk['gambar_produk']);
	}

	$sql = "DELETE FROM tbl_produk WHERE id_produk=$idProduk";
	$hapus = $koneksi->prepare($sql);
	$hasil = $hapus->execute();





	header("Location: produk.php");
}

header("Location: produk.php");