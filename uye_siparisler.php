<?php
    if(isset($_SESSION["kullanici_email"])){
        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 30;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;

        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT DISTINCT siparis_no FROM siparisler WHERE uye_id = ? ORDER BY siparis_no DESC");
        $sorgu_toplamKayitSayisi -> execute([$kullanici_id]);
        $toplamKayitSayisi = $sorgu_toplamKayitSayisi -> rowCount();
        $sf_totalPageCount = ceil($toplamKayitSayisi / $sf_kayitSayisi);
        ?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td><hr /></td>
    </tr>
    <tr>
        <td>
            <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                <td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0px; font-weight: bold;"><a href="index.php?SO=40" style="text-decoration: none; color: #151515">Üyelik Bilgilerim</a></td>
                    <td width="10">&nbsp;</td>
                    <td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0px; font-weight: bold;"><a href="index.php?SO=43" style="text-decoration: none; color: #151515">Adresler</a></td>
                    <td width="10">&nbsp;</td>
                    <td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0px; font-weight: bold;"><a href="index.php?SO=53" style="text-decoration: none; color: #151515">Favoriler</a></td>
                    <td width="10">&nbsp;</td>
                    <td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0px; font-weight: bold;"><a href="index.php?SO=52" style="text-decoration: none; color: #151515">Yorumlar</a></td>
                    <td width="10">&nbsp;</td>
                    <td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0px; font-weight: bold;"><a href="index.php?SO=49" style="text-decoration: none; color: #151515">Siparişler</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><hr /></td>
    </tr>
    <tr>
        <td width="1065" valign="top">
            <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td colspan="8"><h3>Hesabım > Siparişler</h3></td>
                </tr>
                <tr height="30">
                    <td colspan="8" valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm Siparişlerinizi Bu Alandan Görüntüleyebilirsiniz.</td>
                </tr>
                <tr height="50">
                    <td width="125" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Sipariş Numarası</td>
                    <td width="75" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Resim</td>
                    <td width="50" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Yorum</td>
                    <td width="415" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Adı</td>
                    <td width="100" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Fiyatı</td>
                    <td width="50" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Adet</td>
                    <td width="100" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Toplam Ürün Fiyatı</td>
                    <td width="150" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Kargo Durumu / Takip</td>
                </tr>
                <?php
                    $sorgu_siparisNoGetir = $veritaConn -> prepare("SELECT DISTINCT siparis_no FROM siparisler WHERE uye_id = ? ORDER BY siparis_no DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi"); // LIMIT VE SAYFALAMA
                    $sorgu_siparisNoGetir -> execute([$kullanici_id]);
                    $siparis_noSayisi = $sorgu_siparisNoGetir -> rowCount();
                    $siparisNolar = $sorgu_siparisNoGetir -> fetchAll(PDO::FETCH_ASSOC);

                    if($siparis_noSayisi > 0){
                        foreach($siparisNolar as $siparisNo){
                            $yerel_siparisNo = DonusumleriGeriDondur($siparisNo["siparis_no"]);
                            $sorgu_siparisGetir = $veritaConn -> prepare("SELECT * FROM siparisler WHERE uye_id = ? AND siparis_no = ? ORDER BY id ASC");
                            $sorgu_siparisGetir -> execute([$kullanici_id, $yerel_siparisNo]);
                            $siparis_sayisi = $sorgu_siparisGetir -> rowCount();
                            $siparisler = $sorgu_siparisGetir -> fetchAll(PDO::FETCH_ASSOC);
                            foreach($siparisler as $siparis){
                                $yerel_urun_turu = DonusumleriGeriDondur($siparis["urun_tur"]);
                                $yerel_kargoDurumu = DonusumleriGeriDondur($siparis["siparis_kargoDurum"]);
                                if($yerel_kargoDurumu == 0){
                                    $kargoDurumuYazdir = "Beklemede";
                                }else{
                                    $kargoDurumuYazdir = DonusumleriGeriDondur($siparis["siparis_kargoGonderiKodu"]);
                                }
                            
                ?>
                <tr height="30">
                    <td width="125" align="left">&nbsp;#<?php echo DonusumleriGeriDondur($siparis["siparis_no"]); ?></td>
                    <td width="75" align="left">&nbsp;<img src="resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($siparis["urun_resimBir"]); ?>" border="0" width="60" height="80"></td>
                    <td width="50" align="left">&nbsp;<a href="index.php?SO=50&id=<?php echo DonusumleriGeriDondur($siparis["urun_id"]); ?>"><img src="resimler/icons/message.png" border="0"></a></td>
                    <td width="415" align="left">&nbsp;<?php echo DonusumleriGeriDondur($siparis["urun_ad"]); ?></td>
                    <td width="100" align="left">&nbsp;<?php echo FiyatBicimlendir(DonusumleriGeriDondur($siparis["urun_fiyat"])); ?> TL</td>
                    <td width="50" align="left">&nbsp;<?php echo DonusumleriGeriDondur($siparis["urun_siparisAdedi"]); ?></td>
                    <td width="100" align="left">&nbsp;<?php echo FiyatBicimlendir(DonusumleriGeriDondur($siparis["siparis_toplamUrunFiyati"])); ?> TL</td>
                    <td width="150" align="left">&nbsp;<?php echo DonusumleriGeriDondur($kargoDurumuYazdir); ?></td>
                </tr>
                <?php
                            }
                            ?>
                            <tr height="30">
                                <td colspan="8"><hr /></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr height="50">
                            <td colspan="8" align="center">
                                <div class="pagingContainer">
                                    <div class="pagingContainerTextArea">
                                        Toplam <?php echo $sf_totalPageCount; ?> sayfada, <?php echo $toplamKayitSayisi; ?> adet kayıt bulunmaktadır.
                                    </div>
                                    <div class="pagingContainerTextAreaForNumbers">
                                        <?php
                                            if($sf_totalPageCount > 1){
                                                if($sf_value > 1){
                                                    echo "<span class='pagePassive'><a href='index.php?SO=49&SF=1'><<</a></span>";
                                                    
                                                    $sf_decreasedValue = $sf_value - 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=49&SF=" . $sf_decreasedValue . "'><</a></span>";
                                                }
    
                                                for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                                    if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                                        if($sf_value == $sf_indexValue){
                                                            echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                                        }else{
                                                            echo "<span class='pagePassive'><a href='index.php?SO=49&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                                        }
                                                    }
                                                }
    
                                                if($sf_value != $sf_totalPageCount){
                                                    $sf_increasedValue = $sf_value + 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=49&SF=" . $sf_increasedValue . "'>></a></span>";
                                                    
                                                    echo "<span class='pagePassive'><a href='index.php?SO=49&SF=" . $sf_totalPageCount . "'>>></a></span>";
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }else{
                        ?>
                <tr height="50">
                    <td colspan="8" align="left"><b>Sisteme Kayıtlı Siparişiniz Bulunmamaktadır.</b></td>
                </tr>
                        <?php
                    }
                ?>
            </table>
        </td>
    </tr>
</table>
        <?php
    }else{
        header("Location:index.php");
        exit();
        ?>
        <?php
    }
?>