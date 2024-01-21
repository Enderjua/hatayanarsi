# UYARI - WARNING

Bu proje tamamlanmamıştır. Son güncelleme 20 ocak 2024 tarihi olmakla birlikte, tamamlanmayı amaçlayan, hayata geçirilmesi **planlanmayan**, forklanıp toplulukla geliştirilmeye açık özgür yazılım projesidir. Bu özgür yazılım projesi, dilenirse farklı bir amaç uğruna blog olarak kullanılabilir, dilenirse isminden bağımsız ve farklı biçimde aynı amaçla kullanılabilir. Her geçen güncelleme vakti burada paylaşılacaktır. Lütfen topluluk geliştirilmesi başlanırsa bize ulaşın.
enderjua@gmail.com
<br>
&
<br>
This project is incomplete. The last update was on January 20, 2024. It is an open-source software project aimed at completion, **with no plans for implementation.** It is designed to be forked and developed by the community. This free software project can be used as a blog for a different purpose if desired or used for the same purpose independently of its name. Updates will be shared here with each passing update. Please reach out to us if community development is initiated at enderjua@gmail.com

# KULLANILAN TEKNOLOJİLER - USED ​​TECHNOLOGIES
![HTML](https://img.shields.io/badge/-HTML-333333?style=flat&logo=HTML5)
![CSS](https://img.shields.io/badge/-CSS-333333?style=flat&logo=CSS3&logoColor=1572B6)
![JavaScript](https://img.shields.io/badge/-JavaScript-333333?style=flat&logo=javascript)
![PHP](https://img.shields.io/badge/-PHP-333333?style=flat&logo=php)
<br>
![MySQL](https://img.shields.io/badge/-MySQL-333333?style=flat&logo=mysql)
<br>
![GitHub](https://img.shields.io/badge/-GitHub-333333?style=flat&logo=github)

# DEMO VİDEOSU

[![Video](https://raw.githubusercontent.com/Enderjua/hatayanarsi/main/hatayanarsi.mp4)](https://raw.githubusercontent.com/Enderjua/hatayanarsi/main/hatayanarsi.mp4)

# PROJEDEKİ EKSİKLER - MISSING COMPONENTS IN THE PROJECT

Ana Proje | [Eklendi](https://github.com/gethugothemes/bookworm-light)  | [Eklenecek](https://gethugothemes.com/products/bookworm/?ref=github) |
:------------ |    :----:    |     :----:    |
Blog Paylaşımı ve Bu Yolda Gereken PHP kontrolleri, SQL izinleri                   | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Blog Paylaşımlarını Denetleme, Düzenleme           | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Yetkiye Göre, Yazarın Blogları ve Tüm Yöneticilere Blog Gösterimi                 | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Yetkili Profili Düzenleme           | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Yetkili Profiline Göre Arayüz Ekranı              | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Bloglara Yorum Ekleme                        | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Bloglarla İlgili Detayları Depolama    | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Kitap Bağışı için Kullanıcı Formu                        | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Kitap Bağışı İsteklerini Görüntüleme, Düzenleme ve Kullanıcılara Sunma                   | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Blogları, Alanlarına Göre Ayırma                | ![](https://demo.gethugothemes.com/icons/tick.png) | ![](https://demo.gethugothemes.com/icons/tick.png)                |
Üyelik Sistemi                      | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png)    |
Üyelik Sistemine Göre Yorumları Ayarlama    | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png)    |
Üyelerin, Yetkili Olmak için İstek Gönderebilmeleri                    | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png)    |
Üyelerin, Ücretsiz Kitap Satın Alabilmeleri                    | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png)    |
Üyelerin, Reklamsız Bir Website için Premium Ayrıcalıkları                                       | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png) |
Üyelerin, Sistemdeki Diğer Yardımlaşma ve Dayanışma Olanaklarından Yararlanmaları                                        | ![](https://demo.gethugothemes.com/icons/x.png)    | ![](https://demo.gethugothemes.com/icons/tick.png) |


# CİHAZA KURULUM - LOCAL DEVELOPMENT

```bash
# clone the repository
git clone https://github.com/Enderjua/hatayanarsi.git

# cd in the project directory
$ cd hatayanarsi

# start xampp
# create a mysql, name = hatayanarsi, password = ''
# look hatayanarsi/sql dict. have hatayanarsi.sql
# import hatayanarsi.sql on hatayanarsi
# done.
```

# BAZI KODLAR VE ANLAMLARI - FEATURES

```php
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

// Burada, veritabanında adminin onayladığı verileri çekip books değişkenine atıyoruz. daha sonrasında booksların içerisindeki tüm satırları tek tek alabileceğiz.

?>
```

!!important!!
admin panel-> esinjua@gmail.com & esin123

# PROJEDEKİ BAZI GÜZELLİKLER.

- [Bootstrap](https://getbootstrap.com)
- [Jquery](https://jquery.com)
- [FuseJs](https://fusejs.io)
- [Line awesome](https://icons8.com/line-awesome)
- [Google Fonts](https://fonts.google.com/)
