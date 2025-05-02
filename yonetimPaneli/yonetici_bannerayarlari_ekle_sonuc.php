<?php
    namespace Verot\Upload;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_bannerResmi = $_FILES["bannerResmi"];
        //
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
        if(($gelen_bannerAlani != "") and ($gelen_bannerAdi != "")){
            if(($gelen_bannerResmi["name"] != "") and ($gelen_bannerResmi["type"] != "") and ($gelen_bannerResmi["tmp_name"] != "") and ($gelen_bannerResmi["error"] == 0) and ($gelen_bannerResmi["size"] > 0)){
                //resim isimlendirme ve dizini
                $resim_yeniAd = ResimAdiOlustur();
                $resim_uzanti = substr($gelen_bannerResmi["name"], -4);
                if($resim_uzanti == "jpeg")
                    $resim_uzanti = "." . $resim_uzanti;
                //$resim_yeniAd = $resim_yeniAd . $resim_uzanti;
                //$resim_dizini = $upload_resim_dizini . $resim_yeniAd;
                //--------------------------------------------------------------
                $is_logoYukle = new Upload($_FILES["bannerResmi"], "tr-TR");
                if($is_logoYukle -> uploaded){
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
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=19'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=19'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
                //-------------------------------------------------------------------------------------------------------------------------------------------------------------
                
                $sorgu_bannerEkle = $veritaConn -> prepare("INSERT INTO banner(bannerAlani, bannerAdi, bannerResmi) VALUES(?, ?, ?)");
                $sorgu_bannerEkle -> execute([$gelen_bannerAlani, $gelen_bannerAdi, $resimDiziniForDB]);
                $eklemeSayisi = $sorgu_bannerEkle -> rowCount();
                if($eklemeSayisi > 0){
                    header("Location:index.php?SOAE=1&SOAI=18");
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Banner Eklenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=19'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Banner Resmini Yükleyiniz.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Ekleyeceğiniz Banner'in Resmini Sisteme Yükleyerek İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=19'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }

        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=19'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>