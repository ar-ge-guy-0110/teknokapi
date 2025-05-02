<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_POST["kullaniciAdi"])){
            $gelen_kullaniciAdi = Guvenlik($_POST["kullaniciAdi"]);
        }else{
            $gelen_kullaniciAdi = "";
        }
        if(isset($_POST["sifre"])){
            $gelen_sifre = Guvenlik($_POST["sifre"]);
        }else{
            $gelen_sifre = "";
        }
        if(isset($_POST["adiSoyadi"])){
            $gelen_adiSoyadi = Guvenlik($_POST["adiSoyadi"]);
        }else{
            $gelen_adiSoyadi = "";
        }
        if(isset($_POST["ePostaAdresi"])){
            $gelen_ePostaAdresi = Guvenlik($_POST["ePostaAdresi"]);
        }else{
            $gelen_ePostaAdresi = "";
        }
        if(isset($_POST["telNo"])){
            $gelen_telNo = Guvenlik($_POST["telNo"]);
        }else{
            $gelen_telNo = "";
        }
        if(($gelen_kullaniciAdi != "") and ($gelen_sifre != "") and ($gelen_adiSoyadi != "") and ($gelen_ePostaAdresi != "") and ($gelen_telNo != "")){
            //aynı eposta veya aynı kullanıcı adı veya aynı telefon olmamalı
            $bool_kullaniciAdiAyni = false;
            $bool_ePostaAdresiAyni = false;
            $bool_telNoAyni = false;
            $sorgu_bilgileriDenetle = $veritaConn -> prepare("SELECT kullaniciAdi, ePostaAdresi, telNo FROM yoneticiler WHERE kullaniciAdi = ? OR ePostaAdresi = ? OR telNo = ? LIMIT 1");
            $sorgu_bilgileriDenetle -> execute([$gelen_kullaniciAdi, $gelen_ePostaAdresi, $gelen_telNo]);
            $ayniSonucSayisi = $sorgu_bilgileriDenetle -> rowCount();
            if($ayniSonucSayisi > 0){
                $_SESSION["mesaj_ana_y"] = "Dikkat. Yönetici Eklenemedi.";
                $_SESSION["mesaj_aciklama_y"] = "";
                $ayniBilgiler = $sorgu_bilgileriDenetle -> fetch(PDO::FETCH_ASSOC);
                if($gelen_kullaniciAdi == $ayniBilgiler["kullaniciAdi"]){
                    $_SESSION["mesaj_aciklama_y"] .= "Aynı Kullanıcı Adı";
                    $bool_kullaniciAdiAyni = true;
                }
                if($gelen_ePostaAdresi == $ayniBilgiler["ePostaAdresi"]){
                    if($bool_kullaniciAdiAyni == true)
                        $_SESSION["mesaj_aciklama_y"] .= "<br />";
                    $_SESSION["mesaj_aciklama_y"] .= "Aynı E-Posta Adresi";
                    $bool_ePostaAdresiAyni = true;
                }
                if($gelen_telNo == $ayniBilgiler["telNo"]){
                    if(($bool_kullaniciAdiAyni == true) or ($bool_ePostaAdresiAyni == true))
                        $_SESSION["mesaj_aciklama_y"] .= "<br />";
                    $_SESSION["mesaj_aciklama_y"] .= "Aynı Telefon Numarası";
                    $bool_telNoAyni = true;
                }
                $_SESSION["mesaj_aciklama_y"] .= " Kullanılıyor.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=37'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }else{
                $md5Sifre = md5($gelen_sifre);
                $sorgu_yoneticiEkle = $veritaConn -> prepare("INSERT INTO yoneticiler(kullaniciAdi, sifre, adiSoyadi, ePostaAdresi, telNo) VALUES(?, ?, ?, ?, ?)");
                $sorgu_yoneticiEkle -> execute([$gelen_kullaniciAdi, $md5Sifre, $gelen_adiSoyadi, $gelen_ePostaAdresi, $gelen_telNo]);
                $eklemeSayisi = $sorgu_yoneticiEkle -> rowCount();
                if($eklemeSayisi > 0){
                    header("Location:index.php?SOAE=1&SOAI=36");
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Yönetici Eklenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=37'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=37'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>