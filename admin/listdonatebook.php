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
$successMessageGet = false;
$errorMessageGet = false;


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

if ($userRole == 'founder' or $userRole == 'admin') {
    $userPermOld = 3;
} else if ($userRole == 'yazar' or $userRole == 'editor') {
    $userPermOld = 2;
} else {
    $userPermOld = false;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hatayanarsi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}





function getBookInfo($bookId)
{
    global $pdo;

    // Ensure $pdo is not null before using it
    if (!$pdo) {
        try {
            // Veritabanı bağlantısı
            $pdo = new PDO("mysql:host=localhost;dbname=hatayanarsi", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Hata: ' . $e->getMessage();
            return null;
        }
    }

    // Kitap bilgilerini veritabanından al
    $stmt = $pdo->prepare("SELECT * FROM kitapbagis WHERE id = ?");
    $stmt->execute([$bookId]);
    $bookInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    return $bookInfo;
}





if ($userPermOld != false) {
    try {
        // Veritabanı bağlantısı
        $pdo = new PDO("mysql:host=localhost;dbname=hatayanarsi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Blog tablosundaki tüm verileri çek
        $stmt = $pdo->query("SELECT * FROM kitapbagis");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Veritabanı bağlantısını kapat
        // $pdo = null;
    } catch (PDOException $e) {
        echo 'Hata: ' . $e->getMessage();
    }
} else {
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hatayanarsi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Formdan gelen bookI değerini al
$bookIdGet = $_POST['bookIdGet'] ?? null;
$bookData = null;
$check = isset($blogData);

if ($userPermOld == 3) {
    if ($bookIdGet) {
        $_SESSION['bookIdGet'] = $bookIdGet;
        $bookData = getBookInfo($bookIdGet);
        $check = true;

        // Formdaki diğer değerleri SESSION'a kaydet
        $_SESSION['kitapAdi'] = $bookData['kitapAd'];
        $_SESSION['yazar'] = $bookData['yazar'];
        $_SESSION['onayDurumu'] = $bookData['onayDurumu'];
    }

    // Blog durumunu değiştir
    if (isset($_POST['changeStatus'])) {
        try {
            $newStatus = $_POST['bookStatus'];

            // Güncelleme SQL sorgusunu hazırla
            $updateSql = "UPDATE kitapbagis SET onayDurumu = ? WHERE id = ?";
            $stmt = $pdo->prepare($updateSql);
            $stmt->execute([$newStatus, $_SESSION['bookIdGet']]);

            // Başarı durumunu kontrol et
            if ($stmt->rowCount() > 0) {
                $successMessageGet = "Kitap durumu başarıyla güncellendi.";
            } else {
                $errorMessageGet = "Kitap durumu güncellenirken bir hata oluştu.";
            }

            // Güncellenen blog verilerini tekrar çek
            $blogData = getBookInfo($_SESSION['bookIdGet']);

            $check = null;
        } catch (PDOException $e) {
            echo 'Hata: ' . $e->getMessage(); // Hatanın detaylarını ekrana bastırır
        }
    }
} else if ($userPermOld == 2) {
    if(isset($bookIdGet)) {
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

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Kitap Listesi</span>
        </li>
    </ul>

    <br>
    <!-- Recent Transactions -->
    <div class="panel">
        <div class="dataTable-top">
            <h5 class="text-lg font-semibold dark:text-white-light">Kitaplar</h5>
            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                <a href="javascript:;" @click="toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ltr:mr-4 rtl:ml-4">
                        <path d="M17 7.82959L18.6965 9.35641C20.239 10.7447 21.0103 11.4389 21.0103 12.3296C21.0103 13.2203 20.239 13.9145 18.6965 15.3028L17 16.8296" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        <path opacity="0.5" d="M13.9868 5L10.0132 19.8297" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M7.00005 7.82959L5.30358 9.35641C3.76102 10.7447 2.98975 11.4389 2.98975 12.3296C2.98975 13.2203 3.76102 13.9145 5.30358 15.3028L7.00005 16.8296" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </a>
                <ul x-cloak x-show="open" x-transition x-transition.duration.300ms class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                    <li><a href="itemsadd.php" @click="villaAdd()">Add</a></li>
                    <li><a href="itemsremove.php:;" @click="villaRemove()">Remove</a></li>
                </ul>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th class="ltr:rounded-l-md rtl:rounded-r-md">ID</th>
                        <th>Kitap Adı</th>
                        <th>Kitap Yayını</th>
                        <th>Kitap Baskı No</th>
                        <th>Kitap Baskı Yılı</th>
                        <th>Kitap Alım Fiyatı</th>
                        <th>Kitap Yazarı</th>
                        <th>Donor İl</th>
                        <th>Donor İlce</th>
                        <th>Donor İletişim Bilgisi</th>
                        <th>Kitap Fotoğrafı</th>
                        <th>Kitap Fotoğrafı 2</th>
                        <th>Onay Durumu</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($books as $book) : ?>
                    <tr>
                        <td><?= $book['id'] ?></td>

                        <td><?= $book['kitapAd'] ?></td>
                        <td><?= $book['yayin'] ?></td>
                        <td><?= $book['baskiNo'] ?></td>
                        <td><?= $book['baskiYil'] ?></td>
                        <td><?= $book['alimFiyati'] ?></td>
                        <td><?= $book['yazar'] ?></td>
                        <td><?= $book['il'] ?></td>
                        <td><?= $book['ilce'] ?></td>
                        <td> <button class="badge bg-primary" type="button" @click="showLyrics(`<?= htmlspecialchars(json_encode($book['iletisimBilgisi']), ENT_QUOTES, 'UTF-8') ?>`)">
                                View
                        <td>
                            <button type="button" class="badge bg-primary" @click="showImage('<?php echo $book['fotograf']  ?>')">View</button>
                        </td>
                        <td>
                            <button type="button" class="badge bg-primary" @click="showImage('<?php echo $book['fotograf2']  ?>')">View</button>
                        </td>
                        <td><?= $book['onayDurumu'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<br>

<div class="panel">
    <?php if ($check == null) : ?>
        <form method="POST" class="space-y-5">

            <div>
                <label for="bookIdGet">Getirilecek Kitap ID</label>

                <input id="bookIdGet" name="bookIdGet" type="text" placeholder="2" class="form-input" required />
            </div>
            <button name="getUsers" type="submit" class="btn btn-danger !mt-6">Getir</button>
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
                    <label for="kitapAdi">Kitap Adı</label>
                    <input id="kitapAdi" name="kitapAdi" type="text" value="<?=  $_SESSION['kitapAdi'] ?>" class="form-input" readonly />
                </div>
                <div>
                    <label for="author">Kitap Yazar</label>
                    <input id="kitapAdi" name="kitapAdi" type="text" value="<?= $_SESSION['yazar'] ?>" class="form-input" readonly />

                </div>
                <div>
                    <label for="bookStatus">Onay Durumu</label>
                    <select id="bookStatus" name="bookStatus" class="form-select">

                        <option value="Beklemede" <?= ($_SESSION['onayDurumu'] == 'Beklemede') ? 'selected' : '' ?>>Beklemede</option>
                        <option value="Onaylanamadı" <?= ($_SESSION['onayDurumu']  == 'Onaylanamadı') ? 'selected' : '' ?>>Deaktif</option>
                        <option value="Onaylandı" <?= ($_SESSION['onayDurumu']  == 'Onaylandı') ? 'selected' : '' ?>>Onaylandı</option>

                    </select>
                </div>
                <button name="changeStatus" type="submit" class="btn btn-primary !mt-6">Değiştir</button>

            </form>
        <?php endif; ?>
</div>



</div>
</div>
</div>
<script>
    async function showImage(imageUrl) {
        new window.Swal({
            html: `<img src="../bagislar/${imageUrl}" alt="Resim" style="max-width: 100%;" />`,
            padding: '2em',
        });
    }
    async function showDescription(descripton) {
        new window.Swal({
            text: descripton,
            padding: '2em',
        });
    }
    async function showLyrics(lyrics) {
        new window.Swal({
            text: lyrics,
            padding: '2em',
        });
    }
</script>

<script>

</script>
<?php include 'includes/footer-main.php'; ?>