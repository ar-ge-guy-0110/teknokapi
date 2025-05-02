<?php
    if(isset($_SESSION["kullanici_email"])){
        //FIYAT HESAPLARI
        $sorgu_alisverisSepeti = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.sepetNumarasi, sepet.uyeId, sepet.urunId, sepet.adresId, sepet.variantId, sepet.urunAdedi, sepet.kargoFirmasiSecimi, sepet.odemeSecimi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_kdvOrani, urunler.urun_variantBasligi, urunler.urun_kargoUcreti, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet, kargo_firmalar.logo AS kargo_logo, kargo_firmalar.ad AS kargo_ad, uyeler_adresler.tamisim AS adres_tamisim, uyeler_adresler.adres, uyeler_adresler.ilce AS adres_ilce, uyeler_adresler.il AS adres_il, uyeler_adresler.ulke AS adres_ulke, uyeler_adresler.telno AS adres_telno FROM sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id JOIN kargo_firmalar ON sepet.kargoFirmasiSecimi = kargo_firmalar.id JOIN uyeler_adresler ON sepet.adresId = uyeler_adresler.id WHERE sepet.uyeId = ?");
        $sorgu_alisverisSepeti -> execute([$kullanici_id]);
        $sepettekilerSayisi = $sorgu_alisverisSepeti -> rowCount();
        if($sepettekilerSayisi > 0){
            $sepettekiler = $sorgu_alisverisSepeti -> fetchAll(PDO::FETCH_ASSOC);
            $sepetteToplamUrunFiyatHesap = 0;
            $sepetteToplamUrunKargoFiyatHesap = 0;
            $sepetteki_sepetNumarasi = "";
            $sepetteki_toplamUrun = 0;
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
            }
            if($sepetteToplamUrunFiyatHesap >= $ucretsizKargoBaraji){
                $sorgu_kargoFiyatiBelirle = $veritaConn -> prepare("UPDATE siparisler SET urun_kargoUcreti = 0 WHERE uye_id = ? AND siparis_no = ?");
                $sorgu_kargoFiyatiBelirle -> execute([$kullanici_id, $sepetteki_sepetNumarasi]);
                $ToplamOdenecek = $sepetteToplamUrunFiyatHesap;
                $sepetteToplamUrunKargoFiyatHesap = 0;
            }else{
                $ToplamOdenecek = $sepetteToplamUrunFiyatHesap + $sepetteToplamUrunKargoFiyatHesap;
            }
        }else{
            header("Location:index.php");
            exit();
        }

        //SANAL POS API %99 BANKALARIN KULLANDIGI YAPI
        $clientId       = DonusumleriGeriDondur($clientId);                         // Bankadan Sanal Pos Onaylanınca Bankanın Verdiği İşyeri Numarası
        $amount         = $ToplamOdenecek;                                          // Sepet Ücreti Ya da İşlem Tutarı Ya da Karttan Çekilecek Tutar
        $oid            = $sepetteki_sepetNumarasi;                                 // Sipariş Numarası (Tekrarlanmayan Bir Değer) (Örneğin Sepet Tablosundaki IDyi Kullanabilirsiniz) (Her İşlemde Değişmeli ve Asla Tekrarlanmamalı)
        $okUrl          = "http://www.yesimtaki.com/sepetcreditcardoremetamam.php"; // Ödeme İşlemi Başarıyla Gerçekleşir ise Dönülecek Sayfa
        $failUrl        = "http://www.yesimtaki.com/sepetcreditcardoremehata.php";  // Odeme İşlemi Red Olur ise Dönülecek Sayfa
        $rnd            = @microtime();
        $storekey       = DonusumleriGeriDondur($storekey);                         // Sanal Pos Onaylandığında Bankanın Size Verdiği Sanal Pos Ekranına Girerek Oluşturulacak Olan İş Yeri Anahtarı
        $storetype      = "3d";                                                     // 3D Modeli
        $hashstr        = $clientId.$oid.$amount.$okUrl.$failUrl.$rnd.$storekey;    // Bankanın Kendi Ayarladığı Hash Parametresi
        $hash           = @base64_encode(@pack('H*',@sha1($hashstr)));              // Bankanın Kendi Ayarladığı Hash Şifreleme Parametresi
        $description    = "Ürün Satışı";                                            // Extra Bir Açıkama Yazmak İsterseniz Çekim İle İlgili Buraya Yazıyoruz
        $xid            = "";                                                       // 20 bytelik, 28 Karakterli base64 Olarak Boş Bırakılınca Sistem Tarafından Otomatik Üretilir. Lütfen Boş Bırakın
        $lang           = "";                                                       // Çekim Gösterim Dili Default Türkçedir. Ayarlamak İsterseniz Türkçe (tr), İngilizce (en) Girilmelidir. Boş Bırakılırsa (tr) Kabul Edilmiş Olur.
        $email          = "";                                                       // İsterseniz Çekimi Yapan Kullanıcınızın E-Postasını Gönderebilirsiniz
        $userid         = "";                                                       // İsterseniz Çekimi Yapan Kullanıcınızın Id'sini Gönderebilirsiniz
?>
<form action="https://<sunucu_adresi>/<3dgate_path>" method="post"> <?php //Bu Adres Banka veya EST Firması Tarafından Verilir ?>
    <input type="hidden" name="clientid" value="<?=$clientId?>" />
    <input type="hidden" name="amount" value="<?=$amount?>" />
    <input type="hidden" name="oid" value="<?=$oid?>" />
    <input type="hidden" name="okUrl" value="<?=$okUrl?>" />
    <input type="hidden" name="failUrl" value="<?=$failUrl?>" />
    <input type="hidden" name="rnd" value="<?=$rnd?>" />
    <input type="hidden" name="hash" value="<?=$hash?>" />
    <input type="hidden" name="storetype" value="3d" />
    <input type="hidden" name="lang" value="tr" />
    <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="800" valign="top">
                <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td ><h3>Alışveriş Sepeti</h3></td>
                    </tr>
                    <tr height="30">
                        <td  valign="top" style="border-bottom: 1px dashed #3cccb9;">Kredi Kartı Bilgilerini Aşağıda Belirtebilir ve Ödeme Yapabilirsin.</td>
                    </tr>
                    <tr height="10"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr>
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="40">
                                    <td width="250">Kredi Kartı Numarası</td>
                                    <td colspan="4" width="550"><input type="text" name="pan" class="beauslot" /></td>
                                </tr>
                                <tr height="40">
                                    <td>Son Kullanma Tarihi</td>
                                    <td width="100">
                                        <select name="Ecom_Payment_Card_ExpDate_Month" class="beaucombobox2">
                                            <option value=""></option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </td>
                                    <td width="20" align="center"> - </td>
                                    <td width="100">
                                        <select name="Ecom_Payment_Card_ExpDate_Year" class="beaucombobox2">
                                            <option value=""></option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                        </select>
                                    </td>
                                    <td width="330"></td>
                                </tr>
                                <tr height="40">
                                    <td>Kart Türü</td>
                                    <td colspan="4"><input type="radio" value="1" name="cardType"> Visa <input type="radio" value="2" name="cardType"> MasterCard</td>
                                </tr>
                                <tr height="40">
                                    <td>Güvenlik Kodu</td>
                                    <td width="100"><input type="text" name="cv2" size="4" value="" class="beauslot" /></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr height="40">
                                    <td align="center">&nbsp;</td>
                                    <td colspan="4" align="left"><input type="submit" value="Ödeme Yap" class="beaubgreen"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="15">&nbsp;</td>
            <td width="250" valign="top">
                <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td align="right"><h3>Sipariş Özeti</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;" >Toplam <b style="color: #3cccb9;"><?php echo $sepetteki_toplamUrun; ?></b> ürün</td>
                    </tr>
                    <tr height="5">
                        <td height="5" style="font-size: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Net Ödenecek Tutar (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($ToplamOdenecek) ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Ürünlerin Toplam Ücreti (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($sepetteToplamUrunFiyatHesap) ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Toplam Kargo Ücreti (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($sepetteToplamUrunKargoFiyatHesap) ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php

    }else{
        header("Location:index.php");
        exit();
    }
?>