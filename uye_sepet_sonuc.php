<?php
    //STOK GUNCELLE
    //URUN SATISI ARTIR
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_POST["OdemeTuruSecimi"])){
            $gelen_odemeTuru = $_POST["OdemeTuruSecimi"];
        }else{
            $gelen_odemeTuru = "";
        }
        if(isset($_POST["TaksitSecimi"])){
            $gelen_taksitSecimi = $_POST["TaksitSecimi"];
        }else{
            $gelen_taksitSecimi = "";
        }

        if($gelen_odemeTuru != ""){
            switch($gelen_odemeTuru){
                case "Banka Havalesi":
                    $sorgu_alisverisSepeti = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.sepetNumarasi, sepet.uyeId, sepet.urunId, sepet.adresId, sepet.variantId, sepet.urunAdedi, sepet.kargoFirmasiSecimi, sepet.odemeSecimi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_kdvOrani, urunler.urun_variantBasligi, urunler.urun_kargoUcreti, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet, kargo_firmalar.logo AS kargo_logo, kargo_firmalar.ad AS kargo_ad, uyeler_adresler.tamisim AS adres_tamisim, uyeler_adresler.adres, uyeler_adresler.ilce AS adres_ilce, uyeler_adresler.il AS adres_il, uyeler_adresler.ulke AS adres_ulke, uyeler_adresler.telno AS adres_telno FROM sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id JOIN kargo_firmalar ON sepet.kargoFirmasiSecimi = kargo_firmalar.id JOIN uyeler_adresler ON sepet.adresId = uyeler_adresler.id WHERE sepet.uyeId = ?");
                    $sorgu_alisverisSepeti -> execute([$kullanici_id]);
                    $sepettekilerSayisi = $sorgu_alisverisSepeti -> rowCount();
                    if($sepettekilerSayisi > 0){
                        $sepettekiler = $sorgu_alisverisSepeti -> fetchAll(PDO::FETCH_ASSOC);
                        $sepetteToplamUrunFiyatHesap = 0;
                        $sepetteToplamUrunKargoFiyatHesap = 0;
                        $sepetteki_sepetNumarasi = "";
                        foreach($sepettekiler as $sepetteki){
                            //sepet
                            $sepetteki_id = $sepetteki["sepetId"];
                            $sepetteki_sepetNumarasi = $sepetteki["sepetNumarasi"];
                            $sepetteki_uyeId = $sepetteki["uyeId"];
                            $sepetteki_urunId = $sepetteki["urunId"];
                            $sepetteki_adresId = $sepetteki["adresId"];
                            $sepetteki_variantId = $sepetteki["variantId"];
                            $sepetteki_kargoFirmasiSecimi = $sepetteki["kargoFirmasiSecimi"];
                            $sepetteki_urunAdedi = $sepetteki["urunAdedi"];
                            $sepetteki_odemeSecimi = $sepetteki["odemeSecimi"];
                            $sepetteki_urun_kargoUcreti = $sepetteki["urun_kargoUcreti"];
                            //urunler
                            $sepetteki_urun_tur = $sepetteki["urun_tur"];
                            $sepetteki_urun_resimBir = $sepetteki["urun_resimBir"];
                            $sepetteki_urun_ad = $sepetteki["urun_ad"];
                            $sepetteki_urun_fiyat = $sepetteki["urun_fiyat"];
                            $sepetteki_urun_paraBirimi = $sepetteki["urun_paraBirimi"];
                            $sepetteki_urun_variantBasligi = $sepetteki["urun_variantBasligi"];
                            $sepetteki_urun_kdvOrani = $sepetteki["urun_kdvOrani"];
                            //urunler_variantlar
                            $sepetteki_variant_ad = $sepetteki["variant_ad"];
                            //$sepetteki_variant_stokAdet = $sepetteki["variant_stokAdet"];
                            //kargo_firmalar
                            $sepetteki_kargo_logo = $sepetteki["kargo_logo"];
                            $sepetteki_kargo_ad = $sepetteki["kargo_ad"];
                            //uyeler_adresler
                            $sepetteki_adres_tamisim = $sepetteki["adres_tamisim"];
                            $sepetteki_adres = $sepetteki["adres"];
                            $sepetteki_adres_ilce = $sepetteki["adres_ilce"];
                            $sepetteki_adres_il = $sepetteki["adres_il"];
                            $sepetteki_adres_ulke = $sepetteki["adres_ulke"];
                            $sepetteki_adresTumu = $sepetteki_adres . " " . $sepetteki_adres_ilce . " " . $sepetteki_adres_il . " " . $sepetteki_adres_ulke;
                            $sepetteki_adres_telno = $sepetteki["adres_telno"];

                            switch($sepetteki_urun_paraBirimi){
                                case "USD":
                                    //$hesapUrunFiyatBicim = FiyatBicimlendir($sepetteki_urun_fiyat * $kurUSD);
                                    $hesapUrunFiyat = ($sepetteki_urun_fiyat * $kurUSD) * $sepetteki_urunAdedi;
                                    $tekUrunFiyat = ($sepetteki_urun_fiyat * $kurUSD);
                                    $sepetteToplamUrunFiyatHesap += $hesapUrunFiyat;
                                    break;
                                case "EUR":
                                    //$hesapUrunFiyatBicim = FiyatBicimlendir($sepetteki_urun_fiyat * $kurEuro);
                                    $hesapUrunFiyat = ($sepetteki_urun_fiyat * $kurEuro) * $sepetteki_urunAdedi;
                                    $tekUrunFiyat = ($sepetteki_urun_fiyat * $kurEuro);
                                    $sepetteToplamUrunFiyatHesap += $hesapUrunFiyat;
                                    break;
                                default:
                                    //$hesapUrunFiyatBicim = FiyatBicimlendir($sepetteki_urun_fiyat);
                                    $hesapUrunFiyat = $sepetteki_urun_fiyat * $sepetteki_urunAdedi;
                                    $tekUrunFiyat = $sepetteki_urun_fiyat;
                                    $sepetteToplamUrunFiyatHesap += $hesapUrunFiyat;
                                    break;
                            }

                            $sepetteTekUrunKargoFiyatHesap = $sepetteki_urun_kargoUcreti * $sepetteki_urunAdedi;
                            $sepetteToplamUrunKargoFiyatHesap += $sepetteki_urun_kargoUcreti * $sepetteki_urunAdedi;
                            
                            $sorgu_siparisEkle = $veritaConn -> prepare("INSERT INTO siparisler(siparis_no, urun_id, urun_tur, uye_id, urun_ad, urun_fiyat, urun_kdvOrani, urun_siparisAdedi, siparis_toplamUrunFiyati, urun_kargoFirmasiSecimi, urun_kargoUcreti, urun_resimBir, urun_variantBasligi, urun_variantSecimi, siparis_adres_adiSoyadi, siparis_adres_detay, siparis_adres_telefon, siparisodemeSecimi, siparis_taksitSecimi, siparis_tarih, siparis_ipAdresi, urun_variantId) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $sorgu_siparisEkle -> execute([$sepetteki_sepetNumarasi, $sepetteki_urunId, $sepetteki_urun_tur, $sepetteki_uyeId, $sepetteki_urun_ad, $tekUrunFiyat, $sepetteki_urun_kdvOrani, $sepetteki_urunAdedi, $hesapUrunFiyat, $sepetteki_kargo_ad, $sepetteTekUrunKargoFiyatHesap, $sepetteki_urun_resimBir, $sepetteki_urun_variantBasligi, $sepetteki_variant_ad, $sepetteki_adres_tamisim, $sepetteki_adresTumu, $sepetteki_adres_telno, $gelen_odemeTuru, 0, $zamanDamgasi, $ip_adresi, $sepetteki_variantId]);
                            $eklemeSayisi = $sorgu_siparisEkle -> rowCount();
                            if($eklemeSayisi > 0){
                                $sorgu_islenenSepetteyiSil = $veritaConn -> prepare("DELETE FROM sepet WHERE id = ? AND uyeId = ? LIMIT 1");
                                $sorgu_islenenSepetteyiSil -> execute([$sepetteki_id, $sepetteki_uyeId]);

                                $sorgu_urunSatisSayisiArtir = $veritaConn -> prepare("UPDATE urunler SET urun_toplamSatisSayisi = (urun_toplamSatisSayisi + ?) WHERE id = ?");
                                $sorgu_urunSatisSayisiArtir -> execute([$sepetteki_urunAdedi, $sepetteki_urunId]);

                                $sorgu_satilanUrununStogunuGuncelle = $veritaConn -> prepare("UPDATE urunler_variantlar SET variant_stokAdet = (variant_stokAdet - ?) WHERE id = ? LIMIT 1");
                                $sorgu_satilanUrununStogunuGuncelle -> execute([$sepetteki_urunAdedi, $sepetteki_variantId]);

                            }else{
                                $_SESSION["mesaj_ana"] = "Hata. Sipariş Alınamadı.";
                                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                                $_SESSION["resim_yolu"] = "resimler/hata.png";
                                header("Location:index.php?SO=33");
                                exit();
                            }
                        }

                        if($sepetteToplamUrunFiyatHesap >= $ucretsizKargoBaraji){
                            $sorgu_kargoFiyatiBelirle = $veritaConn -> prepare("UPDATE siparisler SET urun_kargoUcreti = 0 WHERE uye_id = ? AND siparis_no = ?");
                            $sorgu_kargoFiyatiBelirle -> execute([$kullanici_id, $sepetteki_sepetNumarasi]);
                            $ToplamOdenecek = $sepetteToplamUrunFiyatHesap;
                        }else{
                            $ToplamOdenecek = $sepetteToplamUrunFiyatHesap + $sepetteToplamUrunKargoFiyatHesap;
                        }
                        
                        $_SESSION["mesaj_ana"] = "Tebrikler. Siparişiniz Başarıyla Alındı.";
                        $_SESSION["mesaj_aciklama"] = "İlgili birim ödemenizi kontrol ettikten sonra ürün / ürünleriniz kargoya teslim edilecektir.";
                        $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu"] = "resimler/tamam.png";
                        header("Location:index.php?SO=33"); //BAŞARILI
                        exit();
                    }else{
                        header("Location:index.php");
                        exit();
                    }
                    break;
                case "Kredi Kartı":
                    if(($gelen_taksitSecimi != "") and (($gelen_taksitSecimi >= 1) and ($gelen_taksitSecimi <= 9))){
                        $sorgu_sepetiGuncelle = $veritaConn -> prepare("UPDATE sepet SET odemeSecimi = ?, taksitSecimi = ? WHERE uyeId = ?");
                        $sorgu_sepetiGuncelle -> execute([$gelen_odemeTuru, $gelen_taksitSecimi, $kullanici_id]);
                        $guncellemeSayisi = $sorgu_sepetiGuncelle -> rowCount();
                        if($guncellemeSayisi > 0){
                            header("Location:index.php?SO=68");
                            exit();
                        }else{
                            header("Location:index.php");
                            exit();
                        }
                    }else{
                        header("Location:index.php");
                        exit();
                    }
                    break;
                default:
                    header("Location:index.php");
                    exit();
                    break;
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