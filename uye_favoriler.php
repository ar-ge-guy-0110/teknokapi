<?php
    if(isset($_SESSION["kullanici_email"])){
        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 10;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;

        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT * FROM uyeler_favoriler WHERE uye_id = ? ORDER BY id DESC");
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
                    <td colspan="4"><h3>Hesabım > Favoriler</h3></td>
                </tr>
                <tr height="30">
                    <td colspan="4" valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm Siparişlerinizi Bu Alandan Görüntüleyebilirsiniz.</td>
                </tr>
                <tr height="50">
                    <td width="75" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Resim</td>
                    <td width="25" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Sil</td>
                    <td width="865" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Adı</td>
                    <td width="100" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Fiyatı</td>
                </tr>
                <?php
                    $sorgu_favoriler = $veritaConn -> prepare("SELECT * FROM uyeler_favoriler WHERE uye_id = ? ORDER BY id DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi"); // LIMIT VE SAYFALAMA
                    $sorgu_favoriler -> execute([$kullanici_id]);
                    $favoriSayisi = $sorgu_favoriler -> rowCount();
                    $favoriler = $sorgu_favoriler -> fetchAll(PDO::FETCH_ASSOC);

                    if($favoriSayisi > 0){
                        foreach($favoriler as $favori){
                            $sorgu_urun = $veritaConn -> prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
                            $sorgu_urun -> execute([$favori["urun_id"]]);
                            $urun = $sorgu_urun -> fetch(PDO::FETCH_ASSOC);

                            $urun_adi = $urun["urun_ad"];
                            $urun_turu = $urun["urun_tur"];
                            $urun_fiyati = $urun["urun_fiyat"];
                            $urun_paraBirimi = $urun["urun_paraBirimi"];
                            $urun_resmi = $urun["urun_resimBir"];
                            
                ?>
                <tr height="30">
                    <td width="75" align="left" style="padding-left: 30px;border-bottom: 1px dashed #3cccb9;">&nbsp;<a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><img src="resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun_resmi); ?>" border="0" width="60" height="80"></a></td>
                    <td width="50" align="left" style="padding-left: 30px;border-bottom: 1px dashed #3cccb9;">&nbsp;<a href="index.php?SO=54&id=<?php echo DonusumleriGeriDondur($favori["id"]); ?>"><img src="resimler/button/delete.png" border="0"></a></td>
                    <td width="415" align="left" style="padding-left: 30px;border-bottom: 1px dashed #3cccb9;" class="beaulinkforanchor">&nbsp;<a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>" ><?php echo DonusumleriGeriDondur($urun_adi); ?></a></td>
                    <td width="100" align="left" style="padding-left: 30px;border-bottom: 1px dashed #3cccb9;" class="beaulinkforanchor">&nbsp;<a href="index.php?SO=58&id=<?php echo DonusumleriGeriDondur($urun["id"]);?>"><?php echo FiyatBicimlendir(DonusumleriGeriDondur($urun_fiyati)); ?> <?php echo DonusumleriGeriDondur($urun_paraBirimi); ?></a></td>
                </tr>
                <?php
                            }
                            ?>

                            <?php
                        
                        ?>
                        <tr height="50">
                            <td colspan="4" align="center">
                                <div class="pagingContainer">
                                    <div class="pagingContainerTextArea">
                                        Toplam <?php echo $sf_totalPageCount; ?> sayfada, <?php echo $toplamKayitSayisi; ?> adet kayıt bulunmaktadır.
                                    </div>
                                    <div class="pagingContainerTextAreaForNumbers">
                                        <?php
                                            if($sf_totalPageCount > 1){
                                                if($sf_value > 1){
                                                    echo "<span class='pagePassive'><a href='index.php?SO=53&SF=1'><<</a></span>";
                                                    
                                                    $sf_decreasedValue = $sf_value - 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=53&SF=" . $sf_decreasedValue . "'><</a></span>";
                                                }
    
                                                for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                                    if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                                        if($sf_value == $sf_indexValue){
                                                            echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                                        }else{
                                                            echo "<span class='pagePassive'><a href='index.php?SO=53&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                                        }
                                                    }
                                                }
    
                                                if($sf_value != $sf_totalPageCount){
                                                    $sf_increasedValue = $sf_value + 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=53&SF=" . $sf_increasedValue . "'>></a></span>";
                                                    
                                                    echo "<span class='pagePassive'><a href='index.php?SO=53&SF=" . $sf_totalPageCount . "'>>></a></span>";
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
                    <td colspan="4" align="left"><b>Sisteme Kayıtlı Favori Ürününüz Bulunmamaktadır.</b></td>
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