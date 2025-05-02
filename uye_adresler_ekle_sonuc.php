<?php
    //CONTROL SESSION
    if(isset($_SESSION["kullanici_email"])){
        //CONTROL AND SECURE THE VALUES
        if(isset($_POST["IsimSoyisim"])){
            $gelen_isimSoyisim = Guvenlik($_POST["IsimSoyisim"]);
        }else{
            $gelen_isimSoyisim = "";
        }
        if(isset($_POST["Adres"])){
            $gelen_Adres = Guvenlik($_POST["Adres"]);
        }else{
            $gelen_Adres = "";
        }
        if(isset($_POST["Ilce"])){
            $gelen_Ilce = Guvenlik($_POST["Ilce"]);
        }else{
            $gelen_Ilce = "";
        }
        if(isset($_POST["Il"])){
            $gelen_Il = Guvenlik($_POST["Il"]);
        }else{
            $gelen_Il = "";
        }
        if(isset($_POST["Ulke"])){
            $gelen_Ulke = Guvenlik($_POST["Ulke"]);
        }else{
            $gelen_Ulke = "";
        }
        if(isset($_POST["TelNo"])){
            $gelen_TelNo = Guvenlik($_POST["TelNo"]);
        }else{
            $gelen_TelNo = "";
        }

        //CONTROL BIG PICTURE
        if(($gelen_isimSoyisim != "") and ($gelen_Adres != "") and ($gelen_Ilce != "") and ($gelen_Il != "") and ($gelen_Ulke != "") and ($gelen_TelNo != "")){
            $sorgu_uye_adresEkle = $veritaConn -> prepare("INSERT INTO uyeler_adresler (uye_id, tamisim, adres, ilce, il, ulke, telno) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sorgu_uye_adresEkle -> execute([$kullanici_id, $gelen_isimSoyisim, $gelen_Adres, $gelen_Ilce, $gelen_Il, $gelen_Ulke, $gelen_TelNo]);
            $sorgu_uye_adresEkle_kontrol = $sorgu_uye_adresEkle -> rowCount();

            if($sorgu_uye_adresEkle_kontrol > 0){
                $_SESSION["mesaj_ana"] = "Tebrikler. Adres Kaydı Başarıyla Eklendi.";
                $_SESSION["mesaj_aciklama"] = "Üye Hesabınıza Belirtmiş Olduğunuz Adres Kaydı Başarıyla Eklenmiştir.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/tamam.png";
                header("Location:index.php?SO=33"); //TAMAM
                exit();
            }else{
                $_SESSION["mesaj_ana"] = "Hata. Adres Kaydı Eklenemedi.";
                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/hata.png";
                header("Location:index.php?SO=33"); //HATA
                exit();
            }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Adres Kayıt Formunda Eksik Veri Girişi.";
            $_SESSION["mesaj_aciklama"] = "Adres Kayıt Formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/dikkat.png";
            header("Location:index.php?SO=33"); //BILGILER YOK
            exit();
        }
    }else{
        header("Location:index.php"); //SESSION YOK, KOTU KULLANICI
        exit();
    }
?>