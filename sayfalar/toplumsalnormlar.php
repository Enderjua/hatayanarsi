<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$lessthan5 = false;

function createSafeFileName($string) {
    // Türkçe karakterleri İngilizce karakterlere dönüştür
    $string = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], 
                          ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'], $string);
    
    // Alfanümerik olmayan karakterleri kaldır ve boşlukları '-' ile değiştir
    $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
    $string = preg_replace("/[\s]/", "-", $string);
    
    return strtolower($string) . '.php';
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hatayanarsi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}   

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * 5; // Her sayfada 5 veri

$sql = "SELECT * FROM blog WHERE mekanEtiketler LIKE '%Toplumsal Normlar%' ORDER BY blogTarihi DESC LIMIT $offset, 5";
$result = $conn->query($sql);

$lessthan5 = ($result->num_rows <= 5) ? true : false;

$veriDizisi = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $veriDizisi[] = $row;
    }
}

$conn->close();

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



                <main>
                    <!-- .top_full_ads -->
                    <div class='top_full_ads uk-container'>
                        <div class='full_ads_section no-items section' id='full_ads_section_1'></div>
                    </div>
                    <!-- .main_slider -->
                    <div class='main_slider uk-container'>
                        <div class='main_slider_section no-items section' id='main_slider_section'>
                        </div>
                    </div>
                    <!-- .main_content -->
                    <div class='main_content uk-container'>
                        <!-- .main -->
                        <div class='main section' id='main'>
                            <div class='widget Label' data-version='2' id='Label1'>
                                <div class='filtering_labels uk-grid uk-margin-bottom uk-flex-right'>
                                    <div class='select_label uk-width-expand@m'>



                                        <div class='select_view uk-width-exapnd uk-width-auto@m'>
                                            <ul class='uk-list uk-list-inline uk-visible@l'>
                                                <li>
                                                    <span class='mark uk-button'><span class='uk-margin-small-right' data-uk-icon='cog'>
                                                        </span><span>View</span></span>
                                                </li>
                                                <li class='uk-active'><a class='uk-icon-button' data-uk-icon='expand' data-uk-tooltip='pos:top' href='##!' id='view_e' title='Gönderileri Genişlet'></a></li>
                                                <li><a class='uk-icon-button' data-uk-icon='shrink' data-uk-tooltip='pos:top' href='##!' id='view_s' title='Gönderileri Küçült'></a></li>
                                            </ul>
                                            <div class='uk-grid-small uk-hidden@l' data-uk-grid=''>
                                                <div class='uk-width-auto'><span data-uk-icon='cog'></span></div>
                                                <div class='uk-width-auto@m uk-width-expand'>
                                                    <select class='uk-select'>
                                                        <option value='expand'>Gönderileri Genişlet</option>
                                                        <option value='shrink'>Gönderileri Küçült</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <script class='js'>
                                                orThemes.init(__bu3G)()
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class='widget Blog' data-version='2' id='Blog1'>
                                    <div class='blog_posts hfeed uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-4@xxl uk-grid' data-uk-grid='masonry:true' id='blog_posts'>


                                    <?php


if (!$lessthan5) {
    foreach ($veriDizisi as $veri) {
?>
        <article class='post hentry' data-id='<?php echo $veri['dataId']; ?>'>

            <div class='uk-card uk-card-hover uk-card-secondary'>
                <div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $veri['blogBaslik']; ?>'>
                    <a href='<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']); ?>'>
                        <img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/' . $veri['kapakFoto']; ?>' width='345' />
                        <div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
                        <div class='uk-position-center'>
                            <span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
                        </div>
                    </a>
                </div>
                <div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $veri['mekanEtiketler'];
                                                                        $etiketlerDizi = explode(", ", $mekanEtiketler); ?>
                    <div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                                                                                                                                            foreach ($etiketlerDizi as $etiket) {
                                                                                                                                                                                echo '#' . $etiket . ', ';
                                                                                                                                                                            }
                                                                                                                                                                            ?></a></div>
                    <h2 class='post_title entry-title uk-margin'>
                        <a href='<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']); ?>'' rel='bookmark'><?php echo $veri['blogBaslik']; ?></a>
                     </h2>
                    <div class='post_snippet entry-summary uk-position-relative'>
                    <p id="body<?php echo $veri['dataId']; ?>"><?php echo substr($veri['blogAciklama1'], 0, 100); // İlk 100 karakteri al ?> <a href="<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']);  ?>">Read more</a>
</p>
                    </div>
                    <div class='post_meta uk-grid uk-grid-small'><?php $aylar = [
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
                                                                    $tarihParcalari = explode(" ", $veri['blogTarihi']);
                                                                    $gunAyYil = explode("-", $tarihParcalari[0]);
                                                                    
                                                                    $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

                                                                    ?>
                        <div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
                        <div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $veri['blogYorumSayisi']; ?></span></div>
                        <div class='post_views uk-width-auto'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                            </svg>
                            <span><?php echo $veri['blogGorunmeSayisi']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <div class='post inline_banner'>
    <div class='uk-card uk-card-hover uk-card-secondary'>
        <div class='post_content uk-card-small uk-card-body'>
            <div class='inline_banner_demo' data-height='250'>
                Reklam Alanı
            </div>
        </div>
    </div>
</div>
<?php
    }
} else {
    foreach ($veriDizisi as $veri) {
        ?>
        <article class='post hentry' data-id='<?php echo $veri['dataId']; ?>'>

            <div class='uk-card uk-card-hover uk-card-secondary'>
                <div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $veri['blogBaslik']; ?>'>
                    <a href='<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']); ?>'>
                        <img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/' . $veri['kapakFoto']; ?>' width='345' />
                        <div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
                        <div class='uk-position-center'>
                            <span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
                        </div>
                    </a>
                </div>
                <div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $veri['mekanEtiketler'];
                    $etiketlerDizi = explode(", ", $mekanEtiketler); ?>
                    <div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                            foreach ($etiketlerDizi as $etiket) {
                                echo '#' . $etiket . ', ';
                            }
                            ?></a></div>
                    <h2 class='post_title entry-title uk-margin'>
                        <a href='<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']); ?>'' rel='bookmark'><?php echo $veri['blogBaslik']; ?></a>
                    </h2>
                    <div class='post_snippet entry-summary uk-position-relative'>
                        <p id="body<?php echo $veri['dataId']; ?>"><?php echo substr($veri['blogAciklama1'], 0, 100); // İlk 100 karakteri al ?> <a href="<?php echo "https://localhost/hatay/bloglar/".createSafeFileName($veri['blogBaslik']);  ?>">Read more</a>
                        </p>
                    </div>
                    <div class='post_meta uk-grid uk-grid-small'><?php $aylar = [
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
                        $tarihParcalari = explode(" ", $veri['blogTarihi']);
                        $gunAyYil = explode("-", $tarihParcalari[0]);

                        $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

                        ?>
                        <div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
                        <div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $veri['blogYorumSayisi']; ?></span></div>
                        <div class='post_views uk-width-auto'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                            </svg>
                            <span><?php echo $veri['blogGorunmeSayisi']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <div class='post inline_banner'>
            <div class='uk-card uk-card-hover uk-card-secondary'>
                <div class='post_content uk-card-small uk-card-body'>
                    <div class='inline_banner_demo' data-height='250'>
                        Reklam Alanı
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</main>
    <div style="padding-bottom: 100px;" class="blog_pager uk-text-center uk-margin-large-top" id="blog_pager" bis_skin_checked="1">
    <a class="blog-pager-older-link uk-button uk-button-default uk-icon" data-uk-icon="more" href="http://localhost/hatay/sayfalar/eylemler.php?page='. ($page + 1) . '" title="Daha Fazlası">
        <span class="uk-margin-small-right">Daha Fazlası</span>
        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="more"><circle cx="3" cy="10" r="2"></circle><circle cx="10" cy="10" r="2"></circle><circle cx="17" cy="10" r="2"></circle></svg>
    </a>
</div>';
   
}
?>

    

                   
                    
                </main>
                

                





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