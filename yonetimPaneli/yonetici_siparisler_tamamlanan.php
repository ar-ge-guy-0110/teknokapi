<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        $sf_butonSayisi = 2;
        $sf_kayitSayisi = 10;
        $sf_sayfalamayaBaslanacakKayitSayisi = ($sf_value * $sf_kayitSayisi) - $sf_kayitSayisi;

        $sorgu_toplamKayitSayisi = $veritaConn -> prepare("SELECT DISTINCT siparis_no FROM siparisler WHERE siparis_onayDurum = ? AND siparis_kargoDurum = ?");
        $sorgu_toplamKayitSayisi -> execute([1, 1]);
        $toplamKayitSayisi = $sorgu_toplamKayitSayisi -> rowCount();
        $sf_totalPageCount = ceil($toplamKayitSayisi / $sf_kayitSayisi);
        $sf_link = "SOAE=1&SOAI=56";
        $sf = "SOAE=1";
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;SİPARİŞLER (TAMAMLANAN)</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=54" style="color: #171717; text-decoration: none;">Bekleyen Siparişler</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
<?php
        $sorgu_siparisNoGetir = $veritaConn -> prepare("SELECT DISTINCT siparis_no FROM siparisler WHERE siparis_onayDurum = ? AND siparis_kargoDurum = ? AND siparis_kargoGonderiKodu IS NOT NULL ORDER BY id ASC LIMIT $sf_sayfalamayaBaslanacakKayitSayisi, $sf_kayitSayisi"); // LIMIT VE SAYFALAMA
        $sorgu_siparisNoGetir -> execute([1, 1]);
        $siparis_noSayisi = $sorgu_siparisNoGetir -> rowCount();
        $siparisNolar = $sorgu_siparisNoGetir -> fetchAll(PDO::FETCH_ASSOC);
        if($siparis_noSayisi > 0){
            foreach($siparisNolar as $siparisNo){


                        $sorgu_siparisler = $veritaConn -> prepare("SELECT * FROM siparisler WHERE siparis_no = ? AND siparis_onayDurum = ? AND siparis_kargoDurum = ?");
                        $sorgu_siparisler -> execute([$siparisNo["siparis_no"], 1, 1]);
                        $sorguSayi = $sorgu_siparisler -> rowCount();
                        if($sorguSayi > 0){
                            $siparisler = $sorgu_siparisler -> fetchAll(PDO::FETCH_ASSOC);
                            $toplamFiyat = 0;
                            foreach($siparisler as $siparis){
                                $urunToplamFiyati = $siparis["siparis_toplamUrunFiyati"];
                                $siparisTarihi = timestamp2time($siparis["siparis_tarih"]);
                                $toplamFiyat += $urunToplamFiyati;
                            }
?>
                        <tr>
                            <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
                                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                                    <tr height="30">
                                        <td align="left" width="120" style="color: black;">Sipariş Tarihi</td>
                                        <td align="left" width="20" style="color: black;"><b>:</b></td>
                                        <td align="left" width="225"><?php echo $siparisTarihi; ?></td>
                                        <td align="left" width="120" style="color: black;"><b>Sipariş Tutarı</b></td>
                                        <td align="left" width="20" style="color: black;">:</td>
                                        <td align="left" width="170"><?php echo FiyatBicimlendir($toplamFiyat); ?></td>
                                        <td align="left" width="75">
                                            <table width="75" align="right" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="25"><a href="index.php?SOAE=1&SOAI=55&siparisno=<?php echo DonusumleriGeriDondur($siparisNo["siparis_no"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                                                    <td width="50"><a href="index.php?SOAE=1&SOAI=55&siparisno=<?php echo DonusumleriGeriDondur($siparisNo["siparis_no"]) ?>" style="color: #00000FF; text-decoration: none;">Detay</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
<?php
                        }else{
                            $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Bilgileri Çekilemedi.";
                            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                            exit();
                        }
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
                                            echo "<span class='pagePassive'><a href='index.php?" . $sf_link . "&SF=1'><<</a></span>";
                                            
                                            $sf_decreasedValue = $sf_value - 1;
                                            echo "<span class='pagePassive'><a href='index.php?" . $sf_link ."&SF=" . $sf_decreasedValue . "'><</a></span>";
                                        }
                                        for($sf_indexValue = ($sf_value - $sf_butonSayisi); $sf_indexValue <= ($sf_value + $sf_butonSayisi); $sf_indexValue++){
                                            if(($sf_indexValue > 0) and ($sf_indexValue <= $sf_totalPageCount)){
                                                if($sf_value == $sf_indexValue){
                                                    echo "<span class='pageActive'>" . $sf_indexValue . "</span>";
                                                }else{
                                                    echo "<span class='pagePassive'><a href='index.php?" . $sf_link ."&SF=" . $sf_indexValue . "'>" . $sf_indexValue . "</a></span>";
                                                }
                                            }
                                        }
                                        if($sf_value != $sf_totalPageCount){
                                            $sf_increasedValue = $sf_value + 1;
                                            echo "<span class='pagePassive'><a href='index.php?". $sf . "&" . $sf_link ."&SF=" . $sf_increasedValue . "'>></a></span>";
                                            
                                            echo "<span class='pagePassive'><a href='index.php?" . $sf_link ."&SF=" . $sf_totalPageCount . "'>>></a></span>";
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
    <tr>
        <td colspan="2">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="750">Kayıtlı tamamlanan sipariş bulunmamaktadır.</td>
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