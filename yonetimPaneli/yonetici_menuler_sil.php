<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id != ""){
            //en az iki aynı ürün türünde menu olmalidir silme islemi icin.
            $sorgu_menuIdBul = $veritaConn -> prepare("SELECT id, urun_tur FROM menuler WHERE id != ? AND urun_tur = (SELECT urun_tur FROM menuler WHERE id = ? LIMIT 1) ORDER BY id DESC;");
            $sorgu_menuIdBul -> execute([$gelen_id, $gelen_id]);
            $sorguSayisi = $sorgu_menuIdBul -> rowCount();
            if($sorguSayisi > 1){
                $enSonEklenenMenuId = $sorgu_menuIdBul -> fetch(PDO::FETCH_ASSOC);
                $enSonEklenenMenuId = $enSonEklenenMenuId["id"];

                $sorgu_menuSil = $veritaConn -> prepare("DELETE FROM menuler WHERE id = ?");
                $sorgu_menuSil -> execute([$gelen_id]);
                $silmeSayisi = $sorgu_menuSil -> rowCount();
                if($silmeSayisi > 0){
                    //bagil ürünleri bul ve durumu 0 la
                    $sorgu_bagilUrunleriBul = $veritaConn -> prepare("SELECT id FROM urunler WHERE menuId = ?");
                    $sorgu_bagilUrunleriBul -> execute([$gelen_id]);
                    $bulunanUrunSayisi = $sorgu_bagilUrunleriBul -> rowCount();
                    if($bulunanUrunSayisi > 0){
                        $menuyeBagliUrunler = $sorgu_bagilUrunleriBul -> fetchAll(PDO::FETCH_ASSOC);
    
                        $sorgu_bagilUrunleriEtkisizlestir = $veritaConn -> prepare("UPDATE urunler SET urun_durum = ? WHERE menuId = ?");
                        $sorgu_bagilUrunleriEtkisizlestir -> execute([0, $gelen_id]);
                        $sorguSayisi = $sorgu_bagilUrunleriEtkisizlestir -> rowCount();
                        if($sorguSayisi > 0){
                            foreach($menuyeBagliUrunler as $menuyeBagliUrun){
                                $urunId = $menuyeBagliUrun["id"];
                                
                                //ürünü sepetlerden temizle
                                $sorgu_sepetTemizle = $veritaConn -> prepare("DELETE FROM sepet WHERE urunId = ?");
                                $sorgu_sepetTemizle -> execute([$urunId]);
                
                                //favorilerden boşalt
                                $sorgu_favoriTemizle = $veritaConn -> prepare("DELETE FROM uyeler_favoriler WHERE urun_id = ?");
                                $sorgu_favoriTemizle -> execute([$urunId]);
    
                                //ürüne varolan bir menuid ver
                                $sorgu_menuidVer = $veritaConn -> prepare("UPDATE urunler SET menuId = ? WHERE id = ?");
                                $sorgu_menuidVer -> execute([$enSonEklenenMenuId, $urunId]);
                            }
                            header("Location:index.php?SOAE=1&SOAI=30"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }else{
                            $_SESSION["mesaj_ana_y"] = "Hata. Silinen Menüye Bağlı Ürünler Etkisizleştirilemedi.";
                            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=30'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }
                    }else{
                        header("Location:index.php?SOAE=1&SOAI=30"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Menü Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=30'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Menü Silinemedi.";
                $_SESSION["mesaj_aciklama_y"] = "Silme İşlemi İçin Halihazırda Bulunan En Az 2 Aynı Ürün Türünde Menü Bulunmalıdır. Lütfen Sisteme 1 Adet Aynı Ürün Türünde Menü Ekleyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=30'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Menü Silinemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=30'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>