<?php

if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: index.php");
    exit; // Bu komutla scriptin geri kalanını çalıştırmayı durdurun.
}


?>

<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {


    $conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $token = $_POST["token"];

    if ($new_password !== $confirm_password) {
        $errorMsg = "Şifreler aynı değil!";
        echo $errorMsg;
        exit;
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

    $newToken = generateToken();

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=?, resetToken='$newToken' WHERE resetToken=?");
    $stmt->bind_param("ss", $hashed_password, $token);
    $result = $stmt->execute();

    if ($result) {
        $successMsg = "Başarıyla şifre güncellendi!";
    } else {
        $errorMsg = "Şifre güncellenemedi!";
    }

    $conn->close();
}
?>


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

<div class="flex justify-center items-center min-h-screen bg-[url('/assets/images/map.svg')] dark:bg-[url('/assets/images/map-dark.svg')] bg-cover bg-center">
    <div class="panel sm:w-[480px] m-6 max-w-lg w-full">
        <div class="flex items-center mb-10">
            <div class="ltr:mr-4 rtl:ml-4">
                <img src="/assets/images/user-profile.jpeg" class="w-16 h-16 object-cover rounded-full" alt="images" />
            </div>
            <div class="flex-1">
                <h4 class="text-2xl">Yeni Şifre Belirleme</h4>
                <p>Yeni şifrenizi girin:</p>
            </div>
        </div>
        <form class="space-y-5" method="post">
            <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
            <div>
                <label for="new_password">Yeni Şifre</label>
                <input id="new_password" name="new_password" type="password" class="form-input" placeholder="Enter New Password" required />
            </div>
            <div>
                <label for="confirm_password">Şifre Doğrulama</label>
                <input id="confirm_password" name="confirm_password" type="password" class="form-input" placeholder="Confirm New Password" required />
            </div>
            <button type="submit" name="change_password" class="btn btn-primary w-full">Şifreyi Değiştir</button>
            <div class="mt-4 text-center">
                <a href="index.php" class="text-blue-500 hover:underline">Giriş yap</a>
            </div>

        </form>
        <?php if ($errorMsg) : ?>
            <p class="mt-4 text-red-500"><?= $errorMsg ?></p>
        <?php endif; ?>
        <?php if ($successMsg) : ?>
            <p class="mt-4 text-green-500"><?= $successMsg ?></p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer-main-auth.php'; ?>