<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";


$gagalMenambahkan = false;
$berhasilMenambahkan = false;

if(isset($_POST['daftar'])){
	
	$idUser = $_SESSION['id_user'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordHash = md5($password);
	
	if(empty(trim($username)) || empty(trim($password))){
		$gagalMenambahkan = true;
	}else{
		$tambahProduk = "INSERT INTO tbl_e_wallet (id_user, username, password) VALUES (:id_user, :username, :password)";
		$tambah = $koneksi->prepare($tambahProduk);
		$tambah->bindParam(":id_user", $idUser);
		$tambah->bindParam(":username", $username);
		$tambah->bindParam(":password", $passwordHash);
		$tambah->execute();

		$idterakhir = $koneksi->lastInsertId();
		$updateUser = "UPDATE tbl_user SET id_e_wallet = :id_e_wallet WHERE id_user = $idUser";
		$update = $koneksi->prepare($updateUser);
		$update->bindParam("id_e_wallet", $idterakhir);
		$update->execute();


		$berhasilMenambahkan = true;
	}
}



?>
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Halaman
                    </div>
                    <h2 class="page-title">
                        Daftar E-Wallet
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($gagalMenambahkan): ?>
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
                        Gagal menambahkan E-Wallet
                    </div>
                </div>
            </div>
            <?php elseif($berhasilMenambahkan): ?>
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
                        Berhasil menambahkan E-Wallet
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <form class="card" method="post" action="">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" />
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok_produk">
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/masuk-e-wallet.php" class="btn btn-warning">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="daftar">Daftar E-Wallet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>