<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_REQUEST["aramaIcerigi"])){
            $gelen_aramaIcerigi = Guvenlik($_REQUEST["aramaIcerigi"]);
            $aramaKosulu = "AND (urun_ad LIKE '%" . $gelen_aramaIcerigi . "%')";
            $sayfalamaKosulu = "&aramaIcerigi=" . $gelen_aramaIcerigi;
        }else{
            $gelen_aramaIcerigi = "";
            $aramaKosulu = "";
            $sayfalamaKosulu = "";
        }

        $hangi_urun = "";
        $hangi_sayfa = "48";
        $hangi_istekYazisi = "index.php?SOAE=1&SOAI=";

        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 9;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;
    
        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT urunler.*, menuler.menu_ad FROM urunler JOIN menuler ON menuler.id = urunler.menuId WHERE urun_durum = ? " . $aramaKosulu);
        $sorgu_toplamKayitSayisi -> execute([1]);
        $toplamKayitSayisi = $sorgu_toplamKayitSayisi -> rowCount();
        $sf_totalPageCount = ceil($toplamKayitSayisi / $sf_kayitSayisi);
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;ÜRÜNLER</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=49" style="color: #171717; text-decoration: none;">Yeni Ürün Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="aramaAlani">
                            <form action="<?php echo $hangi_istekYazisi . $hangi_sayfa; ?>" method="post">
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
            </table>
        </td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_urunler = $veritaConn -> prepare("SELECT urunler.*, menuler.menu_ad FROM urunler JOIN menuler ON menuler.id = urunler.menuId WHERE urun_durum = ? " . $aramaKosulu. " ORDER BY id DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi");
        $sorgu_urunler -> execute([1]);
        $sorguSayi = $sorgu_urunler -> rowCount();
        if($sorguSayi > 0){
            $urunler = $sorgu_urunler -> fetchAll(PDO::FETCH_ASSOC);
            foreach($urunler as $urun){
                $yerel_urun_turu = DonusumleriGeriDondur($urun["urun_tur"]);
                $urunAdi = DonusumleriGeriDondur($urun["urun_ad"]);
                $urunMenuAdi = DonusumleriGeriDondur($urun["menu_ad"]);
                $urunTuru = DonusumleriGeriDondur($urun["urun_tur"]);
                $urunParaBirimi = DonusumleriGeriDondur($urun["urun_paraBirimi"]);
                $urunFiyati = DonusumleriGeriDondur($urun["urun_fiyat"]);
                /*
                if($urunParaBirimi == "USD"){
                    $urunHesaplanmisFiyat = $urunFiyati * $kurUSD;
                }else if($urunParaBirimi == "EUR"){
                    $urunHesaplanmisFiyat = $urunFiyati * $kurEuro;
                }else{
                    $urunHesaplanmisFiyat = $urunFiyati;
                }
                */
                $urunToplamSatisAdedi = DonusumleriGeriDondur($urun["urun_toplamSatisSayisi"]);
                $urunToplamYorumSayisi = DonusumleriGeriDondur($urun["urun_yorumSayisi"]);
                $urunToplamPuanSayisi = DonusumleriGeriDondur($urun["urun_toplamYorumPuani"]);
                $urunToplamGoruntulenmeSayisi = DonusumleriGeriDondur($urun["urun_goruntulenmeSayisi"]);
    ?>
    <tr height="80">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="60"><img src="../resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun["urun_resimBir"]); ?>" border="0" width="60" height="80"></td>
                    <td width="10">&nbsp;</td>
                    <td width="680" valign="top">
                        <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr height="25">
                                <td colspan="2"><?php echo $urunTuru . " -> " . $urunMenuAdi; ?></td>
                            </tr>
                            <tr height="25">
                                <td width="540"><?php echo $urunAdi; ?></td>
                                <td width="100" align="right"><?php echo FiyatBicimlendir($urunFiyati) . " " . $urunParaBirimi; ?></td>
                            </tr>
                            <tr height="25">
                                <td><?php echo $urunToplamSatisAdedi; ?> adet satıldı. <?php echo $urunToplamYorumSayisi; ?> adet yorumda  <?php echo $urunToplamPuanSayisi; ?> puan aldı. <?php echo $urunToplamGoruntulenmeSayisi; ?> kez görüntülendi.</td>
                                <td width="140">
                                    <table width="140" align="right" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="25" valign="center"><a href="index.php?SOAE=1&SOAI=52&id=<?php echo DonusumleriGeriDondur($urun["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"><a></td>
                                            <td width="70" valign="center"><a href="index.php?SOAE=1&SOAI=52&id=<?php echo DonusumleriGeriDondur($urun["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle<a></td>
                                            <td width="25" valign="center"><a href="index.php?SOAE=1&SOAI=51&id=<?php echo DonusumleriGeriDondur($urun["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a><td>
                                            <td width="20" valign="center"><a href="index.php?SOAE=1&SOAI=51&id=<?php echo DonusumleriGeriDondur($urun["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a><td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
            }
    ?>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <?php
            if($sf_totalPageCount > 1){
    ?>
    <tr height="50">
        <td colspan="2" align="center">
            <div class="pagingContainer">
                <div class="pagingContainerTextArea">
                    Toplam <?php echo $sf_totalPageCount; ?> sayfada, <?php echo $toplamKayitSayisi; ?> adet kayıt bulunmaktadır.
                </div>
                <div class="pagingContainerTextAreaForNumbers">
                    <?php
                        if($sf_totalPageCount > 1){
                            if($sf_value > 1){
                                echo "<span class='pagePassive'><a href='" . $hangi_istekYazisi . $hangi_sayfa . $sayfalamaKosulu . "&SF=1'><<</a></span>";
                                
                                $sf_decreasedValue = $sf_value - 1;
                                echo "<span class='pagePassive'><a href='" . $hangi_istekYazisi . $hangi_sayfa . $sayfalamaKosulu . "&SF=" . $sf_decreasedValue . "'><</a></span>";
                            }
                            for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                    if($sf_value == $sf_indexValue){
                                        echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                    }else{
                                        echo "<span class='pagePassive'><a href='" . $hangi_istekYazisi . $hangi_sayfa . $sayfalamaKosulu . "&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                    }
                                }
                            }
                            if($sf_value != $sf_totalPageCount){
                                $sf_increasedValue = $sf_value + 1;
                                echo "<span class='pagePassive'><a href='" . $hangi_istekYazisi . $hangi_sayfa . $sayfalamaKosulu . "&SF=" . $sf_increasedValue . "'>></a></span>";
                                
                                echo "<span class='pagePassive'><a href='" . $hangi_istekYazisi . $hangi_sayfa . $sayfalamaKosulu . "&SF=" . $sf_totalPageCount . "'>>></a></span>";
                            }
                        }
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php
            }
    }else{
    ?>
    <tr>
        <td colspan="2">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="750">Kayıtlı ürün bulunmamaktadır.</td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>