<?php
    //SELECT yorumlar.id, uyeler.uye_email, uyeler.uye_tamisim, urunler.urun_ad, yorumlar.puan, yorumlar.yorum_metni, yorumlar.yorum_tarihi, yorumlar.yorum_ip_adresi FROM yorumlar JOIN uyeler ON uyeler.id = yorumlar.uye_id JOIN urunler ON urunler.id = yorumlar.urun_id
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_REQUEST["aramaIcerigi"])){
            $gelen_aramaIcerigi = Guvenlik($_REQUEST["aramaIcerigi"]);
            $aramaKosulu = "AND (uye_email LIKE '%" . $gelen_aramaIcerigi . "%' OR uye_tamisim LIKE '%" . $gelen_aramaIcerigi . "%' OR urun_ad LIKE '%" . $gelen_aramaIcerigi . "%' OR yorum_metni LIKE '%" . $gelen_aramaIcerigi . "%')";
            $sayfalamaKosulu = "&aramaIcerigi=" . $gelen_aramaIcerigi;
        }else{
            $gelen_aramaIcerigi = "";
            $aramaKosulu = "";
            $sayfalamaKosulu = "";
        }

        $hangi_urun = "";
        $hangi_sayfa = "46";
        $hangi_istekYazisi = "index.php?SOAE=1&SOAI=";

        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 10;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;
    
        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT yorumlar.id, uyeler.uye_email, uyeler.uye_tamisim, urunler.urun_ad, yorumlar.puan, yorumlar.yorum_metni, yorumlar.yorum_tarihi, yorumlar.yorum_ip_adresi FROM yorumlar JOIN uyeler ON uyeler.id = yorumlar.uye_id JOIN urunler ON urunler.id = yorumlar.urun_id WHERE uye_silinme_durumu = ? " . $aramaKosulu . "");
        $sorgu_toplamKayitSayisi -> execute([0]);
        $toplamKayitSayisi = $sorgu_toplamKayitSayisi -> rowCount();
        $sf_totalPageCount = ceil($toplamKayitSayisi / $sf_kayitSayisi);
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;YORUMLAR</h3></td>
    </tr>
    <tr height="10">
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr>
        <td>
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
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_yorumlar = $veritaConn -> prepare("SELECT yorumlar.id, uyeler.uye_email, uyeler.uye_tamisim, urunler.urun_ad, yorumlar.puan, yorumlar.yorum_metni, yorumlar.yorum_tarihi, yorumlar.yorum_ip_adresi FROM yorumlar JOIN uyeler ON uyeler.id = yorumlar.uye_id JOIN urunler ON urunler.id = yorumlar.urun_id WHERE uye_silinme_durumu = ? " . $aramaKosulu. " ORDER BY id DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi");
        $sorgu_yorumlar -> execute([0]);
        $sorguSayi = $sorgu_yorumlar -> rowCount();
        if($sorguSayi > 0){
            $yorumlar = $sorgu_yorumlar -> fetchAll(PDO::FETCH_ASSOC);
            foreach($yorumlar as $yorum){
    ?>
    <tr height="105">
        <td style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="30">
                    <td width="85"><b>Tam İsmi</b></td>
                    <td width="10"><b>:</b></td>
                    <td width="150"><?php echo DonusumleriGeriDondur($yorum["uye_tamisim"]); ?></td>
                    <td width="90"><b>E-Posta</b></td>
                    <td width="10"><b>:</b></td>
                    <td width="200"><?php echo DonusumleriGeriDondur($yorum["uye_email"]); ?></td>
                    <td width="70"><b>Yorum Yapılan Ürün</b></td>
                    <td width="10"><b>:</b></td>
                    <td width="95"><?php echo DonusumleriGeriDondur($yorum["urun_ad"]); ?></td>
                </tr>
                <tr height="30">
                    <td><b>Verilen Puan</b></td>
                    <td><b>:</b></td>
                    <td><?php echo DonusumleriGeriDondur($yorum["puan"]); ?></td>
                    <td><b>Yorum Tarihi</b></td>
                    <td><b>:</b></td>
                    <td><?php echo timestamp2time(DonusumleriGeriDondur($yorum["yorum_tarihi"])); ?></td>
                    <td><b>Yorum</b></td>
                    <td><b>:</b></td>
                    <td><?php echo DonusumleriGeriDondur($yorum["yorum_metni"]); ?></td>
                </tr>
                <tr>
                    <td colspan="9" align="right">
                        <table width="95" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="40"></td>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=47&id=<?php echo DonusumleriGeriDondur($yorum["id"]) ?>"><img src="../resimler/button/remove.png"border="0"></a></td>
                                <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=47&id=<?php echo DonusumleriGeriDondur($yorum["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil<a></td>
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
        <td>&nbsp;</td>
    </tr>
    <?php
            if($sf_totalPageCount > 1){
    ?>
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
        <td>
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="750">Kayıtlı yorum bulunmamaktadır.</td>
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