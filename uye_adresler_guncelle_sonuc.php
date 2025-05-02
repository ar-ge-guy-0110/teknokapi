<?php
    /*
                $_SESSION["mesaj_ana"] = "Tebrikler. Adres Kaydı Başarıyla Güncellendi.";
                $_SESSION["mesaj_aciklama"] = "Üye Hesabınıza Belirtmiş Olduğunuz Adres Kaydı Başarıyla Güncellenmiştir.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/tamam.png";
                header("Location:index.php?SO=33"); //TAMAM
                exit();

                $_SESSION["mesaj_ana"] = "Hata. Adres Kaydı Güncellenemedi.";
                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/hata.png";
                header("Location:index.php?SO=33"); //HATA
                exit();

                $_SESSION["mesaj_ana"] = "Dikkat. Adres Kayıt Güncelleme Formunda Eksik Veri Girişi.";
                $_SESSION["mesaj_aciklama"] = "Adres Kayıt Güncelleme Formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                header("Location:index.php?SO=33"); //BILGILER YOK
                exit();
    */
    //CONTROL SESSION
    if(isset($_SESSION["kullanici_email"])){
        //CONTROL AND SECURE THE VALUES
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
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
        if(($gelen_id != "") and ($gelen_isimSoyisim != "") and ($gelen_Adres != "") and ($gelen_Ilce != "") and ($gelen_Il != "") and ($gelen_Ulke != "") and ($gelen_TelNo != "")){
            $sorgu_adres = $veritaConn -> prepare("SELECT * FROM uyeler_adresler WHERE id = ? AND uye_id = ? LIMIT 1");
            $sorgu_adres -> execute([$gelen_id, $kullanici_id]);
            $sorgu_adres_kontrol = $sorgu_adres -> rowCount();
            $uye_adres = $sorgu_adres -> fetch(PDO::FETCH_ASSOC);
            if($sorgu_adres_kontrol > 0){
                if(($gelen_isimSoyisim == $uye_adres['tamisim']) and ($gelen_Adres == $uye_adres['adres']) and ($gelen_Ilce == $uye_adres['ilce']) and ($gelen_Il == $uye_adres['il']) and ($gelen_Ulke == $uye_adres['ulke']) and ($gelen_TelNo == $uye_adres['telno'])){
                    $_SESSION["mesaj_ana"] = "Dikkat. Adres Kayıt Güncelleme Formunda Değişiklik Yok.";
                    $_SESSION["mesaj_aciklama"] = "Adres Kayıt Güncelleme Formu dahilinde hiçbir değişiklik yapılmadı.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                    header("Location:index.php?SO=33"); //BILGILER YOK
                    exit();
                }
            }
            
            $sorgu_uye_adresGuncelle = $veritaConn -> prepare("UPDATE uyeler_adresler SET tamisim = ?, adres = ?, ilce = ?, il = ?, ulke = ?, telno = ? WHERE id = ? AND uye_id = ?");
            $sorgu_uye_adresGuncelle -> execute([$gelen_isimSoyisim, $gelen_Adres, $gelen_Ilce, $gelen_Il, $gelen_Ulke, $gelen_TelNo, $gelen_id, $kullanici_id]);
            $sorgu_uye_adresGuncelle_kontrol = $sorgu_uye_adresGuncelle -> rowCount();

            if($sorgu_uye_adresGuncelle_kontrol > 0){
                $_SESSION["mesaj_ana"] = "Tebrikler. Adres Kaydı Başarıyla Güncellendi.";
                $_SESSION["mesaj_aciklama"] = "Üye Hesabınıza Belirtmiş Olduğunuz Adres Kaydı Başarıyla Güncellenmiştir.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/tamam.png";
                header("Location:index.php?SO=33"); //TAMAM
                exit();
            }else{
                $_SESSION["mesaj_ana"] = "Hata. Adres Kaydı Güncellenemedi.";
                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/hata.png";
                header("Location:index.php?SO=33"); //HATA
                exit();
            }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Adres Kayıt Güncelleme Formunda Eksik Veri Girişi.";
            $_SESSION["mesaj_aciklama"] = "Adres Kayıt Güncelleme Formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
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