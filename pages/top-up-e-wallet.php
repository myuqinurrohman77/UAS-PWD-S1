<?php require_once "bagian/header.php"; ?>
<?php 

require_once "../koneksi/koneksi.php";

$idUser = $_SESSION['id_user'];

$gagalTopUp = false;
$berhasilTopUp = false;

if(isset($_POST['top-up'])){
	if(trim($_POST['nominal']) == "" || empty($_POST['nominal'])){
		$gagalTopUp = true;
	}else{
		$nominal = $_POST['nominal'];

		$uang = "SELECT tbl_e_wallet.jumlah_uang FROM tbl_user JOIN tbl_e_wallet ON tbl_user.id_e_wallet = tbl_e_wallet.id_e_wallet WHERE tbl_user.id_user = $idUser";
		$uangUser = $koneksi->prepare($uang);
		$uangUser->execute();
		$dataUang = $uangUser->fetch(PDO::FETCH_ASSOC);
		$uangSekarang = $dataUang['jumlah_uang'];
		$total = $uangSekarang + $nominal;

		if(isset($dataUang['jumlah_uang']) && $dataUang['jumlah_uang'] !== NULL){
			$sql = "UPDATE tbl_e_wallet SET jumlah_uang = :jumlah_uang WHERE id_user = $idUser";
			$topUp = $koneksi->prepare($sql);
			$topUp->bindParam(':jumlah_uang', $total);
			$hasil = $topUp->execute();
		}else{
			$sql = "UPDATE tbl_e_wallet SET jumlah_uang = :jumlah_uang WHERE id_user = $idUser";
			$topUp = $koneksi->prepare($sql);
			$topUp->bindParam(':jumlah_uang', $nominal);
			$hasil = $topUp->execute();
		}

		$berhasilTopUp = true;
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
                        Top Up E-Wallet
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($gagalTopUp): ?>
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
                        Gagal Top Up
                    </div>
                </div>
            </div>
            <?php elseif($berhasilTopUp): ?>
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
                        berhasil Top Up
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
                                    <label class="form-label">Nominal Rupiah</label>
                                    <input type="number" class="form-control" name="nominal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/profile.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="top-up">Top Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>