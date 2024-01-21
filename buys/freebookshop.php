<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$successmessage = false;
$errormessages = false;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hatayanarsi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Kitap verilerini çek
$stmt = $pdo->query("SELECT kitapAd, yayin, baskiNo, baskiYil, alimFiyati, yazar, fotograf FROM kitapbagis WHERE onayDurumu = 'Onaylandı'");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include('../includes/blogHead.php'); ?>

<body class='v1-8 homepage_view multiple_view dark rounded'>
    <style>
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-item {
            flex-basis: calc(20% - 20px);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .product-item:hover {
            transform: scale(1.05);
        }

        .product-box-border {
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .product-image-wrapper img {
            width: 100%;
            border-radius: 8px 8px 0 0;
        }

        .product-details {
            padding: 15px;
        }

        .product-rating {
            color: #f8d500;
        }

        .product-rating i {
            margin-right: 5px;
        }

        .product-title {
            text-decoration: none;
            color: #343a40;
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .product-author {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .product-format {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .product-price {
            margin-top: 10px;
        }

        .discounted-price {
            color: #dc3545;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .product-discount {
            font-size: 0.8rem;
            background-color: #dc3545;
            color: #fff;
            padding: 3px 5px;
            border-radius: 3px;
            margin-left: 5px;
        }

        .current-price {
            color: #28a745;
            font-size: 1rem;
            font-weight: bold;
        }

        .add-to-cart-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 15px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-to-cart-button:hover {
            background-color: #0056b3;
        }
    </style>

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
        <?php foreach ($books as $book) : ?>
            <div class="product-item zoom ease">
                <div class="product-box-border">
                    <a href="#" class="product-image-wrapper">
                        <img src="<?php echo "https://localhost/hatay/bagislar/".$book['fotograf']; ?>" alt="<?php echo $book['kitapAd']; ?>">
                    </a>
                    <div class="product-details">
                        <div class="product-rating">
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <i class="star-icon"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="product-info">
                            <a style="color: #f8f9fa;" href="#" class="product-title"><?php echo $book['kitapAd']; ?></a>
                            <div class="product-author"><?php echo $book['yazar']; ?></div>
                            <div class="product-format"><?php echo $book['baskiNo']." No"; echo "<br>"; echo $book['baskiYil']." Yılı"; ?></div>
                        </div>
                        <div class="product-price">
                            <div class="current-price"><?php echo number_format($book['alimFiyati'], 2); ?> TL</div>
                        </div><br>
                        <button class="add-to-cart-button">Sepete Ekle</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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