<?php

session_start();

require_once "../koneksi/koneksi.php";

$gagalLogin = false;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	if(!(empty($email)) && !(empty($password))){
	$sql = "SELECT * FROM tbl_user WHERE email=:email AND password=:password";
	$user = $koneksi->prepare($sql);
	$user->bindParam(":email", $email);
	$user->bindParam(":password", $password);
	$user->execute();
	$hasil = $user->fetch(PDO::FETCH_ASSOC);

	if($hasil){
		$_SESSION['login'] = true;
		$_SESSION['id_user'] = $hasil['id_user'];
		$_SESSION['nama_lengkap'] = $hasil['nama_lengkap'];
		$_SESSION['email'] = $hasil['email'];
		$_SESSION['role'] = $hasil['role'];
		$_SESSION['foto_profile'] = $hasil['foto_profile'];
		header("Location: beranda.php");
	}else{
		$gagalLogin = true;
	}

	$koneksi = null;
	}else{
		$gagalLogin = true;
	}

}


?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-flags.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-payments.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/demo.min.css?1692870487" rel="stylesheet" />
    <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <?php if($gagalLogin): ?>
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex">
                        <div>
                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>
                        </div>
                        <div>
                            Gagal Login
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login</h2>
                    <form action="" method="post" autocomplete="off" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="emailanda@email.com"
                                autocomplete="off" name="email">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" placeholder="password" autocomplete="off"
                                    name="password">
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center text-secondary mt-3">
                Belum memiliki akun? <a href="daftar.php" tabindex="-1">Daftar</a>
            </div>
            <div class="kembali" style="text-align: center ;"><a href="../index.php">Kembali</a></div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>

</html>