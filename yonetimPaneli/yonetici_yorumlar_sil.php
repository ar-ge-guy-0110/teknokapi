<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id != ""){
            //yorum sil ve dolayısıyla ürün puanlarının yeniden yapılandır
            $sorgu_uyeYorum = $veritaConn -> prepare("SELECT * FROM yorumlar WHERE id = ?");
            $sorgu_uyeYorum -> execute([$gelen_id]);
            $sorguSayisi = $sorgu_uyeYorum -> rowCount();
            if($sorguSayisi > 0){
                $yorum = $sorgu_uyeYorum -> fetch(PDO::FETCH_ASSOC);
                $yorumYapilanUrunId = $yorum["urun_id"];
                $yorumPuan = $yorum["puan"];
                $sorgu_urunPuanDusur = $veritaConn -> prepare("UPDATE urunler SET urun_toplamYorumPuani = urun_toplamYorumPuani - ?, urun_yorumSayisi = urun_yorumSayisi - ? WHERE id = ?");
                $sorgu_urunPuanDusur -> execute([$yorumPuan, 1, $yorumYapilanUrunId]);
                $sorguSayisi = $sorgu_urunPuanDusur -> rowCount();
                if($sorguSayisi <= 0){
                    $_SESSION["mesaj_ana_y"] = "Hata. Üyenin Yorum Yaptığı Üründen Puan Düşürülemedi ve Yorumlar Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=46'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }else{
                    $sorgu_yorumSil = $veritaConn -> prepare("DELETE FROM yorumlar WHERE id = ? LIMIT 1");
                    $sorgu_yorumSil -> execute([$gelen_id]);
                    $silmeSayisi = $sorgu_yorumSil -> rowCount();
                    if($silmeSayisi > 0){
                        header("Location:index.php?SOAE=1&SOAI=46"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Yorum Silinemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=46'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Yorum Silinemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=46'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Yorum Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=46'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>