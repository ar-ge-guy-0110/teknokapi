<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_POST["urunTuru"])){
            $gelen_urunTuru = Guvenlik($_POST["urunTuru"]);
        }else{
            $gelen_urunTuru = "";
        }
        if(isset($_POST["menuAdi"])){
            $gelen_menuAdi = Guvenlik($_POST["menuAdi"]);
        }else{
            $gelen_menuAdi = "";
        }
        if(($gelen_urunTuru != "") and ($gelen_menuAdi != "")){
            switch($gelen_urunTuru){
                case "kolye":
                    $gelen_urunTuru = "Kolye";
                    break;
                case "takiseti":
                    $gelen_urunTuru = "Takı Seti";
                    break;
                case "bileklik":
                    $gelen_urunTuru = "Bileklik";
                    break;
                default:
                    break;
            }
            $sorgu_menuEkle = $veritaConn -> prepare("INSERT INTO menuler(urun_tur, menu_ad) VALUES(?, ?)");
            $sorgu_menuEkle -> execute([$gelen_urunTuru, $gelen_menuAdi]);
            $eklemeSayisi = $sorgu_menuEkle -> rowCount();
            if($eklemeSayisi > 0){
                header("Location:index.php?SOAE=1&SOAI=30");
                exit();
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Menü Eklenemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=31'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=31'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>