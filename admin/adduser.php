<?php
require_once 'includes/connect.php';
session_start();
if (!$_SESSION['username']) {
    header('Location: index.php');
}
// Database bağlantınızı burada tanımlayın.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hatayanarsi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if ($userRole == 'founder') {
    $userPermOld = 3;
} else if ($userRole == 'yazar' or $userRole == 'admin' or $userRole == 'editor') {
    $userPermOld = 2;
} else {
    $userPermOld = false;
}



function getUserInfo($username)
{
    global $pdo;

    // Blogun bilgilerini veritabanından al
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userInfo;
}





// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateToken($length = 20)
{
    // Karışık karakterlerden oluşan bir dizi oluşturuluyor.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    // Belirtilen uzunlukta rastgele bir token oluşturuluyor.
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}


if (isset($_POST['addUser'])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Parolayı hashliyoruz.
    $yetkisi = $_POST["yetkisi"];
    $pp = $_POST["pp"];
    $email = $_POST["email"];
    $bio = $_POST["bio"];
    $website = $_POST["website"];
    $sosyalMedya = $_POST["sosyalMedya"];
    $token = generateToken();
    // SQL sorgusunu hazırlayın
    $sql = "SELECT yetkisi FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    // Sorguyu çalıştırın
    $stmt->execute([$_SESSION['username']]);

    // Sonucu alın
    $yetki = $stmt->fetchColumn();



    // Yetki kontrolü
    if ($yetki == 'founder') {
        $olusturulmaTarihi = date("Y-m-d H:i:s");  // Mevcut tarihi ve saati alıyoruz.

        $sql = "INSERT INTO users (username, password, yetkisi, pp, email, olusturulmaTarihi, bio, website, sosyalMedya, resetToken)
            VALUES ('$username', '$password', '$yetkisi', '$pp', '$email', '$olusturulmaTarihi', '$bio', '$website', '$sosyalMedya', '$token')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = true;
        } else {
            $falseMessage = true;
            // İsterseniz burada bir hata mesajı da ayarlayabilirsiniz.
        }
    } else {
        $errorMessage = true;
        // Yetki yetersiz hatası
    }

    $conn->close();
}

// Formdan gelen blogId değerini al
$usernameGet = isset($_POST['usernameGet']) ? $_POST['usernameGet'] : null;
$userData = null;
$check = isset($userData);

?>


<?php include 'includes/header-main.php'; ?>

<div x-data="finance">
    <br>
    <div class="pt-5">
        <form method="post">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 text-white">
                <!-- Username -->
                <div class="panel">
                    <div class="text-md font-semibold">Username</div>
                    <input type="text" name="username" class="form-input mt-5" required />
                </div>

                <!-- Password -->
                <div class="panel">
                    <div class="text-md font-semibold">Password</div>
                    <input type="password" name="password" class="form-input mt-5" required />
                </div>

                <!-- Yetkisi (Role) -->
                <div class="panel">
                    <div class="text-md font-semibold">Role</div>
                    <select name="yetkisi" class="form-input mt-5" required>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="yazar">Yazar</option>
                    </select>
                </div>

                <!-- Profile Picture (PP) -->
                <div class="panel">
                    <div class="text-md font-semibold">Profile Picture URL</div>
                    <input type="text" name="pp" class="form-input mt-5" />
                </div>

                <!-- Email -->
                <div class="panel">
                    <div class="text-md font-semibold">Email</div>
                    <input type="email" name="email" class="form-input mt-5" required />
                </div>

                <!-- Bio -->
                <div class="panel">
                    <div class="text-md font-semibold">Bio</div>
                    <textarea name="bio" class="form-textarea mt-5" required></textarea>
                </div>

                <!-- Website -->
                <div class="panel">
                    <div class="text-md font-semibold">Website</div>
                    <input type="url" name="website" class="form-input mt-5" />
                </div>

                <!-- Sosyal Medya -->
                <div class="panel">
                    <div class="text-md font-semibold">Social Media URLs (comma separated)</div>
                    <input type="text" name="sosyalMedya" class="form-input mt-5" />
                </div>
            </div>
            <div class="text-center">
                <button name="addUser" type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
                <div id="messageContainer" style="display: none;">
                    <p class="text-success">Kullanıcı başarıyla eklendi.</p>
                </div>
                <div id="messageContainer2" style="display: none;">
                    <p class="text-false">Kullanıcı eklenemedi.</p>
                </div>
                <div id="messageContainer3" style="display: none;">
                    <p class="text-false">Kullanıcı eklemek için yeterli yetkiniz yok.</p>
                    
                </div>


            </div>
        </form>
    </div>

    <br>

    <div class="panel">
            <?php if ($check == null) : ?>
                <form method="POST" class="space-y-5">

                    <div>
                        <label for="usernameGet">Getirilecek Kullanıcı Adı</label>

                        <input id="usernameGet" name="usernameGet" type="text" placeholder="Marijua" class="form-input" required />
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
                            <label for="username">Kullanıcı Adı</label>
                            <input id="username" name="username" type="text" value="<?= $_POST['usernameGet'] ?>" class="form-input" readonly />
                        </div>
                        <div>
                        <label for="userPerm">Hesap Yetkisi</label>
                            <select id="userPerm" name="userPerm" class="form-select">
                                <?php if($_SESSION['yetkisi'] == 'founder') {
                                   ?> <option value="founder">Founder</option>
                               <?php } else { ?>
                                <option value="admin" <?= ($_SESSION['yetkisi'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="editor" <?= ($_SESSION['yetkisi'] == 'editor') ? 'selected' : '' ?>>Editör</option>
                                <option value="yazar" <?= ($_SESSION['yetkisi'] == 'yazar') ? 'selected' : '' ?>>Yazar</option>
                                <?php  } ?>
                            </select>
                            
                        </div>
                        <div>
                            <label for="userStatus">Hesap Durumu</label>
                            <select id="userStatus" name="userStatus" class="form-select">
                            <?php if($_SESSION['yetkisi'] == 'founder') {
                                   ?> <option value="aktif">Aktif</option>
                               <?php } else { ?>
                                <option value="aktif" <?= ($_SESSION['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="deaktif" <?= ($_SESSION['status'] == 'deaktif') ? 'selected' : '' ?>>Deaktif</option>
                                <option value="banned" <?= ($_SESSION['status'] == 'banned') ? 'selected' : '' ?>>Banned</option>
                                <?php  } ?>
                            </select>
                        </div>
                        <button name="changeStatus" type="submit" class="btn btn-primary !mt-6">Değiştir</button>

                    </form>
                <?php endif; ?>
        </div>


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