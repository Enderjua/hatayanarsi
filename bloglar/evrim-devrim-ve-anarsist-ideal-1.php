<?php require_once '../includes/connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$successMessage = false;
$falseMessage = false;

$id = 3;
// Veriyi çekmek için SQL sorgusu
$sql = "SELECT id, kapakFoto, mekanEtiketler, blogBaslik, blogAciklama1, blogAciklamaTuru1, aciklama1Renk, aciklama1ResimKonumu, aciklama1Resim, blogAciklama2, blogAciklamaTuru2, aciklama2Renk, aciklama2ResimKonumu, aciklama2Resim, 
resimOlsunMu, ekstraResim, gununSozu, gununSozuYazari, blogYazarDusuncesi, blogDurumu, blogTarihi, blogYorumSayisi, blogGorunmeSayisi, blogYazari FROM blog WHERE id = $id";

// Sorguyu çalıştır
$stmt = $pdo->query($sql);


$non = false;
$color = false;
$picture = false;
$sag = false;
$sol = false;
$non2 = false;
$color2 = false;
$picture2 = false;
$sag2 = false;
$sol2 = false;
$extrapicture = false;




// Veriyi dizi olarak al
$blog = $stmt->fetch();
if ($blog) {
    $kapakFotografi = $blog['kapakFoto'];
    $mekanEtiketler = $blog['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);
    $baslik = $blog['blogBaslik'];
    $blogAciklama1s = $blog['blogAciklama1'];
    $blogAciklamaTuru1 = $blog['blogAciklamaTuru1'];
    if ($blogAciklamaTuru1 == "Hiçbiri") {
        $non = true;
    } else if ($blogAciklamaTuru1 == "Renkli") {
        $color = true;
        $aciklama1Renk = $blog['aciklama1Renk'];
    } else if ($blogAciklamaTuru1 == "Resimli") {
        $picture = true;
        $aciklama1ResimKonumu = $blog['aciklama1ResimKonumu'];
        if ($aciklama1ResimKonumu == "Sağ") {
            $sag = true;
        } else {
            $sol = true;
        }
        $aciklama1Resim = $blog['aciklama1Resim'];
    }
    $blogAciklama2 = $blog['blogAciklama2'];
    $blogAciklamaTuru2 = $blog['blogAciklamaTuru2'];
    if ($blogAciklamaTuru2 == "Hiçbiri") {
        $non2 = true;
    } else if ($blogAciklamaTuru2 == "Renkli") {
        $color2 = true;
        $aciklama2Renk = $blog['aciklama2Renk'];
    } else if ($blogAciklamaTuru2 == "Resimli") {
        $picture2 = true;
        $aciklama2ResimKonumu = $blog['aciklama2ResimKonumu'];
        if ($aciklama2ResimKonumu == "Sağ") {
            $sag2 = true;
        } else {
            $sol2 = true;
        }
        $aciklama2Resim = $blog['aciklama2Resim'];
    }
    $resimOlsunMu = $blog['resimOlsunMu'];
    if ($resimOlsunMu == "Evet") {
        $extrapicture = true;
        $ekstraResim = $blog['ekstraResim'];
    }
    $gununSozu = $blog['gununSozu'];
    $gununSozuYazari = $blog['gununSozuYazari'];
    $blogYazarDusuncesi = $blog['blogYazarDusuncesi'];
    $blogDurumu = $blog['blogDurumu'];
    $blogTarihi = $blog['blogTarihi'];
    $blogYorumSayisi = $blog['blogYorumSayisi'];
    $blogGorunmeSayisi = $blog['blogGorunmeSayisi'];
    $blogYazari = $blog['blogYazari'];
}



?>

<?php
if (isset($_POST['yorum'])) {
    // Veritabanı bağlantısı
    $baglanti = new PDO('mysql:host=localhost;dbname=hatayanarsi', 'root', '');

    // POST verilerini al
    $adsoyad = $_POST['username'];
    $yorum = $_POST['comment'];
    $blog_id = $id;

    // Tarihi al
    $tarih = date('Y-m-d H:i:s'); // Şu anki tarihi ve saati al

    // Veritabanına kaydet
    $sorgu = $baglanti->prepare("INSERT INTO yorumlar (blogId, yorum, adsoyad, tarih) VALUES (?, ?, ?, ?)");
    $result = $sorgu->execute([$blog_id, $yorum, $adsoyad, $tarih]);

    if ($result) {
        $successMessage = true;
    } else {
        $falseMessage = true;
        // İsterseniz burada bir hata mesajı da ayarlayabilirsiniz.
    }
}
?>

<?php

$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// $blogYazari'ya karşılık gelen pp değerini çekiyoruz
$sql = "SELECT pp FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $blogYazari);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$pp_link = $row['pp'];  // bu değişken pp'nin linkini içeriyor

// blog tablosundan rastgele bir satır çekiyoruz
$sql = "SELECT kapakFoto, blogBaslik, blogAciklama1 FROM blog ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$kapakFoto = "http://localhost/hatay/admin/" . $row['kapakFoto'];
$blogBaslik = $row['blogBaslik'];
$blogAciklama1 = mb_substr($row['blogAciklama1'], 0, 100) . "...";  // İlk 100 karakteri alıp sonuna '...' ekliyoruz

$conn->close();

// Veritabanı bağlantısı (zaten mevcutsa bu adımı atlayabilirsiniz)
$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// blog tablosundan blogGorunmeSayisi'ne göre sıralı olarak en fazla olan ilk 5 blogu çekiyoruz
$sql = "SELECT kapakFoto, blogBaslik, blogAciklama1 FROM blog ORDER BY blogGorunmeSayisi DESC LIMIT 5";
$result = $conn->query($sql);

$popularBlogs = [];
while ($row = $result->fetch_assoc()) {
    $row['blogAciklama1'] = mb_substr($row['blogAciklama1'], 0, 100) . "...";  // İlk 100 karakteri alıp sonuna '...' ekliyoruz
    $popularBlogs[] = $row;
}

// Bağlantıyı kapatıyoruz
$conn->close();


// Veritabanı bağlantısı (zaten mevcutsa bu adımı atlayabilirsiniz)
$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// Kullanıcının son ziyaret zamanını çerezden alıyoruz
$lastVisit = isset($_COOKIE['lastVisit']) ? intval($_COOKIE['lastVisit']) : 0;

// Geçerli zamanı alıyoruz
$currentTime = time();

// Eğer kullanıcının son ziyareti üzerinden 5 dakika (300 saniye) geçtiyse ya da hiç ziyaret etmediyse
if ($currentTime - $lastVisit > 180 || $lastVisit == 0) {
    // blogGorunmeSayisi'ni arttırıyoruz
    $sql = "UPDATE blog SET blogGorunmeSayisi = blogGorunmeSayisi + 1 WHERE id = ?";  // Burada id'nizi de belirtmelisiniz
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);  // $blogId değişkenini blogunuzun id'si ile değiştirin
    $stmt->execute();
    $stmt->close();

    // Kullanıcının son ziyaret zamanını güncelliyoruz
    setcookie('lastVisit', $currentTime, time() + 365 * 24 * 3600);  // 1 yıl süreyle çerez saklanacak
}

// Bağlantıyı kapatıyoruz
$conn->close();


$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// Hata kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Yorumlar tablosunda belirtilen blogId'ye eşleşen yorum sayısını al
$sql = "SELECT COUNT(*) as yorum_sayisi FROM yorumlar WHERE blogId=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$yorum_sayisi = $row['yorum_sayisi'];

// Yorum sayısını blog tablosunda güncelle
$sql = "UPDATE blog SET blogYorumSayisi=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $yorum_sayisi, $id);
$stmt->execute();

$conn->close();

// Veritabanı bağlantısı
$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// Hata kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $id değişkenini kullanarak blogDurumu sütununu sorgula
$sql = "SELECT blogDurumu FROM blog WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$blogDurumu = $row['blogDurumu'];

$alertMessage = "";
$alertType = "";

if ($blogDurumu == "Beklemede") {
    $alertMessage = "Blog yetkililer tarafından kontrol aşamasındadır.";
    $alertType = "warning"; // Sarı renkli uyarı mesajı için
} elseif ($blogDurumu == "Yayından Kaldırıldı") {
    $alertMessage = "Blog yetkililer tarafından kaldırılmıştır.";
    $alertType = "danger"; // Kırmızı renkli hata mesajı için
}

?>


<?php include('../includes/blogHead.php'); ?>

<body class='v1-8 homepage_view multiple_view dark rounded'>
    <!-- .wrapper -->
    <div class='wrapper uk-offcanvas-content uk-light'>
        <!-- header -->
        <?php include('../includes/blogHeader.php'); ?>

        <div class="wrapper uk-offcanvas-content uk-light" bis_skin_checked="1">
    <!-- header -->
    <header>

        <?php
        if (!empty($alertMessage)) {
            echo '<div class="container mt-3"><div class="alert alert-' . $alertType . ' alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>' . 
                  $alertMessage . '</div></div>';
                  include('../includes/blogFooter.php');
                  include('../includes/sidenav.php');
                  exit;
        }
        ?>





                <div class="top_bg has_full_header" bis_skin_checked="1">

                    <div class="full_header" bis_skin_checked="1">
                        <div class="uk-container" bis_skin_checked="1">
                            <h1 class="post_title entry-title uk-article-title"><?php echo $baslik;  ?></h1>
                            <div class="post_header uk-article-meta uk-margin-bottom" bis_skin_checked="1">
                                <div class="post_header_line" bis_skin_checked="1"><span class="post_author vcard uk-margin-right uk-margin-small-bottom"><span class="post_author_label uk-margin-xsmall-right"><span class="uk-icon uk-margin-small-right" data-uk-icon="icon:user;ratio:.75"><svg width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="user">
                                                    <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.9" cy="6.4" r="4.4"></circle>
                                                    <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,19 C2.3,14.5 5.8,11.2 10,11.2 C14.2,11.2 17.7,14.6 18.5,19.2"></path>
                                                </svg></span>Yazar</span><span class="fn"><a class="g-profile" href="#" rel="author" title="author profile"><span><?php echo $blogYazari; ?> </span></a></span></span><span class="post_timestamp uk-margin-right uk-margin-small-bottom"><span class="post_timestamp_label uk-margin-xsmall-right"><span class="uk-icon uk-margin-small-right" data-uk-icon="icon:clock;ratio:.75"><svg width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="clock">
                                                    <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9"></circle>
                                                    <rect x="9" y="4" width="1" height="7"></rect>
                                                    <path fill="none" stroke="#000" stroke-width="1.1" d="M13.018,14.197 L9.445,10.625"></path>
                                                </svg></span>Yayınlanma Tarihi</span>
                                        <meta content="#"><a class="timestamp-link" href="#" rel="bookmark" title="permanent link"><time class="published" datetime="2018-04-05T01:08:00-07:00" title="2018-04-05T01:08:00-07:00"><?php echo $blogTarihi; ?></time></a>
                                    </span><span class="post_comment_link uk-margin-right uk-margin-small-bottom"><span class="post_comment_link_label"><span class="uk-icon uk-margin-small-right" data-uk-icon="icon:comment;ratio:.75"><svg width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="comment">
                                                    <path d="M6,18.71 L6,14 L1,14 L1,1 L19,1 L19,14 L10.71,14 L6,18.71 L6,18.71 Z M2,13 L7,13 L7,16.29 L10.29,13 L18,13 L18,2 L2,2 L2,13 L2,13 Z"></path>
                                                </svg></span></span><a class="comment-link" href="#" onclick="">
                                            <?php echo $blogYorumSayisi; ?> Yorum
                                        </a></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- main -->
            <main>
                <!-- .top_full_ads -->
                <div class="top_full_ads uk-container" bis_skin_checked="1">
                    <div class="full_ads_section no-items section" id="full_ads_section_1" bis_skin_checked="1"></div>
                </div>
                <!-- .main_content -->
                <div class="main_content uk-container" bis_skin_checked="1">
                    <div class="uk-grid" bis_skin_checked="1">
                        <!-- .main -->
                        <div class="uk-width-2-3@l" bis_skin_checked="1">
                            <div class="main section" id="main" bis_skin_checked="1">
                                <div class="widget Blog" data-version="2" id="Blog1" bis_skin_checked="1">
                                    <div class="single_post hfeed uk-child-width-1-1" id="single_post" bis_skin_checked="1">
                                        <article class="post hentry">
                                            <div class="post_content" bis_skin_checked="1">



                                                <div class="inline_banner" bis_skin_checked="1">
                                                    <div class="inline_banner_demo" data-height="90" bis_skin_checked="1">
                                                        Reklam Alanı
                                                    </div>
                                                </div>
                                                <div class="post_body entry-content uk-margin-large-bottom" id="post_body_4536402983010354906" data-uk-lightbox="toggle:a[imageanchor]" bis_skin_checked="1">
                                                    <div style="" bis_skin_checked="1">
                                                        <div style="text-align: justify;" bis_skin_checked="1"> <a href="#" imageanchor="1" data-type="image"><img src="http://localhost/hatay/admin/<?= $kapakFotografi ?>" data-original-width="920" data-original-height="627" border="0"></a></div>
                                                    </div> <br>
                                                    <?php if ($non == true) {
                                                    ?>
                                                        <hr>
                                                        <p style="text-align: justify"><?php echo $blogAciklama1s; ?></p>
                                                        <?php } else if ($color == true) {
                                                        if ($aciklama1Renk == "kirmizi") {
                                                        ?>

                                                            <hr>
                                                            <div class="uk-padding-medium" style="background:#e43433;color:#fff;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama1s; ?></div> <?php } else if ($aciklama1Renk == "yesil") {
                                                                                                                                                                                                                ?> <div class="uk-padding-medium" style="background:#16A085;color:#FAFDFD;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama1s; ?></div>

                                                        <?php } else if ($aciklama1Renk == "gri") {
                                                        ?> <div class="uk-padding-medium" style="background:#888888;color:#FFFFFF;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama1s; ?></div>
                                                        <?php }
                                                                                                                                                                                                        } else if ($picture == true) {
                                                                                                                                                                                                            if ($aciklama1ResimKonumu == "sol") {
                                                        ?> <div class="uk-padding-medium" style="background:#888;color:#FFF" bis_skin_checked="1">
                                                                <div class="uk-grid-medium uk-grid" data-uk-grid="" bis_skin_checked="1">
                                                                    <div class="uk-width-1-3@m uk-first-column image-wrapper" bis_skin_checked="1">
                                                                        <a href="#" imageanchor="1" data-type="image">
                                                                            <img src="admin/<?= $aciklama1Resim ?>" border="0">
                                                                        </a>
                                                                    </div>
                                                                    <div class="uk-width-2-3@m" bis_skin_checked="1">
                                                                        <p style="text-align: justify;" class=""><?php echo $blogAciklama1s; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else if ($aciklama1ResimKonumu == "alt") { ?>
                                                            <div class="uk-padding-medium" style="background:#888;color:#FFF" bis_skin_checked="1">
                                                                <div class="uk-grid-medium uk-grid" data-uk-grid="" bis_skin_checked="1">
                                                                    <div class="uk-width-2-3@m text-wrapper" bis_skin_checked="1">
                                                                        <p style="text-align: justify;"><?php echo $blogAciklama1s; ?></p>
                                                                    </div>
                                                                    <div class="uk-width-1-3@m uk-first-column image-wrapper" bis_skin_checked="1">
                                                                        <a href="#" imageanchor="1" data-type="image">
                                                                            <img src="admin/<?= $aciklama1Resim ?>" border="0">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php }
                                                                                                                                                                                                        } ?>
                                                    <br>
                                                    <br>


                                                    <?php if ($non2 == true) {
                                                    ?>
                                                        <hr>
                                                        <p style="text-align: justify"><?php echo $blogAciklama2; ?></p>
                                                        <?php } else if ($color2 == true) {
                                                        if ($aciklama2Renk == "kirmizi") {
                                                        ?>

                                                            <hr>
                                                            <div class="uk-padding-medium" style="background:#e43433;color:#fff;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama2; ?></div> <?php } else if ($aciklama2Renk == "yesil") {
                                                                                                                                                                                                                ?> <div class="uk-padding-medium" style="background:#16A085;color:#FAFDFD;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama2; ?></div>

                                                        <?php } else if ($aciklama2Renk == "gri") {
                                                        ?> <div class="uk-padding-medium" style="background:#888888;color:#FFFFFF;text-align:justify" bis_skin_checked="1"><?php echo $blogAciklama2; ?></div>
                                                        <?php }
                                                                                                                                                                                                        } else if ($picture2 == true) {
                                                                                                                                                                                                            if ($aciklama2ResimKonumu == "sol") {
                                                        ?> <div class="uk-padding-medium" style="background:#888;color:#FFF" bis_skin_checked="1">
                                                                <div class="uk-grid-medium uk-grid" data-uk-grid="" bis_skin_checked="1">
                                                                    <div class="uk-width-1-3@m uk-first-column image-wrapper" bis_skin_checked="1">
                                                                        <a href="#" imageanchor="1" data-type="image">
                                                                            <img src="admin/<?= $aciklama2Resim ?>" border="0">
                                                                        </a>
                                                                    </div>
                                                                    <div class="uk-width-2-3@m" bis_skin_checked="1">
                                                                        <p style="text-align: justify;" class=""><?php echo $blogAciklama2; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else if ($aciklama2ResimKonumu == "sag") { ?>
                                                            <div class="uk-padding-medium" style="background:#888;color:#FFF" bis_skin_checked="1">
                                                                <div class="uk-grid-medium uk-grid" data-uk-grid="" bis_skin_checked="1">
                                                                    <div class="uk-width-2-3@m text-wrapper" bis_skin_checked="1">
                                                                        <p style="text-align: justify;"><?php echo $blogAciklama2; ?></p>
                                                                    </div>
                                                                    <div class="uk-width-1-3@m uk-first-column image-wrapper" bis_skin_checked="1">
                                                                        <a href="#" imageanchor="1" data-type="image">
                                                                            <img src="admin/<?= $aciklama2Resim ?>" border="0">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php }
                                                                                                                                                                                                        } ?>
                                                    <blockquote>
                                                        <p><?php echo $gununSozu;  ?></p>
                                                        <footer><?php echo $gununSozuYazari ?></footer>
                                                    </blockquote>
                                                </div>


                                                <div class="inline_banner" bis_skin_checked="1">
                                                    <div class="inline_banner_demo" data-height="90" bis_skin_checked="1">
                                                        Reklam Alanı
                                                    </div>
                                                </div>

                                                <div class="post_footer uk-article-meta" bis_skin_checked="1">
                                                    <div class="post_footer_line post_footer_line_1" bis_skin_checked="1"><span class="post_labels uk-margin-right uk-margin-small-bottom"><span class="post_labels_label uk-margin-xsmall-right"><span class="uk-icon uk-margin-small-right" data-uk-icon="icon:tag;ratio:.75"><svg width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="tag">
                                                                        <path fill="none" stroke="#000" stroke-width="1.1" d="M17.5,3.71 L17.5,7.72 C17.5,7.96 17.4,8.2 17.21,8.39 L8.39,17.2 C7.99,17.6 7.33,17.6 6.93,17.2 L2.8,13.07 C2.4,12.67 2.4,12.01 2.8,11.61 L11.61,2.8 C11.81,2.6 12.08,2.5 12.34,2.5 L16.19,2.5 C16.52,2.5 16.86,2.63 17.11,2.88 C17.35,3.11 17.48,3.4 17.5,3.71 L17.5,3.71 Z"></path>
                                                                        <circle cx="14" cy="6" r="1"></circle>
                                                                    </svg></span>Etiketler</span>
                                                            <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '<a href="#" rel="tag">#' . $etiket . '</a> ';
                                                            }
                                                            ?> </a></span></div>
                                                    <div class="post_footer_line post_footer_line_2" bis_skin_checked="1">
                                                        <div class="post_share uk-margin-right uk-margin-small-bottom" bis_skin_checked="1"><span class="post_share_label"><span class="uk-icon uk-margin-small-right" data-uk-icon="icon:social;ratio:.75"><svg width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="social">
                                                                        <line fill="none" stroke="#000" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7"></line>
                                                                        <line fill="none" stroke="#000" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8"></line>
                                                                        <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3"></circle>
                                                                        <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3"></circle>
                                                                        <circle fill="none" stroke="#000" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3"></circle>
                                                                    </svg></span>Paylaş</span>
                                                            <ul class="post_share_buttons uk-iconnav uk-text-center uk-margin-remove">
                                                                <li class="uk-padding-remove"><span class="icon_facebook uk-icon-button uk-icon" data-href="https://www.facebook.com/sharer/sharer.php?u=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html" data-uk-icon="facebook" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="facebook">
                                                                            <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_twitter uk-icon-button uk-icon" data-href="https://twitter.com/intent/tweet?text=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html" data-uk-icon="twitter" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="twitter">
                                                                            <path d="M19,4.74 C18.339,5.029 17.626,5.229 16.881,5.32 C17.644,4.86 18.227,4.139 18.503,3.28 C17.79,3.7 17.001,4.009 16.159,4.17 C15.485,3.45 14.526,3 13.464,3 C11.423,3 9.771,4.66 9.771,6.7 C9.771,6.99 9.804,7.269 9.868,7.539 C6.795,7.38 4.076,5.919 2.254,3.679 C1.936,4.219 1.754,4.86 1.754,5.539 C1.754,6.82 2.405,7.95 3.397,8.61 C2.79,8.589 2.22,8.429 1.723,8.149 L1.723,8.189 C1.723,9.978 2.997,11.478 4.686,11.82 C4.376,11.899 4.049,11.939 3.713,11.939 C3.475,11.939 3.245,11.919 3.018,11.88 C3.49,13.349 4.852,14.419 6.469,14.449 C5.205,15.429 3.612,16.019 1.882,16.019 C1.583,16.019 1.29,16.009 1,15.969 C2.635,17.019 4.576,17.629 6.662,17.629 C13.454,17.629 17.17,12 17.17,7.129 C17.17,6.969 17.166,6.809 17.157,6.649 C17.879,6.129 18.504,5.478 19,4.74"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_whatsapp uk-icon-button uk-icon" data-href="https://wa.me/?text=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html" data-uk-icon="whatsapp" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="whatsapp">
                                                                            <path d="M16.7,3.3c-1.8-1.8-4.1-2.8-6.7-2.8c-5.2,0-9.4,4.2-9.4,9.4c0,1.7,0.4,3.3,1.3,4.7l-1.3,4.9l5-1.3c1.4,0.8,2.9,1.2,4.5,1.2 l0,0l0,0c5.2,0,9.4-4.2,9.4-9.4C19.5,7.4,18.5,5,16.7,3.3 M10.1,17.7L10.1,17.7c-1.4,0-2.8-0.4-4-1.1l-0.3-0.2l-3,0.8l0.8-2.9 l-0.2-0.3c-0.8-1.2-1.2-2.7-1.2-4.2c0-4.3,3.5-7.8,7.8-7.8c2.1,0,4.1,0.8,5.5,2.3c1.5,1.5,2.3,3.4,2.3,5.5 C17.9,14.2,14.4,17.7,10.1,17.7 M14.4,11.9c-0.2-0.1-1.4-0.7-1.6-0.8c-0.2-0.1-0.4-0.1-0.5,0.1c-0.2,0.2-0.6,0.8-0.8,0.9 c-0.1,0.2-0.3,0.2-0.5,0.1c-0.2-0.1-1-0.4-1.9-1.2c-0.7-0.6-1.2-1.4-1.3-1.6c-0.1-0.2,0-0.4,0.1-0.5C8,8.8,8.1,8.7,8.2,8.5 c0.1-0.1,0.2-0.2,0.2-0.4c0.1-0.2,0-0.3,0-0.4C8.4,7.6,7.9,6.5,7.7,6C7.5,5.5,7.3,5.6,7.2,5.6c-0.1,0-0.3,0-0.4,0 c-0.2,0-0.4,0.1-0.6,0.3c-0.2,0.2-0.8,0.8-0.8,2c0,1.2,0.8,2.3,1,2.4c0.1,0.2,1.7,2.5,4,3.5c0.6,0.2,1,0.4,1.3,0.5 c0.6,0.2,1.1,0.2,1.5,0.1c0.5-0.1,1.4-0.6,1.6-1.1c0.2-0.5,0.2-1,0.1-1.1C14.8,12.1,14.6,12,14.4,11.9"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_telegram uk-icon-button uk-icon" data-href="https://t.me/share/url?url=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html&amp;txt=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video" data-uk-icon="telegram" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="telegram">
                                                                            <path d="M19.959,65.926,16.941,80.16c-.228,1-.822,1.255-1.665.781l-4.6-3.389L8.458,79.687a1.155,1.155,0,0,1-.924.451l.33-4.683,8.523-7.7c.371-.33-.08-.513-.576-.183L5.275,74.2.739,72.784c-.987-.308-1-.987.205-1.46l17.743-6.835C19.508,64.181,20.227,64.672,19.959,65.926Z" transform="translate(-0.016 -62.399)"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_pinterest uk-icon-button uk-icon" data-href="https://pinterest.com/pin/create/button/?url=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html&amp;media=https://lh3.googleusercontent.com/blogger_img_proxy/AAOd8Myzal4O1Ecgp4z4HY-7JcXaEj5rWM8yNk82Yv8MJTAkLYyiw-0Y6XEbgh3JOZgDrYRsdvcW-p7bzg2XjcR1vCcreUOWb9BToP_zNymt7svUnkCv&amp;description=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video" data-uk-icon="pinterest" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="pinterest">
                                                                            <path d="M10.21,1 C5.5,1 3,4.16 3,7.61 C3,9.21 3.85,11.2 5.22,11.84 C5.43,11.94 5.54,11.89 5.58,11.69 C5.62,11.54 5.8,10.8 5.88,10.45 C5.91,10.34 5.89,10.24 5.8,10.14 C5.36,9.59 5,8.58 5,7.65 C5,5.24 6.82,2.91 9.93,2.91 C12.61,2.91 14.49,4.74 14.49,7.35 C14.49,10.3 13,12.35 11.06,12.35 C9.99,12.35 9.19,11.47 9.44,10.38 C9.75,9.08 10.35,7.68 10.35,6.75 C10.35,5.91 9.9,5.21 8.97,5.21 C7.87,5.21 6.99,6.34 6.99,7.86 C6.99,8.83 7.32,9.48 7.32,9.48 C7.32,9.48 6.24,14.06 6.04,14.91 C5.7,16.35 6.08,18.7 6.12,18.9 C6.14,19.01 6.26,19.05 6.33,18.95 C6.44,18.81 7.74,16.85 8.11,15.44 C8.24,14.93 8.79,12.84 8.79,12.84 C9.15,13.52 10.19,14.09 11.29,14.09 C14.58,14.09 16.96,11.06 16.96,7.3 C16.94,3.7 14,1 10.21,1"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_reddit uk-icon-button uk-icon" data-href="https://www.reddit.com/submit?url=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html&amp;title=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video" data-uk-icon="reddit" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="reddit">
                                                                            <path d="M19 9.05a2.56 2.56 0 0 0-2.56-2.56 2.59 2.59 0 0 0-1.88.82 10.63 10.63 0 0 0-4.14-1v-.08c.58-1.62 1.58-3.89 2.7-4.1.38-.08.77.12 1.19.57a1.15 1.15 0 0 0-.06.37 1.48 1.48 0 1 0 1.51-1.45 1.43 1.43 0 0 0-.76.19A2.29 2.29 0 0 0 12.91 1c-2.11.43-3.39 4.38-3.63 5.19 0 0 0 .11-.06.11a10.65 10.65 0 0 0-3.75 1A2.56 2.56 0 0 0 1 9.05a2.42 2.42 0 0 0 .72 1.76A5.18 5.18 0 0 0 1.24 13c0 3.66 3.92 6.64 8.73 6.64s8.74-3 8.74-6.64a5.23 5.23 0 0 0-.46-2.13A2.58 2.58 0 0 0 19 9.05zm-16.88 0a1.44 1.44 0 0 1 2.27-1.19 7.68 7.68 0 0 0-2.07 1.91 1.33 1.33 0 0 1-.2-.72zM10 18.4c-4.17 0-7.55-2.4-7.55-5.4S5.83 7.53 10 7.53 17.5 10 17.5 13s-3.38 5.4-7.5 5.4zm7.69-8.61a7.62 7.62 0 0 0-2.09-1.91 1.41 1.41 0 0 1 .84-.28 1.47 1.47 0 0 1 1.44 1.45 1.34 1.34 0 0 1-.21.72z"></path>
                                                                            <path d="M6.69 12.58a1.39 1.39 0 1 1 1.39-1.39 1.38 1.38 0 0 1-1.38 1.39z"></path>
                                                                            <path d="M14.26 11.2a1.39 1.39 0 1 1-1.39-1.39 1.39 1.39 0 0 1 1.39 1.39z"></path>
                                                                            <path d="M13.09 14.88a.54.54 0 0 1-.09.77 5.3 5.3 0 0 1-3.26 1.19 5.61 5.61 0 0 1-3.4-1.22.55.55 0 1 1 .73-.83 4.09 4.09 0 0 0 5.25 0 .56.56 0 0 1 .77.09z"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_linkedin uk-icon-button uk-icon" data-href="https://www.linkedin.com/shareArticle?url=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html&amp;titlePost No.1 Containing a &amp;quot;Youtube&amp;quot; Video" data-uk-icon="linkedin" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="linkedin">
                                                                            <path d="M5.77,17.89 L5.77,7.17 L2.21,7.17 L2.21,17.89 L5.77,17.89 L5.77,17.89 Z M3.99,5.71 C5.23,5.71 6.01,4.89 6.01,3.86 C5.99,2.8 5.24,2 4.02,2 C2.8,2 2,2.8 2,3.85 C2,4.88 2.77,5.7 3.97,5.7 L3.99,5.7 L3.99,5.71 L3.99,5.71 Z"></path>
                                                                            <path d="M7.75,17.89 L11.31,17.89 L11.31,11.9 C11.31,11.58 11.33,11.26 11.43,11.03 C11.69,10.39 12.27,9.73 13.26,9.73 C14.55,9.73 15.06,10.71 15.06,12.15 L15.06,17.89 L18.62,17.89 L18.62,11.74 C18.62,8.45 16.86,6.92 14.52,6.92 C12.6,6.92 11.75,7.99 11.28,8.73 L11.3,8.73 L11.3,7.17 L7.75,7.17 C7.79,8.17 7.75,17.89 7.75,17.89 L7.75,17.89 L7.75,17.89 Z"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_tumblr uk-icon-button uk-icon" data-href="https://www.tumblr.com/share/link?url=https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html&amp;name=Post No.1 Containing a &amp;quot;Youtube&amp;quot; Video" data-uk-icon="tumblr" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="tumblr">
                                                                            <path d="M6.885,8.598c0,0,0,3.393,0,4.996c0,0.282,0,0.66,0.094,0.942c0.377,1.509,1.131,2.545,2.545,3.11 c1.319,0.472,2.356,0.472,3.676,0c0.565-0.188,1.132-0.659,1.132-0.659l-0.849-2.263c0,0-1.036,0.378-1.603,0.283 c-0.565-0.094-1.226-0.66-1.226-1.508c0-1.603,0-4.902,0-4.902h2.828V5.771h-2.828V2H8.205c0,0-0.094,0.66-0.188,0.942 C7.828,3.791,7.262,4.733,6.603,5.394C5.848,6.147,5,6.43,5,6.43v2.168H6.885z"></path>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_copy uk-icon-button uk-icon" data-copy="https://salbuta-dark-1.blogspot.com/2018/04/post-no1-containing-video.html" data-uk-icon="copy" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="copy">
                                                                            <rect fill="none" stroke="#000" x="3.5" y="2.5" width="12" height="16"></rect>
                                                                            <polyline fill="none" stroke="#000" points="5 0.5 17.5 0.5 17.5 17"></polyline>
                                                                        </svg></span></li>
                                                                <li class="uk-padding-remove"><span class="icon_mail uk-icon-button uk-icon" data-href="https://www.blogger.com/share-post.g?blogID=935024140932500473&amp;postID=4536402983010354906&amp;target=email" data-uk-icon="mail" data-uk-tooltip="pos:top" role="button" title="" aria-expanded="false"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="mail">
                                                                            <polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline>
                                                                            <path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path>
                                                                        </svg></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="post_author_profile uk-margin-top" bis_skin_checked="1">
                                                        <div class="uk-grid uk-grid-medium" bis_skin_checked="1">
                                                            <div class="uk-width-auto uk-visible@m" bis_skin_checked="1">
                                                                <div class="post_author_profile_photo" bis_skin_checked="1">
                                                                    <a class="g-profile" href="#" rel="author" title="author profile">
                                                                        <img alt="author photo" loading="lazy" src="<?php echo $pp_link; ?>" width="113" height="113">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="uk-width-expand" bis_skin_checked="1">
                                                                <div class="post_author_profile_name uk-flex uk-flex-middle uk-margin-small-bottom uk-text-uppercase" bis_skin_checked="1">
                                                                    <a class="g-profile uk-margin-right uk-hidden@m" href="#" rel="author" title="author profile">
                                                                        <img alt="author photo" loading="lazy" src="<?php echo $pp_link; ?>" width="30" height="30">
                                                                    </a>
                                                                    <a class="g-profile" href="#" rel="author" title="author profile">
                                                                        <span><?php echo $blogYazari; ?></span>
                                                                    </a>
                                                                </div>
                                                                <div class="post_author_profile_desc" bis_skin_checked="1">
                                                                    <span><?php echo $blogYazarDusuncesi; ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <br>
                                            <!-- Yorum Formu Başlangıcı -->
                                            <div class="comments-section">
                                                <h3>Yorum Yap</h3>
                                                <form method="post">
                                                    <div class="uk-margin">
                                                        <label for="username">Adınız:</label>
                                                        <input type="text" id="username" name="username" required class="uk-input">
                                                    </div>

                                                    <div class="uk-margin">
                                                        <label for="comment">Yorumunuz:</label>
                                                        <textarea id="comment" name="comment" required class="uk-textarea" rows="4"></textarea>
                                                    </div>

                                                    <div class="uk-margin">
                                                        <button name="yorum" type="submit" class="uk-button uk-button-primary">Yorum Gönder</button>
                                                        <div id="messageContainer" style="display: none;">
                                                            <p class="text-success">Yorumunuz başarıyla eklendi.</p>
                                                        </div>
                                                        <div id="messageContainer2" style="display: none;">
                                                            <p class="text-false">Yorumunuz eklenemedi.</p>
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                                // Türkçe ayları temsil eden bir dizi
                                                $aylar = [
                                                    '01' => 'OCAK',
                                                    '02' => 'ŞUBAT',
                                                    '03' => 'MART',
                                                    '04' => 'NİSAN',
                                                    '05' => 'MAYIS',
                                                    '06' => 'HAZİRAN',
                                                    '07' => 'TEMMUZ',
                                                    '08' => 'AĞUSTOS',
                                                    '09' => 'EYLÜL',
                                                    '10' => 'EKİM',
                                                    '11' => 'KASIM',
                                                    '12' => 'ARALIK'
                                                ];

                                                // Yorumları veritabanından çek
                                                $sorgu = $pdo->prepare("SELECT * FROM yorumlar WHERE blogId = ? ORDER BY tarih DESC");
                                                $sorgu->execute([$id]);

                                                $yorumlar = $sorgu->fetchAll();

                                                echo "<div class='comments-list uk-margin-top'>";

                                                if (!$yorumlar) {
                                                    echo "<p>Henüz yorum yapılmamış. İlk yorum yapan sen ol!</p>";
                                                }

                                                foreach ($yorumlar as $yorum) {
                                                    $tarihParcalari = explode(" ", $yorum['tarih']);
                                                    $gunAyYil = explode("-", $tarihParcalari[0]);
                                                    $saat = explode(":", $tarihParcalari[1]);
                                                    $formatlanmisTarih = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0] . " SAAT " . $saat[0] . ":" . $saat[1];
                                                ?>
                                                    <div class="uk-card uk-card-default uk-card-body uk-margin-bottom" style="background-color: #313131; color: #FFF;">
                                                        <h4 class="uk-card-title" style="color: #FFF; font-weight: bold;"><?= htmlspecialchars($yorum['adsoyad']) ?></h4>
                                                        <p><?= htmlspecialchars($yorum['yorum']) ?></p>
                                                        <span class="uk-text-meta"><?= $formatlanmisTarih ?></span>
                                                    </div> <?php
                                                        }
                                                        echo "</div>";

                                                            ?>

                                                <?php

                                                if ($successMessage) {
                                                    echo '<script>
document.addEventListener("DOMContentLoaded", function() {
document.getElementById("messageContainer").style.display = "block";
});
</script>';
                                                }
                                                if ($falseMessage) {
                                                    echo '<script>
document.addEventListener("DOMContentLoaded", function() {
document.getElementById("messageContainer2").style.display = "block";
});
</script>';
                                                }
                                                ?>

                                            </div>
                                            <!-- Yorum Formu Sonu -->

                                            <!-- Buraya yorum yazılma yeri gelecek. CSS kodlarını sen arka plana göre yapacaksın. Web siteye uyacak şekilde class'ları kullan. Yorum işlemi PHP ile yapılacak. Backend'i sen temel olarak yaz. Name değerlerini dolu tut ki PHP ile işlem yapılsın. -->
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .sidebar -->
                        <div class="uk-width-1-3@l" bis_skin_checked="1">
                            <div class="sidebar section" id="sidebar" bis_skin_checked="1">
                                <div class="widget HTML" data-version="2" id="HTML3" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Reklamlar</span></h3>
                                    <div class="widget-content" bis_skin_checked="1">
                                        <div class="inline_banner_demo" data-height="250" bis_skin_checked="1">Reklam Alanı</div>
                                    </div>
                                </div>
                                <div class="widget FeaturedPost" data-version="2" id="FeaturedPost1" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Benzer Yazılar</span></h3>
                                    <div class="widget-content" bis_skin_checked="1">
                                        <ul>
                                            <li>
                                                <div class="item-content" bis_skin_checked="1">
                                                    <div class="item-thumbnail uk-text-center uk-position-relative uk-transition-toggle" bis_skin_checked="1">
                                                        <a href="#"> <!-- Bu href'i blog postunun linki ile güncelleyebilirsiniz -->
                                                            <img alt="Image" loading="lazy" src="<?php echo $kapakFoto; ?>" width="195" height="345">
                                                            <div class="uk-position-cover uk-transition-fade uk-overlay-primary" bis_skin_checked="1"></div>
                                                            <div class="uk-position-center" bis_skin_checked="1">
                                                                <span class="uk-transition-fade uk-icon" data-uk-icon="icon:play-circle;ratio:2.3"></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="item-title" bis_skin_checked="1">
                                                        <a href="#"><?php echo $blogBaslik; ?></a> <!-- Bu href'i blog postunun linki ile güncelleyebilirsiniz -->
                                                    </div>
                                                    <div class="item-snippet" bis_skin_checked="1"><?php echo $blogAciklama1; ?></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="widget PopularPosts" data-version="2" id="PopularPosts1" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Viral Gönderiler</span></h3>
                                    <div class="widget-content" bis_skin_checked="1">
                                        <ul>
                                            <?php foreach ($popularBlogs as $blog) : ?>
                                                <li>
                                                    <div class="item-content uk-transition-toggle" bis_skin_checked="1">
                                                        <div class="item-thumbnail uk-text-center" bis_skin_checked="1">
                                                            <a class="uk-position-relative uk-overflow-hidden" href="#"> <!-- Bu href'i blog postunun linki ile güncelleyebilirsiniz -->
                                                                <img alt="Image" loading="lazy" src="<?php echo "http://localhost/hatay/admin/" . $blog['kapakFoto']; ?>" width="72" height="72">
                                                                <div class="uk-position-cover uk-transition-fade uk-overlay-primary" bis_skin_checked="1"></div>
                                                                <div class="uk-position-center" bis_skin_checked="1">
                                                                    <span class="uk-transition-fade uk-icon" data-uk-icon="icon:image;ratio:1.5"></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="item-title" bis_skin_checked="1">
                                                            <a href="#"><?php echo $blog['blogBaslik']; ?></a> <!-- Bu href'i blog postunun linki ile güncelleyebilirsiniz -->
                                                        </div>
                                                        <div class="item-snippet" bis_skin_checked="1"><?php echo $blog['blogAciklama1']; ?></div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="widget Label" data-version="2" id="Label4" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Etiketler</span></h3>
                                    <div class="widget-content list-label-widget-content" bis_skin_checked="1">
                                        <ul class="uk-list uk-list-bullet uk-margin-remove">
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Eylem</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Hatay İçi</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Hatay Dışı</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Toplumsal Norm</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Bilgilendirme</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="label-name" href="#">
                                                    <span class="label-text">Duyurular</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget PageList" data-version="2" id="PageList1" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Sayfalar</span></h3>
                                    <div class="widget-content" bis_skin_checked="1">
                                        <ul class="uk-list uk-list-bullet uk-margin-remove">
                                            <li>
                                                <a href="#">Instagram</a>
                                            </li>
                                            <li>
                                                <a href="#">Twitter</a>
                                            </li>
                                            <li>
                                                <a href="#">Discord</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget HTML" data-version="2" id="HTML4" bis_skin_checked="1">
                                    <h3 class="widget_title uk-heading-bullet"><span>Reklamlar</span></h3>
                                    <div class="widget-content uk-sticky" data-uk-sticky="bottom:.main_content;offset:80;media:992" bis_skin_checked="1" style="">
                                        <div class="inline_banner_demo" data-height="250" bis_skin_checked="1">Reklam Alanı</div>
                                    </div>
                                    <div class="uk-sticky-placeholder" style="height: 250px; margin: 0px;" bis_skin_checked="1" hidden=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .bottom_full_ads -->
                <div class="bottom_full_ads uk-container" bis_skin_checked="1">
                    <div class="full_ads_section bottom no-items section" id="full_ads_section_2" bis_skin_checked="1"></div>
                </div>
            </main>
            <!-- footer -->

        </div>


        <!-- footer -->
        <?php include('../includes/blogFooter.php'); ?>
    </div>
    <!-- .sidenav -->
    <?php include('../includes/sidenav.php'); ?>
    <!-- script -->
    <script src="../assets/js/send.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src='https://hub.orthemes.com/static/themes/themeforest/salbuta/plugins-1.8.min.js'></script>

    <script type="text/javascript" src="https://www.blogger.com/static/v1/widgets/1882169140-widgets.js"></script>
    <script src="../assets/js/pages.js"></script>

</body>

</html>