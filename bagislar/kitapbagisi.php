<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$successmessage = false;
$errormessages = false;

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

// Formdan veri alındığını kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al
    $kitapAdi = $_POST["kitapAdi"];
    $yayin = $_POST["yayin"];
    $baski = $_POST["baski"];
    $basimYili = $_POST["basimYili"];
    $fiyat = $_POST["fiyat"];
    $yazar = $_POST["yazar"];
    $sehir = $_POST["sehir"];
    $il = $_POST["il"];
    $iletisim = $_POST["iletisim"];
    $durum = "Beklemede";

    // Dosyaları yükle ve dosya yollarını al
    $foto1 = uploadFile($_FILES["foto1"], "assets/resimler/kitapbagis/");
    $foto2 = uploadFile($_FILES["foto2"], "assets/resimler/kitapbagis/");

    // MySQL bağlantısını yap
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hatayanarsi";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Veritabanına verileri ekle
    $sql = "INSERT INTO kitapbagis (kitapAd, yayin, baskiNo, baskiYil, alimFiyati, yazar, il, ilce, iletisimBilgisi, fotograf, fotograf2, onayDurumu) 
            VALUES ('$kitapAdi', '$yayin', '$baski', '$basimYili', '$fiyat', '$yazar', '$sehir', '$il', '$iletisim', '$foto1', '$foto2', '$durum')";

    if ($conn->query($sql) === TRUE) {
        $successmessage = "Başarıyla kayıt formunuz gönderildi! Yöneticiler en kısa sürede sizinle iletişime geçecek.";
    } else {
        $errormessages = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Bağlantıyı kapat
    $conn->close();
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

                <main>
                    <div class="container mt-5">
                        <h2 class="mb-4">Kitap Bağışı Formu</h2>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="kitapAdi">Kitap Adı:</label>
                                <input type="text" class="form-control" id="kitapAdi" name="kitapAdi" required>
                            </div>
                            <div class="form-group">
                                <label for="yayin">Yayını:</label>
                                <input type="text" class="form-control" id="yayin" name="yayin" required>
                            </div>
                            <div class="form-group">
                                <label for="baski">Kaçıncı Baskı:</label>
                                <input type="number" class="form-control" id="baski" name="baski" required>
                            </div>
                            <div class="form-group">
                                <label for="basimYili">Basım Yılı:</label>
                                <input type="number" class="form-control" id="basimYili" name="basimYili" required>
                            </div>
                            <div class="form-group">
                                <label for="fiyat">Alım Fiyatı:</label>
                                <input type="text" class="form-control" id="fiyat" name="fiyat" required>
                            </div>
                            <div class="form-group">
                                <label for="yazar">Kitap Yazarı:</label>
                                <input type="text" class="form-control" id="yazar" name="yazar" required>
                            </div>
                            <div class="form-group">
                                <label for="sehir">Şehir (İl):</label>
                                <input type="text" class="form-control" id="sehir" name="sehir" required>
                            </div>
                            <div class="form-group">
                                <label for="il">İlçe:</label>
                                <input type="text" class="form-control" id="il" name="il" required>
                            </div>
                            <div class="form-group">
                                <label for="iletisim">İletişim Bilgisi:</label>
                                <input type="text" class="form-control" id="iletisim" name="iletisim" required>
                            </div>
                            <div class="form-group">
                                <label for="foto1">Kitap Kapak Fotoğrafı 1:</label>
                                <input type="file" class="form-control" id="foto1" name="foto1" required>
                            </div>
                            <div class="form-group">
                                <label for="foto2">Kitap Fotoğrafı 2:</label>
                                <input type="file" class="form-control" id="foto2" name="foto2" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Formu Gönder</button>
                            <?php
                            if ($successmessage) {
                                echo '<div id="errorContainer">' . $successmessage . '</div>';
                            }
                            ?>
                            <?php
                            if ($errormessages) {
                                echo '<div id="errorContainer">' . $errormessages . '</div>';
                            }
                            ?>
                        </form>
                    </div>
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
        <script>
            // Sayfa yüklendiğinde çalışacak JavaScript kodları
            document.addEventListener('DOMContentLoaded', function() {
                // Pop-up mesajını göstermek için bir fonksiyon
                function showPopup() {
                    alert("Bu bir pop-up mesajıdır. Hoş geldiniz!");
                }

                // Belirli bir süre sonra pop-up mesajını göstermek için kullanabilirsiniz
                // setTimeout(showPopup, 3000); // Örnekte 3000 milisaniye (3 saniye) sonra gösterilecek

                // Sayfa yüklendiğinde pop-up mesajını göstermek için:
                // showPopup();
            });
        </script>