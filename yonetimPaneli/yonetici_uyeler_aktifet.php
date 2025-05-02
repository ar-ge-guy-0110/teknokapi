<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id != ""){
            $sorgu_uyeSil = $veritaConn -> prepare("UPDATE uyeler SET uye_silinme_durumu = ? WHERE id = ? LIMIT 1");
            $sorgu_uyeSil -> execute([0, $gelen_id]);
            $sorguSayisi = $sorgu_uyeSil -> rowCount();
            if($sorguSayisi > 0){
                header("Location:index.php?SOAE=1&SOAI=43"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Üye Aktif Edilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=43'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>