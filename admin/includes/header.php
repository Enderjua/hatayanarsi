<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı adını SESSION'dan alıyoruz
$username = $_SESSION['username'] ?? '';

if(empty($username)){
    die("Kullanıcı adı bulunamadı.");
}

// Veritabanı bağlantısı
$conn = new mysqli('localhost', 'root', '', 'hatayanarsi');

// Hata kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL sorgusu
$sql = "SELECT pp, yetkisi, email FROM users WHERE username=?";
$stmt = $conn->prepare($sql);

if(!$stmt) {
    die("SQL sorgusunda bir hata oluştu: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$pp = $userData['pp'];
$yetki = $userData['yetkisi'];
$email = $userData['email'];

$stmt->close();
$conn->close();
?>


<header :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
    <div class="shadow-sm">
        <div class="relative bg-white flex w-full items-center px-5 py-2.5 dark:bg-[#0e1726]">
            <div class="horizontal-logo flex lg:hidden justify-between items-center ltr:mr-2 rtl:ml-2">
                <a href="/" class="main-logo flex items-center shrink-0">
                    <img class="w-8 ltr:-ml-1 rtl:-mr-1 inline" src="/assets/images/logo.svg" alt="image" />
                    <span class="text-2xl ltr:ml-1.5 rtl:mr-1.5  font-semibold  align-middle hidden md:inline dark:text-white-light transition-all duration-300">HATAY</span>
                </a>

                <a href="javascript:;" class="collapse-icon flex-none dark:text-[#d0d2d6] hover:text-primary dark:hover:text-primary flex lg:hidden ltr:ml-2 rtl:mr-2 p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:bg-white-light/90 dark:hover:bg-dark/60" @click="$store.app.toggleSidebar()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
            <div x-data="header" class="sm:flex-1 ltr:sm:ml-0 ltr:ml-auto sm:rtl:mr-0 rtl:mr-auto flex items-center space-x-1.5 lg:space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
                    <button type="button" class="search_btn sm:hidden p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:bg-white-light/90 dark:hover:bg-dark/60" @click="search = ! search">
                        <svg class="w-4.5 h-4.5 mx-auto dark:text-[#d0d2d6]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                    <a href="javascript:;" class="relative group" @click="toggle()">
                        <span><img class="w-9 h-9 rounded-full object-cover saturate-50 group-hover:saturate-100" src="<?= $pp ?>" alt="image" /></span>
                    </a>
                    <ul x-cloak x-show="open" x-transition x-transition.duration.300ms class="ltr:right-0 rtl:left-0 text-dark dark:text-white-dark top-11 !py-0 w-[230px] font-semibold dark:text-white-light/90">
                        <li>
                            <div class="flex items-center px-4 py-4">
                                <div class="flex-none">
                                    <img class="rounded-md w-10 h-10 object-cover" src="<?= $pp ?>" alt="image" />
                                </div>
                                <div class="ltr:pl-4 rtl:pr-4">
                                    <h4 class="text-base"><?php echo $username; ?><span class="badge text-xs badge-outline-danger rounded-none px-1 ltr:ml-2 rtl:ml-2"><?php echo $yetki; ?></span></h4>
                                    <a class="text-black/60  hover:text-primary dark:text-dark-light/60 dark:hover:text-white" href="javascript:;"><?php echo $email; ?></a>
                                </div>
                            </div>
                        </li>
                        <li>
    <a href="kullanici.php" class="!py-3" @click="toggle">
        <svg class="w-4.5 h-4.5 ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Burada istediğiniz bir ikon kullanabilirsiniz -->
        </svg>
        Kullanıcı Paneli
    </a>
</li>
<li class="border-t border-white-light dark:border-white-light/10">
    <a href="logout.php" class=" text-danger !py-3" @click="toggle">
        <!-- Mevcut Sign Out ikonu ve metni -->
        Sign Out
    </a>
</li>

                    </ul>
                </div>
            </div>
        </div>

