<?php
    if((isset($_SESSION["kullanici_email"]))){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_favoriSil = $veritaConn -> prepare("DELETE FROM uyeler_favoriler WHERE id = ? AND uye_id = ?");
            $sorgu_favoriSil -> execute([$gelen_id, $kullanici["id"]]);
            $favoriSil_sayi = $sorgu_favoriSil -> rowCount();

            if($favoriSil_sayi > 0){
                //$_SESSION["mesaj_ana"] = "Tebrikler. Favori Ürün Kaydı Başarıyla Silindi.";
                //$_SESSION["mesaj_aciklama"] = "Üyelik hesabınızdan daha önceden tanımlanmış olan favori ürün kaldırıldı.";
                //$_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                //$_SESSION["resim_yolu"] = "resimler/tamam.png";
                header("Location:index.php?SO=53"); // TAMAM
                exit();
            }else{
                $_SESSION["mesaj_ana"] = "Hata. Favori Ürün Kaydı Silinemedi.";
                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/hata.png";
                header("Location:index.php?SO=33"); // HATA
                exit();
            }
        }else{
            $_SESSION["mesaj_ana"] = "Hata. Favori Ürün Kaydı Silinemedi.";
            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/hata.png";
            header("Location:index.php?SO=33"); // HATA
            exit();
        }

    }else{
        header("Location:index.php");
        exit();
    }
?>