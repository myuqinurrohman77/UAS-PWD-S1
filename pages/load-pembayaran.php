<?php

session_start();

if(!($_SESSION['role'] == "2")){
	header("Location: ../pages/login.php");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$_SESSION['id_produk'] = $_POST['id_produk'];
	$_SESSION['jumlah_produk'] = $_POST['jumlah_produk'];

	session_write_close();
	header("Location: pembayaran.php");
	exit();
}


?>