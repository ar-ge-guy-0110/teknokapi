<?php
    if(isset($_SESSION["kullanici_email"])){
        //Stok yoksa kaldırtmayı unutma.
        $sorgu_stokKontrolSepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id, sepet.variantId, sepet.urunAdedi, urunler_variantlar.variant_stokAdet FROM sepet JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ?");
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
?>
<form action="index.php?SO=66" method="post">
    <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="800" valign="top">
                <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td colspan="2"><h3>Alışveriş Sepeti</h3></td>
                    </tr>
                    <tr height="30">
                        <td colspan="2" valign="top" style="border-bottom: 1px dashed #3cccb9;">Adres ve Kargo Seçimini Aşağıdan Belirtebilirsin.</td>
                    </tr>
                    <tr height="10"><td colspan="2" style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40">
                        <td align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Adres Seçimi</strong>
                        </td>
                        <td align="right" bgcolor="#3cccb9">
                            <a href="index.php?SO=45" style="color: #101010; text-decoration: none; font-weight: bold;">+ Yeni Adres Ekle&nbsp;</a>
                        </td>
                    </tr>
                    <?php
                        $sorgu_sepettekiUrunler = $veritaConn -> prepare("SELECT sepet.id AS sepetId, sepet.urunAdedi, urunler.urun_tur, urunler.urun_resimBir, urunler.urun_ad, urunler.urun_fiyat, urunler.urun_paraBirimi, urunler.urun_variantBasligi, urunler.urun_kargoUcreti, urunler_variantlar.variant_ad, urunler_variantlar.variant_stokAdet FROM sepet JOIN urunler ON sepet.urunId = urunler.id JOIN urunler_variantlar ON sepet.variantId = urunler_variantlar.id WHERE sepet.uyeId = ? ORDER BY sepet.id DESC");
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

                                $birUrunToplamFiyatiBicim = FiyatBicimlendir($hesapUrunFiyat * $urunAdedi);
                            }

                            if($sepettekiToplamFiyat >= $ucretsizKargoBaraji){
                                $sepettekiToplamKargoUcreti = 0;
                            }

                            $sepettekiToplamKargoFiyatiBicim = FiyatBicimlendir($sepettekiToplamKargoUcreti);
                            $odenecekToplamTutar = $sepettekiToplamFiyat + $sepettekiToplamKargoUcreti;

                            $sorgu_kullaniciAdresleri = $veritaConn -> prepare("SELECT * FROM uyeler_adresler WHERE uye_id = ? ORDER BY id DESC");
                            $sorgu_kullaniciAdresleri -> execute([$kullanici_id]);
                            $kullaniciAdresSayisi = $sorgu_kullaniciAdresleri -> rowCount();
                            $kullaniciAdresleri = $sorgu_kullaniciAdresleri -> fetchAll(PDO::FETCH_ASSOC);
                            if($kullaniciAdresSayisi > 0){
                                foreach($kullaniciAdresleri as $kullaniciAdresi){

                    ?>
                    <tr>
                        <td colspan="2" align="left">
                            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="50">
                                    <td width="25" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                        <input type="radio" name="AdresSecimi" value="<?php echo DonusumleriGeriDondur($kullaniciAdresi["id"]); ?>">
                                    </td>
                                    <td width="775" style="border-bottom: 1px dashed #3cccb9;" align="left">
                                        <?php echo DonusumleriGeriDondur($kullaniciAdresi["tamisim"]); ?> - <?php echo DonusumleriGeriDondur($kullaniciAdresi["adres"]); ?> <?php echo DonusumleriGeriDondur($kullaniciAdresi["ilce"]); ?> / <?php echo DonusumleriGeriDondur($kullaniciAdresi["il"]); ?> - <?php echo DonusumleriGeriDondur($kullaniciAdresi["telno"]); ?>
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
                        <td colspan="2" align="left">Sisteme Kayıtlı Adresiniz Bulunmamaktadır. Lütfen Öncelikle "Hesabım" Alanından Adres Ekleyiniz.<br /> Adres Eklemek İçin <a href="index.php?SO=43" style="color: #646464; text-decoration: none;"><strong>Buraya</strong></a> Tıklayınız.</td>
                    </tr>
                    <?php
                            }
                    ?>
                    <tr height="10"><td colspan="2" style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40">
                        <td colspan="2" align="left" bgcolor="#3cccb9" style="color: #101010">
                            &nbsp;<strong>Kargo Firması Seçimi</strong>
                        </td>
                    </tr>
                    <tr height="10"><td colspan="2" style="font-size: 10px;">&nbsp;</td></tr>
                    <tr height="40">
                        <td colspan="2"  align="left">
							<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
									<?php 
										$sorgu_kargoFirmalari = $veritaConn -> prepare("SELECT * FROM kargo_firmalar");
										$sorgu_kargoFirmalari -> execute();
										$firma_sayisi = $sorgu_kargoFirmalari -> rowCount();
										$firma_kayitlari = $sorgu_kargoFirmalari -> fetchAll(PDO::FETCH_ASSOC);

										$firma_yazdir_dongu_sayisi = 1;
										$firma_yazdir_sutun_adedi = 3;

										foreach($firma_kayitlari as $firma){
											if(($firma_yazdir_dongu_sayisi > $firma_yazdir_sutun_adedi) or ($firma_yazdir_dongu_sayisi == 1)){
												echo "<tr>";
											}
									?>
									<td width="260">
										<table align="center" border="0" cellpadding="0" cellspacing="0"  style="border: 1px dashed #3cccb9; margin-bottom: 10px">
                                            <tr>
												<td colspan="2" align="center">&nbsp;</td>
											</tr>
											<tr height="80">
												<td colspan="2" align="center"><img src="<?php echo DonusumleriGeriDondur($firma["logo"]); ?>" border="0" width="260" height="80"></td>
											</tr>
											<tr height="25">
												<td width="25"><input type="radio" name="KargoSecimi" value="<?php echo DonusumleriGeriDondur($firma["id"]); ?>"></td>
												<td width="235"><?php echo DonusumleriGeriDondur($firma["ad"]); ?></td>
											</tr>
                                            <tr>
												<td colspan="2" align="center">&nbsp;</td>
											</tr>
										</table>
									</td>
									<?php
										    if($firma_yazdir_dongu_sayisi < $firma_yazdir_sutun_adedi){
											

										
									?>
									<td width="20">&nbsp;</td>
									<?php
										    }
											if($firma_yazdir_dongu_sayisi > $firma_yazdir_sutun_adedi){
												echo "</tr>";

											}
											$firma_yazdir_dongu_sayisi++;
											if($firma_yazdir_dongu_sayisi > $firma_yazdir_sutun_adedi){
												$firma_yazdir_dongu_sayisi = 1;
											}
										}
									?>
							<table>
                        </td>
                    </tr>
                    <?php
                        }else{
                            header("Location:index.php?SO=61");
                            exit();
                    ?>
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
                            <input type="submit" value="ÖDEME SEÇİMİ" class="AlisverisiTamamlaButonu">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
        <?php
    }
    else{
        header("Location:index.php");
        exit();
        ?>
        <?php
    }
?>