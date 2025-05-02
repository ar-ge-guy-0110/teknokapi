<?php
    namespace Verot\Upload;
    use PDO;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //FILE
        $gelen_kargoFirmasiLogosu = $_FILES["kargoFirmasiLogosu"];
        //
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if(isset($_POST["kargoFirmasiAdi"])){
            $gelen_kargoFirmasiAdi = Guvenlik($_POST["kargoFirmasiAdi"]);
        }else{
            $gelen_kargoFirmasiAdi = "";
        }
        if(($gelen_id != "") and ($gelen_kargoFirmasiAdi != "")){
            $sorgu_kargoFirmasiGuncelle = $veritaConn -> prepare("UPDATE kargo_firmalar SET ad = ? WHERE id = ? LIMIT 1");
            $sorgu_kargoFirmasiGuncelle -> execute([$gelen_kargoFirmasiAdi, $gelen_id]);
            $guncellemeSayisi = $sorgu_kargoFirmasiGuncelle -> rowCount();
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
            if(($gelen_kargoFirmasiLogosu["name"] != "") and ($gelen_kargoFirmasiLogosu["type"] != "") and ($gelen_kargoFirmasiLogosu["tmp_name"] != "") and ($gelen_kargoFirmasiLogosu["error"] == 0) and ($gelen_kargoFirmasiLogosu["size"] > 0)){
                $sorgu_kargoFirmasiResimYolu = $veritaConn -> prepare("SELECT logo FROM kargo_firmalar WHERE id = ?");
                $sorgu_kargoFirmasiResimYolu -> execute([$gelen_id]);
                $resimSayisi = $sorgu_kargoFirmasiResimYolu -> rowCount();
                if($resimSayisi > 0){
                    $kargoFirmasiResimYolu = $sorgu_kargoFirmasiResimYolu -> fetch(PDO::FETCH_ASSOC);
                    $kargoFirmasiResimYolu = "../" . $kargoFirmasiResimYolu["logo"];
                    unlink($kargoFirmasiResimYolu);
                }
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
                $resim_uzanti = substr($gelen_kargoFirmasiLogosu["name"], -4);
                if($resim_uzanti == "jpeg")
                    $resim_uzanti = "." . $resim_uzanti;
                //$resim_yeniAd = $resim_yeniAd . $resim_uzanti;
                //$resim_dizini = $upload_resim_dizini . $resim_yeniAd;
                //--------------------------------------------------------------

                //yeni resim upload
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
                        $sorgu_logoYoluGuncelle = $veritaConn -> prepare("UPDATE kargo_firmalar SET logo = ? WHERE id = ? LIMIT 1");
                        $sorgu_logoYoluGuncelle -> execute([$resimDiziniForDB, $gelen_id]);
                        $resimDBGuncellemeKontrol = $sorgu_logoYoluGuncelle -> rowCount();
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Güncellenemedi.";
                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=16&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
                //-------------------------------------------------------------------------------------------------------------------------------------------------------------
            }
            header("Location:index.php?SOAE=1&SOAI=12");
            exit();
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=16'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>