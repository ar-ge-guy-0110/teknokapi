<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="1065" align="center" border="0" cellspacing="0" cellpadding="0">
                <?php
                    $sorgu_banner = $veritaConn -> prepare("SELECT * FROM banner WHERE bannerAlani = 'Ana Sayfa' ORDER BY gosterimSayisi ASC LIMIT 1");
                    $sorgu_banner -> execute();
                    $bannerSayisi = $sorgu_banner -> rowCount();
                    if($bannerSayisi > 0){
                        $banner = $sorgu_banner -> fetch(PDO::FETCH_ASSOC);
                        $sorgu_bannerGosterimGuncelle = $veritaConn -> prepare("UPDATE banner SET gosterimSayisi = gosterimSayisi + 1 WHERE id = ? LIMIT 1");
                        $sorgu_bannerGosterimGuncelle -> execute([$banner["id"]]);
                ?>
                <tr height="80">
                    <td><img src="<?php echo $banner["bannerResmi"] ?>" border="0"></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </td>
    </tr>

    <tr height="35">
        <td bgcolor="3cccb9" style="color: black;">&nbsp;<strong>En Yeni Ürünler</strong></td>
    </tr>
    <tr height="5">
        <td style="font-size: 5px;">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <?php
                        $sorgu_enYeniUrunler = $veritaConn -> prepare("SELECT * FROM urunler WHERE urun_durum = '1' ORDER BY id DESC LIMIT 5"); //
                        $sorgu_enYeniUrunler -> execute();
                        $urunSayisi = $sorgu_enYeniUrunler -> rowCount();
                        $urunler = $sorgu_enYeniUrunler -> fetchAll(PDO::FETCH_ASSOC);
                        $donguSayisi = 1;
                        //border: 1px dashed #3cccb9;
                        foreach($urunler as $urun){
                            $urun_adi = DonusumleriGeriDondur($urun["urun_ad"]);
                            $urun_turu = DonusumleriGeriDondur($urun["urun_tur"]);
                            $urun_fiyati = DonusumleriGeriDondur($urun["urun_fiyat"]);
                            $urun_paraBirimi = DonusumleriGeriDondur($urun["urun_paraBirimi"]);
                            $urun_resmi = DonusumleriGeriDondur($urun["urun_resimBir"]);
                            $urun_yorumSayisi = DonusumleriGeriDondur($urun["urun_yorumSayisi"]);
                            $urun_toplamYorumPuani = DonusumleriGeriDondur($urun["urun_toplamYorumPuani"]);
                            
                            if($urun_paraBirimi == "USD"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurUSD;
                            }else if($urun_paraBirimi == "EUR"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurEuro;
                            }else{
                                $urun_hesaplanmisFiyat = $urun_fiyati;
                            }
                            if($urun_yorumSayisi > 0){
                                $puanHesaplama = number_format($urun_toplamYorumPuani / $urun_yorumSayisi, 2, ".", "");
                            }else{
                                $puanHesaplama = 0;
                            }
                            
                            if($puanHesaplama == 0){
                                $puanResmi = "resimler/rating/ratingZeroStar.png";
                            }else if(($puanHesaplama > 0) and ($puanHesaplama <= 1)){
                                $puanResmi = "resimler/rating/ratingOneStar.png";
                            }else if(($puanHesaplama > 1) and ($puanHesaplama <= 2)){
                                $puanResmi = "resimler/rating/ratingTwoStar.png";
                            }else if(($puanHesaplama > 2) and ($puanHesaplama <= 3)){
                                $puanResmi = "resimler/rating/ratingThreeStar.png";
                            }else if(($puanHesaplama > 3) and ($puanHesaplama <= 4)){
                                $puanResmi = "resimler/rating/ratingFourStar.png";
                            }else if($puanHesaplama > 4){
                                $puanResmi = "resimler/rating/ratingFiveStar.png";
                            }
                    ?>
                    <td width="205" valign="top">
                        <table width="205" align="left" border="0" cellpadding="0" cellspacing="0"  style="margin-bottom: 10px">
                            <tr height="40">
                                <td align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun_resmi); ?>" border="0" width="185" height="247"></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #3cccb9; font-weight: bold; text-decoration: none;"><?php echo $urun_turu; ?></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205; max-width: 205; height: 20px; overflow: hidden; line-height: 20px;"><?php echo $urun_adi; ?></div></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #050307; font-weight: bold; text-decoration: none;"><?php echo DonusumleriGeriDondur(FiyatBicimlendir($urun_hesaplanmisFiyat)); ?> TL</a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="<?php echo $puanResmi; ?>" width="180" height="30" border="0"></a></td>
                            </tr>
                        </table>
                        <br />
                    </td>
                    <?php
                            if($donguSayisi < 4){
                    ?>
                    <td width="10">&nbsp;</td>
                    <?php
                            }
                            $donguSayisi++;
                        }
                    ?>
                    </tr>
                </tr>
            </table>
        </td>
    </tr>

    <tr height="35">
    <td bgcolor="3cccb9" style="color: black;">&nbsp;<strong>En Popüler Ürünler</strong></td>
    </tr>
    <tr height="5">
        <td style="font-size: 5px;">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <?php
                        $sorgu_enPopulerUrunler = $veritaConn -> prepare("SELECT * FROM urunler WHERE urun_durum = '1' ORDER BY urun_goruntulenmeSayisi DESC LIMIT 5"); //
                        $sorgu_enPopulerUrunler -> execute();
                        $urunSayisi = $sorgu_enPopulerUrunler -> rowCount();
                        $urunler = $sorgu_enPopulerUrunler -> fetchAll(PDO::FETCH_ASSOC);
                        $donguSayisi = 1;
                        //border: 1px dashed #3cccb9;
                        foreach($urunler as $urun){
                            $urun_adi = DonusumleriGeriDondur($urun["urun_ad"]);
                            $urun_turu = DonusumleriGeriDondur($urun["urun_tur"]);
                            $urun_fiyati = DonusumleriGeriDondur($urun["urun_fiyat"]);
                            $urun_paraBirimi = DonusumleriGeriDondur($urun["urun_paraBirimi"]);
                            $urun_resmi = DonusumleriGeriDondur($urun["urun_resimBir"]);
                            $urun_yorumSayisi = DonusumleriGeriDondur($urun["urun_yorumSayisi"]);
                            $urun_toplamYorumPuani = DonusumleriGeriDondur($urun["urun_toplamYorumPuani"]);
                            
                            if($urun_paraBirimi == "USD"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurUSD;
                            }else if($urun_paraBirimi == "EUR"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurEuro;
                            }else{
                                $urun_hesaplanmisFiyat = $urun_fiyati;
                            }
                            if($urun_yorumSayisi > 0){
                                $puanHesaplama = number_format($urun_toplamYorumPuani / $urun_yorumSayisi, 2, ".", "");
                            }else{
                                $puanHesaplama = 0;
                            }
                            
                            if($puanHesaplama == 0){
                                $puanResmi = "resimler/rating/ratingZeroStar.png";
                            }else if(($puanHesaplama > 0) and ($puanHesaplama <= 1)){
                                $puanResmi = "resimler/rating/ratingOneStar.png";
                            }else if(($puanHesaplama > 1) and ($puanHesaplama <= 2)){
                                $puanResmi = "resimler/rating/ratingTwoStar.png";
                            }else if(($puanHesaplama > 2) and ($puanHesaplama <= 3)){
                                $puanResmi = "resimler/rating/ratingThreeStar.png";
                            }else if(($puanHesaplama > 3) and ($puanHesaplama <= 4)){
                                $puanResmi = "resimler/rating/ratingFourStar.png";
                            }else if($puanHesaplama > 4){
                                $puanResmi = "resimler/rating/ratingFiveStar.png";
                            }
                    ?>
                    <td width="205" valign="top">
                        <table width="205" align="left" border="0" cellpadding="0" cellspacing="0"  style="margin-bottom: 10px">
                            <tr height="40">
                                <td align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun_resmi); ?>" border="0" width="185" height="247"></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #3cccb9; font-weight: bold; text-decoration: none;"><?php echo $urun_turu; ?></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205; max-width: 205; height: 20px; overflow: hidden; line-height: 20px;"><?php echo $urun_adi; ?></div></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #050307; font-weight: bold; text-decoration: none;"><?php echo DonusumleriGeriDondur(FiyatBicimlendir($urun_hesaplanmisFiyat)); ?> TL</a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="<?php echo $puanResmi; ?>" width="180" height="30" border="0"></a></td>
                            </tr>
                        </table>
                        <br />
                    </td>
                    <?php
                            if($donguSayisi < 4){
                    ?>
                    <td width="10">&nbsp;</td>
                    <?php
                            }
                            $donguSayisi++;
                        }
                    ?>
                    </tr>
                </tr>
            </table>
        </td>
    </tr>

    <tr height="35">
    <td bgcolor="3cccb9" style="color: black;">&nbsp;<strong>En Çok Satılan Ürünler</strong></td>
    </tr>
    <tr height="5">
        <td style="font-size: 5px;">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <?php
                        $sorgu_enCokSatilanUrunler = $veritaConn -> prepare("SELECT * FROM urunler WHERE urun_durum = '1' ORDER BY urun_toplamSatisSayisi DESC LIMIT 5"); //
                        $sorgu_enCokSatilanUrunler -> execute();
                        $urunSayisi = $sorgu_enCokSatilanUrunler -> rowCount();
                        $urunler = $sorgu_enCokSatilanUrunler -> fetchAll(PDO::FETCH_ASSOC);
                        $donguSayisi = 1;
                        //border: 1px dashed #3cccb9;
                        foreach($urunler as $urun){
                            $urun_adi = DonusumleriGeriDondur($urun["urun_ad"]);
                            $urun_turu = DonusumleriGeriDondur($urun["urun_tur"]);
                            $urun_fiyati = DonusumleriGeriDondur($urun["urun_fiyat"]);
                            $urun_paraBirimi = DonusumleriGeriDondur($urun["urun_paraBirimi"]);
                            $urun_resmi = DonusumleriGeriDondur($urun["urun_resimBir"]);
                            $urun_yorumSayisi = DonusumleriGeriDondur($urun["urun_yorumSayisi"]);
                            $urun_toplamYorumPuani = DonusumleriGeriDondur($urun["urun_toplamYorumPuani"]);
                            
                            if($urun_paraBirimi == "USD"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurUSD;
                            }else if($urun_paraBirimi == "EUR"){
                                $urun_hesaplanmisFiyat = $urun_fiyati * $kurEuro;
                            }else{
                                $urun_hesaplanmisFiyat = $urun_fiyati;
                            }
                            if($urun_yorumSayisi > 0){
                                $puanHesaplama = number_format($urun_toplamYorumPuani / $urun_yorumSayisi, 2, ".", "");
                            }else{
                                $puanHesaplama = 0;
                            }
                            
                            if($puanHesaplama == 0){
                                $puanResmi = "resimler/rating/ratingZeroStar.png";
                            }else if(($puanHesaplama > 0) and ($puanHesaplama <= 1)){
                                $puanResmi = "resimler/rating/ratingOneStar.png";
                            }else if(($puanHesaplama > 1) and ($puanHesaplama <= 2)){
                                $puanResmi = "resimler/rating/ratingTwoStar.png";
                            }else if(($puanHesaplama > 2) and ($puanHesaplama <= 3)){
                                $puanResmi = "resimler/rating/ratingThreeStar.png";
                            }else if(($puanHesaplama > 3) and ($puanHesaplama <= 4)){
                                $puanResmi = "resimler/rating/ratingFourStar.png";
                            }else if($puanHesaplama > 4){
                                $puanResmi = "resimler/rating/ratingFiveStar.png";
                            }
                    ?>
                    <td width="205" valign="top">
                        <table width="205" align="left" border="0" cellpadding="0" cellspacing="0"  style="margin-bottom: 10px">
                            <tr height="40">
                                <td align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun_resmi); ?>" border="0" width="185" height="247"></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #3cccb9; font-weight: bold; text-decoration: none;"><?php echo $urun_turu; ?></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205; max-width: 205; height: 20px; overflow: hidden; line-height: 20px;"><?php echo $urun_adi; ?></div></a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #050307; font-weight: bold; text-decoration: none;"><?php echo DonusumleriGeriDondur(FiyatBicimlendir($urun_hesaplanmisFiyat)); ?> TL</a></td>
                            </tr>
                            <tr height="25">
                                <td width="205" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="<?php echo $puanResmi; ?>" width="180" height="30" border="0"></a></td>
                            </tr>
                        </table>
                        <br />
                    </td>
                    <?php
                            if($donguSayisi < 4){
                    ?>
                    <td width="10">&nbsp;</td>
                    <?php
                            }
                            $donguSayisi++;
                        }
                    ?>
                    </tr>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="258">
                        <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center"><img src="resimler/icons/fastdelivery128.png" border="0"></td>
                            </tr>
                            <tr>
                                <td align="center"><b>Bugün Teslimat</b></td>
                            </tr>
                            <tr>
                                <td align="center">Saat 14:00' a kadar verdiğiniz siparişler aynı gün kapınızda.</td>
                            </tr>
                        </table>
                    </td>
                    <td width="11">&nbsp;</td>
                    <td width="258">
                        <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center"><img src="resimler/icons/security128.png" border="0"></td>
                                </tr>
                                <tr>
                                    <td align="center"><b>Tek Tıkla Güvenli Alışveriş</b></td>
                                </tr>
                                <tr>
                                    <td align="center">Ödeme bilgilerinizi kaydedin, güvenli alışveriş yapın.</td>
                                </tr>
                        </table>
                    </td>
                    <td width="11">&nbsp;</td>
                    <td width="258">
                        <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center"><img src="resimler/icons/mobile128.png" border="0"></td>
                            </tr>
                            <tr>
                                <td align="center"><b>Mobil Erişim</b></td>
                            </tr>
                            <tr>
                                <td align="center">Her platformdan sitemize erişebilir ve alışveriş yapabilirsiniz.</td>
                            </tr>
                        </table>
                    </td>
                    <td width="11">&nbsp;</td>
                    <td width="258">
                        <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center"><img src="resimler/icons/return128.png" border="0"></td>
                            </tr>
                            <tr>
                                <td align="center"><b>Kolay İade</b></td>
                            </tr>
                            <tr>
                                <td align="center">Aldığınız herhangi bir ürünü 14 gün içerisinde kolaylıkla iade edebilirsiniz.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>