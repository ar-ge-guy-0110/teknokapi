<?php
    if(isset($_SESSION["kullanici_email"])){
        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 10;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;

        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT * FROM yorumlar WHERE uye_id = ? ORDER BY yorum_tarihi DESC");
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
                    <td colspan="2"><h3>Hesabım > Yorumlar</h3></td>
                </tr>
                <tr height="30">
                    <td colspan="2" valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm Yorumlarınızı Bu Alandan Görüntüleyebilirsiniz.</td>
                </tr>
                <tr height="50">
                    <td width="84" style="background: #3cccb9;color: #151515;" align="left">&nbsp;Puan</td>
                    <td width="981" style="background: #3cccb9;color: #151515;padding-left: 30px;" align="left">&nbsp;Yorum</td>
                </tr>
                <?php
                    $sorgu_yorumGetir = $veritaConn -> prepare("SELECT * FROM yorumlar WHERE uye_id = ? ORDER BY yorum_tarihi DESC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi"); // LIMIT VE SAYFALAMA
                    $sorgu_yorumGetir -> execute([$kullanici_id]);
                    $yorumSayisi = $sorgu_yorumGetir -> rowCount();
                    $yorumlar = $sorgu_yorumGetir -> fetchAll(PDO::FETCH_ASSOC);

                    if($yorumSayisi > 0){
                        foreach($yorumlar as $yorum){
                            $yorumPuani = $yorum["puan"];
                            if($yorumPuani == 1){
                                $resimDosyasiYolu = "resimler/rating/ratingOneStar.png";
                            }else if($yorumPuani == 2){
                                $resimDosyasiYolu = "resimler/rating/ratingTwoStar.png";
                            }else if($yorumPuani == 3){
                                $resimDosyasiYolu = "resimler/rating/ratingThreeStar.png";
                            }else if($yorumPuani == 4){
                                $resimDosyasiYolu = "resimler/rating/ratingFourStar.png";
                            }else{
                                $resimDosyasiYolu = "resimler/rating/ratingFiveStar.png";
                            }

                            
                ?>
                <tr>
                    <td width="84" align="left" style="border-bottom: 1px dashed #3cccb9;padding: 0px 0px;padding-bottom: 20px;" valign="top">&nbsp;<img src="<?php echo $resimDosyasiYolu; ?>" border="0"width="84" height="11"></td>
                    <td width="981" align="left" style="padding-left: 30px;border-bottom: 1px dashed #3cccb9;padding: 15px 5px;">&nbsp;#<?php echo DonusumleriGeriDondur($yorum["yorum_metni"]); ?></td>
                </tr>
                <?php
                            ?>
                            <?php
                        }
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
                                                    echo "<span class='pagePassive'><a href='index.php?SO=52&SF=1'><<</a></span>";
                                                    
                                                    $sf_decreasedValue = $sf_value - 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=52&SF=" . $sf_decreasedValue . "'><</a></span>";
                                                }
    
                                                for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                                    if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                                        if($sf_value == $sf_indexValue){
                                                            echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                                        }else{
                                                            echo "<span class='pagePassive'><a href='index.php?SO=52&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                                        }
                                                    }
                                                }
    
                                                if($sf_value != $sf_totalPageCount){
                                                    $sf_increasedValue = $sf_value + 1;
                                                    echo "<span class='pagePassive'><a href='index.php?SO=52&SF=" . $sf_increasedValue . "'>></a></span>";
                                                    
                                                    echo "<span class='pagePassive'><a href='index.php?SO=52&SF=" . $sf_totalPageCount . "'>>></a></span>";
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
                    <td colspan="2" align="left"><b>Sisteme Kayıtlı Yorumunuz Bulunmamaktadır.<?php echo $sf_sayfalamayaBaslanacakKayitSayisi; ?></b></td>
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