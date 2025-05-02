<?php
    namespace Verot\Upload;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_bankaLogosu = $_FILES["bankaLogosu"];
        //
        if(isset($_POST["bankaAdi"])){
            $gelen_bankaAdi = Guvenlik($_POST["bankaAdi"]);
        }else{
            $gelen_bankaAdi = "";
        }
        if(isset($_POST["bankaSubeAdi"])){
            $gelen_bankaSubeAdi = Guvenlik($_POST["bankaSubeAdi"]);
        }else{
            $gelen_bankaSubeAdi = "";
        }
        if(isset($_POST["bankaSubeKodu"])){
            $gelen_bankaSubeKodu = Guvenlik($_POST["bankaSubeKodu"]);
        }else{
            $gelen_bankaSubeKodu = "";
        }
        if(isset($_POST["bankaSehir"])){
            $gelen_bankaSehir = Guvenlik($_POST["bankaSehir"]);
        }else{
            $gelen_bankaSehir = "";
        }
        if(isset($_POST["bankaUlke"])){
            $gelen_bankaUlke = Guvenlik($_POST["bankaUlke"]);
        }else{
            $gelen_bankaUlke = "";
        }
        if(isset($_POST["bankaParaBirimi"])){
            $gelen_bankaParaBirimi = Guvenlik($_POST["bankaParaBirimi"]);
        }else{
            $gelen_bankaParaBirimi = "";
        }
        if(isset($_POST["bankaHesapSahibi"])){
            $gelen_bankaHesapSahibi = Guvenlik($_POST["bankaHesapSahibi"]);
        }else{
            $gelen_bankaHesapSahibi = "";
        }
        if(isset($_POST["bankaHesapNumarasi"])){
            $gelen_bankaHesapNumarasi = Guvenlik($_POST["bankaHesapNumarasi"]);
        }else{
            $gelen_bankaHesapNumarasi = "";
        }
        if(isset($_POST["bankaHesapIban"])){
            $gelen_bankaHesapIban = Guvenlik($_POST["bankaHesapIban"]);
        }else{
            $gelen_bankaHesapIban = "";
        }
        if(($gelen_bankaAdi != "") and ($gelen_bankaSubeAdi != "") and ($gelen_bankaSubeKodu != "") and ($gelen_bankaSehir != "") and ($gelen_bankaUlke != "") and ($gelen_bankaParaBirimi != "") and ($gelen_bankaHesapSahibi != "") and ($gelen_bankaHesapNumarasi != "") and ($gelen_bankaHesapIban != "")){
            if(($gelen_bankaLogosu["name"] != "") and ($gelen_bankaLogosu["type"] != "") and ($gelen_bankaLogosu["tmp_name"] != "") and ($gelen_bankaLogosu["error"] == 0) and ($gelen_bankaLogosu["size"] > 0)){
                //resim isimlendirme ve dizini
                $resim_yeniAd = ResimAdiOlustur();
                $resim_uzanti = substr($gelen_bankaLogosu["name"], -4);
                if($resim_uzanti == "jpeg")
                    $resim_uzanti = "." . $resim_uzanti;
                //$resim_yeniAd = $resim_yeniAd . $resim_uzanti;
                //$resim_dizini = $upload_resim_dizini . $resim_yeniAd;
                //--------------------------------------------------------------
                $is_logoYukle = new Upload($_FILES["bankaLogosu"], "tr-TR");
                if($is_logoYukle -> uploaded){
                    $is_logoYukle -> mime_magic_check = true;
                    $is_logoYukle -> image_allowed = array("image/*");
                    $is_logoYukle -> file_overwrite = true;

                    $is_logoYukle -> image_convert = "png";
                    $is_logoYukle -> image_quality = 100;
                    $resimMime = $is_logoYukle -> image_convert;

                    $is_logoYukle -> image_background_color  = null;
                    $is_logoYukle -> image_resize = true;
                    $is_logoYukle -> image_ratio = true;
                    //$is_logoYukle -> image_x = 125;
                    $is_logoYukle -> image_y = 294;
                    $is_logoYukle -> file_new_name_body = $resim_yeniAd;
                    $resimIsmi = $is_logoYukle -> file_new_name_body . "." . $resimMime;
                    $resimDiziniForDB = "resimler/uimage/" . $resimIsmi;

                    $is_logoYukle -> process($upload_resim_dizini);
                    if($is_logoYukle -> processed){
                        $is_logoYukle -> clean();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
                //-------------------------------------------------------------------------------------------------------------------------------------------------------------
                
                $sorgu_bankaHesabiEkle = $veritaConn -> prepare("INSERT INTO banka_hesaplarimiz(BankaLogosu, BankaAdi, KonumSehir, KonumUlke, SubeAdi, SubeKodu, ParaBirimi, HesapSahibi, HesapNumarasi, IbanNumarasi) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sorgu_bankaHesabiEkle -> execute([$resimDiziniForDB, $gelen_bankaAdi, $gelen_bankaSehir, $gelen_bankaUlke, $gelen_bankaSubeAdi, $gelen_bankaSubeKodu, $gelen_bankaParaBirimi, $gelen_bankaHesapSahibi, $gelen_bankaHesapNumarasi, $gelen_bankaHesapIban]);
                $eklemeSayisi = $sorgu_bankaHesabiEkle -> rowCount();
                if($eklemeSayisi > 0){
                    header("Location:index.php?SOAE=1&SOAI=6");
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabı Eklenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Banka Resmini Yükleyiniz.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Ekleyeceğiniz Bankanın Logosunu Sisteme Yükleyerek İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }

        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>