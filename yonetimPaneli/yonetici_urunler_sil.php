<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id != ""){
            $sorgu_urunMenuIdSorgula = $veritaConn -> prepare("SELECT menuId FROM urunler WHERE id = ?");
            $sorgu_urunMenuIdSorgula -> execute([$gelen_id]);
            $sorguSayisi = $sorgu_urunMenuIdSorgula -> rowCount();
            if($sorguSayisi > 0){
                $urunMenuId = $sorgu_urunMenuIdSorgula -> fetch(PDO::FETCH_ASSOC);
                $urunMenuId = DonusumleriGeriDondur($urunMenuId["menuId"]);

                $sorgu_urunSil = $veritaConn -> prepare("UPDATE urunler SET urun_durum = ? WHERE id = ? LIMIT 1");
                $sorgu_urunSil -> execute([0, $gelen_id]);
                $sorguSayisi = $sorgu_urunSil -> rowCount();
                if($sorguSayisi > 0){
                    //ürünü sepetlerden temizle
                    $sorgu_sepetTemizle = $veritaConn -> prepare("DELETE FROM sepet WHERE urunId = ?");
                    $sorgu_sepetTemizle -> execute([$gelen_id]);
    
                    //favorilerden boşalt
                    $sorgu_favoriTemizle = $veritaConn -> prepare("DELETE FROM uyeler_favoriler WHERE urun_id = ?");
                    $sorgu_favoriTemizle -> execute([$gelen_id]);
    
                    //menulerden urun sayisini azalt
                    $sorgu_menuUrunSayisiGuncelle = $veritaConn -> prepare("UPDATE menuler SET urun_sayi = urun_sayi - ? WHERE id = ?");
                    $sorgu_menuUrunSayisiGuncelle -> execute([1, $urunMenuId]);
                    $sorguSayisi = $sorgu_menuUrunSayisiGuncelle -> rowCount();
                    if($sorguSayisi > 0){
                        header("Location:index.php?SOAE=1&SOAI=48");
                        exit();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Menü Ürün Sayısı Düşürülemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
    
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Ürün Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Ürün Silinemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Ürün Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>