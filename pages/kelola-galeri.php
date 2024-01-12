<?php 

require_once "../koneksi/koneksi.php";

$sql = "SELECT * FROM tbl_galeri";
$ambil = $koneksi->prepare($sql);
$ambil->execute();
$dataGambar = $ambil->fetchAll(PDO::FETCH_ASSOC);

// var_dump($dataGambar).PHP_EOL;


?>
<?php require_once "bagian/header-admin.php"; ?>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/galeri.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-back-up" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 14l-4 -4l4 -4" />
                                    <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Kembali
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
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
                        Data Gambar Galeri
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Gambar</th>
                                    <th>Aksi</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataGambar as $dt): ?>
                                <tr>
                                    <td data-label="Name">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                style="background-image: url(../assets/galeri/<?= $dt['nama_gambar'] ?>)"></span>
                                            <!-- <div class="flex-fill">
                                                <div class="font-weight-medium"><?= $dt['nama_lengkap'] ?></div>
                                                <div class="text-secondary"><a href="#"
                                                        class="text-reset"><?= $dt['email'] ?></a></div>
                                            </div> -->
                                        </div>
                                    </td>
                                    <td data-label="Title">
                                        <div class="text-secondary"><?= $dt['nama_gambar'] ?></div>
                                    </td>
                                    <td class="text-secondary" data-label="Role">
                                        <a href="../pages/hapus-gambar-galeri.php?id_galeri=<?= $dt['id_galeri'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" style="color: red;">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>