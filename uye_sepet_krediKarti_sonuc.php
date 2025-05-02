<?php
    session_start(); ob_start();
    require_once("ayarlar/ayar.php");
    require_once("ayarlar/fonksiyonlar.php");
    require_once("ayarlar/site_sayfalari.php");
    $oid = $_POST["oid"]; //deneme icin bunu kapatin
    //$oid = $_GET["oid"]; deneme icin bunu acin
    $sorgu_sepet = $veritaConn -> prepare("SELECT * FROM sepet WHERE sepetNumarasi = ? LIMIT 1");
    $sorgu_sepet -> execute([$oid]);
    $sepet = $sorgu_sepet -> fetch(PDO::FETCH_ASSOC);
    $taksitSayisi = $sepet["taksitSecimi"];
    if($taksitSayisi == 1)
        $taksitSayisi = "";

    echo $taksitSayisi;
    /**/ //deneme icin sondakini silin
    $hashparams         =   $_POST["HASHPARAMS"];
    $hashparamsval      =   $_POST["HASHPARAMSVAL"];
    $hashparam          =   $_POST["HASH"];
    $storekey           =   DonusumleriGeriDondur($storekey);
    $paramsval          =   "";
    $index1             =   0;
    $index2             =   0;
    while($index1 < @strlen($hashparams)){
        $index2 = @strpos($hashparams, ":", $index1);
        $vl = $_POST[@substr($hashparams, $index1, $index2 - $index1)];
        if($vl == null)
            $vl = "";
        $paramsval = $paramsval.$vl;
        $index1 = $index2 + 1;
        $storekey = DonusumleriGeriDondur($storekey);
        $hashval = $paramsval.$storekey;
        $hash = @base64_encode(@pack('H*', @sha1($hashval)));
        if($paramsval != $hashparamsval || $hashparam != $hash)
            echo "<h4>Güvenlik Uyarısı! Sayısal İmza Geçerli Değil.</h4>";
        $name = DonusumleriGeriDondur($BAPIName);
        $password = DonusumleriGeriDondur($BAPIPassword);
        $clientid = $_POST["clientid"];
        $mode = "P"; // P Çekim İşlemi Demek, T Test İşlemi Demek. (Kesinlikle P Olacak Yoksa Çekimler Kart Sahibine Geri Döner)
        $type = "Auth"; // Auth: Satış, PreAuth: On Authorization
        $expires = $_POST["Ecom_Payment_Card_ExpDate_Month"] . "/" . $_POST["Ecom_Payment_Card_ExpDate_Year"];
        $cv2 = $_POST["cv2"];
        $tutar = $_POST["amount"];
        $taksit = DonusumleriGeriDondur($taksitSayisi); // Taksit Yapılacak İse Taksit Sayısı Girilmeli, 0 Kesinlikle Girilmeyecektir. Tek Çekim İçin Boş Bırakılacaktır, Taksit İşlemleri İçin Minimum 2 Girilir. Maksimum Bankanın Size Vereceği Taksit Sayısı Kadardır.
        $lip = GetHostByName($REMOTE_ADDR);
        $email = "";
        $mdStatus = $_POST["mdStatus"];
        $xid = $_POST["xid"];
        $eci = $_POST["eci"];
        $cavv = $_POST["cavv"];
        $md = $_POST["md"];
        if($mdStatus == "1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4"){
            $request = "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>" . "<CC5Request>" . "<Name>{NAME}</Name>" . "<Password>{PASSWORD}</Password>" . "<ClientId>{CLIENTID}</ClientId>" . "<IPAddress>{IP}</IPAddress>" . "<Email>{EMAIL}</Email>" . "<Mode>P</Mode>" . "<OrderId>{OID}</OrderId>" . "<GroupId></GroupId>" . "<TransId></TransId>" . "<UserId></UserId>" . "<Type>{TYPE}</Type>" . "<Number>{MD}</Number>" . "<Expires></Expires>" . "<Cvv2Val></Cvv2Val>" . "<Total>{TUTAR}</Total>" . "<Currency>949</Currency>" . "<Taksit>{TAKSIT}</Taksit>" . "<PayerTxnId>{XID}</PayerTxnId>" . "<PayerSecurityLevel>{ECI}</PayerSecurityLevel>" . "<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>" . "<CardholderPresentCode>13</CardholderPresentCode>" . "<BillTo>" . "<Name></Name>" . "<Street1></Street1>" . "<Street2></Street2>" . "<Street3></Street3>" . "<City></City>" . "<StateProv></StateProv>" . "<PostalCode></PostalCode>" . "<Country></Country>" . "<Company></Company>" . "<TelVoice></TelVoice>" . "</BillTo>" . "<ShipTo>" . "<Name></Name>" . "<Street1></Street1>" . "<Street2></Street2>" . "<Street3></Street3>" . "<City></City>" . "<StateProv></StateProv>" . "<PostalCode></PostalCode>" . "<Country></Country>" . "</ShipTo>" . "<Extra></Extra>" . "</CC5Request>";
            $request = @str_replace("{NAME}", $name, $request);
            $request = @str_replace("{PASSWORD}", $password, $request);
            $request = @str_replace("{CLIENTID}", $clientid, $request);
            $request = @str_replace("{IP}", $lip, $request);
            $request = @str_replace("{OID}", $oid, $request);
            $request = @str_replace("{TYPE}", $type, $request);
            $request = @str_replace("{XID}", $xid, $request);
            $request = @str_replace("{ECI}", $eci, $request);
            $request = @str_replace("{CAVV}", $cavv, $request);
            $request = @str_replace("{MD}", $md, $request);
            $request = @str_replace("{TUTAR}", $tutar, $request);
            $request = @str_replace("{TAKSIT}", $taksit, $request);
            $url = "https://<sunucu_adresi>/<apiserver_path>";
            $ch = @curl_init();
            @curl_setopt($ch, CURLOPT_URL, $url);
            @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            @curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            @curl_setopt($ch, CURLOPT_TIMEOUT, 90);
            @curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            $result = @curl_exec($ch);
            if(@curl_errno($ch)){
                print @curl_error($ch);
            }else{
                @curl_close($ch);
            }
            $Response = "";
            $OrderId = "";
            $AuthCode = "";
            $ProcReturnCode = "";
            $ErrMsg = "";
            $HOSTMSG = "";
            $HostRefNum = "";
            $TransId = "";
            $response_tag = "Response";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $Response = @substr($result, $posf, $posl - $posf);
            $response_tag = "OrderId";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            $response_tag = "AuthCode";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            $response_tag = "ProcReturnCode";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            $response_tag = "ErrMsg";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            $response_tag = "HostRefNum";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            $response_tag = "TransId";
            $posf = @strpos($result, ("<" . $response_tag . ">"));
            $posl = @strpos($result, ("</" . $response_tag . ">"));
            $posf = $posf + @strlen($response_tag) + 2;
            $OrderId = @substr($result, $posf, $posl - $posf);
            if($Response == "Approved"){
                // deneme icin buraya */ ekleyin
                echo "Ödeme işleminiz başarıyla gerçekleştirildi."; // İster direk sayfayı yönlendiririz, istersekde burda işlem yapabiliriz.

                $sorgu_alisverisSepeti = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.sepetNumarasi, sepet.uyeId, sepet.urunId, sepet.adresId, sepet.variantId, sepet.urunAdedi, sepet.kargoFirmasiSecimi, sepet.odemeSecimi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_kdvOrani, urunler.urun_variantBasligi, urunler.urun_kargoUcreti, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet, kargo_firmalar.logo AS kargo_logo, kargo_firmalar.ad AS kargo_ad, uyeler_adresler.tamisim AS adres_tamisim, uyeler_adresler.adres, uyeler_adresler.ilce AS adres_ilce, uyeler_adresler.il AS adres_il, uyeler_adresler.ulke AS adres_ulke, uyeler_adresler.telno AS adres_telno FROM sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id JOIN kargo_firmalar ON sepet.kargoFirmasiSecimi = kargo_firmalar.id JOIN uyeler_adresler ON sepet.adresId = uyeler_adresler.id WHERE sepet.sepetNumarasi = ?");
                $sorgu_alisverisSepeti -> execute([$oid]);
                $sepettekilerSayisi = $sorgu_alisverisSepeti -> rowCount();
                if($sepettekilerSayisi > 0){
                    $sepettekiler = $sorgu_alisverisSepeti -> fetchAll(PDO::FETCH_ASSOC);
                    $sepetteToplamUrunFiyatHesap = 0;
                    $sepetteToplamUrunKargoFiyatHesap = 0;
                    $sepetteki_sepetNumarasi = "";
                    $sepetteki_toplamUrun = 0;
                    $sepetteki_odemeSecimi = "";
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
                        $sepetteki_toplamUrun += $sepetteki_urunAdedi;
                        $sepetteTekUrunKargoFiyatHesap = $sepetteki_urun_kargoUcreti * $sepetteki_urunAdedi;
                        $sepetteToplamUrunKargoFiyatHesap += $sepetteki_urun_kargoUcreti * $sepetteki_urunAdedi;

                        $sorgu_siparisEkle = $veritaConn -> prepare("INSERT INTO siparisler(siparis_no, urun_id, urun_tur, uye_id, urun_ad, urun_fiyat, urun_kdvOrani, urun_siparisAdedi, siparis_toplamUrunFiyati, urun_kargoFirmasiSecimi, urun_kargoUcreti, urun_resimBir, urun_variantBasligi, urun_variantSecimi, siparis_adres_adiSoyadi, siparis_adres_detay, siparis_adres_telefon, siparisodemeSecimi, siparis_taksitSecimi, siparis_tarih, siparis_ipAdresi, urun_variantId) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $sorgu_siparisEkle -> execute([$sepetteki_sepetNumarasi, $sepetteki_urunId, $sepetteki_urun_tur, $sepetteki_uyeId, $sepetteki_urun_ad, $tekUrunFiyat, $sepetteki_urun_kdvOrani, $sepetteki_urunAdedi, $hesapUrunFiyat, $sepetteki_kargo_ad, $sepetteTekUrunKargoFiyatHesap, $sepetteki_urun_resimBir, $sepetteki_urun_variantBasligi, $sepetteki_variant_ad, $sepetteki_adres_tamisim, $sepetteki_adresTumu, $sepetteki_adres_telno, $sepetteki_odemeSecimi, $taksitSayisi, $zamanDamgasi, $ip_adresi, $sepetteki_variantId]);
                        $eklemeSayisi = $sorgu_siparisEkle -> rowCount();
                        if($eklemeSayisi > 0){
                            $sorgu_islenenSepetteyiSil = $veritaConn -> prepare("DELETE FROM sepet WHERE id = ? AND uyeId = ? LIMIT 1");
                            $sorgu_islenenSepetteyiSil -> execute([$sepetteki_id, $sepetteki_uyeId]);

                            $sorgu_urunSatisSayisiArtir = $veritaConn -> prepare("UPDATE urunler SET urun_toplamSatisSayisi = (urun_toplamSatisSayisi + ?) WHERE id = ?");
                            $sorgu_urunSatisSayisiArtir -> execute([$sepetteki_urunAdedi, $sepetteki_urunId]);

                            $sorgu_satilanUrununStogunuGuncelle = $veritaConn -> prepare("UPDATE urunler_variantlar SET variant_stokAdet = (variant_stokAdet - ?) WHERE id = ? LIMIT 1");
                            $sorgu_satilanUrununStogunuGuncelle -> execute([$sepetteki_urunAdedi, $sepetteki_variantId]);
                        }
                    }
                    if($sepetteToplamUrunFiyatHesap >= $ucretsizKargoBaraji){
                        $sorgu_kargoFiyatiBelirle = $veritaConn -> prepare("UPDATE siparisler SET urun_kargoUcreti = 0 WHERE uye_id = ? AND siparis_no = ?");
                        $sorgu_kargoFiyatiBelirle -> execute([$sepetteki_uyeId, $sepetteki_sepetNumarasi]);
                        $ToplamOdenecek = $sepetteToplamUrunFiyatHesap;
                    }else{
                        $ToplamOdenecek = $sepetteToplamUrunFiyatHesap + $sepetteToplamUrunKargoFiyatHesap;
                    }
                }
                // deneme icin buraya /* ekleyin
            }else{
                echo "Ödeme işleminiz sırasında hata oluştu. Hata = " . $ErrMsg;
            }

        }else{
            echo "Kredi Kartı Bankası 3D Onayı Vermedi, Lütfen Bilgilerinizi Kontrol Edip Tekrar Deneyiniz. Sorununuz Devam Eder İse Lütfen Kartınızın Sahibi Olan Bankanın Müşteri Temsilcileriyle İletişime Geçiniz.";
        }
    }
    // deneme icin buraya */ ekleyin
    $veritaConn = null;
    ob_end_flush();
?>