<?php
    namespace Verot\Upload;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_siteLogosu = $_FILES["siteLogosu"];
        //
        if(isset($_POST["siteAdi"])){
            $gelen_siteAdi = Guvenlik($_POST["siteAdi"]);
        }else{
            $gelen_siteAdi = "";
        }
        if(isset($_POST["siteBasligi"])){
            $gelen_siteBasligi = Guvenlik($_POST["siteBasligi"]);
        }else{
            $gelen_siteBasligi = "";
        }
        if(isset($_POST["siteAciklamasi"])){
            $gelen_siteAciklamasi = Guvenlik($_POST["siteAciklamasi"]);
        }else{
            $gelen_siteAciklamasi = "";
        }
        if(isset($_POST["siteAnahtarKelimeler"])){
            $gelen_siteAnahtarKelimeler = Guvenlik($_POST["siteAnahtarKelimeler"]);
        }else{
            $gelen_siteAnahtarKelimeler = "";
        }
        if(isset($_POST["siteTelifHaklariMetni"])){
            $gelen_siteTelifHaklariMetni = Guvenlik($_POST["siteTelifHaklariMetni"]);
        }else{
            $gelen_siteTelifHaklariMetni = "";
        }
        if(isset($_POST["siteLinki"])){
            $gelen_siteLinki = Guvenlik($_POST["siteLinki"]);
        }else{
            $gelen_siteLinki = "";
        }
        if(isset($_POST["siteEPostaAdresi"])){
            $gelen_siteEPostaAdresi = Guvenlik($_POST["siteEPostaAdresi"]);
        }else{
            $gelen_siteEPostaAdresi = "";
        }
        if(isset($_POST["siteEPostaSifresi"])){
            $gelen_siteEPostaSifresi = Guvenlik($_POST["siteEPostaSifresi"]);
        }else{
            $gelen_siteEPostaSifresi = "";
        }
        if(isset($_POST["siteEPostaHostAdresi"])){
            $gelen_siteEPostaHostAdresi = Guvenlik($_POST["siteEPostaHostAdresi"]);
        }else{
            $gelen_siteEPostaHostAdresi = "";
        }
        if(isset($_POST["FacebookLinki"])){
            $gelen_FacebookLinki = Guvenlik($_POST["FacebookLinki"]);
        }else{
            $gelen_FacebookLinki = "";
        }
        if(isset($_POST["TwitterLinki"])){
            $gelen_TwitterLinki = Guvenlik($_POST["TwitterLinki"]);
        }else{
            $gelen_TwitterLinki = "";
        }
        if(isset($_POST["LinkedInLinki"])){
            $gelen_LinkedInLinki = Guvenlik($_POST["LinkedInLinki"]);
        }else{
            $gelen_LinkedInLinki = "";
        }
        if(isset($_POST["PinterestLinki"])){
            $gelen_PinterestLinki = Guvenlik($_POST["PinterestLinki"]);
        }else{
            $gelen_PinterestLinki = "";
        }
        if(isset($_POST["InstagramLinki"])){
            $gelen_InstagramLinki = Guvenlik($_POST["InstagramLinki"]);
        }else{
            $gelen_InstagramLinki = "";
        }
        if(isset($_POST["YoutubeLinki"])){
            $gelen_YoutubeLinki = Guvenlik($_POST["YoutubeLinki"]);
        }else{
            $gelen_YoutubeLinki = "";
        }
        if(isset($_POST["dolarKuru"])){
            $gelen_dolarKuru = Guvenlik($_POST["dolarKuru"]);
        }else{
            $gelen_dolarKuru = "";
        }
        if(isset($_POST["euroKuru"])){
            $gelen_euroKuru = Guvenlik($_POST["euroKuru"]);
        }else{
            $gelen_euroKuru = "";
        }
        if(isset($_POST["ucretsizKargoBaraji"])){
            $gelen_ucretsizKargoBaraji = Guvenlik($_POST["ucretsizKargoBaraji"]);
        }else{
            $gelen_ucretsizKargoBaraji = "";
        }
        if(isset($_POST["vposapi_ClientID"])){
            $gelen_vposapi_ClientID = Guvenlik($_POST["vposapi_ClientID"]);
        }else{
            $gelen_vposapi_ClientID = "";
        }
        if(isset($_POST["vposapi_StoreKey"])){
            $gelen_vposapi_StoreKey = Guvenlik($_POST["vposapi_StoreKey"]);
        }else{
            $gelen_vposapi_StoreKey = "";
        }
        if(isset($_POST["vposapi_KullaniciAdi"])){
            $gelen_vposapi_KullaniciAdi = Guvenlik($_POST["vposapi_KullaniciAdi"]);
        }else{
            $gelen_vposapi_KullaniciAdi = "";
        }
        if(isset($_POST["vposapi_Sifre"])){
            $gelen_vposapi_Sifre = Guvenlik($_POST["vposapi_Sifre"]);
        }else{
            $gelen_vposapi_Sifre = "";
        }

        if(($gelen_siteAdi != "") and ($gelen_siteBasligi != "") and ($gelen_siteAciklamasi != "") and ($gelen_siteBasligi != "") and ($gelen_siteAnahtarKelimeler != "") and ($gelen_siteTelifHaklariMetni != "") and ($gelen_siteLinki != "") and ($gelen_siteEPostaAdresi != "") and ($gelen_siteEPostaSifresi != "") and ($gelen_siteEPostaHostAdresi != "") and ($gelen_FacebookLinki != "") and ($gelen_TwitterLinki != "") and ($gelen_LinkedInLinki != "") and ($gelen_PinterestLinki != "") and ($gelen_InstagramLinki != "") and ($gelen_YoutubeLinki != "") and ($gelen_dolarKuru != "") and ($gelen_euroKuru != "") and ($gelen_ucretsizKargoBaraji != "") and ($gelen_vposapi_ClientID != "") and ($gelen_vposapi_StoreKey != "") and ($gelen_vposapi_KullaniciAdi != "") and ($gelen_vposapi_Sifre != "")){
            $sorgu_ayarlariGuncelle = $veritaConn -> prepare("UPDATE ayarlar SET site_adi = ?, site_title = ?, site_description = ?, site_keywords = ?, site_copyright_metni = ?, site_email_adresi = ?, site_email_sifresi = ?, site_email_host_adresi = ?, site_linki = ?, Sosyal_Link_Facebook = ?, Sosyal_Link_Twitter = ?, Sosyal_Link_LinkedIn = ?, Sosyal_Link_Pinterest = ?, Sosyal_Link_Instagram = ?, Sosyal_Link_YouTube = ?, kurUSD = ?, kurEuro = ?, ucretsizKargoBaraji = ?, clientId = ?, storekey = ?, BAPIName = ?, BAPIPassword = ?");
            $sorgu_ayarlariGuncelle -> execute([$gelen_siteAdi, $gelen_siteBasligi, $gelen_siteAciklamasi, $gelen_siteAnahtarKelimeler, $gelen_siteTelifHaklariMetni, $gelen_siteEPostaAdresi, $gelen_siteEPostaSifresi, $gelen_siteEPostaHostAdresi, $gelen_siteLinki, $gelen_FacebookLinki, $gelen_TwitterLinki, $gelen_LinkedInLinki, $gelen_PinterestLinki, $gelen_InstagramLinki, $gelen_YoutubeLinki, $gelen_dolarKuru, $gelen_euroKuru, $gelen_ucretsizKargoBaraji, $gelen_vposapi_ClientID, $gelen_vposapi_StoreKey, $gelen_vposapi_KullaniciAdi, $gelen_vposapi_Sifre]);
            $guncellemeSayisi = $sorgu_ayarlariGuncelle -> rowCount();
            
            if(($gelen_siteLogosu["name"] != "") and ($gelen_siteLogosu["type"] != "") and ($gelen_siteLogosu["tmp_name"] != "") and ($gelen_siteLogosu["error"] == 0) and ($gelen_siteLogosu["size"] > 0)){
                $is_logoYukle = new Upload($_FILES["siteLogosu"], "tr-TR");
                if($is_logoYukle -> uploaded){
                    $is_logoYukle -> mime_magic_check = true;
                    $is_logoYukle -> image_allowed = array("image/*");
                    $is_logoYukle -> file_overwrite = true;

                    $is_logoYukle -> image_convert = "png";
                    $is_logoYukle -> image_quality = 100;
                    $resimMime = $is_logoYukle -> image_convert;

                    $is_logoYukle -> image_background_color  = null;
                    $is_logoYukle -> image_resize = true;
                    $is_logoYukle -> image_x = 125;
                    $is_logoYukle -> image_y = 125;
                    $is_logoYukle -> file_new_name_body = "Logo";
                    $resimIsmi = $is_logoYukle -> file_new_name_body . "." . $resimMime;

                    $is_logoYukle -> process($upload_resim_dizini);
                    if($is_logoYukle -> processed){
                        $is_logoYukle -> clean();
                        $yeniLogoDizini = "resimler/uimage/" . $resimIsmi;
                        $sorgu_logoYoluGuncelle = $veritaConn -> prepare("UPDATE ayarlar SET site_logosu = ?");
                        $sorgu_logoYoluGuncelle -> execute([$yeniLogoDizini]);
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=1'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
            }
			$_SESSION["mesaj_ana_y"] = "Tebrikler. Ayarlar Başarıyla Güncellendi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem başarıyla tamamlandı.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=1'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/tamam.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
            /*
            $_SESSION["mesaj_ana_y"] = "Hata. Ayarlar Güncellenemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=1'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
            */
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Ayarlar Güncellenemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=1'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>