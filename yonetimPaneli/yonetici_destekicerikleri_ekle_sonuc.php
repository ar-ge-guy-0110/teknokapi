<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_POST["soru"])){
            $gelen_soru = Guvenlik($_POST["soru"]);
        }else{
            $gelen_soru = "";
        }
        if(isset($_POST["cevap"])){
            $gelen_cevap = Guvenlik($_POST["cevap"]);
        }else{
            $gelen_cevap = "";
        }
        if(($gelen_soru != "") and ($gelen_cevap != "")){
            $sorgu_soruEkle = $veritaConn -> prepare("INSERT INTO sorular(soru, cevap) VALUES(?, ?)");
            $sorgu_soruEkle -> execute([$gelen_soru, $gelen_cevap]);
            $eklemeSayisi = $sorgu_soruEkle -> rowCount();
            if($eklemeSayisi > 0){
                header("Location:index.php?SOAE=1&SOAI=24");
                exit();
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Destek İçeriği Eklenemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=25'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=25'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>