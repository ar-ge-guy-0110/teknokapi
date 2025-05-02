<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;KARGO AYARLARI</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=13" style="color: #171717; text-decoration: none;">Yeni Kargo Firması Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_kargoFirmalari = $veritaConn -> prepare("SELECT * FROM kargo_firmalar ORDER BY ad ASC");
        $sorgu_kargoFirmalari -> execute();
        $sorguSayi = $sorgu_kargoFirmalari -> rowCount();
        if($sorguSayi > 0){
            $kargoFirmalari = $sorgu_kargoFirmalari -> fetchAll(PDO::FETCH_ASSOC);
            foreach($kargoFirmalari as $kargoFirmasi){
    ?>
    <tr height="35">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="760" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="200" align="left">
                        <img src="../<?php echo DonusumleriGeriDondur($kargoFirmasi["logo"]); ?>" border="0" width="140" height="30">
                    </td>
                    <td width="10" align="left">&nbsp;</td>
                    <td width="150" align="left"><b>Kargo Firması Adı</b></td>
                    <td width="20" align="left"><b>:</b></td>
                    <td width="210" align="left"><?php echo DonusumleriGeriDondur($kargoFirmasi["ad"]); ?></td>
                    <td width="10" align="left">&nbsp;</td>
                    <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=16&id=<?php echo DonusumleriGeriDondur($kargoFirmasi["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                    <td width="70" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=16&id=<?php echo DonusumleriGeriDondur($kargoFirmasi["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle</a></td>
                    <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=15&id=<?php echo DonusumleriGeriDondur($kargoFirmasi["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                    <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=15&id=<?php echo DonusumleriGeriDondur($kargoFirmasi["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
                    <td width="750">Kayıtlı Kargo Firması bulunmamaktadır.</td>
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