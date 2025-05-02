<?php
    if(isset($_GET["id"])){
        $gelen_urunId = SayiliIcerikleriFiltrele(Guvenlik($_GET["id"]));

        $query_urun = $veritaConn -> prepare("SELECT * FROM urunler WHERE id = ? AND urun_durum = 1 LIMIT 1");
        $query_urun -> execute([$gelen_urunId]);
        $urunSayisi = $query_urun -> rowCount();

        if($urunSayisi > 0){
            $urunBilgileri = $query_urun -> fetch(PDO::FETCH_ASSOC);

            $urun_id = DonusumleriGeriDondur($urunBilgileri["id"]);
            $urun_adi = DonusumleriGeriDondur($urunBilgileri["urun_ad"]);
            $urun_fiyati = DonusumleriGeriDondur($urunBilgileri["urun_fiyat"]);
            $urun_paraBirimi = DonusumleriGeriDondur($urunBilgileri["urun_paraBirimi"]);
            $urun_turu = DonusumleriGeriDondur($urunBilgileri["urun_tur"]);
            $urun_yorumSayisi = DonusumleriGeriDondur($urunBilgileri["urun_yorumSayisi"]);
            $urun_toplamYorumPuani = DonusumleriGeriDondur($urunBilgileri["urun_toplamYorumPuani"]);
            $urun_resmi1 = DonusumleriGeriDondur($urunBilgileri["urun_resimBir"]);
            $urun_resmi2 = DonusumleriGeriDondur($urunBilgileri["urun_resimIki"]);
            $urun_resmi3 = DonusumleriGeriDondur($urunBilgileri["urun_resimUc"]);
            $urun_resmi4 = DonusumleriGeriDondur($urunBilgileri["urun_resimDort"]);
            $resimYolu = "resimler/urun/" . ConvertEng($urun_turu) . "/";
            $urun_variantBasligi = DonusumleriGeriDondur($urunBilgileri["urun_variantBasligi"]);
            $urun_aciklama = DonusumleriGeriDondur($urunBilgileri["urun_aciklama"]);

            //HIT GUNCELLE
            $sorgu_urunHitGuncelle = $veritaConn -> prepare("UPDATE urunler SET urun_goruntulenmeSayisi = (urun_goruntulenmeSayisi + 1) WHERE id = ?");
            $sorgu_urunHitGuncelle -> execute([$urun_id]);
            //HIT GUNCELLE END

            if($urun_paraBirimi == "USD"){
                $urun_hesaplanmisFiyat = $urun_fiyati * $kurUSD;
            }else if($urun_paraBirimi == "EUR"){
                $urun_hesaplanmisFiyat = $urun_fiyati * $kurEuro;
            }else{
                $urun_hesaplanmisFiyat = $urun_fiyati;
            }
            ?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="350" valign="top">
            <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="border: 1px solid #3cccb9;" align="center"><img id="BigImage" src="<?php echo DonusumleriGeriDondur($resimYolu) . DonusumleriGeriDondur($urun_resmi1); ?>" border="0" width="330" height="440"></td>
                </tr>
                <tr height="5"><td style="font-size: 5px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="78" style="border: 1px solid #3cccb9;"><img src="<?php echo DonusumleriGeriDondur($resimYolu) . DonusumleriGeriDondur($urun_resmi1); ?>" border="0" width="78" height="104" onClick="$.ChangeTheBigImage('<?php echo $resimYolu . $urun_resmi1; ?>')"></td>
                                <td width="10">&nbsp;</td>
                                <?php if($urun_resmi2 != ""){?><td width="78" style="border: 1px solid #3cccb9;"><img src="<?php echo DonusumleriGeriDondur($resimYolu) . DonusumleriGeriDondur($urun_resmi2); ?>" border="0" width="78" height="104" onClick="$.ChangeTheBigImage('<?php echo $resimYolu . $urun_resmi2; ?>')"></td><?php }else{ ?><td width="78">&nbsp;</td><?php } ?>
                                <td width="10">&nbsp;</td>
                                <?php if($urun_resmi3 != ""){?><td width="78" style="border: 1px solid #3cccb9;"><img src="<?php echo DonusumleriGeriDondur($resimYolu) . DonusumleriGeriDondur($urun_resmi3); ?>" border="0" width="78" height="104" onClick="$.ChangeTheBigImage('<?php echo $resimYolu . $urun_resmi3; ?>')"></td><?php }else{ ?><td width="78">&nbsp;</td><?php } ?>
                                <td width="10">&nbsp;</td>
                                <?php if($urun_resmi4 != ""){?><td width="78" style="border: 1px solid #3cccb9;"><img src="<?php echo DonusumleriGeriDondur($resimYolu) . DonusumleriGeriDondur($urun_resmi4); ?>" border="0" width="78" height="104" onClick="$.ChangeTheBigImage('<?php echo $resimYolu . $urun_resmi4; ?>')"></td><?php }else{ ?><td width="78">&nbsp;</td><?php } ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr height="50">
                                <td bgcolor="#F1F1F1"><b>&nbsp;REKLAMLAR</b></td>
                            </tr>
                                <?php
                                    $sorgu_banner = $veritaConn -> prepare("SELECT * FROM banner WHERE bannerAlani = 'Ürün Detay' ORDER BY gosterimSayisi ASC LIMIT 1");
                                    $sorgu_banner -> execute();;
                                    $banner = $sorgu_banner -> fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <tr height="350">
                                        <td><img src="<?php echo DonusumleriGeriDondur($banner["bannerResmi"]); ?>" border="0"></td>
                                    </tr>
                                <?php
                                    $sorgu_bannerGuncelle = $veritaConn -> prepare("UPDATE banner SET gosterimSayisi = gosterimSayisi + 1 WHERE id = ? LIMIT 1");
                                    $sorgu_bannerGuncelle -> execute([DonusumleriGeriDondur($banner["id"])]);
                                ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="10" valign="top">&nbsp;</td>
        <td width="705" valign="top">
            <table width="705" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="50" bgcolor="#F1F1F1">
                    <td style="text-align: left; font-size: 18px; font-weight: bold;">&nbsp;<?php echo DonusumleriGeriDondur($urun_adi); ?></td>
                </tr>
                <tr>
                    <td>
                        <form action="index.php?SO=60&id=<?php echo DonusumleriGeriDondur($urun_id); ?>" method="post">
                            <table width="705" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr height="45">
                                    <td width="30"><a href="<?php echo DonusumleriGeriDondur($soslink_facebook); ?>" target="_blank"><img src="resimler/icons/facebook24x24.png" border="0" style="margin-top: 5px"></a></td>
                                    <td width="30"><a href="<?php echo DonusumleriGeriDondur($soslink_twitter); ?>" target="_blank"><img src="resimler/icons/twitter24x24.png" border="0" style="margin-top: 5px"></a></td>
                                    <?php
                                        if(isset($_SESSION["kullanici_email"])){
                                    ?>
                                    <td width="30"><a href="index.php?SO=59&id=<?php echo DonusumleriGeriDondur($urun_id); ?>"><img src="resimler/icons/star.png" border="0" style="margin-top: 5px"></a></td>
                                    <?php
                                        }else{
                                    ?>
                                    <td width="30"><img src="resimler/icons/star.png" border="0" style="margin-top: 5px"></td>
                                    <?php
                                        }
                                    ?>
                                    <td width="10">&nbsp;</td>
                                    <td width="605"><input type="submit" value="SEPETE EKLE" class="SepeteEklemeButonu"></td>
                                </tr>
                                <tr height="45">
                                    <td colspan="5">
                                        <table width="705" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr height="45">
                                                <td width="500" align="left">
                                                    <select name="variant" class="beaucombobox">
                                                        <option value="">Lütfen <?php echo DonusumleriGeriDondur($urun_variantBasligi); ?> Seçiniz</option>
                                                        <?php
                                                            $sorgu_urunVaryantlari = $veritaConn -> prepare("SELECT * FROM urunler_variantlar WHERE urun_id = ? AND variant_stokAdet > 0 ORDER BY variant_ad ASC");
                                                            $sorgu_urunVaryantlari -> execute([DonusumleriGeriDondur($urun_id)]);
                                                            $varyantSayisi = $sorgu_urunVaryantlari -> rowCount();
                                                            if($varyantSayisi > 0){
                                                                $varyantlar = $sorgu_urunVaryantlari -> fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($varyantlar as $varyant){

                                                        ?>
                                                        <option value="<?php echo DonusumleriGeriDondur($varyant["id"]); ?>"><?php echo $varyant["variant_ad"]; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td width="205" align="right" style="font-size: 25px; color: black; font-weight: bold;"><?php echo DonusumleriGeriDondur(FiyatBicimlendir($urun_hesaplanmisFiyat)); ?> TL</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>
                <tr>
                    <td>
                        <table width="705" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr height="30">
                                <td>
                                    <img src="resimler/icons/hourglass.png" border="0" style="margin-top: 3px;">
                                </td>
                                <td>
                                    Siparişiniz <?php echo UcGunIleriTarihBul(); ?> tarihine kadar kargoya verilecektir.
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    <img src="resimler/icons/clock24x24_1.png" border="0" style="margin-top: 3px;">
                                </td>
                                <td>
                                    İlgili ürün süper hızlı gönderi kapsamındadır. Aynı gün teslimat yapılabilir.
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    <img src="resimler/icons/credit.png" border="0" style="margin-top: 3px;">
                                </td>
                                <td>
                                    Tüm bankaların kredi kartları ile peşin veya taksitli ödeme seçeneği.
                                </td>
                            </tr>
                            <tr height="30">
                                <td>
                                    <img src="resimler/icons/bank2.png" border="0" style="margin-top: 3px;">
                                </td>
                                <td>
                                    Tüm bankalardan havale veya EFT ile ödeme seçeneği.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>
                <tr height="30">
                    <td style="color: #000;background-color: #3cccb9; font-weight: bold;">Ürün Açıklaması</td>
                </tr>
                <tr>
                    <td><?php echo $urun_aciklama; ?></td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>
                <tr height="30">
                    <td style="color: #000;background-color: #3cccb9; font-weight: bold;">Yorumlar</td>
                </tr>
                <tr>
                    <td>
                        <div style="width: 705px; max-width: 705px; height: 300px; max-height: 300px; overflow-y: scroll;">
                            <table width="685" align="left" border="0" cellpadding="0" cellspacing="0">
                                <?php
                                    $sorgu_urunYorumlari = $veritaConn -> prepare("SELECT yorumlar.urun_id, yorumlar.uye_id, yorumlar.puan, yorumlar.yorum_metni, yorumlar.yorum_tarihi, uyeler.uye_tamisim FROM yorumlar JOIN uyeler ON yorumlar.uye_id = uyeler.id WHERE yorumlar.urun_id = ? ORDER BY yorum_tarihi DESC");
                                    $sorgu_urunYorumlari -> execute([$urun_id]);
                                    $yorumSayisi = $sorgu_urunYorumlari -> rowCount();
                                    if($yorumSayisi > 0){
                                        $urunYorumlari = $sorgu_urunYorumlari -> fetchAll(PDO::FETCH_ASSOC);
                                        foreach($urunYorumlari as $urunYorumu){
                                            $urunPuani = DonusumleriGeriDondur($urunYorumu["puan"]);
                                            switch($urunPuani){
                                                case 1:
                                                    $urunPuanResmi = "resimler/rating/ratingOneStar64x9.png";
                                                    break;
                                                case 2:
                                                    $urunPuanResmi = "resimler/rating/ratingTwoStar64x9.png";
                                                    break;
                                                case 3:
                                                    $urunPuanResmi = "resimler/rating/ratingThreeStar64x9.png";
                                                    break;
                                                case 4:
                                                    $urunPuanResmi = "resimler/rating/ratingFourStar64x9.png";
                                                    break;
                                                case 5:
                                                    $urunPuanResmi = "resimler/rating/ratingFiveStar64x9.png";
                                                    break;
                                                default:
                                                    $urunPuanResmi = "resimler/rating/ratingZeroStar64x9.png";
                                                    break;
                                            }
                                            $urunYorumcusuTamAdi = DonusumleriGeriDondur($urunYorumu["uye_tamisim"]);
                                            $urunYorumTarihi = TarihBul(DonusumleriGeriDondur($urunYorumu["yorum_tarihi"]));
                                            $urunYorumuIcerigi = DonusumleriGeriDondur($urunYorumu["yorum_metni"]);
                                        ?>
                                        <tr height="30">
                                            <td width="64"><img src="<?php echo $urunPuanResmi; ?>"></td>
                                            <td width="10">&nbsp;</td>
                                            <td width="451"><?php echo $urunYorumcusuTamAdi; ?></td>
                                            <td width="10">&nbsp;</td>
                                            <td width="150" align="right"><?php echo $urunYorumTarihi; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="border-bottom: 1px dashed #ccc;"><?php echo $urunYorumuIcerigi; ?></td>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                        <td colspan="5">Bu ürüne henüz yorum yapılmamış...</td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

















            <?php
        }else{
            header("Location:index.php");
            exit();
        }
    }else{
        header("Location:index.php");
        exit();
    }
?>