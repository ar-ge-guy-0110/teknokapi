<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_bannerResimYolu = $veritaConn -> prepare("SELECT bannerResmi FROM banner WHERE id = ?");
            $sorgu_bannerResimYolu -> execute([$gelen_id]);
            $resimSayisi = $sorgu_bannerResimYolu -> rowCount();
            if($resimSayisi > 0){
                $bannerResimYolu = $sorgu_bannerResimYolu -> fetch(PDO::FETCH_ASSOC);
                $bannerResimYolu = "../" . $bannerResimYolu["bannerResmi"];

                $sorgu_bannerSil = $veritaConn -> prepare("DELETE FROM banner WHERE id = ?");
                $sorgu_bannerSil -> execute([$gelen_id]);
                $silmeSayisi = $sorgu_bannerSil -> rowCount();
                if($silmeSayisi > 0){
                    unlink($bannerResimYolu);
                    header("Location:index.php?SOAE=1&SOAI=18"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Banner Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=18'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Banner Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=18'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>