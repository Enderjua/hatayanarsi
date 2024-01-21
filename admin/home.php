<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!$_SESSION['username']) {
    header('Location: index.php');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Veritabanı bağlantısı
$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// Hata kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Toplam blog sayısı
$sql = "SELECT COUNT(*) as blog_count FROM blog";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$blog_count = $row['blog_count'];

// Toplam yazar sayısı
$sql = "SELECT COUNT(*) as yazar_count FROM users WHERE yetkisi='yazar'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$yazar_count = $row['yazar_count'];

// Toplam yetkili sayısı
$sql = "SELECT COUNT(*) as yetkili_count FROM users WHERE yetkisi IN ('admin', 'editor', 'founder')";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$yetkili_count = $row['yetkili_count'];

// Kullanıcının yetkisi
$username = $_SESSION['username'];
$sql = "SELECT yetkisi FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_yetki = $row['yetkisi'];

// Son 6 blogu çekiyoruz
$sql = "SELECT * FROM blog ORDER BY id DESC LIMIT 7";
$result = $conn->query($sql);

$blogs = [];
while ($row = $result->fetch_assoc()) {
    $blogs[] = $row;
}

// Her blog için yazarın email bilgisini alıyoruz
foreach ($blogs as &$blog) {
    // print_r($blogs);
    $author = $blog['blogYazari'];
    $sql = "SELECT email FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $blog['authorEmail'] = $row['email'];
}

$conn->close();

?>
<?php include 'includes/header-main.php'; ?>
<div class="row" bis_skin_checked="1">
                                    <div class="col-xl-3 col-md-6" bis_skin_checked="1">
                                        <!-- card -->
                                        <div class="card card-animate" bis_skin_checked="1">
                                            <div class="card-body" bis_skin_checked="1">
                                                <div class="d-flex align-items-center" bis_skin_checked="1">
                                                    <div class="flex-grow-1 overflow-hidden" bis_skin_checked="1">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Toplam Blog Sayısı</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4" bis_skin_checked="1">
                                                    <div bis_skin_checked="1">
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0"><?= $blog_count ?></span></h4>
                                                        
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6" bis_skin_checked="1">
                                        <!-- card -->
                                        <div class="card card-animate" bis_skin_checked="1">
                                            <div class="card-body" bis_skin_checked="1">
                                                <div class="d-flex align-items-center" bis_skin_checked="1">
                                                    <div class="flex-grow-1 overflow-hidden" bis_skin_checked="1">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Toplam Yazar Sayısı</p>
                                                    </div>
                                  
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4" bis_skin_checked="1">
                                                    <div bis_skin_checked="1">
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="36894"><?= $yazar_count ?></span></h4>
                                                       
                                                    </div>
                                      
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6" bis_skin_checked="1">
                                        <!-- card -->
                                        <div class="card card-animate" bis_skin_checked="1">
                                            <div class="card-body" bis_skin_checked="1">
                                                <div class="d-flex align-items-center" bis_skin_checked="1">
                                                    <div class="flex-grow-1 overflow-hidden" bis_skin_checked="1">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Toplam Yetkili Sayısı</p>
                                                    </div>
                             
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4" bis_skin_checked="1">
                                                    <div bis_skin_checked="1">
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="1"> <?= $yetkili_count ?></span></h4>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6" bis_skin_checked="1">
                                        <!-- card -->
                                        <div class="card card-animate" bis_skin_checked="1">
                                            <div class="card-body" bis_skin_checked="1">
                                                <div class="d-flex align-items-center" bis_skin_checked="1">
                                                    <div class="flex-grow-1 overflow-hidden" bis_skin_checked="1">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Sahip Olduğunuz Yetki</p>
                                                    </div>
                                  
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4" bis_skin_checked="1">
                                                    <div bis_skin_checked="1">
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="36894"><?= $user_yetki ?></span></h4>
                                                       
                                                    </div>
                                      
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->


                                    
                                </div>
                                <div class="col-xl-8">
                                        <div class="card">
                                            <div style="padding-top: 10px; padding-left: 10px;" class="card-header align-items-center d-flex">
                                                <h4  class="card-title mb-0 flex-grow-1">Son Bloglar</h4>
                                              
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                            <div class="table-responsive table-card">
    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
        <thead class="text-muted table-light">
            <tr>
                <th scope="col">Blog Sayısı</th>
                <th scope="col">Blog Yazarı</th>
                <th scope="col">Blog Başlığı</th>
                <th scope="col">Blok Etiketleri</th>
                <th scope="col">Blog Yazarı Maili</th>
                <th scope="col">Blog Durumu</th>
                <th scope="col">Blog Okunma Sayısı</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
            <tr>
                <td><?= $blog['id'] ?></td>
                <td><?= $blog['blogYazari'] ?></td>
                <td><?= $blog['blogBaslik'] ?></td>
                <td><?= $blog['mekanEtiketler'] ?></td>
                <td><?= $blog['authorEmail'] ?></td>
                <td>
                    <?php
                    if ($blog['blogDurumu'] == "Yayında") {
                        echo '<span class="badge bg-success-subtle text-success">' . $blog['blogDurumu'] . '</span>';
                    } elseif ($blog['blogDurumu'] == "Beklemede") {
                        echo '<span class="badge bg-warning-subtle text-warning">' . $blog['blogDurumu'] . '</span>';
                    } else {
                        echo '<span class="badge bg-danger-subtle text-danger">' . $blog['blogDurumu'] . '</span>';
                    }
                    ?>
                </td>
                <td><?= $blog['blogGorunmeSayisi'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div>

<?php include 'includes/footer-main.php'; ?>
