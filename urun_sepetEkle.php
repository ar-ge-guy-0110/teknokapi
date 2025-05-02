<?php
    if(isset($_GET["id"])){
        $gelen_urunId = Guvenlik($_GET["id"]);
    }else{
        $gelen_urunId = "";
    }
    if(isset($_GET["id"])){
        $gelen_variantId = Guvenlik($_POST["variant"]);
    }else{
        $gelen_variantId = "";
    }

    //UYE GIRISI YAPILDI MI
    if(isset($_SESSION["kullanici_email"])){
        //ID BOS GELMEMELI
        if(($gelen_urunId != "") and ($gelen_variantId != "")){
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //KONTROL 0: Kullanicinin alacagi urunun variantinin stogu varmi
            $sorgu_variantStokKontrol = $veritaConn -> prepare("SELECT * FROM urunler_variantlar WHERE id = ? AND urun_id = ? LIMIT 1");
            $sorgu_variantStokKontrol -> execute([$gelen_variantId, $gelen_urunId]);
            $affectedRowCount = $sorgu_variantStokKontrol -> rowCount();
            if($affectedRowCount > 0){
                $affectedRowCount = 0;
                
                $urunVariantBilgileri = $sorgu_variantStokKontrol -> fetch(PDO::FETCH_ASSOC);
                $variantStokAdedi = $urunVariantBilgileri["variant_stokAdet"];
                if($variantStokAdedi > 0){
                    //KONTROL 1: Kullanicinin herhangi bir sepeti varmi
                    $sorgu_kullaniciSepetKontrol = $veritaConn -> prepare("SELECT * FROM sepet  WHERE uyeId = ? ORDER BY id DESC LIMIT 1");
                    $sorgu_kullaniciSepetKontrol -> execute([$kullanici_id]);
                    $kullaniciSepetSayisi = $sorgu_kullaniciSepetKontrol -> rowCount();
                    if($kullaniciSepetSayisi > 0){
                        //KONTROL 3: Kullanicinin Sepetine ekledigi urunun aynisi sepette varmi, varsa adedini yukselt yoksa yenisini koy
                        $sorgu_urunSepetKontrol = $veritaConn -> prepare("SELECT * FROM sepet  WHERE uyeId = ? AND urunId = ? AND variantId = ? LIMIT 1");
                        $sorgu_urunSepetKontrol -> execute([$kullanici_id, $gelen_urunId, $gelen_variantId]);
                        $urunSepetSayisi = $sorgu_urunSepetKontrol -> rowCount();
                        if($urunSepetSayisi > 0){
                            $urunSepeti = $sorgu_urunSepetKontrol -> fetch(PDO::FETCH_ASSOC);
                            $urununSepettekiMevcutAdedi = $urunSepeti["urunAdedi"];
                            $urununSepetIdsi            = $urunSepeti["id"];
                            $urununYeniAdedi            = $urununSepettekiMevcutAdedi + 1;
                            $sorgu_siparisUrunAdediGuncelle = $veritaConn -> prepare("UPDATE sepet SET urunAdedi = ? WHERE id = ? AND uyeId = ? AND urunId = ? AND variantId = ?");
                            $sorgu_siparisUrunAdediGuncelle -> execute([$urununYeniAdedi, $urununSepetIdsi, $kullanici_id, $gelen_urunId, $gelen_variantId]);
                            
                            $affectedRowCount = $sorgu_siparisUrunAdediGuncelle -> rowCount();
                            if($affectedRowCount > 0){
                                header("Location:index.php?SO=61");
                                exit();
                            }else{
                                $_SESSION["mesaj_ana"] = "Hata. Ürün Sepete Eklenemedi.";
                                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                                $_SESSION["resim_yolu"] = "resimler/hata.png";
                                header("Location:index.php?SO=33");
                                exit();
                            }
                        }else{
                            $sorgu_sepeteUrunEkle = $veritaConn -> prepare("INSERT INTO sepet(uyeId, urunId, variantId, urunAdedi) VALUES(?, ?, ?, ?)");
                            $sorgu_sepeteUrunEkle -> execute([$kullanici_id, $gelen_urunId, $gelen_variantId, 1]);
                            $urunEklemeSayisi = $sorgu_sepeteUrunEkle -> rowCount();
                            $sonIdDegeri = $veritaConn -> lastInsertId();
                            if($urunEklemeSayisi > 0){
                                $sorgu_siparisNumarasiGuncelle = $veritaConn -> prepare("UPDATE sepet SET sepetNumarasi = ? WHERE uyeId = ?");
                                $sorgu_siparisNumarasiGuncelle -> execute([$sonIdDegeri, $kullanici_id]);

                                $affectedRowCount = $sorgu_siparisNumarasiGuncelle -> rowCount();
                                if($affectedRowCount > 0){
                                    header("Location:index.php?SO=61");
                                    exit();
                                }else{
                                    $_SESSION["mesaj_ana"] = "Hata. Ürün Sepete Eklenemedi.";
                                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                                    header("Location:index.php?SO=33");
                                    exit();
                                }
                            }else{
                                $_SESSION["mesaj_ana"] = "Hata. Ürün Sepete Eklenemedi.";
                                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                                $_SESSION["resim_yolu"] = "resimler/hata.png";
                                header("Location:index.php?SO=33");
                                exit();
                            }
                        }
                    }else{
                        //KULLANICININ SEPETTE HERHANGI BIR URUNU  YOK

                        $sorgu_sepeteUrunEkle = $veritaConn -> prepare("INSERT INTO sepet(uyeId, urunId, variantId, urunAdedi) VALUES(?, ?, ?, ?)");
                        $sorgu_sepeteUrunEkle -> execute([$kullanici_id, $gelen_urunId, $gelen_variantId, 1]);
                        $urunEklemeSayisi = $sorgu_sepeteUrunEkle -> rowCount();
                        $sonIdDegeri = $veritaConn -> lastInsertId();
                        if($urunEklemeSayisi > 0){
                            $sorgu_siparisNumarasiGuncelle = $veritaConn -> prepare("UPDATE sepet SET sepetNumarasi = ? WHERE uyeId = ?");
                            $sorgu_siparisNumarasiGuncelle -> execute([$sonIdDegeri, $kullanici_id]);

                            $affectedRowCount = $sorgu_siparisNumarasiGuncelle -> rowCount();
                            if($affectedRowCount > 0){
                                header("Location:index.php?SO=61");
                                exit();
                            }else{
                                $_SESSION["mesaj_ana"] = "Hata. Ürün Sepete Eklenemedi.";
                                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                                $_SESSION["resim_yolu"] = "resimler/hata.png";
                                header("Location:index.php?SO=33");
                                exit();
                            }
                        }else{
                            $_SESSION["mesaj_ana"] = "Hata. Ürün Sepete Eklenemedi.";
                            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu"] = "resimler/hata.png";
                            header("Location:index.php?SO=33");
                            exit();
                        }
                    }
                }else{
                    $_SESSION["mesaj_ana"] = "Dikkat. Ürünün Varyant Stoğu Kalmadı.";
                    $_SESSION["mesaj_aciklama"] = "İstediğiniz ürünün seçtiğiniz varyantının stoğu bitmiş.";
                    $_SESSION["mesaj_yonlendirme"] = "Ürünün sayfasına dönmek için lütfen buraya <a href='index.php?SO=58&id=" . $gelen_urunId . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }else{
                header("Location:index.php");
                exit();
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }else{
            header("Location:index.php");
            exit();
        }
    }else{
        $_SESSION["mesaj_ana"] = "Dikkat. Sepete Ekleme İşlemi Durduruldu.";
        $_SESSION["mesaj_aciklama"] = "Sitemizden ürün satın alabilmek için üye olarak giriş yapmalısınız.";
        $_SESSION["mesaj_yonlendirme"] = "Ürünün sayfasına dönmek için lütfen buraya <a href='index.php?SO=58&id=" . $gelen_urunId . "'><b>tıklayınız.</b></a><br/>Üye olmak isterseniz lütfen buraya <a href=\"index.php?SO=22\"><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu"] = "resimler/dikkat.png";
        header("Location:index.php?SO=33");
        exit();
    }
?>