<?php
    namespace Verot\Upload;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_kargoFirmasiLogosu = $_FILES["kargoFirmasiLogosu"];
        //
        if(isset($_POST["kargoFirmasiAdi"])){
            $gelen_kargoFirmasiAdi = Guvenlik($_POST["kargoFirmasiAdi"]);
        }else{
            $gelen_kargoFirmasiAdi = "";
        }
        if(($gelen_kargoFirmasiAdi != "")){
            if(($gelen_kargoFirmasiLogosu["name"] != "") and ($gelen_kargoFirmasiLogosu["type"] != "") and ($gelen_kargoFirmasiLogosu["tmp_name"] != "") and ($gelen_kargoFirmasiLogosu["error"] == 0) and ($gelen_kargoFirmasiLogosu["size"] > 0)){
                //resim isimlendirme ve dizini
                $resim_yeniAd = ResimAdiOlustur();
                $resim_uzanti = substr($gelen_kargoFirmasiLogosu["name"], -4);
                if($resim_uzanti == "jpeg")
                    $resim_uzanti = "." . $resim_uzanti;
                //$resim_yeniAd = $resim_yeniAd . $resim_uzanti;
                //$resim_dizini = $upload_resim_dizini . $resim_yeniAd;
                //--------------------------------------------------------------
                $is_logoYukle = new Upload($_FILES["kargoFirmasiLogosu"], "tr-TR");
                if($is_logoYukle -> uploaded){
                    $is_logoYukle -> mime_magic_check = true;
                    $is_logoYukle -> image_allowed = array("image/*");
                    $is_logoYukle -> file_overwrite = true;

                    $is_logoYukle -> image_convert = "png";
                    $is_logoYukle -> image_quality = 100;
                    $resimMime = $is_logoYukle -> image_convert;

                    $is_logoYukle -> image_background_color  = null;
                    $is_logoYukle -> image_resize = true;
                    //$is_logoYukle -> image_x = 125;
                    $is_logoYukle -> image_ratio = true;
                    $is_logoYukle -> image_y = 30;
                    $is_logoYukle -> file_new_name_body = $resim_yeniAd;
                    $resimIsmi = $is_logoYukle -> file_new_name_body . "." . $resimMime;
                    $resimDiziniForDB = "resimler/uimage/" . $resimIsmi;

                    $is_logoYukle -> process($upload_resim_dizini);
                    if($is_logoYukle -> processed){
                        $is_logoYukle -> clean();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=13'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=13'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
                //-------------------------------------------------------------------------------------------------------------------------------------------------------------
                
                $sorgu_kargoFirmasiEkle = $veritaConn -> prepare("INSERT INTO kargo_firmalar(logo, ad) VALUES(?, ?)");
                $sorgu_kargoFirmasiEkle -> execute([$resimDiziniForDB, $gelen_kargoFirmasiAdi]);
                $eklemeSayisi = $sorgu_kargoFirmasiEkle -> rowCount();
                if($eklemeSayisi > 0){
                    header("Location:index.php?SOAE=1&SOAI=12");
                    exit();
                }else{
                    $_SESSION["mesaj_ana_y"] = "Hata. Kargo Firması Eklenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=13'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Kargo Firması Resmini Yükleyiniz.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Ekleyeceğiniz Firmanın Logosunu Sisteme Yükleyerek İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=13'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }

        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=13'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>