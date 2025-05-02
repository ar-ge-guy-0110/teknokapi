<?php
    if(isset($_REQUEST["menu_id"])){
        $gelen_menuId = SayiliIcerikleriFiltrele(Guvenlik($_REQUEST["menu_id"]));
        $menuKosulu = " AND menuId = '" . $gelen_menuId . "'";
        $sayfalamaKosulu = "&menu_id=" . $gelen_menuId;
    }else{
        $gelen_menuId = "";
        $menuKosulu = "";
        $sayfalamaKosulu = "";
    }
    if(isset($_REQUEST["aramaIcerigi"])){
        $gelen_aramaIcerigi = Guvenlik($_REQUEST["aramaIcerigi"]);
        $aramaKosulu = "AND urun_ad LIKE '%" . $gelen_aramaIcerigi . "%'";
        $sayfalamaKosulu .= "&aramaIcerigi=" . $gelen_aramaIcerigi;
    }else{
        $gelen_aramaIcerigi = "";
        $aramaKosulu = "";
        $sayfalamaKosulu .= "";
    }

    $sf_butonSayisi = 2;
    $sf_kayitSayisi = 4;
    $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;

    $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT * FROM urunler WHERE urun_tur = 'Kolye' AND urun_durum = '1'" . $menuKosulu . " " . $aramaKosulu . "");
    $sorgu_toplamKayitSayisi -> execute();
    $toplamKayitSayisi = $sorgu_toplamKayitSayisi -> rowCount();
    $sf_totalPageCount = ceil($toplamKayitSayisi / $sf_kayitSayisi);

    $sorgu_menulerinStokSayilariToplami = $veritaConn -> prepare("SELECT SUM(urun_sayi) AS toplamUrunStogu FROM menuler WHERE urun_tur = 'Kolye'");
    $sorgu_menulerinStokSayilariToplami -> execute();
    $menulerinStokSayilariToplami = $sorgu_menulerinStokSayilariToplami -> fetch(PDO::FETCH_ASSOC);
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="250" align="left" valign="top">
            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr height="50">
                                <td bgcolor="#F1F1F1"><b>&nbsp;MENÜLER</b></td>
                            </tr>
                            <tr height="30">
                                <td class="beaulinkforanchorbold">
                                    <a href="index.php?SO=55" style="text-decoration: none; <?php if($gelen_menuId == ""){ ?> color: #646464;<?php }else{ ?> <?php } ?> font-weight: bold;">&nbsp;Tüm Ürünler (<?php echo $menulerinStokSayilariToplami["toplamUrunStogu"]; ?>)</a></td>
                                </td>
                            </tr>
                                <?php
                                    $sorgu_menuler = $veritaConn -> prepare("SELECT * FROM menuler WHERE urun_tur = 'Kolye' ORDER BY menu_ad ASC");
                                    $sorgu_menuler -> execute();
                                    $menuSayisi = $sorgu_menuler -> rowCount();
                                    $menuler = $sorgu_menuler -> fetchAll(PDO::FETCH_ASSOC);

                                    foreach($menuler as $menu){
                                        ?>
                                        <tr height="30">
                                            <td class="beaulinkforanchorbold">
                                                <a href="index.php?SO=55&menu_id=<?php echo $menu["id"]; ?>" style="<?php if($gelen_menuId == $menu["id"]){ ?>color: #646464;<?php }else{ ?> <?php } ?>">&nbsp;<?php echo DonusumleriGeriDondur($menu["menu_ad"]); ?>(<?php echo DonusumleriGeriDondur($menu["urun_sayi"]); ?>)</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr height="50">
                                <td bgcolor="#F1F1F1"><b>&nbsp;REKLAMLAR</b></td>
                            </tr>
                                <?php
                                    $sorgu_banner = $veritaConn -> prepare("SELECT * FROM banner WHERE bannerAlani = 'Menu Altı' ORDER BY gosterimSayisi ASC LIMIT 1");
                                    $sorgu_banner -> execute();;
                                    $banner = $sorgu_banner -> fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr height="250">
                                            <td><img src="<?php echo $banner["bannerResmi"]; ?>" border="0"></td>
                                        </tr>
                                        <?php
                                    $sorgu_bannerGuncelle = $veritaConn -> prepare("UPDATE banner SET gosterimSayisi = gosterimSayisi + 1 WHERE id = ? LIMIT 1");
                                    $sorgu_bannerGuncelle -> execute([$banner["id"]]);
                                        ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="11" align="left">&nbsp;</td>
        <td width="795" align="left" valign="top">
            <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="aramaAlani">
                            <form action="<?php if($menuKosulu!=""){ ?>index.php?SO=55<?php echo "&menu_id=" . $gelen_menuId; }else{ ?> <?php } ?>" method="post">
                                <div class="aramaAlaniButtonArea">
                                    <input type="submit" value="" class="aramaAlaniButton">
                                </div>
                                <div class="aramaAlaniInputArea">
                                    <input type="text" name="aramaIcerigi" class="aramaAlaniInput">
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <?php
                                    $sorgu_urunler = $veritaConn -> prepare("SELECT * FROM urunler WHERE urun_tur = 'Kolye' AND urun_durum = '1'" . $menuKosulu . " " . $aramaKosulu. " ORDER BY id DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi"); //
                                    $sorgu_urunler -> execute();
                                    $urunSayisi = $sorgu_urunler -> rowCount();
                                    $urunler = $sorgu_urunler -> fetchAll(PDO::FETCH_ASSOC);

                                    $donguSayisi = 1;
                                    $sutunAdetSayisi = 4;
                                    //border: 1px dashed #3cccb9;
                                    foreach($urunler as $urun){
                                        $urun_id = DonusumleriGeriDondur($urun["id"]);
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
                                <td width="191" valign="top">
                                    <table width="191" align="left" border="0" cellpadding="0" cellspacing="0"  style="margin-bottom: 10px">
                                        <tr height="40">
                                            <td align="center"><a href="kolyeler/<?php echo SEO(DonusumleriGeriDondur($urun_adi)); ?>/<?php echo SEO(DonusumleriGeriDondur($urun_id)); ?>"><img src="resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun_resmi); ?>" border="0" width="185" height="247"></a></td>
                                        </tr>
                                        <tr height="25">
                                            <td width="191" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #3cccb9; font-weight: bold; text-decoration: none;"><?php echo $urun_turu; ?></a></td>
                                        </tr>
                                        <tr height="25">
                                            <td width="191" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 191; max-width: 191; height: 20px; overflow: hidden; line-height: 20px;"><?php echo $urun_adi; ?></div></a></td>
                                        </tr>
                                        <tr height="25">
                                            <td width="191" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" style="color: #050307; font-weight: bold; text-decoration: none;"><?php echo DonusumleriGeriDondur(FiyatBicimlendir($urun_hesaplanmisFiyat)); ?> TL</a></td>
                                        </tr>
                                        <tr height="25">
                                            <td width="191" align="center"><a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="<?php echo $puanResmi; ?>" width="180" height="30" border="0"></a></td>
                                        </tr>
                                    </table>
                                    <br />
                                </td>
                                <?php
                                    if($donguSayisi < $sutunAdetSayisi){
                                ?>
                                <td width="10">&nbsp;</td>
                                <?php
                                        }
                                        $donguSayisi++;
                                        if($donguSayisi > $sutunAdetSayisi){
                                            echo "</tr><tr>";
                                            $donguSayisi = 1;
                                        }
                                    }
                                ?>
                                </tr>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                    if($sf_totalPageCount > 1){
                ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr height="50">
                    <td align="center">
                        <div class="pagingContainer">
                            <div class="pagingContainerTextArea">
                                Toplam <?php echo $sf_totalPageCount; ?> sayfada, <?php echo $toplamKayitSayisi; ?> adet kayıt bulunmaktadır.
                            </div>
                            <div class="pagingContainerTextAreaForNumbers">
                                <?php
                                    if($sf_totalPageCount > 1){
                                        if($sf_value > 1){
                                            echo "<span class='pagePassive'><a href='index.php?SO=55" . $sayfalamaKosulu . "&SF=1'><<</a></span>";
                                            
                                            $sf_decreasedValue = $sf_value - 1;
                                            echo "<span class='pagePassive'><a href='index.php?SO=55" . $sayfalamaKosulu . "&SF=" . $sf_decreasedValue . "'><</a></span>";
                                        }
                                        for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                            if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                                if($sf_value == $sf_indexValue){
                                                    echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                                }else{
                                                    echo "<span class='pagePassive'><a href='index.php?SO=55" . $sayfalamaKosulu . "&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                                }
                                            }
                                        }
                                        if($sf_value != $sf_totalPageCount){
                                            $sf_increasedValue = $sf_value + 1;
                                            echo "<span class='pagePassive'><a href='index.php?SO=55" . $sayfalamaKosulu . "&SF=" . $sf_increasedValue . "'>></a></span>";
                                            
                                            echo "<span class='pagePassive'><a href='index.php?SO=55" . $sayfalamaKosulu . "&SF=" . $sf_totalPageCount . "'>>></a></span>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </td>
    </tr>
</table>