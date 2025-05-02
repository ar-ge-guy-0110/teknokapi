<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["siparisno"])){
            $siparisno = SVE_BASIC_INPUT($_GET["siparisno"], 10, false, true, true);
        }else{
            $siparisno = "";
        }
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;SİPARİŞ DETAY</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=54" style="color: #171717; text-decoration: none;">Bekleyen Siparişlere Dön&nbsp;</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $boolSiparisOnaylandimi = false;
        $sorgu_siparisler = $veritaConn -> prepare("SELECT * FROM siparisler WHERE siparis_no = ?");
        $sorgu_siparisler -> execute([$siparisno]);
        $siparisler = $sorgu_siparisler -> fetchAll(PDO::FETCH_ASSOC);
        //siparisler getirilemediyse
        if(!$siparisler){
            $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Bilgileri Çekilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
        //
        $donguSayisi = 0;
        foreach($siparisler as $siparis){
            if(($siparis["siparis_onayDurum"] == 1) and ($siparis["siparis_kargoDurum"] == 1) and ($siparis["siparis_kargoGonderiKodu"] != "")){
                $boolSiparisOnaylandimi = true;
                $kargoGonderiKodu = $siparis["siparis_kargoGonderiKodu"];
            }
            $siparisUrunuId = $siparis["urun_id"];
            $sorgu_menu = $veritaConn -> prepare("SELECT menuler.menu_ad FROM menuler JOIN urunler ON urunler.menuId = menuler.id WHERE urunler.id = ? LIMIT 1");
            $sorgu_menu -> execute([$siparisUrunuId]);
            $urunMenu = $sorgu_menu -> fetch(PDO::FETCH_ASSOC);
            if($urunMenu){
                    $urun_turu = DonusumleriGeriDondur($siparis["urun_tur"]);
                    $urunAdi = DonusumleriGeriDondur($siparis["urun_ad"]);
                    $urunMenuAdi = DonusumleriGeriDondur($urunMenu["menu_ad"]);
    ?>
        <tr> <!-- height="80" -->
            <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <?php
                    if($donguSayisi == 0){
                        $donguSayisi++;
                    ?>
                    <tr>
                        <td colspan="3"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Adı Soyadı :</span> <?php echo DonusumleriGeriDondur($siparis["siparis_adres_adiSoyadi"]); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Telefon :</span> <?php echo DonusumleriGeriDondur($siparis["siparis_adres_telefon"]); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Adres :</span> <?php echo DonusumleriGeriDondur($siparis["siparis_adres_detay"]); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td width="60"><img src="../resimler/urun/<?php echo ConvertEng($urun_turu); ?>/<?php echo DonusumleriGeriDondur($siparis["urun_resimBir"]); ?>" border="0" width="60" height="80"></td>
                        <td width="10">&nbsp;</td>
                        <td width="680" valign="top">
                            <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                                <tr height="25">
                                    <td colspan="2" style="font-size: 15px; color: #000;"><?php echo DonusumleriGeriDondur($urun_turu) . " -> " . DonusumleriGeriDondur($urunMenuAdi); ?></td>
                                </tr>
                                <tr height="25">
                                    <td width="680">
                                        <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="350" align="left"><?php echo DonusumleriGeriDondur($urunAdi); ?></td>
                                                <td width="330" align="right"><?php echo DonusumleriGeriDondur($siparis["urun_variantBasligi"]); ?> -> <?php echo DonusumleriGeriDondur($siparis["urun_variantSecimi"]); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="25">
                                    <td width="680">
                                        <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="680" colspan="2" align="left"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Fiyat :</span> <?php echo FiyatBicimlendir(DonusumleriGeriDondur($siparis["urun_fiyat"])); ?> TL, <?php echo DonusumleriGeriDondur($siparis["urun_siparisAdedi"]); ?> <span style="font-size: 16px; color: #000; font-weight: bold !important;">Adet</span>, <span style="font-size: 16px; color: #000; font-weight: bold !important;">Toplam Fiyat :</span> <?php echo FiyatBicimlendir(DonusumleriGeriDondur($siparis["siparis_toplamUrunFiyati"])); ?> TL, <span style="font-size: 16px; color: #000; font-weight: bold !important;">KDV Oranı :</span> %<?php echo DonusumleriGeriDondur($siparis["urun_kdvOrani"]); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="25">
                                    <td width="680">
                                        <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="680" colspan="2" align="left"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Ödeme Türü :</span> <?php echo DonusumleriGeriDondur($siparis["siparisodemeSecimi"]); ?>, <span style="font-size: 16px; color: #000; font-weight: bold !important;">Taksit Sayısı :</span> <?php echo DonusumleriGeriDondur($siparis["siparis_taksitSecimi"]); ?>, <span style="font-size: 16px; color: #000; font-weight: bold !important;">Kargo Seçimi :</span> <?php echo DonusumleriGeriDondur($siparis["urun_kargoFirmasiSecimi"]); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" width="680">
                                                <span style="font-size: 16px; color: #000; font-weight: bold !important;">Kargo Ücreti :</span> <?php echo FiyatBicimlendir(DonusumleriGeriDondur($siparis["urun_kargoUcreti"])); ?> TL
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="25">
                                    <td width="540">      </td>
                                    <td width="100" align="right">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <?php
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Bilgileri Çekilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            break;
            exit();
        }
        ?>
        <?php
    }
        if(!$boolSiparisOnaylandimi){


        ?>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <form action="index.php?SOAE=1&SOAI=58" method="post">
                    <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                        <tr height="40">
                            <td colspan="2"><span style="font-size: 16px; color: #000; font-weight: bold !important;">Gönderi Kodu :</span> </td>
                            <td><input type="text" name="gonderiKodu" maxlength="100"></td>
                        </tr>
                        <input type="hidden" name="siparisKodu" value="<?php echo DonusumleriGeriDondur($siparisno); ?>">
                        <tr height="40">
                            <td colspan="3" align="center"><input type="submit" value="Gönderi Kodunu İşle ve Siparişi Tamamla"></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
</table>
<?php
            }else{
                
                ?>
                    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr> <!-- height="80" -->
                            <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
                                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                                    <tr height="25">
                                        <td width="680">
                                            <table width="680" align="right" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="680" colspan="2" align="left">Kargo Gönderi Kodu = <?php echo $kargoGonderiKodu; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                <?php
            }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>