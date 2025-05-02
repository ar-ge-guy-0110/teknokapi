<?php
    namespace Verot\Upload;
    use PDO;
    if(isset($_SESSION["kullanici_Yonetici"])){
        //normal params
        $boolGecerliParaBirimiGeldi = false;
        $boolVariantsAdded = false;
        if(isset($_POST["urunMenusu"])){
            $gelen_urunMenusu = Guvenlik($_POST["urunMenusu"]);
        }else{
            $gelen_urunMenusu = "";
        }
        if(isset($_POST["urunAdi"])){
            $gelen_urunAdi = Guvenlik($_POST["urunAdi"]);
        }else{
            $gelen_urunAdi = "";
        }
        if(isset($_POST["urunFiyati"])){
            $gelen_urunFiyati = Guvenlik($_POST["urunFiyati"]);
        }else{
            $gelen_urunFiyati = "";
        }
        if((isset($_POST["paraBirimi"]))){
            $gelen_paraBirimi = Guvenlik($_POST["paraBirimi"]);
            if(($gelen_paraBirimi == "TRY") or ($gelen_paraBirimi == "USD") or ($gelen_paraBirimi == "EUR"))
                $boolGecerliParaBirimiGeldi = true;
        }else{
            $gelen_paraBirimi = "";
        }
        if(isset($_POST["kDVOrani"])){
            $gelen_kDVOrani = Guvenlik($_POST["kDVOrani"]);
        }else{
            $gelen_kDVOrani = "";
        }
        if(isset($_POST["kargoUcreti"])){
            $gelen_kargoUcreti = Guvenlik($_POST["kargoUcreti"]);
        }else{
            $gelen_kargoUcreti = "";
        }
        if(isset($_POST["urunAciklamasi"])){
            $gelen_urunAciklamasi = Guvenlik($_POST["urunAciklamasi"]);
        }else{
            $gelen_urunAciklamasi = "";
        }
        if(isset($_POST["varyantBasligi"])){
            $gelen_varyantBasligi = Guvenlik($_POST["varyantBasligi"]);
        }else{
            $gelen_varyantBasligi = "";
        }
        $resimIsmi = array();
        //dynamic params
        $maxVariantCount = 10;
        $variantIndexArray = array(); // which ones in the Post Array is OK? That is depot for those.
        $arrayCounter = 0;
        for($i = 0; $i < $maxVariantCount; $i++){
            $boolIssetName = false;
            $boolIssetStock = false;
            if(isset($_POST["varyantAdi"][$i])){
                if($_POST["varyantAdi"][$i] != ""){
                    $_POST["varyantAdi"][$i] = Guvenlik($_POST["varyantAdi"][$i]);
                    $boolIssetName = true;
                }
            }else{
                $_POST["varyantAdi"][$i] = "";
            }
            if(isset($_POST["varyantStogu"][$i])){
                if($_POST["varyantStogu"][$i] != ""){
                    $_POST["varyantStogu"][$i] = Guvenlik($_POST["varyantStogu"][$i]);
                    $boolIssetStock = true;
                }
            }else{
                $_POST["varyantStogu"][$i] = "";
            }
            if($boolIssetName and $boolIssetStock){
                $variantIndexArray[$arrayCounter] = $i;
                $arrayCounter++;
            }
        }
        if(isset($variantIndexArray)){
            if(count($variantIndexArray) > 0)
                $boolVariantsAdded = true;
        }
        /*
        $foreachCount = 0;
        foreach($_POST['varyantAdi'] as $key => $value){
            if($foreachCount == 0){
                if(isset($value)){
                    $gelen_urunMenusu = Guvenlik($_POST["urunMenusu"]);
                }else{
                    $gelen_urunMenusu = "";
                }
            }
            $foreachCount++;
            if($foreachCount == 10)
                break;
        }
        $foreachCount = 0;
        foreach($_POST['varyantStogu'] as $key => $value){
            $foreachCount++;
            if($foreachCount == 10)
                break;
        }
        */
        //echo $_POST['varyantAdi'][0];

        //files
        $maxImageCount = 4;
        $itemImageArray = $_FILES["urunResmi"];
        //---
        /* CONTROL THE VARIANTS
        print_r($variantIndexArray);
        echo "<br />";
        foreach($variantIndexArray as $variantIndex){
            echo $variantIndex;
            echo "<br />";
            echo $_POST["varyantAdi"][$variantIndex];
            echo "<br />";
        }
        die();
        */

        if(($gelen_urunMenusu != "") and ($gelen_urunAdi != "") and ($gelen_urunFiyati != "") and ($gelen_paraBirimi != "") and ($gelen_kDVOrani != "") and ($gelen_kargoUcreti != "") and ($gelen_urunAciklamasi != "") and ($gelen_varyantBasligi != "") and $boolGecerliParaBirimiGeldi){
            if($boolVariantsAdded){
                if(($itemImageArray["name"][0] != "") and ($itemImageArray["type"][0] != "") and ($itemImageArray["tmp_name"][0] != "") and ($itemImageArray["error"][0] == 0) and ($itemImageArray["size"][0] > 0)){
                    $sorgu_urununMenusu = $veritaConn -> prepare("SELECT urun_tur FROM menuler WHERE id = ?");
                    $sorgu_urununMenusu -> execute([$gelen_urunMenusu]);
                    $menuSayisi = $sorgu_urununMenusu -> rowCount();
                    if($menuSayisi > 0){
                        $urun_tur = $sorgu_urununMenusu -> fetch(PDO::FETCH_ASSOC);
                        $urun_tur = $urun_tur["urun_tur"];
                        $upload_resim_dizini = $siteKokDizin . "/TeknoKapi/resimler/urun/" . ConvertEng($urun_tur);
                        for($i = 0; $i < $maxImageCount; $i++){
                            if(isset($itemImageArray["name"][$i])){
                                $itemImageArray["name"][$i] = Guvenlik($itemImageArray["name"][$i] );
                                $itemImageArray["type"][$i] = Guvenlik($itemImageArray["type"][$i] );
                                $itemImageArray["tmp_name"][$i] = Guvenlik($itemImageArray["tmp_name"][$i] );
                                $itemImageArray["error"][$i] = Guvenlik($itemImageArray["error"][$i] );
                                $itemImageArray["size"][$i] = Guvenlik($itemImageArray["size"][$i] );
                                if(($itemImageArray["name"][$i] != "") and ($itemImageArray["type"][$i] != "") and ($itemImageArray["tmp_name"][$i] != "") and ($itemImageArray["error"][$i] == 0) and ($itemImageArray["size"][$i] > 0)){
                                    //resim isimlendirme ve dizini
                                    $resim_yeniAd = ResimAdiOlustur();
                                    $resim_uzanti = substr($itemImageArray["name"][$i], -4);
                                    if($resim_uzanti == "jpeg")
                                        $resim_uzanti = "." . $resim_uzanti;
                                    //--------------------------------------------------------------
                                    //BURADA KALDIK $itemImageArray -> [name][$i] falan değil, [$i][] Array ( [name] => Array ( [0] => 9e2a1c0c9cb816cb8151f367356acfde.jpg [1] => [2] => [3] => ) [type] => Array ( [0] => image/jpeg [1] => [2] => [3] => ) [tmp_name] => Array ( [0] => C:\xampp\tmp\phpD3C7.tmp [1] => [2] => [3] => ) [error] => Array ( [0] => 0 [1] => 4 [2] => 4 [3] => 4 ) [size] => Array ( [0] => 17884 [1] => 0 [2] => 0 [3] => 0 ) ) bunun düzeltilmesi gerek burada convert edilip uploada verilmesi gerek
                                    $unifiedArrayData[$i] = array("name" => $itemImageArray["name"][$i], "type" => $itemImageArray["type"][$i], "tmp_name" => $itemImageArray["tmp_name"][$i], "error" => $itemImageArray["error"][$i], "size" => $itemImageArray["size"][$i]);
                                    $is_logoYukle = new Upload($unifiedArrayData[$i], "tr-TR");
                                    if($is_logoYukle -> uploaded){
                                        $is_logoYukle -> mime_magic_check = true;
                                        $is_logoYukle -> image_allowed = array("image/*");
                                        $is_logoYukle -> file_overwrite = true;

                                        $is_logoYukle -> image_convert = "png";
                                        $is_logoYukle -> image_quality = 100;
                                        $resimMime = $is_logoYukle -> image_convert;

                                        $is_logoYukle -> image_background_color  = null;
                                        $is_logoYukle -> image_resize = true;
                                        $is_logoYukle -> image_x = 185;
                                        $is_logoYukle -> image_y = 247;
                                        $is_logoYukle -> file_new_name_body = $resim_yeniAd;
                                        $resimIsmi[$i] = $is_logoYukle -> file_new_name_body . "." . $resimMime;

                                        $is_logoYukle -> process($upload_resim_dizini);
                                        if($is_logoYukle -> processed){
                                            $is_logoYukle -> clean();
                                        }else{
                                            $_SESSION["mesaj_ana_y"] = "Hata. Resim Yüklenemedi.";
                                            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                                            exit();
                                        }
                                    }else{
                                        $_SESSION["mesaj_ana_y"] = "Hata. Resim Yüklenemedi.";
                                        $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                                        exit();
                                    }
                                    //-------------------------------------------------------------------------------------------------------------------------------------------------------------
                                }
                            }
                        }
                        if(isset($itemImageArray["name"][0])){
                            if($itemImageArray["name"][0] != "")
                                $urun_resimBir = $resimIsmi[0];
                            else
                                $urun_resimBir = "";
                        }else{
                            $urun_resimBir = "";
                        }
                        if(isset($itemImageArray["name"][1])){
                            if($itemImageArray["name"][1] != "")
                                $urun_resimIki = $resimIsmi[1];
                            else
                                $urun_resimIki = "";
                        }else{
                            $urun_resimIki = "";
                        }
                        if(isset($itemImageArray["name"][2])){
                            if($itemImageArray["name"][2] != "")
                                $urun_resimUc = $resimIsmi[2];
                            else
                                $urun_resimUc = "";
                        }else{
                            $urun_resimUc = "";
                        }
                        if(isset($itemImageArray["name"][3])){
                            if($itemImageArray["name"][3] != "")
                                $urun_resimDort = $resimIsmi[3];
                            else
                                $urun_resimDort = "";
                        }else{
                            $urun_resimDort = "";
                        }

                        $sorgu_urunEkle = $veritaConn -> prepare("INSERT INTO urunler (menuId, urun_tur, urun_ad, urun_fiyat, urun_paraBirimi, urun_kdvOrani, urun_aciklama, urun_resimBir, urun_resimIki, urun_resimUc, urun_resimDort, urun_variantBasligi, urun_kargoUcreti, urun_durum, urun_toplamSatisSayisi, urun_yorumSayisi, urun_toplamYorumPuani, urun_goruntulenmeSayisi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $sorgu_urunEkle -> execute([$gelen_urunMenusu, $urun_tur, $gelen_urunAdi, $gelen_urunFiyati, $gelen_paraBirimi, $gelen_kDVOrani, $gelen_urunAciklamasi, $urun_resimBir, $urun_resimIki, $urun_resimUc, $urun_resimDort, $gelen_varyantBasligi, $gelen_kargoUcreti, 1, 0, 0, 0, 0]);
                        $urunSayisi = $sorgu_urunEkle -> rowCount();
                        $boolVariantAddingHasError = false;
                        if($urunSayisi > 0){
                            $yeniUrunId = $veritaConn -> lastInsertId();
                            //variant ekleyelim
                            foreach($variantIndexArray as $variantIndex){
                                $sorgu_variantEkle = $veritaConn -> prepare("INSERT INTO urunler_variantlar(urun_id, variant_ad, variant_stokAdet) VALUES(?, ?, ?)");
                                $sorgu_variantEkle -> execute([$yeniUrunId, $_POST["varyantAdi"][$variantIndex], $_POST["varyantStogu"][$variantIndex]]);
                                $variantSayisi = $sorgu_variantEkle -> rowCount();
                                if(!($variantSayisi > 0)){
                                    $boolVariantAddingHasError = true;
                                }
                            }
                            if($boolVariantAddingHasError){
                                $_SESSION["mesaj_ana_y"] = "Hata. Bazı Ürün Varyantları Eklenemedi.";
                                $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                                exit();
                            }else{
                                $sorgu_menuSayiGuncelle = $veritaConn -> prepare("UPDATE menuler SET urun_sayi = urun_sayi + 1 WHERE id = ?");
                                $sorgu_menuSayiGuncelle -> execute([$gelen_urunMenusu]);
                                $queryErrInfo = $sorgu_menuSayiGuncelle -> errorInfo();
                                if($queryErrInfo[0] != "00000"){
                                    $_SESSION["mesaj_ana_y"] = "Hata. Ürün Menüsü Bilgileri Güncellenemedi.";
                                    $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                                    exit();
                                }
                                header("Location:index.php?SOAE=1&SOAI=48");
                                exit();
                            }
                        }else{
                            $_SESSION["mesaj_ana_y"] = "Hata. Ürün Eklenemedi.";
                            $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }
                    }else{
                        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Menüsü Bilgileri Alınamadı.";
                        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }

                }else{
                    $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen En Az Bir Resim Ekleyiniz.";
                    $_SESSION["mesaj_aciklama_y"] = "Lütfen En Az Bir Resim Ekleyiniz Ve İşlemi Yeniden Yapınız.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen En Az Bir Varyant Ekleyiniz.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen En Az Bir Varyant Ekleyiniz Ve İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Gerekli Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Gerekli Alanları Doldurunuz Ve İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=49'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
            //, En Az Bir Resim Seçtiğinizden ve En Az Bir Varyant Girdiğinizden Emin Olduktan Sonra
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>