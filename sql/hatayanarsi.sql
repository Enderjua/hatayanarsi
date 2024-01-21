-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 22 Oca 2024, 00:08:07
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hatayanarsi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `kapakFoto` varchar(255) NOT NULL,
  `mekanEtiketler` text DEFAULT NULL,
  `blogBaslik` varchar(255) NOT NULL,
  `blogAciklama1` text NOT NULL,
  `blogAciklamaTuru1` enum('Hiçbiri','Renkli','Resimli','Tablolu') NOT NULL,
  `aciklama1Renk` enum('kirmizi','yesil','gri') DEFAULT NULL,
  `aciklama1ResimKonumu` enum('sol','alt') DEFAULT NULL,
  `aciklama1Resim` varchar(255) DEFAULT NULL,
  `blogAciklama2` text NOT NULL,
  `blogAciklamaTuru2` enum('Hiçbiri','Renkli','Resimli','Tablolu') NOT NULL,
  `aciklama2Renk` enum('kirmizi','yesil','gri') DEFAULT NULL,
  `aciklama2ResimKonumu` enum('sol','alt') DEFAULT NULL,
  `aciklama2Resim` varchar(255) DEFAULT NULL,
  `resimOlsunMu` enum('Hayır','Evet') NOT NULL,
  `ekstraResim` varchar(255) DEFAULT NULL,
  `gununSozu` varchar(255) NOT NULL,
  `gununSozuYazari` varchar(255) NOT NULL,
  `blogYazarDusuncesi` text NOT NULL,
  `blogDurumu` varchar(255) NOT NULL,
  `blogTarihi` varchar(255) NOT NULL,
  `blogYorumSayisi` int(11) NOT NULL,
  `blogGorunmeSayisi` int(11) NOT NULL,
  `blogYazari` varchar(255) NOT NULL,
  `dataId` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `blog`
--

INSERT INTO `blog` (`id`, `kapakFoto`, `mekanEtiketler`, `blogBaslik`, `blogAciklama1`, `blogAciklamaTuru1`, `aciklama1Renk`, `aciklama1ResimKonumu`, `aciklama1Resim`, `blogAciklama2`, `blogAciklamaTuru2`, `aciklama2Renk`, `aciklama2ResimKonumu`, `aciklama2Resim`, `resimOlsunMu`, `ekstraResim`, `gununSozu`, `gununSozuYazari`, `blogYazarDusuncesi`, `blogDurumu`, `blogTarihi`, `blogYorumSayisi`, `blogGorunmeSayisi`, `blogYazari`, `dataId`) VALUES
(1, 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/65055f72c4f9d.jpeg', 'Eylem, Hatay İçi', 'Dikmece Köyü\'nde Yaşananlar: Unutulmaya Yüz Tutmuş Bir Hikaye', ' Dikmece Köyü, Hatay\'ın sakin ve huzurlu köylerinden biriydi. Yemyeşil doğası, temiz havası ve sıcak insanlarıyla bilinirdi. Ancak son yıllarda köylüler, yaşadıkları topraklardan haksız yere sürülmeleriyle ilgili birçok zorlukla karşı karşıya kaldılar. Birkaç yıl önce, köyün kıyısında büyük bir maden rezervi keşfedildi. Bu keşif, köy için büyük bir ekonomik fırsat olarak görüldü. Ancak bu durum, köy halkının yerleşim yerlerinden zorla taşınmalarına neden oldu. Madenin işletilmesi için gerekli olan altyapı çalışmaları, köylülerin evlerinin yıkılmasına ve tarlalarının elinden alınmasına yol açtı. Köylüler, bu duruma karşı çıkarak topraklarından ayrılmayı reddettiler. Ancak devlet, TSK ve Emniyet güçleri, köyü boşaltma kararını uygulamaya koydu. Köylülerin anlattığına göre bu süreçte birçok haksızlık ve zulme maruz kaldılar. Evlerinin yıkılmasına, tarlalarının elinden alınmasına ve hatta bazı köylülerin gözaltına alınmasına tanık oldular. ', 'Renkli', 'kirmizi', NULL, NULL, 'Dikmece Köylüsü Ahmet Bey, \"Burası benim doğduğum, büyüdüğüm yer. Atalarımızdan kalan bu toprakları, maden için bize zorla kaptırmamızı beklemiyorlardı herhalde,\" diyor. Dikmece halkı, yaşadıkları bu haksızlık karşısında seslerini duyurabilmek için birçok eylem ve protesto düzenledi. Ancak bu eylemler, güvenlik güçleri tarafından sert bir şekilde bastırıldı. Hatay\'da yaşanan bu olaylar, ülkenin dört bir yanında büyük tepkilere neden oldu. Dikmece halkının yaşadığı zorluklar, birçok sivil toplum örgütü, gazeteci ve aktivistin gündemine taşındı. Sonuç olarak, Dikmece Köyü\'nde yaşananlar, topraklarından haksız yere sürülen insanların yaşadığı acıları ve zorlukları bir kez daha gözler önüne serdi. Bu olaylar, halkın doğal hakları ve devletin bu haklara saygı gösterip göstermediği konusundaki tartışmaları da beraberinde getirdi.', 'Renkli', 'yesil', NULL, NULL, 'Hayır', NULL, 'Dünyayı yaşanmaz kılan tüm saçmalıkların kaynağı olan Tanrı’ya inanç, dokunulmamış olarak kaldığı sürece, budanmış gövdeden yeni sürgünler fışkırmaya devam edecektir', 'Mihail Bakunin', 'Çok Yaşa Anarşist Topluluk!', 'Yayında', '2023-09-16', 2, 15, 'Marijua', '1'),
(2, 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/65ad98457c7a5.png', 'Bilgilendirme, Hatay İçi Haberler', 'Anarşi Kavramı ', ' Bütün toplumsal ve psişik özgürleşmelerin ortak noktası, insanı birey ya da topluluk halinde tabi kılıp yönetilebilir bir varlığa indirgeyen toplumsal ilişkilerden çıkış ya da insanın kendini yönetilemez bir varlık olarak inşa edilmesidir.\r\n\r\nTabi olmayan ve tabi kılmak üzere güç uygulamayacak özerk bireylerin ortaklaşabildiği ve topluluk kurabildiği, bu türden bir topluluk pratiği köken olarak uygarlık öncesi durumdan itibaren var olmuş ve bastırılmış biçimde bütün kültürlerin içinde yaşamaya devam etmektedir. Farklı kültürlerin bilgelikleri ya da felsefelerinde farklı adlar veya düşünce gelenekleri altında ifade bulan, ortak özellikler gösteren yaygın bilgelik/etik olarak mevcuttur. Bu ortak eğilimi evrensel bir amblem altında toplamayı seçebilir ya da farklı şekillerde ifade edebiliriz. Batı kültürel sahasında, antik Yunan\'a göndermeyle, yöneten bir ayrıcalıklı grubun, oligarşinin, egemenin, tiranın, monarkın, sınıfın, devletin bürokrasinin olmadığı bir durumun ifadesi olarak, kelimesi kelimesine yönetilcilerin olmaması anlamına gelen \"an-arkhos\" [arkhon: oligarşik yönetici] kelimesinin özü, anlamı budur.\r\n\r\nOn dokuzuncu yüzyıla kadar, anarhos\'tan türeyen anarşi terimi, Batı dillerinde uzun bir tarih boyunca aşağılayıcı bir terim olarak ve bir siyasal krizi ifade etmek için kullanıldı. Başsızlık, kargaşa, düzensizlik, yönetim boşluğu, savaş durumu. Ta ki 1840\'ta Mülkiyet nedir? kitabında \"anarşi\" kavramını tarihte ilk kez olumlu bir siyasal yönelimi ifade etmek için tarif eden ve benimseyen Pierre Joseph Proudhon\'a kadar. Anarşi, ya da yöneticilerin olmadığı, üyelerinin hep birlikte kendi kendilerini yönettiği özgür insanların oluşturduğu topluluk fikri, bütün toplumsal özgürlük düşüncelerinin varacağı nihai son sınırı oluşturur. Yanlış anlaşılmasın, özgürlüğün son sınırı değil, özgürlüğün gerçekleşmesinin olanaklılık koşulu olarak tahakküm ve hiyerarşinin olmadığı, kendi kendini yönetebilen toplulukların başlangıcı anlamında son sınır. ', 'Renkli', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/65ad984580970.', ' 19. yüzyılda doğmuş bütün sosyalizm akımlarının ve günümüzdeki \"demokratik sosyalizm ya da \"özerklikçi komünizm\" modellerinin eninde sonunda çözmeye çalıştığı problem anarşiye / doğrudan demokrasiye nasıl varılacağı sorunudur. Bütün devrimci özgürlükçü düşüncelerin, siyasal düşüncelerin ve etik/yaşam felsefelerinin ne kadar özgürlükçü olduğunun kendisine göre sınanacağı/sınandığı kavramsal sınırı oluşturur anarşi. Anarşi kavramı, bir ideoloji tarif etmenin başlama noktası değil, eşitlikçi ve özgürlükçü devrimci teorilerin zorunlu mantıksal doğrultusudur. Bazen açık bazen örtük olarak bütün devrimci ve toplumsal dönüşüm temelli öğretiler bu düşünme biçiminde potansiyel olarak bulunan metodolojileri doğrudan ya da dolaylı olarak benimser. Anarşi, tüm özgürleşme düşüncelerinin ve pratiklerinin içsel mekanizmalarını yöneten eğilimdir. Siyaset içi ve aynı zamanda siyaset üstüdür. Anarşi, tahakkümün sonlanması ve topluluğun kendisini yönetmesi durumudur. İnsan özgürleşmesinin asimptotik üst sınırıdır. ', 'Renkli', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/65ad984580985.', 'Hayır', NULL, 'Kadın hakları arkadaşı incitmiş. Lakin ne rica ettiği Erdoğan\'ın ne de başka birisinin gücü kadın haklarını kaldırmaya yeter. O devir geçti. Kadınlar sizi çiğner geçer.', 'Kürşad Kızıltuğ', 'değiştirildi.', 'Yayında', '2023-09-16', 1, 4, 'Marijua', '2'),
(3, 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/6505bca94f2bf.jpg', 'Bilgilendirme', 'Evrim, Devrim ve Anarşist İdeal 1', ' Evrim insana dair her şeyi kapsar. Devrim de her şeyi kapsamalıdır. Ne var ki bu koşutluk toplumların hayatındaki tek tek olaylarda her zaman belirgin değildir. Tüm ilerlemeler birbirine bağlıdır, bilgimiz ve gücümüz oranında toplumsal ve siyasi, ahlaki ve maddi, bilimsel, sanatsal, endüstriyel tüm alanlarda ilerlemeyi arzularız. Her alanda, sadece evrimci değil, bir o kadar da devrimciyiz çünkü tarihin, bir dizi hazırlığı izleyen bir dizi başarıdan başka bir şey olmadığını biliyoruz. Zihinleri özgürleştiren büyük entelektüel evrimin mantıki sonucu, bireylerin başka bireylerle ilişkilerinde özgürleşmesidir.\r\n\r\nEvrimin ve devrimin aynı olgunun birbirini takip eden iki yönü olduğunu söyleyebiliriz. Evrim devrimden önce gelir ve devrim de, gelecek devrimlerin anası olacak olan yeni bir evrime giden yolu hazırlar. Herhangi bir dönüşüm, hayat değişmeden gerçekleşebilir mi? Bir edimin o edimi yapma arzusundan sonra gerçekleşmesi gibi, devrim de kaçınılmaz olarak evrimi takip etmek zorunda değil midir? Bu ikisi ancak ortaya çıkış zamanlarıyla birbirinden ayırt edilir. Bir tortu nehri tıkadığında, sular engelin önünde yavaş yavaş birikir ve tedrici bir evrimin sonunda bir göl şekillenir. Sonra, aniden akış yönündeki sette bir sızıntı meydana gelir, bir çakıl taşının düşüşü bir su taşmasını tetikler. Baraj bir anda sarsılarak çöker, boşalan göl tekrar nehir olur. Böylece küçük bir karasal devrim meydana gelir. ', 'Renkli', 'gri', NULL, NULL, ' Eğer devrim hep evrimden sonra geliyorsa bu, çevrenin direncinden kaynaklanmaktadır: Akıntının suyu iki yakanın arasından gürülder çünkü kıyı onu yavaşlatmaktadır, gökyüzünde şimşekler çakar çünkü atmosfer buluttaki elektriğe direnç gösterir. Çevrenin hareketsizliği, maddenin her dönüşümünü ve düşüncenin her gerçekleşmesini, değişim sırasında engeller. Yeni olgu, direnç ne kadar büyükse o kadar büyük bir zorlukla ya da daha büyük bir güçle ortaya çıkar. Herder, Fransız İhtilali’nden bahsederken bu konuya değinmiştir. “Tohum toprağa düşer ve uzun zaman ölü görünür, sonra aniden filizlenir, üstünü örten sert toprağı iter, düşmanı olan kil tabakasını deşer, böylece bitki olur, çiçek verir ve meyvesi olgunlaşır.” Bir de çocuğun nasıl doğduğunu düşünün. Anne rahminin karanlığında dokuz ay geçirdikten sonra, o da zarfını delerek şiddetle, bazen annesini bile öldürerek ileri fırlar. Devrimler de böyledir önceki evrimlerin zorunlu neticeleridir.\r\n\r\nAncak, evrimler her zaman adaletli olmadığı gibi devrimler de her zaman ilerleme değildir. Her şey değişir, doğadaki her şey ebedi bir devinimin parçası olarak hareket eder. Ama ilerlemenin olduğu yerde gerileme de olabilir ve eğer bazı evrimler hayatın çoğalması yönünde ilerliyorsa, başkaları da ölüme doğru yönelir. Durmak imkânsızdır, bir yöne ya da ötekine doğru hareket etmek gerekir. Hastalık, yaşlılık, kangren tıpkı ergenlik gibi birer evrimdir. Kurtçukların cesede üşüşmesi, bebeğin ilk çığlığı gibi bir devrimin gerçekleştiğinin göstergesidir. Fizyoloji ve tarih bize bazı evrimlerin gerilemeye işaret ettiğini, bazı devrimlerin ise ölümü içerdiğini gösterir. ', 'Hiçbiri', NULL, NULL, NULL, 'Hayır', NULL, 'Kederli, güçsüz ve hayata karşı yılgındım. Kader bana gün yüzü göstermemiş, sevdiğim varlıkları benden almış, planlarımı mahvetmiş ve umutlarımı boşa çıkarmıştı.', 'Élisée Reclus', 'Çok Yaşa Anarşist Topluluk!', 'Yayında', '2023-09-16', 0, 4, 'Esinjua', '3'),
(4, 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/6505bcea97c7d.jpg', 'Bilgilendirme', 'Evrim, Devrim ve Anarşist İdeal 2', ' İnsanlık tarihinin pek azını biliyoruz. Tüm bildiklerimiz birkaç bin yıl gibi kısa bir sürede yaşanan olaylar. Yine de bu deneyimler bize, evrimleri yavaş ilerlediği için çöken ve yok olan kabileler ve insanlar, kent ve imparatorluklar hakkında bilgi veriyor. Ülkelerin, ulusların yakalandıkları bu hastalıklar çok katmanlı ve çeşitlidir. Orta Asya’da göllerin ve nehirlerin kuruduğu, verimli arazilerin yerini tuz tortullarının aldığı muazzam genişlikteki topraklarda olduğu gibi, iklim ve toprak bozulmuş olabilir. Düşman orduları bazı bölgeleri o denli harap eder ki buralar sonsuza dek ıssız kalır; ne var ki, fetihler ve kıyımlardan, hatta yüzyıllar süren baskı dönemlerinden sonra bazı uluslar yeniden hayata dönmeyi başarmıştır. Böylece, bir ulus yeniden barbarlaşırsa ya da tümüyle yok olursa, gerilemesinin ve çöküşünün nedenlerini dış etkenlerde değil, topluluğun kendisinde ve esas yapısında aramak gerekir. Gerileme tarihini özetleyen temel bir neden -nedenlerin nedeni- vardır. Bu, toplumun bir kısmının diğerlerinin efendisi olması, birkaç kişinin ya da bir aristokrasinin toprak, sermaye, iktidar, eğitim ve onur tekelini elinde tutmasıdır. Bilinçsiz halk kitleleri bu az sayıda insanın tekeline karşı isyan etme iradesini göstermediği an, ölmüşler demektir; yok oluşları zaman meselesidir. Kara veba yakında bu özgürlüğü olmayan, işe yaramaz bireyler yığınını temizleyecektir. Katliamcılar Doğu’dan ya da Batı’dan koşuşurlar, kocaman kentler yerlerini çöle bırakır. Asur ve Mısır böyle ölmüş, Pers İmparatorluğu böyle yıkılmış ve tüm Roma İmparatorluğu birkaç büyük toprak sahibine ait olduğunda barbarlar köleleşmiş proleterlerin yerini almıştır. ', 'Renkli', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/6552026a9c683.', ' Tarihteki tüm dönemler ve olaylar çift yönlü olduklarından, bunları kategorik olarak yargılamak yanlıştır. Ortaçağı ve düşüncenin karanlık gecesini sona erdiren yenilenişin örneği bize, biri çöküşe diğeri ise ilerlemeye neden olan iki devrimin nasıl aynı anda meydana gelebildiğini gösterir. Antikçağ’ın eserlerini yeniden keşfeden, kitaplarının ve öğretilerinin esrarını çözen, bilimi batıl inançlardan kurtararak insanları nesnel araştırmalara yönelten Rönesans dönemi, bir yandan da özgür kent ve beldeler döneminde tüm ihtişamıyla gelişen spontane sanat hareketinin sona ermesine neden oldu. Aniden taşarak kıyısındaki kırsal kültürleri yok eden bir nehir gibiydi. Her şeye yeniden başlamak zorunda kalındı, en azından özgün olan kadim sanat eserlerinin yerini bayağı taklitleri aldı! ', 'Hiçbiri', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/6552026a9c684.', 'Evet', 'assets/yazilar/bloglar/fotograflar/ekstraResimler/6551d72b24271.jpeg', 'Dağın üzerindeki sayısız taşı harekete geçirmek için bazen bir koyunun küçük bir adımı yeter.', 'Élisée Reclus', 'asas', 'Yayında', '2023-09-16', 1, 23, 'Marijua', '4'),
(11, 'assets/yazilar/bloglar/fotograflar/kapakFotograflari/65ad8fcadf315.png', 'Eylem', 'Hatay Anarşist', '\" 19. yüzyılda doğmuş bütün sosyalizm akımlarının ve günümüzdeki \"demokratik sosyalizm ya da \"özerklikçi komünizm\" modellerinin eninde sonunda çözmeye çalıştığı problem anarşiye / doğrudan demokrasiye nasıl varılacağı sorunudur. Bütün devrimci özgürlükçü düşüncelerin, siyasal düşüncelerin ve etik/yaşam felsefelerinin ne kadar özgürlükçü olduğunun kendisine göre sınanacağı/sınandığı kavramsal sınırı oluşturur anarşi. Anarşi kavramı, bir ideoloji tarif etmenin başlama noktası değil, eşitlikçi ve özgürlükçü devrimci teorilerin zorunlu mantıksal doğrultusudur. Bazen açık bazen örtük olarak bütün devrimci ve toplumsal dönüşüm temelli öğretiler bu düşünme biçiminde potansiyel olarak bulunan metodolojileri doğrudan ya da dolaylı olarak benimser. Anarşi, tüm özgürleşme düşüncelerinin ve pratiklerinin içsel mekanizmalarını yöneten eğilimdir. Siyaset içi ve aynı zamanda siyaset üstüdür. Anarşi, tahakkümün sonlanması ve topluluğun kendisini yönetmesi durumudur. İnsan özgürleşmesinin asimptotik üst sınırıdır. \"', 'Hiçbiri', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/65ad8fcadf38c.', '\" 19. yüzyılda doğmuş bütün sosyalizm akımlarının ve günümüzdeki \"demokratik sosyalizm ya da \"özerklikçi komünizm\" modellerinin eninde sonunda çözmeye çalıştığı problem anarşiye / doğrudan demokrasiye nasıl varılacağı sorunudur. Bütün devrimci özgürlükçü düşüncelerin, siyasal düşüncelerin ve etik/yaşam felsefelerinin ne kadar özgürlükçü olduğunun kendisine göre sınanacağı/sınandığı kavramsal sınırı oluşturur anarşi. Anarşi kavramı, bir ideoloji tarif etmenin başlama noktası değil, eşitlikçi ve özgürlükçü devrimci teorilerin zorunlu mantıksal doğrultusudur. Bazen açık bazen örtük olarak bütün devrimci ve toplumsal dönüşüm temelli öğretiler bu düşünme biçiminde potansiyel olarak bulunan metodolojileri doğrudan ya da dolaylı olarak benimser. Anarşi, tüm özgürleşme düşüncelerinin ve pratiklerinin içsel mekanizmalarını yöneten eğilimdir. Siyaset içi ve aynı zamanda siyaset üstüdür. Anarşi, tahakkümün sonlanması ve topluluğun kendisini yönetmesi durumudur. İnsan özgürleşmesinin asimptotik üst sınırıdır. \"', 'Renkli', 'kirmizi', 'sol', 'assets/yazilar/bloglar/fotograflar/aciklamaResimleri/65ad8fcadf399.', 'Hayır', NULL, 'Esin benim aşkım', 'Enderjua', 'ESİN AŞKIM KARIM', 'Yayında', '2023-11-15', 0, 6, 'Marijua', '5');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitapbagis`
--

CREATE TABLE `kitapbagis` (
  `id` int(11) NOT NULL,
  `kitapAd` varchar(255) NOT NULL,
  `yayin` varchar(255) NOT NULL,
  `baskiNo` int(11) NOT NULL,
  `baskiYil` int(11) NOT NULL,
  `alimFiyati` decimal(10,2) NOT NULL,
  `yazar` varchar(255) NOT NULL,
  `il` varchar(100) NOT NULL,
  `ilce` varchar(100) NOT NULL,
  `iletisimBilgisi` varchar(255) NOT NULL,
  `fotograf` varchar(255) NOT NULL,
  `fotograf2` varchar(255) NOT NULL,
  `onayDurumu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kitapbagis`
--

INSERT INTO `kitapbagis` (`id`, `kitapAd`, `yayin`, `baskiNo`, `baskiYil`, `alimFiyati`, `yazar`, `il`, `ilce`, `iletisimBilgisi`, `fotograf`, `fotograf2`, `onayDurumu`) VALUES
(1, 'deneme kitap', '213213', 12321312, 4213123, '124123.00', 'marijua', 'wqewqe', 'wqewqe', '123124', 'assets/resimler/kitapbagis/ustesinden-gelemedigimiz-seyler-13448713-83-O.jpg', 'assets/resimler/kitapbagis/ustesinden-gelemedigimiz-seyler-13448713-83-O.jpg', 'Onaylandı'),
(2, 'deneme kitap 2', 'marijua', 13, 2024, '50.00', 'marijua', 'hatay', 'antakya', 'hatay', 'assets/resimler/kitapbagis/65ad98895ab4d.png', 'assets/resimler/kitapbagis/65ad98895ab79.png', 'Onaylandı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11)
) ;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `yetkisi`, `pp`, `email`, `olusturulmaTarihi`, `sonGiris`, `bio`, `website`, `sosyalMedya`, `status`, `resetToken`) VALUES
(1, 'Marijua', '$2y$10$FKJvay5AqWPIjIGovrw4IOmvnu7YOPARDFaTzqkrfH9cXyjQItpOa', 'founder', 'https://media-ist1-1.cdn.whatsapp.net/v/t61.24694-24/323107486_223313693597374_1414698253150262915_n.jpg?ccb=11-4&oh=01_AdTsJ5pP5CiUZymqRKbijSl7YsdEmp3zl96UCMKEoE95gw&oe=655D78A1&_nc_sid=e6ed6c&_nc_cat=111', 'marijua@hatayanarsi.org', '2023-09-14 04:49:31', NULL, 'Founder by Mate INC', 'https://www.hatayanarsi.org', 'https://instagram.com/marijuabakunin', 'aktif', 'fl0aR9nr3jwKLCPXiH7K'),
(2, 'Esinjua', '$2y$10$P7pY.I1bpxA6ub/mKHkhse6.kU61hm1jt.HX92S.5P5HpgC.jwopu', 'founder', 'https://media-ist1-1.cdn.whatsapp.net/v/t61.24694-24/414687145_1038535233878174_793660369150696836_n.jpg?ccb=11-4&oh=01_AdSrkgUVrv8GSh9ZD7uPfjeWJPRzlHPRZW-8EzXm3vi9Fg&oe=65BA4DFC&_nc_sid=e6ed6c&_nc_cat=100', 'esinjua@gmail.com', '2023-11-13 09:57:25', NULL, '<#22', 'https://www.hatayanarsi.org', '', 'aktif', 'my29OJ2nvUI9n0m4tBwK');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `blogId` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `adsoyad` varchar(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `blogId`, `yorum`, `adsoyad`, `tarih`) VALUES
(1, 1, 'Esin benim aşkım', 'Marijua', '2023-09-16 05:39:51'),
(2, 1, 'ALLAHINA KURBAN SENİN', 'Marijua', '2023-09-16 05:45:07'),
(3, 18, 'Allah', 'Marijua', '2023-09-16 06:33:38'),
(4, 4, 'Esin\'in benim aşkım olduğunu biliyor muydunuz?\r\n', 'Marijua', '2023-11-14 18:56:09'),
(5, 2, 'deneme yorumu.', 'marijua', '2024-01-21 20:17:27');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kitapbagis`
--
ALTER TABLE `kitapbagis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `kitapbagis`
--
ALTER TABLE `kitapbagis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
