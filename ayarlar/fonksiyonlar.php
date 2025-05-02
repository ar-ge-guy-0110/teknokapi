<?php
    $ip_adresi = $_SERVER["REMOTE_ADDR"];
    $zamanDamgasi = time();
    $tarihSaat = date("d.m.Y H:i:s", $zamanDamgasi);
    $siteKokDizin = $_SERVER["DOCUMENT_ROOT"];
    $upload_resim_dizini = $siteKokDizin . "/TeknoKapi/resimler/uimage/";
    $eski_resim_dizini = $siteKokDizin . "/TeknoKapi/resimler/oldimg/";

    function RakamlarHaricTumKarakterleriSil($deger){
        $islem = preg_replace("/[^0-9]/", "", $deger); //preg_replace(1=buraya yazdığımız şeylere uyanları, 2=buraya yazılanla değiştir, 3=buraya yazilan stringdekini)
        return $islem;
    }

    function TumBosluklariSil($deger){
        $islem = preg_replace("/\s|&nbsp;/", "", $deger);
        return $islem;
    }

    function DonusumleriGeriDondur($deger){
        $geridondur = htmlspecialchars_decode($deger, ENT_QUOTES);
        return $geridondur;
    }

    function Guvenlik($deger){
        $boslukSil = trim($deger);
        $taglariTemizle = strip_tags($boslukSil);
        $etkisizlestir = htmlspecialchars($taglariTemizle, ENT_QUOTES);
        return $etkisizlestir;
    }

    function SayiliIcerikleriFiltrele($deger){
        $boslukSil = trim($deger);
        $taglariTemizle = strip_tags($boslukSil);
        $etkisizlestir = htmlspecialchars($taglariTemizle, ENT_QUOTES);
        $temizle = RakamlarHaricTumKarakterleriSil($etkisizlestir);
        return $temizle;
    }

    function IbanBicimlendir($deger){
        $boslukSil = trim($deger);
        $tumbosluksil = TumBosluklariSil($boslukSil);
        $birinciblok = substr($tumbosluksil, 0, 4); //substr(bu stringi, x. karakterden basla, x adet karakteri getir)
        $ikinciblok = substr($tumbosluksil, 4, 4);
        $ucuncublok = substr($tumbosluksil, 8, 4);
        $dorduncublok = substr($tumbosluksil, 12, 4);
        $besinciblok = substr($tumbosluksil, 16, 4);
        $altinciblok = substr($tumbosluksil, 20, 4);
        $yedinciblok = substr($tumbosluksil, 24, 2);
        $Duzenle = $birinciblok . " " . $ikinciblok . " " . $ucuncublok . " " . $dorduncublok . " " . $besinciblok . " " . $altinciblok . " " . $yedinciblok;
        return $Duzenle;
    }

    function AktivasyonKoduUret(){
        $ilkbesli = rand(10000, 99999);
        $ikincibesli = rand(10000, 99999);
        $ucuncubesli = rand(10000, 99999);
        $dorduncubesli = rand(10000, 99999);
        $kod = $ilkbesli . "-" . $ikincibesli . "-" . $ucuncubesli . "-" . $dorduncubesli;
        return $kod;
    }

    function timestamp2time($timestamp){
        $timee = date("d.m.Y. H:i:s", $timestamp);
        return $timee;
    }

    function RefreshUserSession(){
        if(isset($_SESSION["kullanici_email"])){
            if(!isset($veritaConn)){
                //VERITABANI BAGLANTISI
                try{
                    $veritaConn = new PDO("mysql:host=localhost;dbname=teknokapi;charset=UTF8", "root", "");
                }
                catch(PDOException $hata){
                    //echo "Bağlantı Hatası: <br />" . $hata->getMessage();
                    die();
                }
                //
            }
            $emal = $_SESSION["kullanici_email"];
            $sorgu_kullanici = $veritaConn -> prepare("SELECT * FROM uyeler WHERE uye_email = ? LIMIT 1");
            $sorgu_kullanici -> execute([$emal]);
            $kullaniciSayisi = $sorgu_kullanici -> rowCount();
            $kullanici = $sorgu_kullanici -> fetch(PDO::FETCH_ASSOC);
            if($kullaniciSayisi > 0){
                $kullanici_id = $kullanici["id"];
                $kullanici_email = $kullanici["uye_email"];
                $kullanici_sifre = $kullanici["uye_sifre"];
                $kullanici_tamisim = $kullanici["uye_tamisim"];
                $kullanici_telno = $kullanici["uye_telno"];
                $kullanici_cinsiyet = $kullanici["uye_cinsiyet"];
                $kullanici_durum = $kullanici["uye_durum"];
                $kullanici_kayit_tarihi = $kullanici["uye_kayit_tarihi"];
                $kullanici_kayit_ip_adresi = $kullanici["uye_kayit_ip_adresi"];
                $kullanici_aktivasyon_kodu = $kullanici["uye_aktivasyon_kodu"];
            }
        }
    }

    function ConvertEng($text) {
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
        $replace = array('C','c','G','g','i','i','O','o','S','s','U','u','');
        $new_text = str_replace($search,$replace,$text);
        return $new_text;
    }

    function FiyatBicimlendir($deger){
        $bicimlendir = number_format($deger, "2", ",", ".");
        return $bicimlendir;
    }

    function TarihBul($deger){
        $deger = date("d.m.Y H:i:s", $deger);
        return $deger;
    }

    function UcGunIleriTarihBul(){
        global $zamanDamgasi;
        
        $birGun = 86400; //saniyedir
        $hesapla = $zamanDamgasi + (3 * $birGun);
        $hesapla = date("d.m.Y", $hesapla);
        return $hesapla;
    }

    function ResimAdiOlustur(){
        $resimAdi = substr(md5(uniqid(time())), 0, 25);
        return $resimAdi;
    }

    function FileValidationAdmin($filesGlobal, $directedPage, $messagePage, $maxFileSizeInMB, $allowedTypes){
        //Dosya varmı yokmu
        if(!isset($filesGlobal) or $filesGlobal["size"] == 0){
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Dosya Yükleyiniz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Lütfen Dosya Yükleyiniz Ve İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='" . $directedPage . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:" . $messagePage);
            exit();
        }else{
            //dosya bilgileri çek
            $filepath = $filesGlobal['tmp_name'];
            $fileSize = filesize($filepath);
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $filetype = finfo_file($fileinfo, $filepath);

            //dosyanın boyutu 0 mı
            if($fileSize === 0){
                $_SESSION["mesaj_ana_y"] = "Dikkat. Yüklediğiniz Dosya Boş.";
                $_SESSION["mesaj_aciklama_y"] = "Lütfen Dosya Yükleyiniz Ve İşlemi Yeniden Yapınız.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='" . $directedPage . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                header("Location:" . $messagePage);
                exit();
            }else{
                //dosyanın boyutu 3mb den büyükmü (boyut sınırı)
                // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB)) = 3145728
                if($fileSize > $maxFileSizeInMB){
                    $_SESSION["mesaj_ana_y"] = "Dikkat. Yüklediğiniz Dosya, " . $maxFileSizeInMB . "MB sınırını aşıyor";
                    $_SESSION["mesaj_aciklama_y"] = "Lütfen Yükleyeceğiniz Dosya Boyutunu Gözden Geçiriniz Ve İşlemi Yeniden Yapınız.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='" . $directedPage . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                    header("Location:" . $messagePage);
                    exit();
                }else{
                    //dosyanın türlerini buraya yaz ve kontrol et
                    /*
                    $allowedTypes = [
                        'image/png'     => 'png',
                        'image/jpeg'    => 'jpg'
                    ];
                    */
                    if(!in_array($filetype, array_keys($allowedTypes))){
                        $_SESSION["mesaj_ana_y"] = "Dikkat. Yüklediğiniz Dosyanın Türü Geçersiz!";
                        $_SESSION["mesaj_aciklama_y"] = "Yükleyebileceğiniz Dosya Türleri: ";
                        $countArrKey = count(array_keys($allowedTypes));
                        $countOne = 0;
                        foreach(array_keys($allowedTypes) as $arrKey){
                            $countOne++;
                            echo $arrKey;
                            if($countOne != $countArrKey)
                                echo ", ";
                        }
                        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='" . $directedPage . "'><b>tıklayınız.</b></a>";
                        $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                        header("Location:" . $messagePage);
                        exit();
                    }
                }
            }
        }
        return true;
    }

    function FileValidationAdminNoDirection($filesGlobal, $maxFileSizeInMB, $allowedTypes){
        //Dosya varmı yokmu
        if(!isset($filesGlobal) or ($filesGlobal["size"] == 0) or ($filesGlobal["name"] == "") or ($filesGlobal["type"] == "") or ($filesGlobal["tmp_name"] == "") or ($filesGlobal["error"][0] != 0) or ($filesGlobal["size"] <= 0)){
            return false;
        }else{
            //dosya bilgileri çek
            $filepath = $filesGlobal['tmp_name'];
            $fileSize = filesize($filepath);
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $filetype = finfo_file($fileinfo, $filepath);

            //dosyanın boyutu 0 mı
            if($fileSize === 0){
                return false;
            }else{
                //dosyanın boyutu 3mb den büyükmü (boyut sınırı)
                // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB)) = 3145728, for 6mb 6291456
                if($fileSize > $maxFileSizeInMB){
                    return false;
                }else{
                    //dosyanın türlerini buraya yaz ve kontrol et
                    /*
                    $allowedTypes = [
                        'image/png'     => 'png',
                        'image/jpeg'    => 'jpg'
                    ];
                    */
                    if(!in_array($filetype, array_keys($allowedTypes))){
                        return false;
                    }else{
                        return true;
                    }
                }
            }
        }
    }

    function CreateFormToken(){
        $token = md5(uniqid() . rand(777, 1309));
        return $token;
    }

    function SVE_BASIC_INPUT($value, $maxLength = 1,$mustStringsLower = false , $mustNumeric = false, $onlyInteger = false){
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value, ENT_QUOTES);

        if($mustStringsLower){
            $value = strtolower($value);
            //$value = preg_replace('/[^az]/','', $value);
        }
        $value = substr($value, 0, $maxLength);

        if($mustNumeric){
            preg_replace("![][xX]([A-Fa-f0–9]{1,3})!","", $value);
            $numericValidate = is_numeric($value);
            if(!$numericValidate)
                $value = "";
            if($onlyInteger){
                if(!preg_match("/^([0-9]+)$/", $value)){
                    $value = "";
                }
            }else{
                if(!preg_match("/^(([0-9]+)|([0-9]+\.[0-9]+))$/", $value)){
                    $value = "";
                }
            }
        }
        if(strlen($value) > $maxLength){
            $value = "";
        }
        return $value;
    }

    function fileExtensionSimp($name) {
        $n = strrpos($name, '.');
        return ($n === false) ? '' : substr($name, $n+1);
    }

    function SEO($deger){
        $deger = trim($deger);
        $degisecekler = array("ç", "Ç", "ğ", "Ğ", "ı", "İ", "ö", "Ö", "ş", "Ş", "ü", "Ü");
        $degisenler = array("c", "c", "g", "g", "i", "i", "o", "o", "s", "s", "u", "u");
        $deger = str_replace($degisecekler, $degisenler, $deger);
        $deger = mb_strtolower($deger, "UTF-8");
        $deger = preg_replace("/[^a-z0-9.]/", "-", $deger);
        $deger = preg_replace("/-+/", "-", $deger);
        $deger = trim($deger, "-");
        return $deger;
    }
?>