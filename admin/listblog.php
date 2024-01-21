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


if ($userPermOld == 3) {
    try {
        // Veritabanı bağlantısı
        $pdo = new PDO("mysql:host=localhost;dbname=hatayanarsi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Blog tablosundaki tüm verileri çek
        $stmt = $pdo->query("SELECT * FROM blog");
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

      
        // Veritabanı bağlantısını kapat
        $pdo = null;
    } catch (PDOException $e) {
        echo 'Hata: ' . $e->getMessage();
    }
} else if ($userPermOld == 2) {
    try {
        // Veritabanı bağlantısı
        $pdo = new PDO("mysql:host=localhost;dbname=hatayanarsi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sadece kullanıcının yazdığı blogları çek
        $stmt = $pdo->prepare("SELECT * FROM blog WHERE blogYazari = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

     

        // Veritabanı bağlantısını kapat
        $pdo = null;
    } catch (PDOException $e) {
        echo 'Hata: ' . $e->getMessage();
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
            <span>Blog Listesi</span>
        </li>
    </ul>
    
    <br>
    <!-- Recent Transactions -->
    <div class="panel">
        <div class="dataTable-top">
            <h5 class="text-lg font-semibold dark:text-white-light">Bloglar</h5>
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
                        <th>Kapak Fotoğrafı</th>
                        <th>Mekan Etiketleri</th>
                        <th>Blog Başlığı</th>
                        <th>1 Blog Açıklaması</th>
                        <th>2 Blog Açıklaması</th>
                        <th>Günün Sözü</th>
                        <th>Blog Yazar Düşüncesi</th>
                        <th>Blog Durumu</th>
                        <th>Blog Yazarı</th>
                        <th>Blog Görüntülenme Sayısı</th>
                        <th>Blog Yorum Sayısı</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($blogs as $blog) : ?>
                    <tr>
                        <td><?= $blog['id'] ?></td>
                        <td>
                            <button type="button" class="badge bg-primary" @click="showImage('<?php echo $blog['kapakFoto']  ?>')">View</button>
                        </td>
                        <td><?= $blog['mekanEtiketler'] ?></td>
                        <td><?= $blog['blogBaslik'] ?></td>
                        <td>
                            <button class="badge bg-primary" type="button" @click="showDescription(`<?= htmlspecialchars(json_encode($blog['blogAciklama1']), ENT_QUOTES, 'UTF-8') ?>`)">
                                View
                            </button>
                        </td>
                        <td>
                            <button class="badge bg-primary" type="button" @click="showDescription(`<?= htmlspecialchars(json_encode($blog['blogAciklama2']), ENT_QUOTES, 'UTF-8') ?>`)">
                                View
                            </button>
                        </td>
                        <td> <button class="badge bg-primary" type="button" @click="showLyrics(`<?= htmlspecialchars(json_encode($blog['gununSozu']), ENT_QUOTES, 'UTF-8') ?>`)">
                                View
                            </button> </td>
                        <td> <button class="badge bg-primary" type="button" @click="showLyrics(`<?= htmlspecialchars(json_encode($blog['blogYazarDusuncesi']), ENT_QUOTES, 'UTF-8') ?>`)">
                                View
                            </button> </td>
                        <td><?= $blog['blogDurumu'] ?></td>
                        <td><?= $blog['blogYazari'] ?></td>
                        <td><?= $blog['blogGorunmeSayisi'] ?></td>
                        <td><?= $blog['blogYorumSayisi'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
</div>
</div>
<script>
    async function showImage(imageUrl) {
        new window.Swal({
            html: `<img src="${imageUrl}" alt="Resim" style="max-width: 100%;" />`,
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