<?php
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_GET["id"])){
            $gelen_urunId = Guvenlik($_GET["id"]);
        }else{
            $gelen_urunId = "";
        }

        if($gelen_urunId != ""){
            //UYE BU URUNU DAHA ONCE FAVORILERINE EKLEDIMI
            $sorgu_favoriKontrol = $veritaConn -> prepare("SELECT urun_id FROM uyeler_favoriler WHERE urun_id = ? AND uye_id = ? LIMIT 1");
            $sorgu_favoriKontrol -> execute([$gelen_urunId, $kullanici_id]);
            $etkilenenSayisi = $sorgu_favoriKontrol -> rowCount();
            if($etkilenenSayisi <= 0){
                $etkilenenSayisi = 0;
                $sorgu_urunuFavorile = $veritaConn -> prepare("INSERT INTO uyeler_favoriler(urun_id, uye_id) VALUES(?, ?)");
                $sorgu_urunuFavorile -> execute([$gelen_urunId, $kullanici_id]);
                $etkilenenSayisi = $sorgu_urunuFavorile -> rowCount();
    
                if($etkilenenSayisi > 0){
                    $_SESSION["mesaj_ana"] = "Tebrikler. Ürün Favorilere Başarıyla Eklendi.";
                    $_SESSION["mesaj_aciklama"] = "İlgili ürünü favorilerinize eklediğiniz için teşekkür ederiz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ürünün sayfasına dönmek için lütfen buraya <a href='index.php?SO=58&id=" . $gelen_urunId . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/tamam.png";
                    header("Location:index.php?SO=33");
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Ürün Favorilerinize Eklenemedi.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ürünün sayfasına dönmek için lütfen buraya <a href='index.php?SO=58&id=" . $gelen_urunId . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana"] = "Dikkat. Bu Ürünü Daha Önce Favorilerinize Eklemişsiniz.";
                $_SESSION["mesaj_aciklama"] = "Bu ürün zaten favorilerinizde.";
                $_SESSION["mesaj_yonlendirme"] = "Ürünün sayfasına dönmek için lütfen buraya <a href='index.php?SO=58&id=" . $gelen_urunId . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                header("Location:index.php?SO=33");
                exit();
            }
        }else{
            header("Location:index.php");
            exit();
        }
    }else{
        header("Location:index.php");
        exit();
    }
?>