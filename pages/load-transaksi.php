<?php

session_start();

if(!($_SESSION['login'] == true)){
	header("Location: ../pages/login.php");
}

sleep(2);

var_dump($_SESSION['id_user']).PHP_EOL;
var_dump($_SESSION['id_produk']).PHP_EOL;
var_dump($_SESSION['jumlah_produk']).PHP_EOL;
var_dump($_SESSION['total_pembayaran']).PHP_EOL;

?>