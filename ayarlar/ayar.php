<?php
    //VERITABANI BAGLANTISI
    try{
        $veritaConn = new PDO("mysql:host=localhost;dbname=teknokapi;charset=UTF8", "root", "");
    }
    catch(PDOException $hata){
        //echo "Bağlantı Hatası: <br />" . $hata->getMessage();
        die();
    }
    //

    //ANA SITE BILGILERI
    $sorgu_ayarlar = $veritaConn->prepare("SELECT * FROM ayarlar LIMIT 1");
    $sorgu_ayarlar-> execute();
    $ayarSayisi = $sorgu_ayarlar->rowCount();
    $ayar = $sorgu_ayarlar->fetch(PDO::FETCH_ASSOC);

    if($ayarSayisi > 0){
        $site_adi = $ayar["site_adi"];
        $site_title = $ayar["site_title"];
        $site_description = $ayar["site_description"];
        $site_keywords = $ayar["site_keywords"];
        $site_copyright_metni = $ayar["site_copyright_metni"];
        $site_logosu = $ayar["site_logosu"];
        $site_email_adresi = $ayar["site_email_adresi"];
        $site_email_sifresi = $ayar["site_email_sifresi"];
        $site_email_host_adresi = $ayar["site_email_host_adresi"];
        $site_linki = $ayar["site_linki"];
        $soslink_facebook = $ayar["Sosyal_Link_Facebook"];
        $soslink_twitter = $ayar["Sosyal_Link_Twitter"];
        $soslink_linkedin = $ayar["Sosyal_Link_LinkedIn"];
        $soslink_pinterest = $ayar["Sosyal_Link_Pinterest"];
        $soslink_instagram = $ayar["Sosyal_Link_Instagram"];
        $soslink_youtube = $ayar["Sosyal_Link_YouTube"];
        $kurUSD = $ayar["kurUSD"];
        $kurEuro = $ayar["kurEuro"];
        $ucretsizKargoBaraji = $ayar["ucretsizKargoBaraji"];
        $clientId = $ayar["clientId"];
        $storekey = $ayar["storekey"];
        $BAPIName = $ayar["BAPIName"];
        $BAPIPassword = $ayar["BAPIPassword"];
    }
    else{
        //echo "Site Ayarları Sorgusu Hatası!";
        die();
    }
    //

    //SITE SOZLESME METINLERI
    $sorgu_sozmetin = $veritaConn -> prepare("SELECT * FROM sozlesmeler_ve_metinler LIMIT 1");
    $sorgu_sozmetin -> execute();
    $sozmetinSayisi = $sorgu_sozmetin -> rowCount();
    $sozmetin = $sorgu_sozmetin -> fetch(PDO::FETCH_ASSOC);

    if($sozmetinSayisi > 0){
        $Hakkimizda_Metni = $sozmetin["Hakkimizda_Metni"];
        $UyelikSozlesmesi_Metni = $sozmetin["UyelikSozlesmesi_Metni"];
        $KullanimKosullari_Metni = $sozmetin["KullanimKosullari_Metni"];
        $GizlilikSozlesmesi_Metni = $sozmetin["GizlilikSozlesmesi_Metni"];
        $MesafeliSatisSozlesmesi_Metni = $sozmetin["MesafeliSatisSozlesmesi_Metni"];
        $Teslimat_Metni = $sozmetin["Teslimat_Metni"];
        $IptaliadeDegisim_Metni = $sozmetin["IptaliadeDegisim_Metni"];
    }else{
        //echo "Sözleşme Metinleri Sorgusu Hatası!";
        die();
    }
    //

    //OTURUMDAKI KULLANICI SORGUSU
    if(isset($_SESSION["kullanici_email"])){
        $sorgu_kullanici = $veritaConn -> prepare("SELECT * FROM uyeler WHERE uye_email = ? LIMIT 1");
        $sorgu_kullanici -> execute([$_SESSION["kullanici_email"]]);
        $kullaniciSayisi = $sorgu_kullanici -> rowCount();
        $kullanici = $sorgu_kullanici -> fetch(PDO::FETCH_ASSOC);
        if($kullaniciSayisi > 0){
            $kullanici_id = $kullanici["id"];
            $kullanici_email = $kullanici["uye_email"];
            //$kullanici_sifre = $kullanici["uye_sifre"];
            $kullanici_tamisim = $kullanici["uye_tamisim"];
            $kullanici_telno = $kullanici["uye_telno"];
            $kullanici_cinsiyet = $kullanici["uye_cinsiyet"];
            $kullanici_durum = $kullanici["uye_durum"];
            $kullanici_kayit_tarihi = $kullanici["uye_kayit_tarihi"];
            $kullanici_kayit_ip_adresi = $kullanici["uye_kayit_ip_adresi"];
            $kullanici_aktivasyon_kodu = $kullanici["uye_aktivasyon_kodu"];

        }else{
            die();
        }
    }
    //

    //OTURUMDAKI Yonetici SORGUSU
    if(isset($_SESSION["kullanici_Yonetici"])){
        $sorgu_yonetici = $veritaConn -> prepare("SELECT * FROM yoneticiler WHERE kullaniciAdi = ? LIMIT 1");
        $sorgu_yonetici -> execute([$_SESSION["kullanici_Yonetici"]]);
        $yoneticiSayisi = $sorgu_yonetici -> rowCount();
        $yonetici = $sorgu_yonetici -> fetch(PDO::FETCH_ASSOC);
        if($yoneticiSayisi > 0){
            $yoneticiId = $yonetici["id"];
            $yoneticiKullaniciAdi = $yonetici["kullaniciAdi"];
            $yoneticiSifre = $yonetici["sifre"];
            $yoneticiAdiSoyadi = $yonetici["adiSoyadi"];
            $yoneticiEPostaAdresi = $yonetici["ePostaAdresi"];
            $yoneticiTelNo = $yonetici["telNo"];
        }else{
            die();
        }
    }
    //
?>