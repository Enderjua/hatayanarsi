<?php require_once 'includes/connect.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı adını SESSION'dan alıyoruz
$username = $_SESSION['username'] ?? '';

if (empty($username)) {
    header('Location: index.php');
}

$getUserRoleSql = "SELECT yetkisi FROM users WHERE username = ?";
$stmtUserRole = $pdo->prepare($getUserRoleSql);
$stmtUserRole->execute([$username]);
$userRole = $stmtUserRole->fetchColumn();

// İzin verilen rolleri tanımla
$allowedRoles = ['founder', 'admin', 'editor', 'yazar'];

// Yetki kontrolü yap
if (!in_array($userRole, $allowedRoles)) {
    header('Location: index.php');
    exit();
}

$successMessage = false;
$falseMessage = false;
$errorMessage = false;

if (isset($_POST['addBlog'])) {
    // Önce başlığın daha önceden eklenip eklenmediğini kontrol edelim
    $checkTitleSql = "SELECT * FROM blog WHERE blogBaslik = ?";
    $stmt = $pdo->prepare($checkTitleSql);
    $stmt->execute([$_POST['blogBaslik']]);
    $existingBlog = $stmt->fetch();

    if ($existingBlog) {
        $errorMessage = true;
    }
    // Dosya yükleme fonksiyonu
    function uploadFile($file, $target_dir)
    {
        $filename = basename($file["name"]);
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $fileType;
        $targetFilePath = $target_dir . $newFileName;

        // Dosyayı yükle
        move_uploaded_file($file["tmp_name"], $targetFilePath);

        return $targetFilePath;
    }

    $successMessage = false;  // Sayfanın başında bu değişkeni tanımlayın.
    $falseMessage = false;


    $kapakFoto = uploadFile($_FILES['kapakFoto'], 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/');

    $mekanEtiketler = $_POST['mekanEtiketler'];
    $blogBaslik = $_POST['blogBaslik'];
    $blogAciklama1 = $_POST['blogAciklama1'];
    $blogAciklamaTuru1 = $_POST['blogAciklamaTuru1'];
    $aciklama1Renk = $_POST['aciklama1Renk'] ?? NULL;
    $aciklama1ResimKonumu = $_POST['aciklama1ResimKonumu'] ?? NULL;
    $aciklama1Resim = isset($_FILES['aciklama1Resim']) ? uploadFile($_FILES['aciklama1Resim'], 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/') : NULL;
    $blogAciklama2 = $_POST['blogAciklama2'];
    $blogAciklamaTuru2 = $_POST['blogAciklamaTuru2'];
    $aciklama2Renk = $_POST['aciklama2Renk'] ?? NULL;
    $aciklama2ResimKonumu = $_POST['aciklama2ResimKonumu'] ?? NULL;
    $aciklama2Resim = isset($_FILES['aciklama2Resim']) ? uploadFile($_FILES['aciklama2Resim'], 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/') : NULL;
    $resimOlsunMu = $_POST['resimOlsunMu'];
    $ekstraResim = ($resimOlsunMu == 'Evet' && isset($_FILES['ekstraResim'])) ? uploadFile($_FILES['ekstraResim'], 'assets/yazilar/bloglar/fotograflar/ekstraResimler/') : NULL;
    $gununSozu = $_POST['gununSozu'];
    $gununSozuYazari = $_POST['gununSozuYazari'];
    $blogYazarDusuncesi = $_POST['blogYazarDusuncesi'];
    date_default_timezone_set('Europe/Istanbul');
    $blogDurumu = "Beklemede";
    $blogTarihi = date("Y-m-d"); // Bugünün tarihi
    $blogYorumSayisi = 0;
    $blogGorunmeSayisi = 0;
    $blogYazari = $username;

    if ($blogAciklamaTuru1 == "Hiçbiri") {
        $aciklama1Renk = NULL;
        $aciklama1ResimKonumu = NULL;
        $aciklama1Resim = NULL;
    } else if ($blogAciklamaTuru1 == "Renkli") {
        $aciklama1ResimKonumu = NULL;
        $aciklama1Resim = NULL;
    } else if ($blogAciklamaTuru1 == "Resimli") {
        $aciklama1Renk == NULL;
    } else {
        $aciklama1Renk = NULL;
        $aciklama1ResimKonumu = NULL;
        $aciklama1Resim = NULL;
    }

    if ($blogAciklamaTuru2 == "Hiçbiri") {
        $aciklama2Renk = NULL;
        $aciklama2ResimKonumu = NULL;
        $aciklama2Resim = NULL;
    } else if ($blogAciklamaTuru2 == "Renkli") {
        $aciklama2ResimKonumu = NULL;
        $aciklama2Resim = NULL;
    } else if ($blogAciklamaTuru2 == "Resimli") {
        $aciklama2Renk == NULL;
    } else {
        $aciklama2Renk = NULL;
        $aciklama2ResimKonumu = NULL;
        $aciklama2Resim = NULL;
    }
    if (!$errorMessage) {
        // SQL sorgusunu hazırla
        $sql = "INSERT INTO blog (kapakFoto, mekanEtiketler, blogBaslik, blogAciklama1, blogAciklamaTuru1, aciklama1Renk, aciklama1ResimKonumu, aciklama1Resim, blogAciklama2, blogAciklamaTuru2, aciklama2Renk, aciklama2ResimKonumu, aciklama2Resim, resimOlsunMu, ekstraResim, gununSozu, gununSozuYazari, blogYazarDusuncesi, blogDurumu, blogTarihi, blogYorumSayisi, blogGorunmeSayisi, blogYazari) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executionResult = $stmt->execute([$kapakFoto, $mekanEtiketler, $blogBaslik, $blogAciklama1, $blogAciklamaTuru1, $aciklama1Renk, $aciklama1ResimKonumu, $aciklama1Resim, $blogAciklama2, $blogAciklamaTuru2, $aciklama2Renk, $aciklama2ResimKonumu, $aciklama2Resim, $resimOlsunMu, $ekstraResim, $gununSozu, $gununSozuYazari, $blogYazarDusuncesi, $blogDurumu, $blogTarihi, $blogYorumSayisi, $blogGorunmeSayisi, $blogYazari]);

        if ($executionResult) {
            $successMessage = true;
            function createSafeFileName($string)
            {
                // Türkçe karakterleri İngilizce karakterlere dönüştür
                $string = str_replace(
                    ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'],
                    ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'],
                    $string
                );

                // Alfanümerik olmayan karakterleri kaldır ve boşlukları '-' ile değiştir
                $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
                $string = preg_replace("/[\s]/", "-", $string);

                return strtolower($string) . '.php';
            }

            $lastId = $pdo->lastInsertId();

            $template = file_get_contents('../deneme.php');
            $template = str_replace('$id = 0;', '$id = ' . $lastId . ';', $template);

            $fileName = '../bloglar/' . createSafeFileName($_POST['blogBaslik']);
            file_put_contents($fileName, $template);
        } else {
            $falseMessage = true;
            // İsterseniz burada bir hata mesajı da ayarlayabilirsiniz.
        }
    }
}

?>
<?php
// Form gönderildiğinde
// Blog silmek için form gönderildiğinde
if (isset($_POST['blogDelete'])) {
    $blogId = $_POST['blogId'];

    // Kullanıcının yetkisini çek
    $getUserRoleSql = "SELECT yetkisi FROM users WHERE username = ?";
    $stmtUserRole = $pdo->prepare($getUserRoleSql);
    $stmtUserRole->execute([$username]);
    $userRole = $stmtUserRole->fetchColumn();

    // İzin verilen rolleri tanımla
    $allowedRoles = ['founder', 'admin'];

    // Yetki kontrolü yap
    if (in_array($userRole, $allowedRoles)) {
        // Blog durumunu güncelle
        $updateBlogSql = "UPDATE blog SET blogDurumu = 'Yayından Kaldırıldı' WHERE id = ?";
        $stmtUpdateBlog = $pdo->prepare($updateBlogSql);
        $stmtUpdateBlog->execute([$blogId]);

        // İşlem başarılı mesajı
        $successMessage = "Blog başarıyla silindi";
    } else {
        // Yetki hatası mesajı
        $errorMessage = "Yetkiniz yok";
    }
}
?>
<?php include 'includes/header-main.php'; ?>
<style>
    .tag-container {
        display: flex;
        flex-wrap: wrap;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .tag {
        display: flex;
        align-items: center;
        background-color: #f1f1f1;
        border-radius: 20px;
        padding: 5px 10px;
        margin: 5px 5px 5px 0;
    }

    .tag-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 5px 0;
    }

    .tag-close {
        margin-left: 5px;
        cursor: pointer;
    }
</style>


<script defer src="/assets/js/apexcharts.js"></script>
<div x-data="finance">

    <br>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="panel">
            <form method="POST" enctype="multipart/form-data" class="space-y-5">
                <div>
                    <label for="kapakFoto">Kapak Fotoğrafı</label>
                    <input name="kapakFoto" id="kapakFoto" type="file" accept="image/*" class="form-input" required />
                    <small class="form-text text-muted">Lütfen "resim formatına" uygun bir fotoğraf seçin.</small>
                </div>
                <div>
                    <label for="mekanEtiketler">Etiketler (aralara , koyun)</label>
                    <div id="tag-container" class="tag-container">
                        <input name="mekanEtiketler" id="mekanEtiketler" type="text" placeholder="Eylem, Hatay İçi" class="form-input tag-input" />
                    </div>
                    <small class="form-text text-muted">Eylem, Hatay İçi, Hatay Dışı, Toplumsal Norm, Bilgilendirme dışında bir etiket girerseniz blog yazınız yayınlanmaz.</small>
                </div>
                <div>
                    <label for="blogBaslik">Başlık</label>
                    <input id="blogBaslik" name="blogBaslik" type="text" placeholder="Hatay Anarşi Dayanışma Platformu" class="form-input" required />
                </div>
                <div>

                    <label for="blogAciklama1">Açıklama 1</label>
                    <textarea id="blogAciklama1" name="blogAciklama1" rows="7" class="form-textarea" placeholder="Blog ile ilgili açıklama" required></textarea>
                </div>
                <div>
                    <label for="blogAciklamaTuru1">Açıklama Türü?</label>
                    <select id="blogAciklamaTuru1" name="blogAciklamaTuru1" class="form-select text-white-dark" required onchange="handleAciklamaTuruChange(this, 'aciklama1')">
                        <option value="Hiçbiri">Hiçbiri</option>
                        <option value="Renkli">Renkli</option>
                        <option value="Resimli">Resimli</option>
                        <option value="Tablolu">Tablolu(Bakımda)</option>
                    </select>
                    <div id="aciklama1RenkContainer" style="display:none;">
                        <label for="aciklama1Renk">Renk Seçimi:</label>
                        <select id="aciklama1Renk" name="aciklama1Renk">
                            <option value="kirmizi">Kırmızı</option>
                            <option value="yesil">Yeşil</option>
                            <option value="gri">Gri</option>
                        </select>
                    </div>

                    <div id="aciklama1ResimContainer" style="display:none;">
                        <label for="aciklama1ResimKonumu">Resmin Konumu:</label>
                        <select id="aciklama1ResimKonumu" name="aciklama1ResimKonumu">
                            <option value="sol">Üst/Sol</option>
                            <option value="alt">Alt/Sağ</option>
                        </select>
                        <br>
                        <label for="aciklama1Resim">Resim Yükle:</label>
                        <input id="aciklama1Resim" type="file" accept="image/*" name="aciklama1Resim">
                    </div>
                </div>
                <div>
                    <label for="blogAciklama2">Açıklama 2</label>
                    <textarea id="blogAciklama2" name="blogAciklama2" rows="7" class="form-textarea" placeholder="Blog ile ilgili bir alt açıklama" required></textarea>
                </div>
                <div>
                    <label for="blogAciklamaTuru2">Açıklama Türü?</label>
                    <select name="blogAciklamaTuru2" id="blogAciklamaTuru2" class="form-select text-white-dark" required onchange="handleAciklamaTuruChange(this, 'aciklama2')">
                        <option value="Hiçbiri">Hiçbiri</option>
                        <option value="Renkli">Renkli</option>
                        <option value="Resimli">Resimli</option>
                        <option value="Tablolu">Tablolu(Bakımda)</option>
                    </select>
                    <div id="aciklama2RenkContainer" style="display:none;">
                        <label for="aciklama2Renk">Renk Seçimi:</label>
                        <select id="aciklama2Renk" name="aciklama2Renk">
                            <option value="kirmizi">Kırmızı</option>
                            <option value="yesil">Yeşil</option>
                            <option value="gri">Gri</option>
                        </select>
                    </div>

                    <div id="aciklama2ResimContainer" style="display:none;">
                        <label for="aciklama2ResimKonumu">Resmin Konumu:</label>
                        <select id="aciklama2ResimKonumu" name="aciklama2ResimKonumu">
                            <option value="sol">Üst/Sol</option>
                            <option value="alt">Alt/Sağ</option>
                        </select>
                        <br>
                        <label for="aciklama2Resim">Resim Yükle:</label>
                        <input id="aciklama2Resim" type="file" accept="image/*" name="aciklama2Resim">
                    </div>
                </div>

                <div>
                    <label for="resimOlsunMu">Ekstra resim olsun mu?</label>
                    <select id="resimOlsunMu" name="resimOlsunMu" class="form-select text-white-dark" required onchange="handleEkstraResimChange(this)">
                        <option value="Hayır">Hayır</option>
                        <option value="Evet">Evet</option>
                    </select>
                    <div id="ekstraResimContainer" style="display:none;">
                        <label for="ekstraResim">Resim Yükle:</label>
                        <input id="ekstraResim" type="file" accept="image/*" name="ekstraResim">
                    </div>
                </div>

                <div>
                    <label for="gununSozu">Günün Sözü</label>
                    <input id="gununSozu" name="gununSozu" type="text" placeholder="Enayi Olmayın" class="form-input" required />
                </div>
                <div>
                    <label for="gununSozuYazari">Günün Sözü Yazarı</label>
                    <input id="gununSozuYazari" name="gununSozuYazari" type="text" placeholder="Marijua" class="form-input" required />
                </div>
                <div>
                    <label for="blogYazarDüsüncesi">Blog Yazarının Konu İle İlgili Düşünceleri</label>
                    <input id="blogYazarDüsüncesi" name="blogYazarDusuncesi" type="text" placeholder="Çok Yaşa Anarşi Toplulukları!" class="form-input" required />
                </div>
                <button name="addBlog" type="submit" class="btn btn-primary !mt-6">Ekle</button>
                <div id="messageContainer" style="display: none;">
                    <p class="text-success">Bloğunuz başarıyla eklendi.</p>
                </div>
                <div id="messageContainer2" style="display: none;">
                    <p class="text-false">Bloğunuz eklenemedi.</p>
                </div>
                <div id="messageContainer3" style="display: none;">
                    <p class="text-false">Bu başlıkta bir blog zaten var.</p>
                </div>

            </form>
        </div>

        <div class="panel">
            <form method="POST" class="space-y-5">
                <?php if (isset($successMessage)) : ?>
                    <p class="text-success"><?= $successMessage ?></p>
                <?php endif; ?>
                <?php if (isset($errorMessage)) : ?>
                    <p class="text-error"><?= $errorMessage ?></p>
                <?php endif; ?>
                <div>
                    <label for="blogId">Silinicek Blog ID</label>
                    <input id="blogId" name="blogId" type="text" placeholder="1003" class="form-input" required />
                </div>
                <button name="blogDelete" type="submit" class="btn btn-danger !mt-6">Sil</button>
            </form>
        </div>

        <script>
            // Açıklama Türü için Dinamik İşlevsellik
            function handleAciklamaTuruChange(selectElement, prefix) {
                const value = selectElement.value;
                const renkContainer = document.getElementById(prefix + 'RenkContainer');
                const resimContainer = document.getElementById(prefix + 'ResimContainer');
                // Önce tüm konteynerleri gizleyin
                renkContainer.style.display = 'none';
                resimContainer.style.display = 'none';

                if (value === 'Renkli') {
                    renkContainer.style.display = 'block';
                } else if (value === 'Resimli') {
                    resimContainer.style.display = 'block';
                }
            }

            // Ekstra Resim için Dinamik İşlevsellik
            function handleEkstraResimChange(selectElement) {
                const value = selectElement.value;
                const ekstraResimContainer = document.getElementById('ekstraResimContainer');

                if (value === 'Evet') {
                    ekstraResimContainer.style.display = 'block';
                } else {
                    ekstraResimContainer.style.display = 'none';
                }
            }
        </script>

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
        if ($errorMessage) {
            echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("messageContainer3").style.display = "block";
    });
    </script>';
        }
        ?>


        <?php include 'includes/footer-main.php'; ?>