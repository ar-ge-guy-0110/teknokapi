<?php
    if(isset($_SESSION["kullanici_email"])){
        //Stok yoksa kaldırtmayı unutma.
        $sorgu_stokKontrolSepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id, sepet.variantId, sepet.urunAdedi, urunler_variantlar.variant_stokAdet FROM sepet JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ?");
        $sorgu_stokKontrolSepettekiUrunler ->  execute([$kullanici_id]);
        $stokKontrolSepettekiUrunSayisi = $sorgu_stokKontrolSepettekiUrunler -> rowCount();
        if($stokKontrolSepettekiUrunSayisi > 0){
            $sorgu_sepetiGuncelle = $veritaConn -> prepare("UPDATE sepet SET adresId = ?, kargoFirmasiSecimi = ?, odemeSecimi = ?, taksitSecimi = ? WHERE uyeId = ?");
            $sorgu_sepetiGuncelle -> execute([0, 0, "", 0, $kullanici_id]);
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
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="800" valign="top">
            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td ><h3>Alışveriş Sepeti</h3></td>
                </tr>
                <tr height="30">
                    <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Alışveriş Sepetinize Eklemiş Olduğunuz Ürünler Aşağıdadır.</td>
                </tr>
                <?php
                    $sorgu_sepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.urunAdedi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_variantBasligi, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet FROM sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ? ORDER BY sepet.id DESC");
                    $sorgu_sepettekiUrunler -> execute([$kullanici_id]);
                    $sepettekiUrunSayisi = $sorgu_sepettekiUrunler -> rowCount();
                    $sepettekiToplamUrunSayisi = 0;
                    $sepettekiToplamFiyat = 0;
                    if($sepettekiUrunSayisi > 0){
                        $sepettekiUrunler = $sorgu_sepettekiUrunler -> fetchAll(PDO::FETCH_ASSOC);

                        foreach($sepettekiUrunler as $sepettekiUrun){
                            $sepetId = DonusumleriGeriDondur($sepettekiUrun["sepetId"]);
                            $urunAdi = DonusumleriGeriDondur($sepettekiUrun["urun_ad"]);
                            $urunVariantAdi = DonusumleriGeriDondur($sepettekiUrun["variant_ad"]);
                            $urunVariantBasligi = DonusumleriGeriDondur($sepettekiUrun["urun_variantBasligi"]);
                            $urunTuru = DonusumleriGeriDondur($sepettekiUrun["urun_tur"]);
                            $urunResmi = DonusumleriGeriDondur($sepettekiUrun["urun_resimBir"]);
                            $urunAdedi = DonusumleriGeriDondur($sepettekiUrun["urunAdedi"]);
                            $urunFiyati = DonusumleriGeriDondur($sepettekiUrun["urun_fiyat"]);
                            $urunParaBirimi = DonusumleriGeriDondur($sepettekiUrun["urun_paraBirimi"]);
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

                            $birUrunToplamFiyatiBicim = FiyatBicimlendir($hesapUrunFiyat * $urunAdedi);
                ?>
                <tr height="100">
                    <td valign="bottom" align="left">
                        <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td  width="80" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                    <img src="resimler/urun/<?php echo ConvertEng($urunTuru); ?>/<?php echo $urunResmi; ?>" border="0" width="60" height="80">
                                </td>
                                <td width="40" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                    <a href="index.php?SO=62&id=<?php echo $sepetId; ?>"><img src="resimler/button/delete.png" border="0"></a>
                                </td>
                                <td width="540" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                    <?php echo  $urunAdi; ?><br /><?php echo  $urunVariantBasligi; ?>: <?php echo  $urunVariantAdi; ?>
                                </td>
                                <td width="90" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                    <table width="90" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="30" align="center"><?php if($urunAdedi > 1){ ?><a href="index.php?SO=63&id=<?php echo $sepetId; ?>"><img src="resimler/icons/remove.png" border="0" style="margin-top: 5px;"></a><?php } ?></td>
                                            <td width="30" align="center" style="line-height: 20px;"><?php echo $urunAdedi; ?></td>
                                            <td width="30" align="center"><a href="index.php?SO=64&id=<?php echo $sepetId; ?>"><img src="resimler/icons/add.png" border="0" style="margin-top: 5px;"></a></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="150" style="border-bottom: 1px dashed #3cccb9;" align="right">
                                    <?php echo $hesapUrunFiyatBicim; ?> TL<br/><?php echo $birUrunToplamFiyatiBicim; ?> TL
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr height="30">
                    <td valign="bottom" align="left">Alışveriş Sepetinizde Ürün Bulunmamaktadır.</td>
                </tr>
                <?php
                    }
                ?>
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
                    <td align="right">Ödenecek Tutar (KDV Dahil)</td>
                </tr>
                <tr>
                    <td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($sepettekiToplamFiyat); ?> TL</td>
                </tr>
                <tr height="10">
                    <td style="font-size: 10px;">&nbsp;</td>
                </tr>
                <tr>
                    <td><div class="SepetDevamButtonu"><a href="index.php?SO=65"><img src="resimler/icons/online-shopping24x24.png" border="0"><div>DEVAM ET</div></a></div></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        <?php
    }
    else{
        header("Location:index.php");
        exit();
        ?>
        <?php
    }
?>