<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANKA HESAP AYARLARI</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=10" style="color: #171717; text-decoration: none;">Yeni Banka Hesabı Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_bankaHesaplari = $veritaConn -> prepare("SELECT * FROM banka_hesaplarimiz ORDER BY BankaAdi ASC");
        $sorgu_bankaHesaplari -> execute();
        $sorguSayi = $sorgu_bankaHesaplari -> rowCount();
        if($sorguSayi > 0){
            $bankaHesaplari = $sorgu_bankaHesaplari -> fetchAll(PDO::FETCH_ASSOC);
            foreach($bankaHesaplari as $bankaHesabi){
    ?>
    <tr>
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="200">
                        <table width="200" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr height="75">
                                <td><img src="../<?php echo DonusumleriGeriDondur($bankaHesabi["BankaLogosu"]); ?>" border="0" width="140" height="30"></td>
                            </tr>
                            <tr height="30">
                                <td align="left">
                                    <table width="200" align="right" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="25" valign="center"><a href="index.php?SOAE=1&SOAI=7&id=<?php echo DonusumleriGeriDondur($bankaHesabi["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                                            <td width="70" valign="center"><a href="index.php?SOAE=1&SOAI=7&id=<?php echo DonusumleriGeriDondur($bankaHesabi["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle</a></td>
                                            <td width="25" valign="center"><a href="index.php?SOAE=1&SOAI=9&id=<?php echo DonusumleriGeriDondur($bankaHesabi["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                                            <td width="80" valign="center"><a href="index.php?SOAE=1&SOAI=9&id=<?php echo DonusumleriGeriDondur($bankaHesabi["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>




                    <td width="540">
                        <table width="540" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr height="105">
                                <td>
                                    <table width="540" align="right" border="0" cellpadding="0" cellspacing="0">

                                        <tr height="35">
                                            <td>
                                                <table width="540" align="right" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="100"><b>Banka Adı</b></td>
                                                        <td width="20"><b>:</b></td>
                                                        <td width="140"><?php echo DonusumleriGeriDondur($bankaHesabi["BankaAdi"]); ?></td>
                                                        <td width="115"><b>Hesap Sahibi</b></td>
                                                        <td width="20"><b>:</b></td>
                                                        <td width="145"><?php echo DonusumleriGeriDondur($bankaHesabi["HesapSahibi"]); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr height="35">
                                            <td>
                                                <table width="540" align="right" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="180"><b>Şube ve Konum Bilgileri</b></td>
                                                        <td width="20"><b>:</b></td>
                                                        <td width="340"><?php echo DonusumleriGeriDondur($bankaHesabi["SubeAdi"]); ?> (<?php echo DonusumleriGeriDondur($bankaHesabi["SubeKodu"]); ?>) - <?php echo DonusumleriGeriDondur($bankaHesabi["KonumSehir"]); ?> / <?php echo DonusumleriGeriDondur($bankaHesabi["KonumUlke"]); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr height="35">
                                            <td>
                                                <table width="540" align="right" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="110"><b>Hesap Bilgileri</b></td>
                                                        <td width="20"><b>:</b></td>
                                                        <td width="410"><?php echo DonusumleriGeriDondur($bankaHesabi["ParaBirimi"]); ?> / <?php echo DonusumleriGeriDondur($bankaHesabi["HesapNumarasi"]); ?> / <?php echo DonusumleriGeriDondur($bankaHesabi["IbanNumarasi"]); ?></td>
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
            </table>
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
                    <td width="750">Kayıtlı banka hesabı bulunmamaktadır.</td>
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