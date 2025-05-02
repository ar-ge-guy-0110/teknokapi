<?php
    if(empty($_SESSION["kullanici_Yonetici"])){

        //SITE MESAJ SESSIONLARI
        $_SESSION["mesaj_ana_y"] = "";
        $_SESSION["mesaj_aciklama_y"] = "";
        $_SESSION["mesaj_yonlendirme_y"] = "";
        $_SESSION["resim_yolu_y"] = "";
        //


        if(isset($_POST["yKullanici"])){
            $gelen_yKullanici = Guvenlik($_POST["yKullanici"]);
        }else{
            $gelen_yKullanici = "";
        }
        if(isset($_POST["ySifre"])){
            $gelen_ySifre = Guvenlik($_POST["ySifre"]);
        }else{
            $gelen_ySifre = "";
        }

        if(($gelen_yKullanici != "") and ($gelen_ySifre != "")){
            $md5lisifre = md5($gelen_ySifre);

            $sorgu_kullanici_kontrol = $veritaConn -> prepare("SELECT * FROM yoneticiler WHERE kullaniciAdi = ? AND sifre = ?");
            $sorgu_kullanici_kontrol -> execute([$gelen_yKullanici, $md5lisifre]);
            $kullanicisayisi = $sorgu_kullanici_kontrol -> rowCount();
            $kullanici_kayit = $sorgu_kullanici_kontrol -> fetch(PDO::FETCH_ASSOC);

            if($kullanicisayisi > 0){

                $_SESSION["kullanici_Yonetici"] = $gelen_yKullanici;
                if($_SESSION["kullanici_Yonetici"] == $gelen_yKullanici){
                    //GIRIŞ YAP-------------------------------------------------------------------------------------------- HERE!!!
                    header("Location:index.php?SOAE=1");
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Yönetici Girişi Yapılamadı.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Yönetici giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SOAE=0'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=3");
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Eşleşen Yönetici Kaydı Bulunamadı.";
                $_SESSION["mesaj_aciklama_y"] = "Yönetici giriş formu dahilinde yazmış olduğunuz bilgiler ile eşleşen herhangi bir kayıt bulunamadı.";
                $_SESSION["mesaj_yonlendirme_y"] = "Yönetici giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SOAE=0'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/bilinmeyen.png";
                header("Location:index.php?SOAE=3");
                exit();
            }
        }else{
            header("Location:index.php?SOAE=0");
            exit();
        }
    }else{
        header("Location:index.php?SOAE=1");
        exit();
    }
?>