<?php require_once 'includes/connect.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$successMessage = false;
$falseMessage = false;
$errorMessage = false;
$userPermOld = false;

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

if ($userRole == 'founder' or $userRole == 'admin' or $userRole == 'editor') {
    $userPermOld = 3;
} else if ($userRole == 'yazar') {
    $userPermOld = 2;
} else {
    $userPermOld = false;
}

function getBlogInfo($blogId)
{
    global $pdo;

    // Blogun bilgilerini veritabanından al
    $stmt = $pdo->prepare("SELECT * FROM blog WHERE id = ?");
    $stmt->execute([$blogId]);
    $blogInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    return $blogInfo;
}

if (isset($_POST['editBlog'])) {
    if ($userPermOld == false) {
        exit;
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

    $blogId = $_POST['blogId'];

    $kapakFoto = uploadFile($_FILES['kapakFoto'], 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/');

    $mekanEtiketler = $_POST['mekanEtiketler'];
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

    // Güncellenecek alanları saklamak için bir dizi oluştur
    $updateData = [];

    // Mekan Etiketleri
    if (!empty($_POST['mekanEtiketler'])) {
        $updateData['mekanEtiketler'] = $mekanEtiketler;
    }

    // Blog 1 Açıklama
    if (!empty($_POST['blogAciklama1'])) {
        $updateData['blogAciklama1'] = $blogAciklama1;
    }

    // Blog 1 Açıklama Türü
    if ($_POST['blogAciklamaTuru1'] != "Hiçbiri") {
        $updateData['blogAciklamaTuru1'] = $blogAciklamaTuru1;
    }

    // Blog 2 Açıklama 
    if (!empty($_POST['blogAciklama2'])) {
        $updateData['blogAciklama2'] = $blogAciklama2;
    }

    // Blog 2 Açıklama Türü
    if ($_POST['blogAciklamaTuru2'] != "Hiçbiri") {
        $updateData['blogAciklamaTuru2'] = $blogAciklamaTuru2;
    }

    // Resim olsun mu
    if ($_POST['resimOlsunMu'] != "Hiçbiri") {
        $updateData['resimOlsunMu'] = $resimOlsunMu;
    }

    // Günün Sözü
    if (!empty($_POST['gununSozu'])) {
        $updateData['gununSozu'] = $gununSozu;
    }

    // Günün Sözü Yazarı
    if (!empty($_POST['gununSozuYazari'])) {
        $updateData['gununSozuYazari'] = $gununSozuYazari;
    }

    // Blog hakkında yazarın düşüncesi
    if (!empty($_POST['blogYazarDusuncesi'])) {
        $updateData['blogYazarDusuncesi'] = $blogYazarDusuncesi;
    }

    // aciklama1Renk
    if ($_POST['aciklama1Renk'] != NULL) {
        $updateData['aciklama1Renk'] = $aciklama1Renk;
    }

    // aciklama1ResimKonumu
    if ($_POST['aciklama1ResimKonumu'] != NULL) {
        $updateData['aciklama1ResimKonumu'] = $aciklama1ResimKonumu;
    }

    // aciklama2Renk
    if ($_POST['aciklama2Renk'] != NULL) {
        $updateData['aciklama2Renk'] = $aciklama2Renk;
    }

    // aciklama2ResimKonumu
    if ($_POST['aciklama2ResimKonumu'] != NULL) {
        $updateData['aciklama2ResimKonumu'] = $aciklama2ResimKonumu;
    }

    // aciklama1Resim
    if ($_FILES['aciklama1Resim'] != NULL) {
        $updateData['aciklama1Resim'] = $aciklama1Resim;
    }

    // aciklama2Resim
    if ($_FILES['aciklama2Resim'] != NULL) {
        $updateData['aciklama2Resim'] = $aciklama2Resim;
    }

    // kapakFoto
    if (isset($_FILES['kapakFoto']) && $_FILES['kapakFoto']['name'] != NULL) {
        $updateData['kapakFoto'] = $kapakFoto;
    }
    // ekstraResim
    if (isset($_FILES['ekstraResim']) && $_FILES['ekstraResim']['name'] != NULL) {
        $updateData['ekstraResim'] = $ekstraResim;
    }

    if ($userPermOld == 3) {

        // SQL sorgusunu hazırla
        $sql = "UPDATE blog SET ";
        // Her bir alanı SQL sorgusuna ekle
        foreach ($updateData as $key => $value) {
            $sql .= "$key = :$key, ";
        }

        // Son iki karakteri (", ") kaldır
        $sql = rtrim($sql, ", ");

        // WHERE koşulunu ekle
        $sql .= " WHERE id = :blogId";

        // PDO statement'ını hazırla
        $stmt = $pdo->prepare($sql);

        // Güncellenecek alanları bind et
        foreach ($updateData as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // BlogId'yi de bind et
        $stmt->bindValue(":blogId", $blogId);

        // SQL sorgusunu çalıştır
        $updateResult = $stmt->execute();
        $blogs = getBlogInfo($blogId);

        if ($updateResult) {
            $successMessage = true;
        } else if (!$blogs) {
            $errorMessage = true;
        } else {
            $errorMessage = true;
        }
    } elseif ($userPermOld == 2) {

        $blogs = getBlogInfo($blogId);
        if ($blogs['blogYazari'] == $username) {
            // SQL sorgusunu hazırla
            $sql = "UPDATE blog SET ";
            // Her bir alanı SQL sorgusuna ekle
            foreach ($updateData as $key => $value) {
                $sql .= "$key = :$key, ";
            }

            // Son iki karakteri (", ") kaldır
            $sql = rtrim($sql, ", ");

            // WHERE koşulunu ekle
            $sql .= " WHERE id = :blogId";

            // PDO statement'ını hazırla
            $stmt = $pdo->prepare($sql);

            // Güncellenecek alanları bind et
            foreach ($updateData as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            // BlogId'yi de bind et
            $stmt->bindValue(":blogId", $blogId);

            // SQL sorgusunu çalıştır
            $updateResult = $stmt->execute();
            if ($updateResult) {
                $successMessage = true;
            } else {
                $falseMessage = true;
            }
        } else {
            $falseMessage = true;
        }
    }
}


// Formdan gelen blogId değerini al
$blogIdGet = $_POST['blogIdGet'] ?? null;
$blogData = null;
$check = isset($blogData);

if ($userPermOld == 3) {
    if (isset($_POST['getBlogs'])) {
        $_SESSION['blogIdGet'] = $blogIdGet;
        $blogData = getBlogInfo($blogIdGet);
        $check = true;

        // Formdaki diğer değerleri SESSION'a kaydet
        $_SESSION['blogTitle'] = $blogData['blogBaslik'];
        $_SESSION['blogAuthor'] = $blogData['blogYazari'];
        $_SESSION['blogStatus'] = $blogData['blogDurumu'];
    }

    // Blog durumunu değiştir
    if (isset($_POST['changeStatus'])) {
        try {
            $newStatus = $_POST['blogStatus'];

            // Güncelleme SQL sorgusunu hazırla
            $updateSql = "UPDATE blog SET blogDurumu = ? WHERE id = ?";
            $stmt = $pdo->prepare($updateSql);
            $stmt->execute([$newStatus, $_SESSION['blogIdGet']]);

            // Başarı durumunu kontrol et
            if ($stmt->rowCount() > 0) {
                $successMessageGet = "Blog durumu başarıyla güncellendi.";
            } else {
                $errorMessageGet = "Blog durumu güncellenirken bir hata oluştu.";
            }

            // Güncellenen blog verilerini tekrar çek
            $blogData = getBlogInfo($_SESSION['blogIdGet']);

            $check = null;
        } catch (PDOException $e) {
            echo 'Hata: ' . $e->getMessage(); // Hatanın detaylarını ekrana bastırır
        }
    }
} else if ($userPermOld == 2) {
    if(isset($_POST['getBlogs'])) {
        $errorMessageGet = "Bu işlem için yetkiniz yoktur.";
    }
} else {
    exit;
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
                    <label for="blogid">Düzenlenecek Blog ID</label>
                    <input id="blogid" name="blogId" type="text" placeholder="1" class="form-input" />
                </div>

                <div>
                    <label for="kapakFoto">Kapak Fotoğrafı</label>
                    <input name="kapakFoto" id="kapakFoto" type="file" accept="image/*" class="form-input" />
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

                    <label for="blogAciklama1">Açıklama 1</label>
                    <textarea id="blogAciklama1" name="blogAciklama1" rows="7" class="form-textarea" placeholder="Blog ile ilgili açıklama"></textarea>
                </div>
                <div>
                    <label for="blogAciklamaTuru1">Açıklama Türü?</label>
                    <select id="blogAciklamaTuru1" name="blogAciklamaTuru1" class="form-select text-white-dark" onchange="handleAciklamaTuruChange(this, 'aciklama1')">
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
                    <textarea id="blogAciklama2" name="blogAciklama2" rows="7" class="form-textarea" placeholder="Blog ile ilgili bir alt açıklama"></textarea>
                </div>
                <div>
                    <label for="blogAciklamaTuru2">Açıklama Türü?</label>
                    <select name="blogAciklamaTuru2" id="blogAciklamaTuru2" class="form-select text-white-dark" onchange="handleAciklamaTuruChange(this, 'aciklama2')">
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
                    <select id="resimOlsunMu" name="resimOlsunMu" class="form-select text-white-dark" onchange="handleEkstraResimChange(this)">
                        <option value="Hiçbiri">Hiçbiri</option>
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
                    <input id="gununSozu" name="gununSozu" type="text" placeholder="Enayi Olmayın" class="form-input" />
                </div>
                <div>
                    <label for="gununSozuYazari">Günün Sözü Yazarı</label>
                    <input id="gununSozuYazari" name="gununSozuYazari" type="text" placeholder="Marijua" class="form-input" />
                </div>
                <div>
                    <label for="blogYazarDüsüncesi">Blog Yazarının Konu İle İlgili Düşünceleri</label>
                    <input id="blogYazarDüsüncesi" name="blogYazarDusuncesi" type="text" placeholder="Çok Yaşa Anarşi Toplulukları!" class="form-input" />
                </div>
                <button name="editBlog" type="submit" class="btn btn-primary !mt-6">Düzenle</button>
                <div id="messageContainer" style="display: none;">
                    <p class="text-success">Bloğunuz başarıyla düzenlendi.</p>
                </div>
                <div id="messageContainer2" style="display: none;">
                    <p class="text-error">Bloğunuzu düzenlemek için yeterli yetkiniz yok.</p>
                </div>
                <div id="messageContainer3" style="display: none;">
                    <p class="text-error">Böyle bir blog bulunmuyor..</p>
                </div>

            </form>
        </div>

        <div class="panel">
            <?php if ($check == null) : ?>
                <form method="POST" class="space-y-5">

                    <div>
                        <label for="blogId">Getirilecek Blog ID</label>

                        <input id="blogId" name="blogIdGet" type="text" placeholder="1003" class="form-input" required />
                    </div>
                    <button name="getBlogs" type="submit" class="btn btn-danger !mt-6">Getir</button>
                    <?php if (isset($successMessageGet)) : ?>
                        <p class="text-success"><?= $successMessageGet ?></p>
                    <?php endif; ?>
                    <?php if (isset($errorMessageGet)) : ?>

                        <p class="text-error" style="color: red;"><?= $errorMessageGet ?></p>
                    <?php endif; ?>
                    <br>
                <?php endif; ?>

                </form>

                <?php if ($check) : ?>
                    <form method="POST" class="space-y-5">
                        <div>
                            <label for="blogTitle">Başlık</label>

                            <input id="blogTitle" name="blogTitle" type="text" value="<?= $blogData['blogBaslik'] ?>" class="form-input" readonly />
                        </div>
                        <div>
                            <label for="blogAuthor">Yazar</label>
                            <input id="blogAuthor" name="blogAuthor" type="text" value="<?= $blogData['blogYazari'] ?>" class="form-input" readonly />
                        </div>
                        <div>
                            <label for="blogStatus">Durumu</label>
                            <select id="blogStatus" name="blogStatus" class="form-select">
                                <option value="Yayından Kaldırıldı" <?= ($blogData['blogDurumu'] == 'Yayından Kaldırıldı') ? 'selected' : '' ?>>Yayından Kaldırıldı</option>
                                <option value="Yayında" <?= ($blogData['blogDurumu'] == 'Yayında') ? 'selected' : '' ?>>Yayında</option>
                                <option value="Beklemede" <?= ($blogData['blogDurumu'] == 'Beklemede') ? 'selected' : '' ?>>Beklemede</option>
                            </select>
                        </div>
                        <button name="changeStatus" type="submit" class="btn btn-primary !mt-6">Değiştir</button>

                    </form>
                <?php endif; ?>
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