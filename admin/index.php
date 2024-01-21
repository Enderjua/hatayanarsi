<?php
session_start();

if($_SESSION['username']) {
    header('Location: home.php');
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorMsg = "";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    // Database bağlantınızı burada tanımlayın
    $conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit;
        } else {
            $errorMsg = "Kullanıcı bilgileri yanlış. Lütfen tekrar deneyin.";
        }
    } else {
        $errorMsg = "Kullanıcı bilgileri yanlış. Lütfen tekrar deneyin.";
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
                <h4 class="text-2xl">Hello, Admin!</h4>
                <p>Enter your credentials to login to your ADMIN PAGE</p>
            </div>
        </div>
        <form class="space-y-5" method="post">
            <div>
                <label for="username">Username</label>
                <input id="username" name="username" type="text" class="form-input" placeholder="Enter Username" required />
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-input" placeholder="Enter Password" required />
            </div>
            <button type="submit" name="login" class="btn btn-primary w-full">LOGIN</button>
            <div class="mt-4 text-center">
                <a href="unuttum.php" class="text-blue-500 hover:underline">Şifremi Unuttum</a>
            </div>
        </form>
        <?php if ($errorMsg) : ?>
            <p class="mt-4 text-red-500"><?= $errorMsg ?></p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer-main-auth.php'; ?>