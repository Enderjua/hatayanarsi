<?php
session_start();

$username = $_SESSION['username'] ?? '';

if (empty($username)) {
    header("Location: index.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $password = $_POST['password'];
    $pp = $_POST['pp'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $website = $_POST['website'];
    $sosyalMedya = $_POST['sosyalMedya'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password=?, pp=?, email=?, bio=?, website=?, sosyalMedya=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $hashed_password, $pp, $email, $bio, $website, $sosyalMedya, $username);

    if ($stmt->execute()) {
        $successMsg = "Bilgiler başarıyla güncellendi!";
    } else {
        $errorMsg = "Bir hata oluştu. Lütfen tekrar deneyin.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['refresh_token'])) {
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

    $newToken = generateToken();

    $sql = "UPDATE users SET resetToken=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newToken, $username);

    if ($stmt->execute()) {
        $successMsg = "Token başarıyla yenilendi!";
    } else {
        $errorMsg = "Token yenilenirken bir hata oluştu. Lütfen tekrar deneyin.";
    }
}

// Kullanıcının mevcut bilgilerini alalım
$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Hatayanarşi</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="icon" type="image/x-icon" href="/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel='stylesheet' type='text/css' media='screen' href='/assets/css/perfect-scrollbar.min.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/assets/css/style.css'>
    <link defer rel='stylesheet' type='text/css' media='screen' href='/assets/css/animate.css'>
    <script src="/assets/js/perfect-scrollbar.min.js"></script>
    <script defer src="/assets/js/popper.min.js"></script>
    <script defer src="/assets/js/tippy-bundle.umd.min.js"></script>
    <script defer src="/assets/js/sweetalert.min.js"></script>
</head>

<body>
    <div class="flex justify-center items-center min-h-screen bg-[url('/assets/images/map.svg')] dark:bg-[url('/assets/images/map-dark.svg')] bg-cover bg-center">
        <div class="panel sm:w-[480px] m-6 max-w-lg w-full">
            <div class="flex items-center mb-10">
                <div class="ltr:mr-4 rtl:ml-4">
                    <img src="<?= $userData['pp'] ?>" class="w-16 h-16 object-cover rounded-full" alt="User Profile Image" />
                </div>
                <div class="flex-1">
                    <h4 class="text-2xl">Kullanıcı Paneli</h4>
                    <p>Bilgilerinizi güncelleyin</p>
                </div>
            </div>
            <form class="space-y-5" method="post">
                <div>
                    <label for="password">Şifre:</label>
                    <input type="password" id="password" name="password" class="form-input" value="<?= $userData['password'] ?>" required>
                </div>
                <div>
                    <label for="pp">Profil Resmi:</label>
                    <input type="text" id="pp" name="pp" class="form-input" value="<?= $userData['pp'] ?>" required>
                </div>
                <div>
                    <label for="sosyalMedya">Email</label>
                    <input type="text" id="email" name="email" class="form-input" value="<?= $userData['email'] ?>">
                </div>
                <div>
                    <label for="sosyalMedya">Biyografi</label>
                    <input type="text" id="bio" name="bio" class="form-input" value="<?= $userData['bio'] ?>">
                </div>
                <div>
                    <label for="sosyalMedya">Website</label>
                    <input type="text" id="website" name="website" class="form-input" value="<?= $userData['website'] ?>">
                </div>

                <div>
                    <label for="sosyalMedya">Sosyal Medya (Her sosyal medya için araya , koyun):</label>
                    <input type="text" id="sosyalMedya" name="sosyalMedya" class="form-input" value="<?= $userData['sosyalMedya'] ?>">
                </div>

                <button type="submit" name="refresh_token" class="btn btn-secondary mt-2">Tokeni Yenile</button>


                <button type="submit" name="update" class="btn btn-primary w-full">Güncelle</button>
                <div class="mt-4 text-center">
                    <a href="index.php" class="text-blue-500 hover:underline">Geri Dön</a>
                </div>

            </form>

            <div class="mt-4 text-center">
                <strong>Mevcut Token:</strong> <?= $userData['resetToken'] ?><br>
            </div>

            <?php if ($errorMsg) : ?>
                <p class="mt-4 text-red-500"><?= $errorMsg ?></p>
            <?php endif; ?>

            <?php if ($successMsg) : ?>
                <p class="mt-4 text-green-500"><?= $successMsg ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer-main-auth.php'; ?>
</body>

</html>