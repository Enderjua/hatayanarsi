<?php 


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <title>ADMİN - created by marijua</title>
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <link rel="icon" type="image/x-icon" href="/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel='stylesheet' type='text/css' media='screen' href='/assets/css/perfect-scrollbar.min.css' />
    <link rel='stylesheet' type='text/css' media='screen' href='/assets/css/style.css' />
    <link defer rel='stylesheet' type='text/css' media='screen' href='/assets/css/animate.css' />
    <script src="/assets/js/perfect-scrollbar.min.js"></script>
    <script defer src="/assets/js/popper.min.js"></script>
    <script defer src="/assets/js/tippy-bundle.umd.min.js"></script>
    <script defer src="/assets/js/etiket.js"></script>
    <script defer src="/assets/js/sweetalert.min.js"></script>
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <script src="/assets/js/layout.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/etiket.css" rel="stylesheet" type="text/css" />

</head>
<style>
    body {
    background-color: #060818;
    color: #adb5bd;
    font-family: 'Arial', sans-serif;
}

.row {
    display: flex;
    flex-wrap: nowrap;
    margin-left: -15px;
    margin-right: -15px;
    overflow-x: auto;
}

.col-md-6, .col-xl-3 {
    flex: 0 0 auto;
    position: relative;
    width: 25%;
    padding-left: 15px;
    padding-right: 15px;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #0d1b2a;
    border: 1px solid #1b263b;
    border-radius: .25rem;
    margin-bottom: 20px;
}

.card-body {
    flex: 1 1 auto;
    padding: 1.25rem;
}

.text-uppercase {
    text-transform: uppercase;
}

.fw-medium {
    font-weight: 500;
}

.text-muted {
    color: #6c757d;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.fs-14 {
    font-size: 14px;
}

.fs-22 {
    font-size: 22px;
}

.text-success {
    color: #2ecc71;
}

.text-danger {
    color: #e74c3c;
}

.text-info {
    color: #3498db;
}

.text-warning {
    color: #f39c12;
}

.text-primary {
    color: #2980b9;
}

.avatar-sm {
    width: 50px;
    height: 50px;
}

.avatar-title {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

.bg-success-subtle {
    background-color: #2a9055;
}

.bg-info-subtle {
    background-color: #2a6a90;
}

.bg-warning-subtle {
    background-color: #905c2a;
}

.bg-primary-subtle {
    background-color: #2a4a90;
}

.text-decoration-underline {
    text-decoration: underline;
    color: #7a869a;
}

.text-decoration-underline:hover {
    color: #adb5bd;
}

</style>


<body x-data="main" class="antialiased relative font-nunito text-sm font-normal overflow-x-hidden dark vertical full ltr" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme, $store.app.menu, $store.app.layout,$store.app.rtlClass]">

    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 bg-[black]/60 z-50 lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>

    <!-- screen loader -->
    <div class="screen_loader fixed inset-0 bg-[#fafafa] dark:bg-[#060818] z-[60] grid place-content-center animate__animated">
        <svg width="64" height="64" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
            <path d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
                <animate Transform attributeName="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s" repeatCount="indefinite" />
            </path>
            <path d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
                <animate Transform attributeName="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s" repeatCount="indefinite" />
            </path>
        </svg>
    </div>

    <div class="fixed bottom-6 ltr:right-6 rtl:left-6 z-50" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button" class="btn btn-outline-primary rounded-full p-2 animate-pulse bg-[#fafafa] dark:bg-[#060818] dark:hover:bg-primary" @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z" fill="currentColor" />
                    <path d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z" fill="currentColor" />
                </svg>
            </button>
        </template>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("scrollToTop", () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));
        });
    </script>


    <div class="main-container text-black dark:text-white-dark min-h-screen" :class="[$store.app.navbar]">

        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <?php include 'header.php'; ?>
            <div class="p-6 animate__animated" :class="[$store.app.animation]">
