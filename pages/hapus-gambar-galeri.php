<?php

session_start();

if(!($_SESSION['role'] == "2")){
	header("Location: ../pages/login.php");
}

require "../koneksi/koneksi.php";

$idGambar = $_GET['id_galeri'];

$sql = "DELETE FROM tbl_galeri WHERE id_galeri = $idGambar";
$hapus = $koneksi->prepare($sql);
$hapus->execute();

Header("Location: kelola-galeri.php");