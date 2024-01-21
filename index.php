<?php require_once 'includes/connect.php';

// En çok görüntülenen 3 blogu çek
$sql = "SELECT * FROM blog ORDER BY blogGorunmeSayisi DESC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Eğer en az 3 blog döndüyse, bu blogları değişkenlere atayalım
if(count($blogs) >= 5) {
    $blog1 = $blogs[0];
    $blog2 = $blogs[1];
    $blog3 = $blogs[2];
    $blog4 = $blogs[3];
    $blog5 = $blogs[4];

  } else {
    die("3'ten daha az blog bulundu!");
} 
function createSafeFileName($string) {
  // Türkçe karakterleri İngilizce karakterlere dönüştür
  $string = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], 
                        ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'], $string);
  
  // Alfanümerik olmayan karakterleri kaldır ve boşlukları '-' ile değiştir
  $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
  $string = preg_replace("/[\s]/", "-", $string);
  
  return strtolower($string) . '.php';
}

$generatedLink1 = "http://localhost/hatay/bloglar/" . createSafeFileName($blog1['blogBaslik']);
$shortDescription1 = substr($blog1['blogAciklama1'], 0, 100); // İlk 100 karakteri al


$generatedLink2 = "http://localhost/hatay/bloglar/" . createSafeFileName($blog2['blogBaslik']);
$shortDescription2 = substr($blog2['blogAciklama1'], 0, 100); // İlk 100 karakteri al


$generatedLink3 = "http://localhost/hatay/bloglar/" . createSafeFileName($blog3['blogBaslik']);
$shortDescription3 = substr($blog3['blogAciklama1'], 0, 100); // İlk 100 karakteri al


$generatedLink4 = "http://localhost/hatay/bloglar/" . createSafeFileName($blog4['blogBaslik']);
$shortDescription4 = substr($blog4['blogAciklama1'], 0, 100); // İlk 100 karakteri al


$generatedLink5 = "http://localhost/hatay/bloglar/" . createSafeFileName($blog5['blogBaslik']);
$shortDescription5 = substr($blog5['blogAciklama1'], 0, 100); // İlk 100 karakteri al
?>
<?php include('includes/head.php'); ?>
<body class='v1-8 homepage_view multiple_view dark rounded'>
<!-- .wrapper -->
<div class='wrapper uk-offcanvas-content uk-light'>
<!-- header -->
<?php include('includes/header.php'); ?>

<!-- main -->
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
<div class='main section' id='main'><div class='widget Label' data-version='2' id='Label1'>
<div class='filtering_labels uk-grid uk-margin-bottom uk-flex-right'>
<div class='select_label uk-width-expand@m'>
<script class='js'>
                          var filterTags=[];filterTags.push(encodeURIComponent("Fashion"));filterTags.push(encodeURIComponent("Happy Star"));filterTags.push(encodeURIComponent("Mountains"));filterTags.push(encodeURIComponent("Nature"));filterTags.push(encodeURIComponent("Sports"));
                        </script>
<ul class='uk-list uk-list-inline uk-visible@l'>
<li>
<span class='mark uk-button mark_empty'><span class="but2" data-uk-icon='settings'>
</span></span>
</li>
<li>
<a class='uk-button uk-button-default uk-margin-bottom uk-active' data-uk-filter-control='' href='##!'>
Hepsini Gör
</a>
</li>
<li>
<a class='uk-button uk-button-default uk-margin-bottom' data-uk-filter-control='.filter_0' href='##!'>
Bilgilendirme
</a>

</ul>
<div class='uk-grid-small uk-hidden@l' data-uk-grid=''>
<div class='uk-width-auto'><span data-uk-icon='settings'></span></div>
<div class='uk-width-auto@m uk-width-expand'>
<select class='uk-select'>
<option data-uk-filter-control='' value=''>
Hepsini Gör
</option>
<option data-uk-filter-control='.filter_0' value='.filter_0'>
Bilgilendirme
</option>
</select>
</div>
</div>
</div>
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
<script class='js'>orThemes.init(__bu3G)()</script>
</div>
</div>
</div><div class='widget Blog' data-version='2' id='Blog1'>
<div class='blog_posts hfeed uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@l uk-child-width-1-4@xxl uk-grid' data-uk-grid='masonry:true' id='blog_posts'>
<article class='post hentry' data-id='4536402983010354906'>
<script class='js'>
                    var filterTags_4536402983010354906=[];filterTags_4536402983010354906.push(encodeURIComponent("Nature"));
                  </script>

<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $blog1['blogBaslik']; ?>'>
<a href='<?php echo $generatedLink1; ?>'>
<img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/'.$blog1['kapakFoto']; ?>' width='345'/>
<div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
<div class='uk-position-center'>
<span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
</div>
</a>
</div>
<div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $blog1['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);?>
<div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '#'.$etiket.', ';
                                                            }
                                                            ?></a></div><h2 class='post_title entry-title uk-margin'>
<a href='<?php echo $generatedLink1; ?>' rel='bookmark'><?php echo $blog1['blogBaslik']; ?></a>
</h2>
<div class='post_snippet entry-summary uk-position-relative'>
<p id='body4536402983010354906'>
    <textarea class='uk-hidden'><?php echo $shortDescription1; ?></textarea>
    <script class='js'>
        var post = {
            id: "4536402983010354906",
            link: "<?php echo $generatedLink1; ?>",
            more: "Read more"
        };
        orThemes.init(__bu4G)();
    </script>
</p>
</div>
<div class='post_meta uk-grid uk-grid-small'><?php                                                 $aylar = [
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
                                                $tarihParcalari = explode(" ", $blog1['blogTarihi']);
                                                $gunAyYil = explode("-", $tarihParcalari[0]);
                                                $saat = explode(":", $tarihParcalari[1]);
                                                $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

 ?>
<div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
<div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $blog1['blogYorumSayisi']; ?></span></div>
<div class='post_views uk-width-auto'>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
    <span><?php echo $blog1['blogGorunmeSayisi']; ?></span>
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
<article class='post hentry' data-id='4156723629212180041'>
<script class='js'>
                    var filterTags_4156723629212180041=[];filterTags_4156723629212180041.push(encodeURIComponent("Fashion"));filterTags_4156723629212180041.push(encodeURIComponent("Sports"));
                  </script>

<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $blog2['blogBaslik']; ?>'>
<a href='<?php echo $generatedLink2; ?>'>
<img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/'.$blog2['kapakFoto']; ?>' width='345'/>
<div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
<div class='uk-position-center'>
<span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
</div>
</a>
</div>
<div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $blog2['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);?>
<div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '#'.$etiket.', ';
                                                            }
                                                            ?></a></div><h2 class='post_title entry-title uk-margin'>
<a href='<?php echo $generatedLink2; ?>' rel='bookmark'><?php echo $blog2['blogBaslik']; ?></a>
</h2>
<div class='post_snippet entry-summary uk-position-relative'>
<p id='body4536402983010354907'>
    <textarea class='uk-hidden'><?php echo $shortDescription2; ?></textarea>
    <script class='js'>
        var post = {
            id: "4536402983010354907",
            link: "<?php echo $generatedLink2; ?>",
            more: "Read more"
        };
        orThemes.init(__bu4G)();
    </script>
</p>
</div>
<div class='post_meta uk-grid uk-grid-small'><?php                                                 $aylar = [
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
                                                $tarihParcalari = explode(" ", $blog2['blogTarihi']);
                                                $gunAyYil = explode("-", $tarihParcalari[0]);
                                                $saat = explode(":", $tarihParcalari[1]);
                                                $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

 ?>
<div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
<div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $blog2['blogYorumSayisi']; ?></span></div>
<div class='post_views uk-width-auto'>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
    <span><?php echo $blog2['blogGorunmeSayisi']; ?></span>
</div>
</div>
</div>
</div>
</article>
<article class='post hentry' data-id='3908852662785361053'>
<script class='js'>
                    var filterTags_3908852662785361053=[];filterTags_3908852662785361053.push(encodeURIComponent("Nature"));
                  </script>
<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $blog3['blogBaslik']; ?>'>
<a href='<?php echo $generatedLink3; ?>'>
<img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/'.$blog3['kapakFoto']; ?>' width='345'/>
<div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
<div class='uk-position-center'>
<span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
</div>
</a>
</div>
<div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $blog3['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);?>
<div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '#'.$etiket.', ';
                                                            }
                                                            ?></a></div><h2 class='post_title entry-title uk-margin'>
<a href='<?php echo $generatedLink3; ?>' rel='bookmark'><?php echo $blog3['blogBaslik']; ?></a>
</h2>
<div class='post_snippet entry-summary uk-position-relative'>
<p id='body4536402983010354908'>
    <textarea class='uk-hidden'><?php echo $shortDescription3; ?></textarea>
    <script class='js'>
        var post = {
            id: "4536402983010354908",
            link: "<?php echo $generatedLink3; ?>",
            more: "Read more"
        };
        orThemes.init(__bu4G)();
    </script>
</p>
</div>
<div class='post_meta uk-grid uk-grid-small'><?php                                                 $aylar = [
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
                                                $tarihParcalari = explode(" ", $blog3['blogTarihi']);
                                                $gunAyYil = explode("-", $tarihParcalari[0]);
                                                $saat = explode(":", $tarihParcalari[1]);
                                                $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

 ?>
<div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
<div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $blog3['blogYorumSayisi']; ?></span></div>
<div class='post_views uk-width-auto'>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
    <span><?php echo $blog3['blogGorunmeSayisi']; ?></span>
</div>
</div>
</div>
</div>
</article>
<article class='post hentry' data-id='4672338728610488119'>
<script class='js'>
                    var filterTags_4672338728610488119=[];filterTags_4672338728610488119.push(encodeURIComponent("Fashion"));filterTags_4672338728610488119.push(encodeURIComponent("Sports"));
                  </script>

<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $blog4['blogBaslik']; ?>'>
<a href='<?php echo $generatedLink4; ?>'>
<img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/'.$blog4['kapakFoto']; ?>' width='345'/>
<div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
<div class='uk-position-center'>
<span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
</div>
</a>
</div>
<div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $blog4['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);?>
<div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '#'.$etiket.', ';
                                                            }
                                                            ?></a></div><h2 class='post_title entry-title uk-margin'>
<a href='<?php echo $generatedLink4; ?>' rel='bookmark'><?php echo $blog4['blogBaslik']; ?></a>
</h2>
<div class='post_snippet entry-summary uk-position-relative'>
<p id='body4536402983010354909'>
    <textarea class='uk-hidden'><?php echo $shortDescription4; ?></textarea>
    <script class='js'>
        var post = {
            id: "4536402983010354909",
            link: "<?php echo $generatedLink4; ?>",
            more: "Read more"
        };
        orThemes.init(__bu4G)();
    </script>
</p>
</div>
<div class='post_meta uk-grid uk-grid-small'><?php                                                 $aylar = [
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
                                                $tarihParcalari = explode(" ", $blog4['blogTarihi']);
                                                $gunAyYil = explode("-", $tarihParcalari[0]);
                                                $saat = explode(":", $tarihParcalari[1]);
                                                $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

 ?>
<div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
<div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $blog4['blogYorumSayisi']; ?></span></div>
<div class='post_views uk-width-auto'>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
    <span><?php echo $blog4['blogGorunmeSayisi']; ?></span>
</div>
</div>
</div>
</div>
</article>
<article class='post hentry' data-id='4904204533183014055'>
<script class='js'>
                    var filterTags_4904204533183014055=[];filterTags_4904204533183014055.push(encodeURIComponent("Fashion"));filterTags_4904204533183014055.push(encodeURIComponent("Mountains"));filterTags_4904204533183014055.push(encodeURIComponent("Sports"));
                  </script>

<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_thumbnail uk-card-media-top uk-text-center uk-position-relative uk-transition-toggle' data-title='<?php echo $blog5['blogBaslik']; ?>'>
<a href='<?php echo $generatedLink5; ?>'>
<img alt='Image' height='194' loading='eager' sizes='480px' src='<?php echo 'http://localhost/hatay/admin/'.$blog5['kapakFoto']; ?>' width='345'/>
<div class='uk-position-cover uk-transition-fade uk-overlay-primary'></div>
<div class='uk-position-center'>
<span class='uk-transition-fade' data-uk-icon='icon:play-circle;ratio:2.3'></span>
</div>
</a>
</div>
<div class='post_content uk-card-small uk-card-body'> <?php $mekanEtiketler = $blog5['mekanEtiketler'];
    $etiketlerDizi = explode(", ", $mekanEtiketler);?>
<div class='post_labels uk-panel uk-margin-small'><span class='uk-margin-small-right' data-uk-icon='icon:tag;ratio:.7'></span><a href='#' rel='tag'> <?php
                                                            foreach ($etiketlerDizi as $etiket) {
                                                                echo '#'.$etiket.', ';
                                                            }
                                                            ?></a></div><h2 class='post_title entry-title uk-margin'>
<a href='<?php echo $generatedLink5; ?>' rel='bookmark'><?php echo $blog5['blogBaslik']; ?></a>
</h2>
<div class='post_snippet entry-summary uk-position-relative'>
<p id='body4536402983010354901'>
    <textarea class='uk-hidden'><?php echo $shortDescription5; ?></textarea>
    <script class='js'>
        var post = {
            id: "4536402983010354901",
            link: "<?php echo $generatedLink5; ?>",
            more: "Read more"
        };
        orThemes.init(__bu4G)();
    </script>
</p>
</div>
<div class='post_meta uk-grid uk-grid-small'><?php                                                 $aylar = [
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
                                                $tarihParcalari = explode(" ", $blog5['blogTarihi']);
                                                $gunAyYil = explode("-", $tarihParcalari[0]);
                                                $saat = explode(":", $tarihParcalari[1]);
                                                $formatlanmisTarih1 = intval($gunAyYil[2]) . " " . $aylar[$gunAyYil[1]] . " " . $gunAyYil[0];

 ?>
<div class='post_date uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: clock; ratio: .7'></span><span><time class='published' datetime='2018-04-05T01:08:00-07:00' title='2018-04-05T01:08:00-07:00'><?php echo $formatlanmisTarih1; ?></time></span></div>
<div class='post_comments uk-width-auto'><span class='uk-margin-small-right' data-uk-icon='icon: comment; ratio: .7'></span><span><?php echo $blog5['blogYorumSayisi']; ?></span></div>
<div class='post_views uk-width-auto'>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
    <span><?php echo $blog5['blogGorunmeSayisi']; ?></span>
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

<div class='post inline_banner'>
<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_content uk-card-small uk-card-body'>
<div class='inline_banner_demo' data-height='250'>
Reklam Alanı
</div>
</div>
</div>
</div>

<div class='post inline_banner'>
<div class='uk-card uk-card-hover uk-card-secondary'>
<div class='post_content uk-card-small uk-card-body'>
<div class='inline_banner_demo' data-height='250'>
Reklam Alanı
</div>
</div>
</div>
</div>

</div>
</div></div>
</div>
<!-- .bottom_full_ads -->
<div class='bottom_full_ads uk-container'>
<div class='full_ads_section bottom no-items section' id='full_ads_section_2'></div>
</div>
</main>
<!-- footer -->
<?php include('includes/footer.php'); ?>
</div>
<!-- .sidenav -->
<?php include('includes/sidenav.php'); ?>
<!-- script -->
<script src="assets/js/send.js"></script>
<script src="assets/js/script.js"></script>
<script src='https://hub.orthemes.com/static/themes/themeforest/salbuta/plugins-1.8.min.js'></script>

<script type="text/javascript" src="https://www.blogger.com/static/v1/widgets/1882169140-widgets.js"></script>
<script src="assets/js/pages.js"></script>

</body>
</html>