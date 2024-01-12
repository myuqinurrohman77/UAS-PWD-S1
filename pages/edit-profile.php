<?php require_once "bagian/header-profile.php"; ?>
<?php

require_once "../koneksi/koneksi.php";
$panjangPasswordKurang = false;
$passwordTidakSama = false;

$idUser = $_SESSION['id_user'];
$sqlAmbil = "SELECT * FROM tbl_user WHERE id_user = $idUser";
$user = $koneksi->prepare($sqlAmbil);
$user->execute();
$hasil = $user->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$idUser = $_SESSION['id_user'];
	$fotoBaru = $_FILES['foto_baru'];
	$namaLengkap = $_POST['nama_lengkap'];
	$email = $_POST['email'];
	$password_lama = $_POST['password_lama'];
	$password_baru = $_POST['password_baru'];
    $passwordBaruHashing = md5($password_baru);



	// var_dump($hasil).PHP_EOL;


	if(!(empty(trim($password_lama)) && !(empty(trim($password_baru))))){
		if(strlen($password_baru) < 8){
			$panjangPasswordKurang = true;
		}else{
			if(md5($password_lama) === $hasil['password']){
				if(!(strlen($fotoBaru['name']) > 0)){
					$sql = "UPDATE tbl_user SET nama_lengkap = :nama_lengkap_baru, email = :email_baru, password = :password_baru WHERE id_user=$idUser";
					$update = $koneksi->prepare($sql);
					$update->bindParam(":nama_lengkap_baru", $namaLengkap);
					$update->bindParam(":email_baru", $email);
					// $passwordbaru = md5($_POST['password_baru']);
					$update->bindParam(":password_baru", $passwordBaruHashing);
					$update->execute();

					header("Location: login.php");
					session_destroy();
				}else{

					$waktu = date("Y-m-d H:i:s");
					$namaFoto = $fotoBaru['name'];
					$gabungan = md5($namaFoto.$waktu);
					$tipeGambar = substr($fotoBaru['type'], 6, 15);
					$fotoHashing = "$gabungan.$tipeGambar";
					// var_dump($hasilGabungan).PHP_EOL;
               // var_dump($hasil['foto_profile']).PHP_EOL;


                    if($hasil['foto_profile'] === "default.jpeg"){
                        $sql = "UPDATE tbl_user SET foto_profile = :foto_profile_baru, nama_lengkap = :nama_lengkap_baru, email = :email_baru, password = :password_baru WHERE id_user=$idUser";
                        $update = $koneksi->prepare($sql);
                        $update->bindParam(":foto_profile_baru", $fotoHashing);
                        $update->bindParam(":nama_lengkap_baru", $namaLengkap);
                        $update->bindParam(":email_baru", $email);
                        $update->bindParam(":password_baru", $passwordBaruHashing);
                        $update->execute();
                        move_uploaded_file($fotoBaru['tmp_name'], "../assets/foto-profile/".$fotoHashing);
                        header("Location: login.php");
                        session_destroy();
                    }else{
                        if(file_exists("../assets/foto-profile/".$hasil['foto_profile'])){
                            $sql = "UPDATE tbl_user SET foto_profile = :foto_profile_baru, nama_lengkap = :nama_lengkap_baru, email = :email_baru, password = :password_baru WHERE id_user=$idUser";
                            $update = $koneksi->prepare($sql);
                            $update->bindParam(":foto_profile_baru", $fotoHashing);
                            $update->bindParam(":nama_lengkap_baru", $namaLengkap);
                            $update->bindParam(":email_baru", $email);
                            $update->bindParam(":password_baru", $passwordBaruHashing);
                            $update->execute();
                            move_uploaded_file($fotoBaru['tmp_name'], "../assets/foto-profile/".$fotoHashing);
                            header("Location: login.php");
                            unlink("../assets/foto-profile/".$hasil['foto_profile']);
                            session_destroy();
                        }
                    }



				}
			}else{
				$passwordTidakSama = true;
			}
		}
	}

	if(empty(trim($password_baru)) && empty(trim($password_lama))){
		if(!(strlen($fotoBaru['name']) > 0)){
			$sql = "UPDATE tbl_user SET nama_lengkap = :nama_lengkap_baru, email = :email_baru WHERE id_user=$idUser";
			$update = $koneksi->prepare($sql);
			$update->bindParam(":nama_lengkap_baru", $namaLengkap);
			$update->bindParam(":email_baru", $email);
			$update->execute();
			header("Location: login.php");
			session_destroy();
			
			// var_dump(isset($hasil['id_alamat'])).PHP_EOL;
		}else{
			$waktu = date("Y-m-d H:i:s");
			$namaFoto = $fotoBaru['name'];
			$gabungan = md5($namaFoto.$waktu);
			$tipeGambar = substr($fotoBaru['type'], 6, 15);
			$fotoHashing = "$gabungan.$tipeGambar";

                    if($hasil['foto_profile'] === "default.jpeg"){
                        $sql = "UPDATE tbl_user SET foto_profile = :foto_profile_baru, nama_lengkap = :nama_lengkap_baru, email = :email_baru WHERE id_user=$idUser";
                        $update = $koneksi->prepare($sql);
                        $update->bindParam(":foto_profile_baru", $fotoHashing);
                        $update->bindParam(":nama_lengkap_baru", $namaLengkap);
                        $update->bindParam(":email_baru", $email);
                        $update->execute();
                        move_uploaded_file($fotoBaru['tmp_name'], "../assets/foto-profile/".$fotoHashing);
                        header("Location: login.php");
                        session_destroy();
                    }else{
                        if(file_exists("../assets/foto-profile/".$hasil['foto_profile'])){
                            $sql = "UPDATE tbl_user SET foto_profile = :foto_profile_baru, nama_lengkap = :nama_lengkap_baru, email = :email_baru WHERE id_user = :id_user";
                            $update = $koneksi->prepare($sql);
                            $update->bindParam(":foto_profile_baru", $fotoHashing);
                            $update->bindParam(":nama_lengkap_baru", $namaLengkap);
                            $update->bindParam(":email_baru", $email);
                            $update->bindParam(":id_user", $idUser);
                            $update->execute();
                            move_uploaded_file($fotoBaru['tmp_name'], "../assets/foto-profile/".$fotoHashing);
                            header("Location: login.php");
                            unlink("../assets/foto-profile/".$hasil['foto_profile']);
                            session_destroy();
                        }
                    }
		}
	}


	
	
}

?>
<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($passwordTidakSama): ?>
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
                        Password lama anda salah
                    </div>
                </div>
            </div>
            <?php elseif($panjangPasswordKurang): ?>
            <?php if(true): ?>
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
                        Password terlalu pendek
                    </div>
                </div>
            </div>
            <?php endif ?>
            <?php endif ?>
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Akun Saya</h2>
                            <h2 class="card-title">Edit Profile Pengguna</h2>
                            <form action="" method="post" enctype="multipart/form-data">
                                <h3 class="card-title mt-4">Foto Profile</h3>
                                <div class="row align-items-center">
                                    <div class="col-auto"><input type="file" class="form-control" name="foto_baru"
                                            accept="image/jpg, image/png, image/jpeg, image/pjpeg" />
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">Nama Lengkap</h3>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <input type="text" class="form-control w-auto"
                                                value="<?= $_SESSION['nama_lengkap'] ?>" name="nama_lengkap">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">Email</h3>
                                <p class="card-subtitle">This contact will be shown to others publicly, so choose it
                                    carefully.</p>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <input type="text" class="form-control w-auto"
                                                value="<?= $_SESSION['email'] ?>" name="email">
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset($hasil['id_alamat'])): ?>
                                <h3 class="card-title mt-4">Alamat</h3>
                                <a href="../pages/edit-alamat.php" class="btn btn-primary">Edit Alamat</a>
                                <?php endif; ?>
                                <h3 class="card-title mt-4">Password</h3>
                                <p class="card-subtitle">You can set a permanent password if you don't want to use
                                    temporary
                                    login codes.</p>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <input type="text" class="form-control w-auto" name="password_lama"
                                                placeholder="Password Lama">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row g-2 mt-2">
                                        <div class="col-auto">
                                            <input type="text" class="form-control w-auto" name="password_baru"
                                                placeholder="Password Baru">
                                        </div>
                                    </div>
                                </div>

                                <h3 class="card-title mt-4">Informasi</h3>
                                <p class="card-subtitle">Setelah anda menyimpan perubahan pada profil, anda akan dipaksa
                                    login ulang.</p>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="profile.php" class="btn">
                                    Kembali
                                </a>
                                <!-- <button type="submit" class="btn btn-primary">Simpan Perubahan</button> -->
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-small">
                                    Simpan Perubahan
                                </a>
                            </div>
                        </div>
                        <div class="modal modal-blur fade" id="modal-small" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-title">Anda yakin menyimpan perubahan?</div>
                                        <div>Anda akan dipaksa login ulang setelah mengkonfirmasi perubahan.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link link-secondary me-auto"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Ya, simpan
                                            perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "bagian/footer.php"; ?>