-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 May 2025, 22:08:10
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `teknokapi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `site_adi` varchar(50) NOT NULL,
  `site_title` varchar(60) NOT NULL,
  `site_description` varchar(150) NOT NULL,
  `site_keywords` varchar(255) NOT NULL,
  `site_copyright_metni` varchar(255) NOT NULL,
  `site_logosu` varchar(30) NOT NULL,
  `site_email_adresi` varchar(50) NOT NULL,
  `site_email_sifresi` varchar(50) NOT NULL,
  `site_email_host_adresi` varchar(255) NOT NULL,
  `site_linki` varchar(255) NOT NULL,
  `Sosyal_Link_Facebook` varchar(255) NOT NULL,
  `Sosyal_Link_Twitter` varchar(255) NOT NULL,
  `Sosyal_Link_LinkedIn` varchar(255) NOT NULL,
  `Sosyal_Link_Pinterest` varchar(255) NOT NULL,
  `Sosyal_Link_Instagram` varchar(255) NOT NULL,
  `Sosyal_Link_YouTube` varchar(255) NOT NULL,
  `kurUSD` double UNSIGNED NOT NULL,
  `kurEuro` double UNSIGNED NOT NULL,
  `ucretsizKargoBaraji` double UNSIGNED NOT NULL,
  `clientId` varchar(100) NOT NULL,
  `storekey` varchar(100) NOT NULL,
  `BAPIName` varchar(100) NOT NULL,
  `BAPIPassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `site_adi`, `site_title`, `site_description`, `site_keywords`, `site_copyright_metni`, `site_logosu`, `site_email_adresi`, `site_email_sifresi`, `site_email_host_adresi`, `site_linki`, `Sosyal_Link_Facebook`, `Sosyal_Link_Twitter`, `Sosyal_Link_LinkedIn`, `Sosyal_Link_Pinterest`, `Sosyal_Link_Instagram`, `Sosyal_Link_YouTube`, `kurUSD`, `kurEuro`, `ucretsizKargoBaraji`, `clientId`, `storekey`, `BAPIName`, `BAPIPassword`) VALUES
(1, 'Yeşim Takı', 'Takı Dünyası', 'Özgün ve Harika Takılar Uygun Fiyatlarla Yeşim Takı&#039;da.', 'Takı, Küpe, Kolye, Aksesuar, Kişisel Bakım, Temizlik, Güzellik, Yeşim, Mücevher, Ticaret', 'Copyright 2021 - Yeşim Takı - Tüm Hakları Saklıdır.', 'resimler/Logo.svg', 'example', 'ysileiletisim447', 'smtp.gmail.com', 'localhost/teknokapi', 'https://tr-tr.facebook.com/', 'https://twitter.com/?lang=tr', 'https://tr.linkedin.com/', 'https://tr.pinterest.com/', 'https://www.instagram.com/', 'https://www.youtube.com/', 17.33, 18.19, 250, '00000000', '11111111', '3dkullanicim', '3dsifrem');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banka_hesaplarimiz`
--

CREATE TABLE `banka_hesaplarimiz` (
  `id` int(10) UNSIGNED NOT NULL,
  `BankaLogosu` varchar(255) NOT NULL,
  `BankaAdi` varchar(100) NOT NULL,
  `KonumSehir` varchar(100) NOT NULL,
  `KonumUlke` varchar(100) NOT NULL,
  `SubeAdi` varchar(100) NOT NULL,
  `SubeKodu` varchar(100) NOT NULL,
  `ParaBirimi` varchar(100) NOT NULL,
  `HesapSahibi` varchar(255) NOT NULL,
  `HesapNumarasi` varchar(100) NOT NULL,
  `IbanNumarasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `banka_hesaplarimiz`
--

INSERT INTO `banka_hesaplarimiz` (`id`, `BankaLogosu`, `BankaAdi`, `KonumSehir`, `KonumUlke`, `SubeAdi`, `SubeKodu`, `ParaBirimi`, `HesapSahibi`, `HesapNumarasi`, `IbanNumarasi`) VALUES
(1, 'resimler/banka_sertifika/yapikredi_card.png', 'Yapı Kredi', 'Ankara', 'Türkiye', 'Tandoğan', 'A05B5', 'Türk Lirası', 'Administrator', '5464894651', 'TR330006100519786457841326'),
(2, 'resimler/banka_sertifika/akbank_card.png', 'Akbank', 'İstanbul', 'Türkiye', 'Taksim', 'B05B5', 'Türk Lirası', 'Administrator', '5464896651', 'TR330006100319786457841326'),
(3, 'resimler/banka_sertifika/garanti_bonus_card.png', 'Garanti BBVA', 'Trabzon', 'Türkiye', 'Kafdağı', 'A0CB5', 'Türk Lirası', 'Administrator', '5464897651', 'TR330006150519786457841326'),
(4, 'resimler/banka_sertifika/trisbankasi_card.png', 'Türkiye İş Bankası', 'Rize', 'Türkiye', 'Türk Yaylası', 'A0CB9', 'Türk Lirası', 'Administrator', '4464897651', 'TR330008150519786457841326'),
(5, 'resimler/banka_sertifika/denizbank_card.png', 'DenizBank', 'Eskişehir', 'Türkiye', 'YeniŞehir', 'C0CB9', 'Türk Lirası', 'Administrator', '4464895651', 'TR330008151419786457841326'),
(6, 'resimler/banka_sertifika/qnbfinansbank_card.png', 'QNB Finansbank', 'Konya', 'Türkiye', 'Kulu', 'D0CB9', 'Türk Lirası', 'Administrator', '4466797651', 'TR330008102519786457841326');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banner`
--

CREATE TABLE `banner` (
  `id` int(10) NOT NULL,
  `bannerAlani` varchar(100) NOT NULL,
  `bannerAdi` varchar(30) NOT NULL,
  `bannerResmi` varchar(255) NOT NULL,
  `gosterimSayisi` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `banner`
--

INSERT INTO `banner` (`id`, `bannerAlani`, `bannerAdi`, `bannerResmi`, `gosterimSayisi`) VALUES
(1, 'Menu Altı', 'Ornek Reklam 1', 'resimler/reklam/banner1.jpg', 335),
(2, 'Menu Altı', 'Ornek Reklam 2', 'resimler/reklam/banner2.jpg', 335),
(3, 'Menu Altı', 'Ornek Reklam 3', 'resimler/reklam/banner3.jpg', 335),
(4, 'Ürün Detay', 'Örnek Reklam 4', 'resimler/reklam/kareBanner1.jpg', 153),
(5, 'Ürün Detay', 'Örnek Reklam 5', 'resimler/reklam/kareBanner2.jpg', 153),
(6, 'Ürün Detay', 'Örnek Reklam 6', 'resimler/reklam/kareBanner3.jpg', 152),
(7, 'Ana Sayfa', 'Ana Sayfa Banneri 1', 'resimler/banner/AnaSayfa/bannerhome1.jpg', 91),
(8, 'Ana Sayfa', 'Ana Sayfa Banneri 2', 'resimler/banner/AnaSayfa/bannerhome2.jpg', 90);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `havale_bildirimleri`
--

CREATE TABLE `havale_bildirimleri` (
  `id` int(10) UNSIGNED NOT NULL,
  `banka_id` int(10) UNSIGNED NOT NULL,
  `AdiSoyadi` varchar(100) NOT NULL,
  `EmailAdresi` varchar(255) NOT NULL,
  `TelNo` varchar(11) NOT NULL,
  `Aciklama` text NOT NULL,
  `IslemTarihi` int(10) UNSIGNED NOT NULL,
  `Durum` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kargo_firmalar`
--

CREATE TABLE `kargo_firmalar` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(100) NOT NULL,
  `ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `kargo_firmalar`
--

INSERT INTO `kargo_firmalar` (`id`, `logo`, `ad`) VALUES
(1, 'resimler/kargo/yurticikargo.png', 'Yurtiçi Kargo'),
(2, 'resimler/kargo/araskargo.png', 'Aras Kargo'),
(3, 'resimler/kargo/mngkargo.png', 'MNG Kargo'),
(4, 'resimler/kargo/suratkargo.png', 'Sürat Kargo'),
(5, 'resimler/kargo/pttkargo.png', 'PTT Kargo'),
(13, 'resimler/uimage/aeb456d3c267d099f0de0eab5.png', 'mehmet');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menuler`
--

CREATE TABLE `menuler` (
  `id` int(10) UNSIGNED NOT NULL,
  `urun_tur` varchar(100) NOT NULL,
  `menu_ad` varchar(50) NOT NULL,
  `urun_sayi` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `menuler`
--

INSERT INTO `menuler` (`id`, `urun_tur`, `menu_ad`, `urun_sayi`) VALUES
(1, 'Kolye', 'Değerli Taş Kolyeler', 3),
(2, 'Kolye', 'Boncuk Kolyeler', 1),
(3, 'Kolye', 'Metal Kolyeler', 0),
(4, 'Kolye', 'Doğal Kolyeler', 0),
(5, 'Takı Seti', 'Renkli Takı Setleri', 1),
(6, 'Takı Seti', 'Metal Takı Setleri', 1),
(7, 'Takı Seti', 'Doğal Taş Takı Setleri', 0),
(8, 'Takı Seti', 'Doğal Takı Setleri', 0),
(9, 'Bileklik', 'Değerli Taş Bileklik', 1),
(10, 'Bileklik', 'Renkli Bileklik', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sepet`
--

CREATE TABLE `sepet` (
  `id` int(10) UNSIGNED NOT NULL,
  `sepetNumarasi` int(10) UNSIGNED NOT NULL,
  `uyeId` int(10) UNSIGNED NOT NULL,
  `urunId` int(10) UNSIGNED NOT NULL,
  `adresId` int(10) UNSIGNED NOT NULL,
  `variantId` int(10) UNSIGNED NOT NULL,
  `urunAdedi` tinyint(3) UNSIGNED NOT NULL,
  `kargoFirmasiSecimi` tinyint(2) UNSIGNED NOT NULL,
  `odemeSecimi` varchar(50) NOT NULL,
  `taksitSecimi` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `id` int(10) UNSIGNED NOT NULL,
  `siparis_no` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `urun_tur` varchar(50) NOT NULL,
  `uye_id` int(10) UNSIGNED NOT NULL,
  `urun_ad` varchar(255) NOT NULL,
  `urun_fiyat` double UNSIGNED NOT NULL,
  `urun_kdvOrani` int(2) UNSIGNED NOT NULL,
  `urun_siparisAdedi` int(3) UNSIGNED NOT NULL,
  `siparis_toplamUrunFiyati` double UNSIGNED NOT NULL,
  `urun_kargoFirmasiSecimi` varchar(100) NOT NULL,
  `urun_kargoUcreti` double UNSIGNED NOT NULL,
  `urun_resimBir` varchar(30) NOT NULL,
  `urun_variantBasligi` varchar(100) NOT NULL,
  `urun_variantSecimi` varchar(100) NOT NULL,
  `urun_variantId` int(10) UNSIGNED NOT NULL,
  `siparis_adres_adiSoyadi` varchar(100) NOT NULL,
  `siparis_adres_detay` varchar(255) NOT NULL,
  `siparis_adres_telefon` varchar(11) NOT NULL,
  `siparisodemeSecimi` varchar(25) NOT NULL,
  `siparis_taksitSecimi` int(2) UNSIGNED NOT NULL,
  `siparis_tarih` int(10) NOT NULL,
  `siparis_ipAdresi` varchar(20) NOT NULL,
  `siparis_onayDurum` tinyint(1) UNSIGNED NOT NULL,
  `siparis_kargoDurum` tinyint(1) UNSIGNED NOT NULL,
  `siparis_kargoGonderiKodu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`id`, `siparis_no`, `urun_id`, `urun_tur`, `uye_id`, `urun_ad`, `urun_fiyat`, `urun_kdvOrani`, `urun_siparisAdedi`, `siparis_toplamUrunFiyati`, `urun_kargoFirmasiSecimi`, `urun_kargoUcreti`, `urun_resimBir`, `urun_variantBasligi`, `urun_variantSecimi`, `urun_variantId`, `siparis_adres_adiSoyadi`, `siparis_adres_detay`, `siparis_adres_telefon`, `siparisodemeSecimi`, `siparis_taksitSecimi`, `siparis_tarih`, `siparis_ipAdresi`, `siparis_onayDurum`, `siparis_kargoDurum`, `siparis_kargoGonderiKodu`) VALUES
(11, 16, 14, 'Kolye', 1, 'Boncuk Denme', 250, 18, 1, 250, 'Yurtiçi Kargo', 0, 'a67dd4f184a3ac8dd3e977c73.png', 'Varyant', 'trhtrj', 57, 'Mehmet Emin Çelik', '30 Ağustos Mah., 1773. Cad., 33/10, ETİMESGUT/ANKARA Etimesgut Ankara Türkiye', '05453483947', 'Banka Havalesi', 0, 1674173337, '127.0.0.1', 0, 0, ''),
(12, 18, 14, 'Kolye', 1, 'Boncuk Denme', 250, 18, 2, 500, 'Aras Kargo', 0, 'a67dd4f184a3ac8dd3e977c73.png', 'Varyant', 'ytjytj', 58, 'Mehmet Emin Çelik', '30 Ağustos Mah., 1773. Cad., 33/10, ETİMESGUT/ANKARA Etimesgut Ankara Türkiye', '05453483947', 'Banka Havalesi', 0, 1674173916, '127.0.0.1', 0, 0, ''),
(13, 18, 1, 'Kolye', 1, 'Kırmızı Deneme Kolye', 114, 22, 4, 456, 'Aras Kargo', 0, 'e0a8e312a1be345097b331ab0.png', 'Varyant', 'A1', 1, 'Mehmet Emin Çelik', '30 Ağustos Mah., 1773. Cad., 33/10, ETİMESGUT/ANKARA Etimesgut Ankara Türkiye', '05453483947', 'Banka Havalesi', 0, 1674173916, '127.0.0.1', 0, 0, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sorular`
--

CREATE TABLE `sorular` (
  `id` int(10) UNSIGNED NOT NULL,
  `soru` varchar(255) NOT NULL,
  `cevap` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `sorular`
--

INSERT INTO `sorular` (`id`, `soru`, `cevap`) VALUES
(1, '1. Soru Başlığı', '1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı1. Soru Cevabı'),
(2, '2. Soru Başlığı', '2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabı2. Soru Cevabıa'),
(3, '3. Soru Başlığı', '3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı3. Soru Cevabı'),
(4, '4. Soru Başlığı', '4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı4. Soru Cevabı'),
(5, '5. Soru Başlığı', '5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı5. Soru Cevabı'),
(6, '6. Soru Başlığı', '6. Soru Cevabı'),
(7, '7. Soru Başlığı', '7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı7. Soru Cevabı'),
(8, '8. Soru Başlığı', '8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı8. Soru Cevabı'),
(9, '9. Soru Başlığı', '9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı9. Soru Cevabı'),
(10, '10. Soru Başlığı', '10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı10. Soru Cevabı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sozlesmeler_ve_metinler`
--

CREATE TABLE `sozlesmeler_ve_metinler` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `Hakkimizda_Metni` text NOT NULL,
  `UyelikSozlesmesi_Metni` text NOT NULL,
  `KullanimKosullari_Metni` text NOT NULL,
  `GizlilikSozlesmesi_Metni` text NOT NULL,
  `MesafeliSatisSozlesmesi_Metni` text NOT NULL,
  `Teslimat_Metni` text NOT NULL,
  `IptaliadeDegisim_Metni` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `sozlesmeler_ve_metinler`
--

INSERT INTO `sozlesmeler_ve_metinler` (`id`, `Hakkimizda_Metni`, `UyelikSozlesmesi_Metni`, `KullanimKosullari_Metni`, `GizlilikSozlesmesi_Metni`, `MesafeliSatisSozlesmesi_Metni`, `Teslimat_Metni`, `IptaliadeDegisim_Metni`) VALUES
(1, 'Burası Hakkımızda Metnidir.', 'Burası Üyelik Sözleşmesi Metnidir.', 'Burası Kullanım Koşulları Metnidir.', 'Burası Gizlilik Sözleşmesi Metnidir.', 'Burası Mesafeli Satış Sözleşmesi Metnidir.', 'Burası Teslimat Metnidir.Burası Teslimat Metnidir.', 'Burası İptal &amp; İade &amp; Değişim Metnidir.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(10) UNSIGNED NOT NULL,
  `menuId` int(10) UNSIGNED NOT NULL,
  `urun_tur` varchar(100) NOT NULL,
  `urun_ad` varchar(255) NOT NULL,
  `urun_fiyat` double UNSIGNED NOT NULL,
  `urun_paraBirimi` char(3) NOT NULL,
  `urun_kdvOrani` int(2) UNSIGNED NOT NULL,
  `urun_aciklama` text NOT NULL,
  `urun_resimBir` varchar(30) NOT NULL,
  `urun_resimIki` varchar(30) NOT NULL,
  `urun_resimUc` varchar(30) NOT NULL,
  `urun_resimDort` varchar(30) NOT NULL,
  `urun_variantBasligi` varchar(100) NOT NULL,
  `urun_kargoUcreti` double UNSIGNED NOT NULL,
  `urun_durum` tinyint(1) UNSIGNED NOT NULL,
  `urun_toplamSatisSayisi` int(10) UNSIGNED NOT NULL,
  `urun_yorumSayisi` tinyint(1) UNSIGNED NOT NULL,
  `urun_toplamYorumPuani` int(10) UNSIGNED NOT NULL,
  `urun_goruntulenmeSayisi` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `menuId`, `urun_tur`, `urun_ad`, `urun_fiyat`, `urun_paraBirimi`, `urun_kdvOrani`, `urun_aciklama`, `urun_resimBir`, `urun_resimIki`, `urun_resimUc`, `urun_resimDort`, `urun_variantBasligi`, `urun_kargoUcreti`, `urun_durum`, `urun_toplamSatisSayisi`, `urun_yorumSayisi`, `urun_toplamYorumPuani`, `urun_goruntulenmeSayisi`) VALUES
(1, 1, 'Kolye', 'Kırmızı Deneme Kolye', 114, 'TRY', 22, 'Deneme Kolyelerimizdendir.', 'e0a8e312a1be345097b331ab0.png', 'deneme1_2.jpg', '8b44514c7a2fdd48cf4d4c461.png', 'deneme1_4.jpg', 'Varyant', 10, 1, 18, 57, 260, 25),
(2, 5, 'Takı Seti', 'Karma Deneme Takı Seti', 50, 'TRY', 18, 'Deneme Takı Setimizdendir.', 'deneme2_1.jpg', '', '', '', 'Varyant', 10, 1, 2, 0, 0, 17),
(3, 6, 'Takı Seti', 'Karma Deneme Takı Seti 2', 7, 'EUR', 18, 'Deneme Takı Setimizdendir.', 'deneme3_1.jpg', 'deneme3_2.jpg', 'deneme3_3.jpg', '', 'Varyant', 10, 1, 4, 0, 0, 24),
(4, 9, 'Bileklik', 'Deneme Bileklik 1', 45, 'TRY', 18, 'Deneme Bilekliğimizdir.', 'deneme4_1.jpg', '', '', '', 'Varyant', 10, 1, 0, 0, 0, 10),
(5, 10, 'Bileklik', 'Deneme Bileklik 2', 50, 'TRY', 18, 'Deneme Bilekliğimizdendir.', 'deneme5_1.jpg', '', '', '', 'Varyant', 10, 1, 0, 0, 0, 8),
(6, 1, 'Kolye', 'Deneme Kolye Seti 2', 96, 'TRY', 18, 'Deneme Kolye Setimizdendir...', 'deneme6_1.jpg', '', '', '', 'Varyant', 10, 1, 0, 83, 400, 12),
(7, 1, 'Kolye', 'Deneme Kolye Seti 3', 74, 'TRY', 18, 'Deneme Kolye Setimizdendir...', 'deneme7_1.jpg', '', '', '', 'Varyant', 10, 1, 0, 64, 250, 13),
(8, 4, 'Kolye', 'Deneme Kolye Seti 4', 125, 'TRY', 18, 'Deneme Kolye Setimizdendir...', 'deneme8_1.jpg', '', '', '', 'Varyant', 10, 0, 18, 17, 30, 52),
(9, 2, 'Kolye', 'Deneme Kolye Seti 5', 100, 'TRY', 18, 'Deneme Kolye Setimizdendir...', 'deneme9_1.jpg', '', '', '', 'Varyant', 10, 0, 3, 203, 706, 104),
(13, 9, 'Bileklik', 'Deneme455', 21, 'TRY', 12, 'dennemedirrrr', 'a031efb93c9f91a7ba9e5f9ce.png', '', '', '0320c684a96b958de19c1aea6.png', 'Varyant', 14, 0, 0, 0, 0, 1),
(14, 2, 'Kolye', 'Boncuk Denme', 250, 'TRY', 18, 'Deneme Boncukkk', 'a67dd4f184a3ac8dd3e977c73.png', '', 'f189f81a97775b2ec133b2e4b.png', '', 'Varyant', 25, 1, 501, 0, 0, 7),
(15, 10, 'Bileklik', 'Nikola Tesla', 500, 'TRY', 18, 'Nikala Tasla', '9d2e2c17d4f17e39437305663.png', '', '', '', 'Varyant', 50, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler_variantlar`
--

CREATE TABLE `urunler_variantlar` (
  `id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `variant_ad` varchar(100) NOT NULL,
  `variant_stokAdet` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `urunler_variantlar`
--

INSERT INTO `urunler_variantlar` (`id`, `urun_id`, `variant_ad`, `variant_stokAdet`) VALUES
(1, 1, 'A1', 38),
(2, 1, '1_2', 4),
(3, 1, 'C4', 2),
(4, 1, 'C4', 2),
(5, 2, '2_1', 0),
(6, 3, '3_1', 5),
(7, 3, '3_2', 14),
(8, 3, '3_3', 100),
(9, 8, 'Mavi', 20),
(10, 9, 'Yeşil', 8),
(13, 13, 'Kırmızı Deneme455', 12),
(16, 15, 'Nicoal 1', 20),
(17, 15, 'Nicoal 2', 20),
(57, 14, 'trhtrj', 31),
(58, 14, 'ytjytj', 500);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `id` int(10) UNSIGNED NOT NULL,
  `uye_email` varchar(255) NOT NULL,
  `uye_sifre` varchar(100) NOT NULL,
  `uye_tamisim` varchar(100) NOT NULL,
  `uye_telno` varchar(11) NOT NULL,
  `uye_cinsiyet` varchar(5) NOT NULL,
  `uye_durum` tinyint(1) NOT NULL,
  `uye_silinme_durumu` tinyint(1) UNSIGNED NOT NULL,
  `uye_kayit_tarihi` int(10) NOT NULL,
  `uye_kayit_ip_adresi` varchar(20) NOT NULL,
  `uye_aktivasyon_kodu` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`id`, `uye_email`, `uye_sifre`, `uye_tamisim`, `uye_telno`, `uye_cinsiyet`, `uye_durum`, `uye_silinme_durumu`, `uye_kayit_tarihi`, `uye_kayit_ip_adresi`, `uye_aktivasyon_kodu`) VALUES
(1, 'example', '1373dc504de87b37cbcddde8d578ed66', 'Mehmet Emin Çelik', 'example', 'Erkek', 1, 0, 1640811671, '::1', '56172-93468-48917-43601'),
(2, 'example', '1373dc504de87b37cbcddde8d578ed66', 'Mehmet Emin Çelik 2', '0619', 'Erkek', 1, 1, 1641680434, '::1', '39355-53627-49460-33653'),
(4, 'person@example.com', '1373dc504de87b37cbcddde8d578ed66', 'Mehmet Emin Çeliko', 'example', 'Erkek', 1, 0, 1665847182, '::1', '39905-61109-65125-62525'),
(5, 'person2@example.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Kara', 'example', 'Kadin', 1, 0, 1665850249, '::1', '58574-54586-13591-16053');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler_adresler`
--

CREATE TABLE `uyeler_adresler` (
  `id` int(10) UNSIGNED NOT NULL,
  `uye_id` int(10) UNSIGNED NOT NULL,
  `tamisim` varchar(100) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `ilce` varchar(100) NOT NULL,
  `il` varchar(100) NOT NULL,
  `ulke` varchar(100) NOT NULL,
  `telno` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `uyeler_adresler`
--

INSERT INTO `uyeler_adresler` (`id`, `uye_id`, `tamisim`, `adres`, `ilce`, `il`, `ulke`, `telno`) VALUES
(3, 2, 'example', ' Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3Deneme Adresi 3 Deneme Adresi 3', 'Saimekadın', 'Ankara', 'Türkiye', 'example'),
(4, 2, 'example', 'Deneme Adresi 4 Deneme Adresi 4 Deneme Adresi 4Deneme Adresi 4Deneme Adresi 4Deneme Adresi 4Deneme Adresi 4Deneme Adresi 4Deneme Adresi 4 Deneme Adresi 4', 'Şişli', 'İstanbul', 'Türkiye', 'example'),
(5, 1, 'example', 'example', 'example', 'Ankara', 'Türkiye', 'example'),
(7, 4, 'example', 'example', 'example', 'Ankara', 'Türkiye', 'example'),
(8, 5, 'ada', 'example', 'example', 'Ankara', 'Türkiye', 'example');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler_favoriler`
--

CREATE TABLE `uyeler_favoriler` (
  `id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `uye_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yoneticiler`
--

CREATE TABLE `yoneticiler` (
  `id` int(10) UNSIGNED NOT NULL,
  `kullaniciAdi` varchar(100) NOT NULL,
  `sifre` varchar(100) NOT NULL,
  `adiSoyadi` varchar(100) NOT NULL,
  `ePostaAdresi` varchar(255) NOT NULL,
  `telNo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `yoneticiler`
--

INSERT INTO `yoneticiler` (`id`, `kullaniciAdi`, `sifre`, `adiSoyadi`, `ePostaAdresi`, `telNo`) VALUES
(1, 'ad', '523af537946b79c4f8369ed39ba78605', 'ad', 'ad', 'ad'),
(2, 'ed', 'b5f3729e5418905ad2b21ce186b1c01d', 'ed', 'ed', 'ed');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `uye_id` int(10) UNSIGNED NOT NULL,
  `puan` tinyint(1) UNSIGNED NOT NULL,
  `yorum_metni` text NOT NULL,
  `yorum_tarihi` int(10) NOT NULL,
  `yorum_ip_adresi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `urun_id`, `uye_id`, `puan`, `yorum_metni`, `yorum_tarihi`, `yorum_ip_adresi`) VALUES
(3, 9, 1, 5, 'Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!Very Nice Accessory!', 1648582816, '::1'),
(4, 9, 1, 1, 'Testing, it is not bad!', 1648582976, '::1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `banka_hesaplarimiz`
--
ALTER TABLE `banka_hesaplarimiz`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `havale_bildirimleri`
--
ALTER TABLE `havale_bildirimleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kargo_firmalar`
--
ALTER TABLE `kargo_firmalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `menuler`
--
ALTER TABLE `menuler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sepet`
--
ALTER TABLE `sepet`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sorular`
--
ALTER TABLE `sorular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sozlesmeler_ve_metinler`
--
ALTER TABLE `sozlesmeler_ve_metinler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler_variantlar`
--
ALTER TABLE `urunler_variantlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uyeler_adresler`
--
ALTER TABLE `uyeler_adresler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uyeler_favoriler`
--
ALTER TABLE `uyeler_favoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yoneticiler`
--
ALTER TABLE `yoneticiler`
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
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `banka_hesaplarimiz`
--
ALTER TABLE `banka_hesaplarimiz`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `havale_bildirimleri`
--
ALTER TABLE `havale_bildirimleri`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kargo_firmalar`
--
ALTER TABLE `kargo_firmalar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `menuler`
--
ALTER TABLE `menuler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `sepet`
--
ALTER TABLE `sepet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `sorular`
--
ALTER TABLE `sorular`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `sozlesmeler_ve_metinler`
--
ALTER TABLE `sozlesmeler_ve_metinler`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `urunler_variantlar`
--
ALTER TABLE `urunler_variantlar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler_adresler`
--
ALTER TABLE `uyeler_adresler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler_favoriler`
--
ALTER TABLE `uyeler_favoriler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `yoneticiler`
--
ALTER TABLE `yoneticiler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
