<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;Havale Bildirimleri</h3></td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_havaleler = $veritaConn -> prepare("SELECT havale_bildirimleri.*, banka_hesaplarimiz.BankaAdi FROM havale_bildirimleri JOIN banka_hesaplarimiz ON havale_bildirimleri.banka_id = banka_hesaplarimiz.id ORDER BY IslemTarihi ASC");
        $sorgu_havaleler -> execute();
        $sorguSayi = $sorgu_havaleler -> rowCount();
        if($sorguSayi > 0){
            $havaleler = $sorgu_havaleler -> fetchAll(PDO::FETCH_ASSOC);
            foreach($havaleler as $havale){
    ?>
    <tr height="40">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="30">
                    <td align="left" width="375"><b><?php echo DonusumleriGeriDondur($havale["AdiSoyadi"]); ?></b></td>
                    <td align="right" width="375"><b><?php echo timestamp2time($havale["IslemTarihi"]); ?></b></td>
                </tr>
                <tr>
                    <td align="left"><?php echo DonusumleriGeriDondur($havale["EmailAdresi"]); ?></td>
                    <td align="left">Banka: <?php echo DonusumleriGeriDondur($havale["BankaAdi"]); ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"><?php echo DonusumleriGeriDondur($havale["TelNo"]); ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"><?php echo DonusumleriGeriDondur($havale["Aciklama"]); ?></td>
                </tr>
                <tr height="20">
                    <td colspan="2" align="right">
                        <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr height="20">
                            <td width="695">&nbsp;</td>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=62&id=<?php echo DonusumleriGeriDondur($havale["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                                <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=62&id=<?php echo DonusumleriGeriDondur($havale["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
                    <td width="750">Kayıtlı Havale Bildirimi Bulunmamaktadır.</td>
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