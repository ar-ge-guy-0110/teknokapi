<?php
    if(isset($_GET["AktivasyonKodu"])){
        $aktivasyonKodu = Guvenlik($_GET["AktivasyonKodu"]);
    }else{
        $aktivasyonKodu = "";
    }
    if(isset($_GET["EPosta"])){
        $eposta = Guvenlik($_GET["EPosta"]);
    }else{
        $eposta = "";
    }
    if(isset($_POST["Sifre"])){
        $gelen_sifre = Guvenlik($_POST["Sifre"]);
    }else{
        $gelen_sifre = "";
    }
    if(isset($_POST["SifreTekrari"])){
        $gelen_sifretekrar = $_POST["SifreTekrari"];
    }else{
        $gelen_sifretekrar = "";
    }
    $md5lisifre = md5($gelen_sifre);
    //echo $aktivasyonKodu . " AAA " . $eposta . " AAA " . $gelen_sifre . " AAA " . $gelen_sifretekrar;
    //die();

    if(($aktivasyonKodu != "") and ($eposta != "") and ($gelen_sifre != "") and ($gelen_sifretekrar != "")){
        $sorgu_kontrol = $veritaConn -> prepare("SELECT * FROM uyeler WHERE uye_email = ? AND uye_aktivasyon_kodu = ?");
        $sorgu_kontrol -> execute([$eposta, $aktivasyonKodu]);
        $sorgu_kontrol_satir_say = $sorgu_kontrol -> rowCount();
        if($sorgu_kontrol_satir_say > 0){
            if($gelen_sifre == $gelen_sifretekrar){
                $sorgu_uye_sifre_guncelle = $veritaConn -> prepare("UPDATE uyeler SET uye_sifre = ? WHERE uye_email = ? AND uye_aktivasyon_kodu = ? LIMIT 1");
                $sorgu_uye_sifre_guncelle -> execute([$md5lisifre, $eposta, $aktivasyonKodu]);
                $sorgu_uye_sifre_guncelle_satir_say = $sorgu_uye_sifre_guncelle -> rowCount();
                if($sorgu_uye_sifre_guncelle_satir_say > 0){
                    $_SESSION["mesaj_ana"] = "Tebrikler. Yeni Şifre Başarıyla Oluşturuldu.";
                    $_SESSION["mesaj_aciklama"] = "Üyeliğinize ait hesap şifreniz isteğiniz doğrultusunda güncellenmiştir.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";  
                    $_SESSION["resim_yolu"] = "resimler/tamam.png";
                    header("Location:index.php?SO=33");
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Yeni Şifre Oluşturulamadı.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";  
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana"] = "Dikkat. Üye şifre sıfırlama Formunda Eşleşmeyen Şifreler.";
                $_SESSION["mesaj_aciklama"] = "Üye şifre sıfırlama formu dahilinde yazmış olduğunuz şifreler eşleşmemektedir.";
                $_SESSION["mesaj_yonlendirme"] = "Üye 'Şifremi Unuttum' sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=35'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                header("Location:index.php?SO=33");
                exit();
            }

        }else{
            header("Location:index.php");
            exit();
        }
    }else{
        $_SESSION["mesaj_ana"] = "Dikkat. Üye şifre sıfırlama Formunda Eksik Veri Girişi.";
        $_SESSION["mesaj_aciklama"] = "Üye şifre sıfırlama formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
        $_SESSION["mesaj_yonlendirme"] = "Üye 'Şifremi Unuttum' sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=35'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu"] = "resimler/dikkat.png";
        header("Location:index.php?SO=33");
        exit();
    }
?>