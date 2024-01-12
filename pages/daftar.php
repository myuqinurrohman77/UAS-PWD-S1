<?php 

require_once "../koneksi/koneksi.php";

$daftarBershasil = false;
$daftarGagal = false;
$passwordTerlaluPendek = false;
$dataKosong = false;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$nama_lengkap = $_POST['nama_lengkap'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$role = 1;
	if(!(empty($nama_lengkap)) && !(empty($email)) && !(empty($password))){
		if(trim($nama_lengkap) !== "" && trim($email) !== "" && trim($password) !== ""){
			if(strlen($password) > 8){
				$sql = "INSERT INTO tbl_user (nama_lengkap, email, password, role) VALUES (:nama_lengkap,:email,:password, :role)";
				$insert = $koneksi->prepare($sql);
				$insert->bindParam(':nama_lengkap', $nama_lengkap);
				$insert->bindParam(':email', $email);
				$insert->bindParam(':role', $role);
				$insert->bindParam(':password', $password);
	
				$hasil = $insert->execute();
				if($hasil){
					$daftarBershasil = true;
				}else{
					$daftarGagal = true;
				}
	
				$koneksi = null;
			}else{
				$passwordTerlaluPendek = true;
			}
		}
		
	}else{
		$dataKosong = true;
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
    <title>Daftar</title>
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
                <?php if($daftarBershasil): ?>
                <div class="alert alert-success" role="alert">
                    <div class="d-flex">
                        <div>
                            <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </div>
                        <div>
                            Daftar berhasil, akun anda sudah terdaftar
                        </div>
                    </div>
                </div>
                <?php elseif($daftarGagal): ?>
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
                            Daftar akun gagal
                        </div>
                    </div>
                </div>
                <?php elseif($passwordTerlaluPendek): ?>
                <div class="alert alert-warning" role="alert">
                    <div class="d-flex">
                        <div>
                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                <path d="M12 9v4" />
                                <path d="M12 17h.01" />
                            </svg>
                        </div>
                        <div>
                            Password anda terlalu pendek, minimal 8 karakter
                        </div>
                    </div>
                </div>
                <?php elseif($dataKosong): ?>
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
                            Tidak boleh ada form yang kosong
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <form class="card card-md" action="" method="post" autocomplete="off">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Daftar akun</h2>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Nama lengkap anda" name="nama_lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email anda" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Password" autocomplete="off"
                                name="password">
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100" name="btn_daftar">Daftar</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">
                Sudah memiliki akun? <a href="login.php" tabindex="-1">Masuk</a>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>

</html>