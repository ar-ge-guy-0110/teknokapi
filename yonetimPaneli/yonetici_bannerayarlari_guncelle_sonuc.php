<?php
    namespace Verot\Upload;
    use PDO;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_bannerResmi = $_FILES["bannerResmi"];
        //
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if(isset($_POST["bannerAlani"])){
            $gelen_bannerAlani = Guvenlik($_POST["bannerAlani"]);
        }else{
            $gelen_bannerAlani = "";
        }
        if(isset($_POST["bannerAdi"])){
            $gelen_bannerAdi = Guvenlik($_POST["bannerAdi"]);
        }else{
            $gelen_bannerAdi = "";
        }
        if(($gelen_id != "") and ($gelen_bannerAlani != "") and ($gelen_bannerAdi != "")){
            $sorgu_bannerBilgileri = $veritaConn -> prepare("SELECT bannerResmi, bannerAlani FROM banner WHERE id = ?");
            $sorgu_bannerBilgileri -> execute([$gelen_id]);
            $resimSayisi = $sorgu_bannerBilgileri -> rowCount();
            if($resimSayisi > 0){
                $bannerBilgleri = $sorgu_bannerBilgileri -> fetch(PDO::FETCH_ASSOC);
                $bannerAlani = $bannerBilgleri["bannerAlani"];
                //resim turleri Ana Sayfa: 1065x80; Menü Altı: 250x500; Ürün Detay: 350x350
                switch($gelen_bannerAlani){
                    case "anasayfa":
                        $resim_genislik = 1065;
                        $resim_yukseklik = 80;
                        $gelen_bannerAlani = "Ana Sayfa";
                        break;
                    case "menualti":
                        $resim_genislik = 250;
                        $resim_yukseklik = 500;
                        $gelen_bannerAlani = "Menü Altı";
                        break;
                    case "urundetay":
                        $resim_genislik = 350;
                        $resim_yukseklik = 350;
                        $gelen_bannerAlani = "Ürün Detay";
                        break;
                    default:
                        $resim_genislik = 350;
                        $resim_yukseklik = 350;
                        break;
                }
            }
            if($gelen_bannerAlani == $bannerAlani){
                $sorgu_bannerGuncelle = $veritaConn -> prepare("UPDATE banner SET bannerAlani = ?, bannerAdi = ? WHERE id = ? LIMIT 1");
                $sorgu_bannerGuncelle -> execute([$gelen_bannerAlani, $gelen_bannerAdi, $gelen_id]);
                $guncellemeSayisi = $sorgu_bannerGuncelle -> rowCount();
                /*
                if($guncellemeSayisi > 0){
                    header("Location:index.php?SOAE=1&SOAI=6");
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabı Eklenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=10'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
                */
                if(($gelen_bannerResmi["name"] != "") and ($gelen_bannerResmi["type"] != "") and ($gelen_bannerResmi["tmp_name"] != "") and ($gelen_bannerResmi["error"] == 0) and ($gelen_bannerResmi["size"] > 0)){
                    $bannerResmiYolu = "../" . $bannerBilgleri["bannerResmi"];
                    unlink($bannerResmiYolu);

                    //eski resim silindi
                    /*
                    $sorgu_bankaResimYolu = $veritaConn -> prepare("SELECT BankaLogosu FROM banka_hesaplarimiz WHERE id = ? LIMIT 1");
                    $sorgu_bankaResimYolu -> execute([$gelen_id]);
                    $resimKontrol = $sorgu_bankaResimYolu -> rowCount();
                    $bankaResmi = $sorgu_bankaResimYolu -> fetch(PDO::FETCH_ASSOC);
                    $bankaResmiYolu = "../" . $bankaResmi["BankaLogosu"];
                    unlink($bankaResmiYolu);
                    */
                    //---------------------------------

                    //resim isimlendirme ve dizini
                    $resim_yeniAd = ResimAdiOlustur();
                    $resim_uzanti = substr($gelen_bannerResmi["name"], -4);
                    if($resim_uzanti == "jpeg")
                        $resim_uzanti = "." . $resim_uzanti;
                    //$resim_yeniAd = $resim_yeniAd . $resim_uzanti;
                    //$resim_dizini = $upload_resim_dizini . $resim_yeniAd;
                    //--------------------------------------------------------------

                    //yeni resim upload
                    $is_logoYukle = new Upload($_FILES["bannerResmi"], "tr-TR");
                    if($is_logoYukle -> uploaded){
                        $is_logoYukle -> mime_magic_check = true;
                        $is_logoYukle -> image_allowed = array("image/*");
                        $is_logoYukle -> file_overwrite = true;

                        $is_logoYukle -> image_convert = "png";
                        $is_logoYukle -> image_quality = 100;
                        $resimMime = $is_logoYukle -> image_convert;

                        $is_logoYukle -> image_background_color  = null;
                        $is_logoYukle -> image_resize = true;
                        $is_logoYukle -> image_x = $resim_genislik;
                        $is_logoYukle -> image_y = $resim_yukseklik;
                        $is_logoYukle -> file_new_name_body = $resim_yeniAd;
                        $resimIsmi = $is_logoYukle -> file_new_name_body . "." . $resimMime;
                        $resimDiziniForDB = "resimler/uimage/" . $resimIsmi;

                        $is_logoYukle -> process($upload_resim_dizini);
                        if($is_logoYukle -> processed){
                            $is_logoYukle -> clean();
                            $sorgu_resimYoluGuncelle = $veritaConn -> prepare("UPDATE banner SET bannerResmi = ? WHERE id = ? LIMIT 1");
                            $sorgu_resimYoluGuncelle -> execute([$resimDiziniForDB, $gelen_id]);
                            $resimDBGuncellemeKontrol = $sorgu_resimYoluGuncelle -> rowCount();
                        }else{
                            $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=22&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }
                    }
                    //-------------------------------------------------------------------------------------------------------------------------------------------------------------
                }
                header("Location:index.php?SOAE=1&SOAI=18");
                exit();
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Banner Resmi Boyutlarına Uygun Olmayan Banner Alanı Seçildi.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Seçtiğiniz Alana Uygun Boyutta Banner Resmi Yükleyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=22&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }

        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=22&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>