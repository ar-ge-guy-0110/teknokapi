<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_havaleBildirimiVarmi = $veritaConn -> prepare("SELECT id FROM havale_bildirimleri WHERE banka_id = ?");
            $sorgu_havaleBildirimiVarmi -> execute([$gelen_id]);
            $havaleSayisi = $sorgu_havaleBildirimiVarmi -> rowCount();
            if($havaleSayisi == 0){
                $sorgu_bankaResimYolu = $veritaConn -> prepare("SELECT BankaLogosu FROM banka_hesaplarimiz WHERE id = ?");
                $sorgu_bankaResimYolu -> execute([$gelen_id]);
                $resimSayisi = $sorgu_bankaResimYolu -> rowCount();
                if($resimSayisi > 0){
                    $bankaResimYolu = $sorgu_bankaResimYolu -> fetch(PDO::FETCH_ASSOC);
                    $bankaResimYolu = "../" . $bankaResimYolu["BankaLogosu"];
    
                    $sorgu_bankaSil = $veritaConn -> prepare("DELETE FROM banka_hesaplarimiz WHERE id = ?");
                    $sorgu_bankaSil -> execute([$gelen_id]);
                    $silmeSayisi = $sorgu_bankaSil -> rowCount();
                    if($silmeSayisi > 0){
                        unlink($bankaResimYolu);
                        header("Location:index.php?SOAE=1&SOAI=6"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabı Silinemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=6'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Bu Banka İçin ". $havaleSayisi . " Havale Bildirimi Mevcut.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Havale Bildirimlerini Karşılayınız ve İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=6'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabı Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=6'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>