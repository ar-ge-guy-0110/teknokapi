<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id != ""){
            $sorgu_uyeSil = $veritaConn -> prepare("UPDATE uyeler SET uye_silinme_durumu = ? WHERE id = ? LIMIT 1");
            $sorgu_uyeSil -> execute([1, $gelen_id]);
            $sorguSayisi = $sorgu_uyeSil -> rowCount();
            if($sorguSayisi > 0){
                //sepetini temizle
                $sorgu_uyeSepetSil = $veritaConn -> prepare("DELETE FROM sepet WHERE uyeId = ?");
                $sorgu_uyeSepetSil -> execute([$gelen_id]);

                //Varsa yorumları sil ve dolayısıyla ürün puanlarının yeniden yapılandır
                $sorgu_uyeYorumlari = $veritaConn -> prepare("SELECT * FROM yorumlar WHERE uye_id = ?");
                $sorgu_uyeYorumlari -> execute([$gelen_id]);
                $sorguSayisi = $sorgu_uyeYorumlari -> rowCount();
                if($sorguSayisi > 0){
                    $uyeYorumlari = $sorgu_uyeYorumlari -> fetchAll(PDO::FETCH_ASSOC);
                    foreach($uyeYorumlari as $yorum){
                        $yorumYapilanUrunId = $yorum["urun_id"];
                        $yorumPuan = $yorum["puan"];
                        $sorgu_urunPuanDusur = $veritaConn -> prepare("UPDATE urunler SET urun_toplamYorumPuani = urun_toplamYorumPuani - ?, urun_yorumSayisi = urun_yorumSayisi - ? WHERE id = ?");
                        $sorgu_urunPuanDusur -> execute([$yorumPuan, 1, $yorumYapilanUrunId]);
                        $sorguSayisi = $sorgu_urunPuanDusur -> rowCount();
                        if($sorguSayisi <= 0){
                            $_SESSION["mesaj_ana_y"] = "Hata. Üyenin Yorum Yaptığı Üründen Puan Düşürülemedi ve Yorumlar Silinemedi.";
                            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=42'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }
                    }
                    $sorgu_uyeYorumlariSil = $veritaConn -> prepare("DELETE FROM yorumlar WHERE uye_id = ?");
                    $sorgu_uyeYorumlariSil -> execute([$gelen_id]);
                    $sorguSayisi = $sorgu_uyeYorumlariSil -> rowCount();
                    if($sorguSayisi > 0){
                        header("Location:index.php?SOAE=1&SOAI=42"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Üyenin Yorumları Silinemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=42'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }else{
                    header("Location:index.php?SOAE=1&SOAI=42"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Üye Silinemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=42'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Üye Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=42'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>