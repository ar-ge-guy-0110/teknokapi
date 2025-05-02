<?php
    //CONTROL SESSION
    if(isset($_SESSION["kullanici_email"])){
        //CONTROL VALUES
        if(isset($_POST["EpostaAdresi"])){
            $gelen_email = Guvenlik($_POST["EpostaAdresi"]);
        }else{
            $gelen_email = "";
        }
        if(isset($_POST["Sifre"])){
            $gelen_sifre = Guvenlik($_POST["Sifre"]);
        }else{
            $gelen_sifre = "";
        }
        if(isset($_POST["SifreTekrar"])){
            $gelen_sifretekrar = Guvenlik($_POST["SifreTekrar"]);

        }else{
            $gelen_sifretekrar = "";
        }
        if(isset($_POST["IsimSoyisim"])){
            $gelen_tamisim = Guvenlik($_POST["IsimSoyisim"]);
        }else{
            $gelen_tamisim = "";
        }
        if(isset($_POST["TelefonNumarasi"])){
            $gelen_telno = Guvenlik($_POST["TelefonNumarasi"]);
        }else{
            $gelen_telno = "";
        }
        if(isset($_POST["Cinsiyet"])){
            $gelen_cinsiyet = Guvenlik($_POST["Cinsiyet"]);
        }else{
            $gelen_cinsiyet = "";
        }

        //CONTROL BIG PICTURE
        if(($gelen_email != "") and ($gelen_sifre != "") and ($gelen_sifretekrar != "") and ($gelen_tamisim != "") and ($gelen_telno != "") and ($gelen_cinsiyet != "")){
            if(($gelen_email == $kullanici_email) and ($gelen_sifre == "eskisifre") and ($gelen_sifretekrar == "eskisifre") and ($gelen_tamisim == $kullanici_tamisim) and ($gelen_telno == $kullanici_telno) and ($gelen_cinsiyet == $kullanici_cinsiyet)){
                $_SESSION["mesaj_ana"] = "Dikkat. Üye Bilgileri Güncelleme Formunda Değişiklik Yok.";
                $_SESSION["mesaj_aciklama"] = "Üye Bilgileri Güncelleme Formu dahilinde hiçbir değişiklik yapılmadı.";
                $_SESSION["mesaj_yonlendirme"] = "Üye Bilgileri Güncelleme Formu' na dönmek için lütfen buraya <a href='index.php?SO=41'><b>tıklayınız.</b></a> <br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                header("Location:index.php?SO=33"); // HİCBİR DEGİSİKLİK YOK
                exit();
            }
            $sifre_degistir = false;
            $md5lisifre = 0;
            if($gelen_sifre != $gelen_sifretekrar){
                $_SESSION["mesaj_ana"] = "Dikkat. Üye Bilgileri Güncelleme Formunda Eşleşmeyen Şifreler.";
                $_SESSION["mesaj_aciklama"] = "Üye Bilgileri Güncelleme Formu dahilinde yazmış olduğunuz şifreler eşleşmemektedir.";
                $_SESSION["mesaj_yonlendirme"] = "Üye Bilgileri Güncelleme Formu' na dönmek için lütfen buraya <a href='index.php?SO=41'><b>tıklayınız.</b></a> <br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                header("Location:index.php?SO=33"); // ESLESMEYEN SIFRELER
                exit();
            }else{
                if($gelen_sifre != "eskisifre"){
                    $sifre_degistir = true;
                    $md5lisifre = md5($gelen_sifre);
                }
                if(($gelen_email != $kullanici_email) or ($gelen_telno != $kullanici_telno)){
                    $sorgu_kullanici_kontrol = $veritaConn -> prepare("SELECT uye_email, uye_telno, id FROM uyeler WHERE (uye_email = ? OR uye_telno = ?) AND (id <> ?)");
                    $sorgu_kullanici_kontrol -> execute([$gelen_email, $gelen_telno, $kullanici_id]);
                    $kullanicisayisi = $sorgu_kullanici_kontrol -> rowCount();
                    if($kullanicisayisi > 0){
                        $_SESSION["mesaj_ana"] = "Dikkat. Üye Bilgileri Güncelleme Formunda Tekrarlanan Veri Girişi.";
                        $_SESSION["mesaj_aciklama"] = "Üye Bilgileri Güncelleme Formu dahilinde belirtmiş olduğunuz bilgilere ait başka bir kullanıcı bulundu.";
                        $_SESSION["mesaj_yonlendirme"] = "Üye Bilgileri Güncelleme Formu' na dönmek için lütfen buraya <a href='index.php?SO=41'><b>tıklayınız.</b></a> <br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                        header("Location:index.php?SO=33"); // EMAIL VEYA TELNO KULLANILIYOR
                        exit();
                    }
                }

                if($sifre_degistir == true){
                    $sorgu_kullanici_hesap_guncelle = $veritaConn -> prepare("UPDATE uyeler SET uye_email = ?, uye_sifre = ?, uye_tamisim =  ?, uye_telno = ?, uye_cinsiyet = ? WHERE id = ? LIMIT 1");
                    $sorgu_kullanici_hesap_guncelle -> execute([$gelen_email, $md5lisifre, $gelen_tamisim, $gelen_telno, $gelen_cinsiyet, $kullanici_id]);
                }else{
                    $sorgu_kullanici_hesap_guncelle = $veritaConn -> prepare("UPDATE uyeler SET uye_email = ?, uye_tamisim = ?, uye_telno = ?, uye_cinsiyet = ? WHERE id = ? LIMIT 1");
                    $sorgu_kullanici_hesap_guncelle -> execute([$gelen_email, $gelen_tamisim, $gelen_telno, $gelen_cinsiyet, $kullanici_id]);
                }
                $sorgu_kullanici_hesap_guncelle_kontrol = $sorgu_kullanici_hesap_guncelle -> rowCount();
                if($sorgu_kullanici_hesap_guncelle_kontrol > 0){
                    $_SESSION["kullanici_email"] = $gelen_email;
                    RefreshUserSession();
                    $_SESSION["mesaj_ana"] = "Tebrikler. Üye Hesabı Bilgileriniz Başarıyla Güncellendi.";
                    $_SESSION["mesaj_aciklama"] = "Yeni bilgileriniz sistem üzerinde güncellenmiştir.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/tamam.png";
                    header("Location:index.php?SO=33"); //BAŞARILI
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Üye Hesabı Bilgileri Güncellenemedi.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33"); // HATA
                    exit();
                }
            }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Üye Bilgileri Güncelleme Formunda Eksik Veri Girişi.";
            $_SESSION["mesaj_aciklama"] = "Üye Bilgileri Güncelleme Formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Üye Bilgileri Güncelleme Formu' na dönmek için lütfen buraya <a href='index.php?SO=41'><b>tıklayınız.</b></a> <br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/dikkat.png";
            header("Location:index.php?SO=33"); //BILGILER YOK
            exit();
        }
    }else{
        header("Location:index.php"); //SESSION YOK, KOTU KULLANICI
        exit();
    }
?>