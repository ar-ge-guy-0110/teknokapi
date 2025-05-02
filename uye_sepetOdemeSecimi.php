<?php
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_POST["AdresSecimi"])){
            $gelen_adresSecimi = Guvenlik($_POST["AdresSecimi"]);
        }else{
            $gelen_adresSecimi = "";
        }
        if(isset($_POST["KargoSecimi"])){
            $gelen_kargoSecimi = Guvenlik($_POST["KargoSecimi"]);
        }else{
            $gelen_kargoSecimi = "";
        }

        if(($gelen_adresSecimi != "") and ($gelen_kargoSecimi != "")){

            //sepetin kargo ve adres bölümünü güncelle
            $sorgu_adresVeKargoSecenekleriGuncelle = $veritaConn -> prepare("UPDATE sepet SET adresId = ?, kargoFirmasiSecimi = ? WHERE uyeId = ?");
            $sorgu_adresVeKargoSecenekleriGuncelle -> execute([$gelen_adresSecimi, $gelen_kargoSecimi, $kullanici_id]);
            $guncellemeSayisi = $sorgu_adresVeKargoSecenekleriGuncelle -> rowCount();

            //Stok yoksa kaldırtmayı unutma.
            $sorgu_stokKontrolSepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id, sepet.variantId, sepet.urunAdedi, urunler_variantlar.variant_stokAdet FROM sepet  JOIN     urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ?");
            $sorgu_stokKontrolSepettekiUrunler ->  execute([$kullanici_id]);
            $stokKontrolSepettekiUrunSayisi = $sorgu_stokKontrolSepettekiUrunler -> rowCount();
            if($stokKontrolSepettekiUrunSayisi > 0){
                $stokKontrolSepettekiUrunler = $sorgu_stokKontrolSepettekiUrunler -> fetchAll(PDO::FETCH_ASSOC);
                foreach($stokKontrolSepettekiUrunler as $stokKontrolSepettekiUrun){
                    $stokKontrolsepetId = $stokKontrolSepettekiUrun["id"];
                    $stokKontrolVaryantIstenenAdet = $stokKontrolSepettekiUrun["urunAdedi"];
                    $stokKontrolVaryantStogu = $stokKontrolSepettekiUrun["variant_stokAdet"];
                    if($stokKontrolVaryantStogu < $stokKontrolVaryantIstenenAdet){
                        if($stokKontrolVaryantStogu != 0){
                            $sorgu_istenenAdediDuzelt = $veritaConn -> prepare("UPDATE sepet SET urunAdedi = ? WHERE id = ? AND uyeId = ?");
                            $sorgu_istenenAdediDuzelt -> execute([$stokKontrolVaryantStogu, $stokKontrolsepetId, $kullanici_id]);
                        }else{
                            $sorgu_stokBitenUrunuSepettenSil = $veritaConn -> prepare("DELETE FROM sepet WHERE id = ? AND uyeId = ?");
                            $sorgu_stokBitenUrunuSepettenSil -> execute([$stokKontrolsepetId, $kullanici_id]);
                        }
                    }
                
                }
            }
            $sorgu_sepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.urunAdedi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_variantBasligi, urunler.urun_kargoUcreti, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet  FROM    sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ? ORDER BY sepet.id   DESC");
            $sorgu_sepettekiUrunler -> execute([$kullanici_id]);
            $sepettekiUrunSayisi = $sorgu_sepettekiUrunler -> rowCount();
            $sepettekiToplamUrunSayisi = 0;
            $sepettekiToplamFiyat = 0;
            $sepettekiToplamKargoUcreti = 0;
            if($sepettekiUrunSayisi > 0){
                $sepettekiUrunler = $sorgu_sepettekiUrunler -> fetchAll(PDO::FETCH_ASSOC);
                foreach($sepettekiUrunler as $sepettekiUrun){
                    $sepetId = DonusumleriGeriDondur($sepettekiUrun["sepetId"]);
                    //$urunAdi = DonusumleriGeriDondur($sepettekiUrun["urun_ad"]);
                    //$urunVariantAdi = DonusumleriGeriDondur($sepettekiUrun["variant_ad"]);
                    //$urunVariantBasligi = DonusumleriGeriDondur($sepettekiUrun["urun_variantBasligi"]);
                    //$urunTuru = DonusumleriGeriDondur($sepettekiUrun["urun_tur"]);
                    //$urunResmi = DonusumleriGeriDondur($sepettekiUrun["urun_resimBir"]);
                    $urunAdedi = DonusumleriGeriDondur($sepettekiUrun["urunAdedi"]);
                    $urunFiyati = DonusumleriGeriDondur($sepettekiUrun["urun_fiyat"]);
                    $urunParaBirimi = DonusumleriGeriDondur($sepettekiUrun["urun_paraBirimi"]);
                    $urunKargoUcreti = DonusumleriGeriDondur($sepettekiUrun["urun_kargoUcreti"]);
                    //URUNUN HESAPLANMIS SON FIYATI
                    switch($urunParaBirimi){
                        case "USD":
                            $hesapUrunFiyatBicim = FiyatBicimlendir($urunFiyati * $kurUSD);
                            $hesapUrunFiyat = $urunFiyati * $kurUSD;
                            break;
                        case "EUR":
                            $hesapUrunFiyatBicim = FiyatBicimlendir($urunFiyati * $kurEuro);
                            $hesapUrunFiyat = $urunFiyati * $kurEuro;
                            break;
                        default:
                            $hesapUrunFiyatBicim = FiyatBicimlendir($urunFiyati);
                            $hesapUrunFiyat = $urunFiyati;
                            break;
                    }
                    //SEPETTEKI TOPLAM URUN SAYISI
                    $sepettekiToplamUrunSayisi += $urunAdedi;
                    $sepettekiToplamFiyat += ($hesapUrunFiyat * $urunAdedi);
                    $sepettekiToplamKargoUcreti += ($urunAdedi * $urunKargoUcreti);
                }
                if($sepettekiToplamFiyat >= $ucretsizKargoBaraji){
                    $sepettekiToplamKargoUcreti = 0;
                }
                $odenecekToplamTutar = $sepettekiToplamFiyat + $sepettekiToplamKargoUcreti;
                $sepettekiToplamKargoFiyatiBicim = FiyatBicimlendir($sepettekiToplamKargoUcreti);
                $odenecekToplamTutarBicim = FiyatBicimlendir($odenecekToplamTutar);
                //Taksitli Fiyatlar
                $ikiTaksit = number_format(($sepettekiToplamFiyat / 2), "2", ",", ".");
                $ucTaksit = number_format(($sepettekiToplamFiyat / 3), "2", ",", ".");
                $dortTaksit = number_format(($sepettekiToplamFiyat / 4), "2", ",", ".");
                $besTaksit = number_format(($sepettekiToplamFiyat / 5), "2", ",", ".");
                $altiTaksit = number_format(($sepettekiToplamFiyat / 6), "2", ",", ".");
                $yediTaksit = number_format(($sepettekiToplamFiyat / 7), "2", ",", ".");
                $sekizTaksit = number_format(($sepettekiToplamFiyat / 8), "2", ",", ".");
                $dokuzTaksit = number_format(($sepettekiToplamFiyat / 9), "2", ",", ".");
            }

?>
<form action="index.php?SO=67" method="post">
    <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="800" valign="top">
                <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td ><h3>Alışveriş Sepeti</h3></td>
                    </tr>
                    <tr height="30">
                        <td  valign="top" style="border-bottom: 1px dashed #3cccb9;">Ödeme Türü Seçimini Aşağıdan Belirtebilirsin.</td>
                    </tr>
                    <tr height="10"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40">
                        <td align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Ödeme Türü Seçimi</strong>
                        </td>
                    </tr>
                    <tr height="10"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr>
                        <td  align="left">
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="50">
                                    <td width="390" align="left">
                                        <table width="390" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/credit-card128.png" border="0">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td align="center"><input type="radio" name="OdemeTuruSecimi" value="Kredi Kartı" onClick="$.KrediKartiSecildi();"></td></tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="20">&nbsp;</td>
                                    <td width="390" align="left">
                                        <table width="390" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/bankcolorized128.png" border="0">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td align="center"><input type="radio" name="OdemeTuruSecimi" value="Banka Havalesi" onClick="$.BankaHavalesiSecildi();"></td></tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="10"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40" class="KKAlan" style="display: none;">
                        <td height="40" width="800" align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Kredi Kartı İle Ödeme</strong>
                        </td>
                    </tr>
                    <tr height="10" class="KKAlan" style="display: none;"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40" class="KKAlan" style="display: none;">
                        <td height="40" width="800" align="left">Ödeme işleminizde aşağıdaki tüm kredi kartı markaları ile veya diğer markalar ile veya ATM (Bankamatik) kartı ile işlem yapabilirsiniz</td>
                    </tr>
                    <tr class="KKAlan" height="10" style="display: none;"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr class="KKAlan" style="display: none;">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/axess_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="11">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/garanti_bonus_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="11">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/cardfinans_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="10">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/maximum_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/world_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="11">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/paraf_card.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="11">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/diger.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                    <td width="10">&nbsp;</td>
                                    <td width="192">
                                        <table width="192" align="center"  border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #3cccb9; margin-bottom: 10px;">
                                            <tr><td>&nbsp;</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="resimler/banka_sertifika/atmkart.png" border="0" width="80" height="40">
                                                </td>
                                            </tr>
                                            <tr><td>&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="40" class="KKAlan" style="display: none;">
                        <td height="40" width="800" align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Taksit Seçimi</strong>
                        </td>
                    </tr>
                    <tr height="10" class="KKAlan" style="display: none;"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40" class="KKAlan" style="display: none;">
                        <td height="40" width="800" align="left">Lütfen ödeme işleminde uygulanmasını istediğiniz taksit sayısını seçiniz.</td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="1"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">Tek Çekim</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">1 x <?php  echo $sepettekiToplamFiyat; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="2"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">2 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">2 x <?php  echo $ikiTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="3"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">3 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">3 x <?php  echo $ucTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="4"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">4 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">4 x <?php  echo $dortTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="5"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">5 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">5 x <?php  echo $besTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="6"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">6 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">6 x <?php  echo $altiTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="7"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">7 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">7 x <?php  echo $yediTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="8"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">8 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">8 x <?php  echo $sekizTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="KKAlan" height="30">
                        <td>
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="30">
                                    <td width="25" align="left" style="border-bottom: 1px dashed #3cccb9;"><input type="radio" name="TaksitSecimi" value="9"></td>
                                    <td width="375" align="left" style="border-bottom: 1px dashed #3cccb9;">9 Taksit</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;">9 x <?php  echo $dokuzTaksit; ?> TL + (Kargo Ücreti)</td>
                                    <td width="200" align="right" style="border-bottom: 1px dashed #3cccb9;"><?php  echo $odenecekToplamTutarBicim; ?> TL</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="40" class="BHAlan" style="display: none;">
                        <td height="40" width="800" align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Banka Havalesi / EFT İle Ödeme</strong>
                        </td>
                    </tr>
                    <tr height="10" class="BHAlan" style="display: none;"><td  style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40" class="BHAlan" style="display: none;">
                        <td height="40" width="800" align="left">Banka havalesi / EFT ile ürün satın alabilmek için, öncelikle alışveriş sepeti tutarını "Banka Hesaplarımız" sayfasında bulunan herhangi bir hesaba ödeme yaptıktan sonra  "Havale Bildirim Formu" aracılığı ile lütfen tarafımıza bilgi veriniz. "Ödeme Yap" butonuna tıkladığınız anda siparişiniz sisteme kayıt edilecektir.</td>
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
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;" >Toplam <b style="color: #3cccb9;"><?php echo $sepettekiToplamUrunSayisi; ?></b> ürün</td>
                    </tr>
                    <tr height="5">
                        <td height="5" style="font-size: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Net Ödenecek Tutar (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($odenecekToplamTutar) ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Ürünlerin Toplam Ücreti (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($sepettekiToplamFiyat) ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">Toplam Kargo Ücreti (KDV Dahil)</td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo $sepettekiToplamKargoFiyatiBicim ?> TL</td>
                    </tr>
                    <tr height="10">
                        <td style="font-size: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right">
                            <input type="submit" value="ÖDEME YAP" class="AlisverisiTamamlaButonu">
                        </td>
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
    }else{
        header("Location:index.php");
        exit();
        ?>
        <?php
    }
?>