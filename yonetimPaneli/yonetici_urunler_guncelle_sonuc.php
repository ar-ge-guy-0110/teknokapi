<?php
    namespace Verot\Upload;
    use PDO;
    //-Yönetici Girişi Olmalı
    if(!(isset($_SESSION["kullanici_Yonetici"]))){
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
    if(isset($_POST['TT'])){
        $touken = SVE_BASIC_INPUT($_POST['TT'], 32);
    }else{
        $touken = "";
    }
    if($touken != $_SESSION['touken']){
        header("Location:index.php?SOAE=1"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
    //--
    //--bools
    $boolGecerliParaBirimiGeldi = false;
    $boolVariantsMuchMoreThanZero = false;
    //

    //--Normal Inputlar
    if(isset($_GET["id"])){
        $gelen_id = SVE_BASIC_INPUT($_GET["id"], 10, false, true, true);
    }else{
        $gelen_id = "";
    }
    if(isset($_POST["urunMenusu"])){
        $gelen_urunMenusu = SVE_BASIC_INPUT($_POST["urunMenusu"], 10, false, true, true);
        $sorgu_gelenMenuUrunTuruEslestir = $veritaConn -> prepare("SELECT COUNT(urunler.id) FROM menuler JOIN urunler ON urunler.menuId = menuler.id WHERE menuler.id = ? AND urunler.id = ?");
        $sorgu_gelenMenuUrunTuruEslestir -> execute([$gelen_urunMenusu, $gelen_id]);
        $foundedCount = $sorgu_gelenMenuUrunTuruEslestir -> fetchColumn();
        if($foundedCount == 0){
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Ürünün Türüne Göre Menü Seçiniz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Ürünün Türüne Göre Menü Seçiniz Ve İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        $gelen_urunMenusu = "";
    }
    if(isset($_POST["urunAdi"])){
        $gelen_urunAdi = SVE_BASIC_INPUT($_POST["urunAdi"], 255);
    }else{
        $gelen_urunAdi = "";
    }
    if(isset($_POST["urunFiyati"])){
        $gelen_urunFiyati = SVE_BASIC_INPUT($_POST["urunFiyati"], 10, false, true);
    }else{
        $gelen_urunFiyati = "";
    }
    if((isset($_POST["paraBirimi"]))){
        $gelen_paraBirimi = SVE_BASIC_INPUT($_POST["paraBirimi"], 3, false);
        if(($gelen_paraBirimi == "TRY") or ($gelen_paraBirimi == "USD") or ($gelen_paraBirimi == "EUR"))
            $boolGecerliParaBirimiGeldi = true;
        if(!$boolGecerliParaBirimiGeldi){
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Geçerli Para Birimi Giriniz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Geçerli Para Birimi Giriniz Ve İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        $gelen_paraBirimi = "";
    }
    if(isset($_POST["kDVOrani"])){
        $gelen_kDVOrani = SVE_BASIC_INPUT($_POST["kDVOrani"], 2, false, true, true);
    }else{
        $gelen_kDVOrani = "";
    }
    if(isset($_POST["kargoUcreti"])){
        $gelen_kargoUcreti = SVE_BASIC_INPUT($_POST["kargoUcreti"], 10, false, true);
    }else{
        $gelen_kargoUcreti = "";
    }
    if(isset($_POST["urunAciklamasi"])){
        $gelen_urunAciklamasi = SVE_BASIC_INPUT($_POST["urunAciklamasi"], 1400);
    }else{
        $gelen_urunAciklamasi = "";
    }
    if(isset($_POST["varyantBasligi"])){
        $gelen_varyantBasligi = SVE_BASIC_INPUT($_POST["varyantBasligi"], 100);
    }else{
        $gelen_varyantBasligi = "";
    }
    //--

    //--Resimler
    $maxImageCount = 4;
    $itemImageArrayOld = $_FILES["urunResmi"];
    $itemImageArray = array();
    $sorgu_resimler = $veritaConn -> prepare("SELECT urun_resimBir, urun_resimIki, urun_resimUc, urun_resimDort FROM urunler WHERE id = ?");
    $sorgu_resimler -> execute([$gelen_id]);
    $queryErrInfo = $sorgu_resimler -> errorInfo();
    if($queryErrInfo[0] != "00000"){
        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Resim Bilgileri Getirilemedi.";
        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
    $urunResimleri = $sorgu_resimler -> fetch(PDO::FETCH_ASSOC);
    foreach($urunResimleri as $u => $k){
        $urunResimleri[$u] = Guvenlik($k);

    }
    

    $itemImageArrayValidIndexes = array();
    $validIndexCount = 0;

    $maxFileSize = 6291456;
    $allowedTypes = [
        'image/png'     => 'png',
        'image/jpeg'    => 'jpg'
    ];
    $sorgu_urunTuru = $veritaConn -> prepare("SELECT urun_tur FROM urunler WHERE id = ?");
    $sorgu_urunTuru -> execute([$gelen_id]);
    $queryErrInfo = $sorgu_urunTuru -> errorInfo();
    if($queryErrInfo[0] != "00000"){
        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Türü Bilgileri Getirilemedi.";
        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
    $urunTuru = $sorgu_urunTuru -> fetch(PDO::FETCH_ASSOC);
    $urunTuru = $urunTuru["urun_tur"];
    $upload_resim_dizini = $siteKokDizin . "/TeknoKapi/resimler/urun/" . ConvertEng($urunTuru);
    for($i = 0; $i < $maxImageCount; $i++){
        $itemImageArrayOld["name"][$i] = Guvenlik($itemImageArrayOld["name"][$i] );
        $itemImageArrayOld["type"][$i] = Guvenlik($itemImageArrayOld["type"][$i] );
        $itemImageArrayOld["tmp_name"][$i] = Guvenlik($itemImageArrayOld["tmp_name"][$i] );
        $itemImageArrayOld["error"][$i] = Guvenlik($itemImageArrayOld["error"][$i] );
        $itemImageArrayOld["size"][$i] = Guvenlik($itemImageArrayOld["size"][$i] );
        $itemImageArray[$i] = array("name" => $itemImageArrayOld["name"][$i], "type" => $itemImageArrayOld["type"][$i], "tmp_name" => $itemImageArrayOld["tmp_name"][$i], "error" => $itemImageArrayOld["error"][$i], "size" => $itemImageArrayOld["size"][$i]);
        if(FileValidationAdminNoDirection($itemImageArray[$i], $maxFileSize, $allowedTypes)){
            $itemImageArrayValidIndexes[$validIndexCount] = $i;
            $validIndexCount++;
            $resim_yeniAd = ResimAdiOlustur();
            $resim_uzanti = substr($itemImageArray[$i]["name"], -4);
            if($resim_uzanti == "jpeg")
                $resim_uzanti = "." . $resim_uzanti;
            $is_logoYukle = new Upload($itemImageArray[$i], "tr-TR");
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
        }
        //sorguyu c# daki harika sorgu string olusturma seyinden alirsin sanirim bir php projende bunu kullanmistin koç!!!
    }
    if(isset($itemImageArray[0]["name"])){
        if($itemImageArray[0]["name"] != "")
            $urun_resimBir = $resimIsmi[0];
        else
            $urun_resimBir = "";
    }else{
        $urun_resimBir = "";
    }
    if(isset($itemImageArray[1]["name"])){
        if($itemImageArray[1]["name"] != "")
            $urun_resimIki = $resimIsmi[1];
        else
            $urun_resimIki = "";
    }else{
        $urun_resimIki = "";
    }
    if(isset($itemImageArray[2]["name"])){
        if($itemImageArray[2]["name"] != "")
            $urun_resimUc = $resimIsmi[2];
        else
            $urun_resimUc = "";
    }else{
        $urun_resimUc = "";
    }
    if(isset($itemImageArray[3]["name"])){
        if($itemImageArray[3]["name"] != "")
            $urun_resimDort = $resimIsmi[3];
        else
            $urun_resimDort = "";
    }else{
        $urun_resimDort = "";
    }
    //--

    //--exstra kontroller
    if(($gelen_id == "") or ($gelen_urunAdi == "") or ($gelen_urunFiyati == "") or ($gelen_kDVOrani == "") or ($gelen_kargoUcreti == "") or ($gelen_urunAciklamasi == "") or ($gelen_varyantBasligi == "")){
        $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Gerekli Alanları Doldurunuz.";
        $_SESSION["mesaj_aciklama_y"] = "Lütfen Ürün İle İlgili Bütün Gerekli Alanları Doldurduktan Sonra İşlemi Yeniden Yapınız.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
    //--

    //--varyantlar
    $sorgu_urunVaryantlari = $veritaConn -> prepare("SELECT id, urun_id, variant_ad, variant_stokAdet FROM urunler_variantlar WHERE urun_id = ?");
    $sorgu_urunVaryantlari -> execute([$gelen_id]);
    $queryErrInfo = $sorgu_urunVaryantlari -> errorInfo();
    if($queryErrInfo[0] != "00000"){
        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Varyant Bilgileri Getirilemedi.";
        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
    $urunVaryantlari = $sorgu_urunVaryantlari -> fetchAll(PDO::FETCH_ASSOC);
    $urunVaryantSayisi = count($urunVaryantlari);
    echo "<pre>";
    print_r($urunVaryantlari);
    echo "</pre>";
    
    $maxVariantCount = 10;
    $variantIndexArray = array(); // which ones in the Post Array is OK? That is depot for those.
    $doluVariantInputu = 0;
    $silinmisVariantInputu = 0;
    $variantIdDeletingArray = array();
    $variantDeletedInputIndex = array();
    $arrayCounter = 0;
    for($i = 0; $i < $maxVariantCount; $i++){
        if(isset($_POST["varyantAdi"][$i])){
            $gelen_varyantAdi = SVE_BASIC_INPUT($_POST["varyantAdi"][$i], 100);
        }else{
            $gelen_varyantAdi = "";
        }
        if(isset($_POST["varyantStogu"][$i])){
            $gelen_varyantStogu = SVE_BASIC_INPUT($_POST["varyantStogu"][$i], 9, false, true, true);
        }else{
            $gelen_varyantStogu = "";
        }
        if($i < $urunVaryantSayisi){
            if(($gelen_varyantAdi == $urunVaryantlari[$i]["variant_ad"]) and ($gelen_varyantStogu == $urunVaryantlari[$i]["variant_stokAdet"])){
                continue;
            }
            if(($gelen_varyantAdi == "") and ($gelen_varyantStogu == "")){
                echo $i;
                $query_deleteVariant = $veritaConn -> prepare("DELETE FROM urunler_variantlar WHERE urun_id = ? AND id = ? LIMIT 1");
                $query_deleteVariant -> execute([$gelen_id, $urunVaryantlari[$i]["id"]]);
                $queryErrInfo = $query_deleteVariant -> errorInfo();
                if($queryErrInfo[0] != "00000"){
                    $_SESSION["mesaj_ana_y"] = "Hata. Ürün Varyantı Silinemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
                continue;
            }
            if(($gelen_varyantAdi != "") and ($gelen_varyantStogu != "")){
                $query_updateVariant = $veritaConn -> prepare("UPDATE urunler_variantlar SET variant_ad = ?, variant_stokAdet = ? WHERE urun_id = ? AND id = ? LIMIT 1");
                $query_updateVariant -> execute([$gelen_varyantAdi, $gelen_varyantStogu, $gelen_id, $urunVaryantlari[$i]["id"]]);
                $queryErrInfo = $query_updateVariant -> errorInfo();
                if($queryErrInfo[0] != "00000"){
                    $_SESSION["mesaj_ana_y"] = "Hata. Ürün Varyantı Güncellenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }
            }
        }else{
            if(($gelen_varyantAdi == "") or ($gelen_varyantStogu == "")){
                continue;
            }
            $query_addVariant = $veritaConn -> prepare("INSERT INTO urunler_variantlar(urun_id, variant_ad, variant_stokAdet) VALUES(?, ?, ?)");
            $query_addVariant -> execute([$gelen_id, $gelen_varyantAdi, $gelen_varyantStogu]);
            $queryErrInfo = $query_addVariant -> errorInfo();
            if($queryErrInfo[0] != "00000"){
                $_SESSION["mesaj_ana_y"] = "Hata. Ürün Varyant Eklenemedi.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=52&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }
    }
    //--

    //--SANITIZE-VALIDATE-ESCAPE
    //--

    //--islem - 1 )(urun)
    $string_sorgu_bas = "UPDATE urunler SET ";
    $string_sorgu_orta = "menuId = ?,urun_ad = ?,urun_fiyat = ?,urun_paraBirimi = ?,urun_kdvOrani = ?,urun_aciklama = ?, urun_kargoUcreti = ?";
    $string_sorgu_son = " WHERE";
    $string_sorgu_hepsi = "";
    $array_executable = array($gelen_urunMenusu, $gelen_urunAdi, $gelen_urunFiyati, $gelen_paraBirimi, $gelen_kDVOrani, $gelen_urunAciklamasi, $gelen_kargoUcreti);
    for($i = 0; $i < count($itemImageArrayValidIndexes); $i++){
        switch($itemImageArrayValidIndexes[$i]){
            case 0:
                if(strlen($string_sorgu_orta) > 0)
                    $string_sorgu_orta .= ", ";
                $string_sorgu_orta .= "urun_resimBir = ?";
                if($urunResimleri["urun_resimBir"] != ""){
                    $copycat = $upload_resim_dizini . "/" . $urunResimleri["urun_resimBir"];
                    $copycat2 = $eski_resim_dizini . "/" . ResimAdiOlustur() .  "." . fileExtensionSimp($urunResimleri["urun_resimBir"]);
                    if(!copy($copycat, $copycat2)){
                        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Resmi Kopyalanamadı.";
                        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
                unlink($copycat);
                $array_executable[count($array_executable)] = $urun_resimBir;
                break;
            case 1:
                if(strlen($string_sorgu_orta) > 0)
                    $string_sorgu_orta .= ", ";
                $string_sorgu_orta .= "urun_resimIki = ?";
                if($urunResimleri["urun_resimIki"] != ""){
                    $copycat = $upload_resim_dizini . "/" . $urunResimleri["urun_resimIki"];
                    $copycat2 = $eski_resim_dizini . "/" . ResimAdiOlustur() . "." .  fileExtensionSimp($urunResimleri["urun_resimIki"]);
                    if(!copy($copycat, $copycat2)){
                        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Resmi Kopyalanamadı.";
                        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
                unlink($copycat);
                $array_executable[count($array_executable)] = $urun_resimIki;
                break;
            case 2:
                if(strlen($string_sorgu_orta) > 0)
                    $string_sorgu_orta .= ", ";
                $string_sorgu_orta .= "urun_resimUc = ?";
                if($urunResimleri["urun_resimUc"] != ""){
                    $copycat = $upload_resim_dizini . "/" . $urunResimleri["urun_resimUc"];
                    $copycat2 = $eski_resim_dizini . "/" . ResimAdiOlustur() . "." . fileExtensionSimp($urunResimleri["urun_resimUc"]);
                    if(!copy($copycat, $copycat2)){
                        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Resmi Kopyalanamadı.";
                        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
                unlink($copycat);
                $array_executable[count($array_executable)] = $urun_resimUc;
                break;
            case 3:
                if(strlen($string_sorgu_orta) > 0)
                    $string_sorgu_orta .= ", ";
                $string_sorgu_orta .= "urun_resimDort = ?";
                if($urunResimleri["urun_resimDort"] != ""){
                    $copycat = $upload_resim_dizini . "/" . $urunResimleri["urun_resimDort"];
                    $copycat2 = $eski_resim_dizini . "/" . ResimAdiOlustur() . "." .  fileExtensionSimp($urunResimleri["urun_resimDort"]);
                    if(!copy($copycat, $copycat2)){
                        $_SESSION["mesaj_ana_y"] = "Hata. Ürün Resmi Kopyalanamadı.";
                        $_SESSION["mesaj_aciklama_y"] = "Lütfen Tekrar Deneyiniz Veya Sistem Uzmanınıza Durumu Bildiriniz.";
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                        exit();
                    }
                }
                unlink($copycat);
                $array_executable[count($array_executable)] = $urun_resimDort;
                break;
        }
    }
    //According to What?
    $string_sorgu_son .= " id = ?";
    $array_executable[count($array_executable)] = $gelen_id;
    //echo "tamam tamam";
    $string_sorgu_hepsi = $string_sorgu_bas . $string_sorgu_orta . $string_sorgu_son;
    //QUERYSYS-ACT3

    $sorgu_guncelle = $veritaConn -> prepare($string_sorgu_hepsi);
    $sorgu_guncelle -> execute($array_executable);
    //
    header("Location:index.php?SOAE=1&SOAI=48");
    exit();
    //
?>