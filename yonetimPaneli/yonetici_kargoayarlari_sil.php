<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_kargoResimYolu = $veritaConn -> prepare("SELECT logo FROM kargo_firmalar WHERE id = ?");
            $sorgu_kargoResimYolu -> execute([$gelen_id]);
            $resimSayisi = $sorgu_kargoResimYolu -> rowCount();
            if($resimSayisi > 0){
                $kargoResimYolu = $sorgu_kargoResimYolu -> fetch(PDO::FETCH_ASSOC);
                $kargoResimYolu = "../" . $kargoResimYolu["logo"];

                $sorgu_kargoSil = $veritaConn -> prepare("DELETE FROM kargo_firmalar WHERE id = ?");
                $sorgu_kargoSil -> execute([$gelen_id]);
                $silmeSayisi = $sorgu_kargoSil -> rowCount();
                if($silmeSayisi > 0){
                    unlink($kargoResimYolu);
                    header("Location:index.php?SOAE=1&SOAI=12"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Kargo Firması Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=12'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Kargo Firması Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=12'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>