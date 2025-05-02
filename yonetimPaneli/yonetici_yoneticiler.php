<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;YÖNETİCİ AYARLARI</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=37" style="color: #171717; text-decoration: none;">Yeni Yönetici Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_yoneticiler = $veritaConn -> prepare("SELECT * FROM yoneticiler ORDER BY kullaniciAdi ASC");
        $sorgu_yoneticiler -> execute();
        $sorguSayi = $sorgu_yoneticiler -> rowCount();
        if($sorguSayi > 0){
            $yoneticiler = $sorgu_yoneticiler -> fetchAll(PDO::FETCH_ASSOC);
            foreach($yoneticiler as $yonetici){
    ?>
    <tr height="40">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="30">
                    <td align="left" width="125"><?php echo $yonetici["kullaniciAdi"]; ?></td>
                    <td align="left" width="150"><?php echo $yonetici["adiSoyadi"]; ?></td>
                    <td align="left" width="200"><?php echo $yonetici["ePostaAdresi"]; ?></td>
                    <td align="left" width="125"><?php echo $yonetici["telNo"]; ?></td>
                    <td align="right" width="150">
                        <table width="150" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=40&id=<?php echo DonusumleriGeriDondur($yonetici["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                                <td width="70" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=40&id=<?php echo DonusumleriGeriDondur($yonetici["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle</a></td>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=39&id=<?php echo DonusumleriGeriDondur($yonetici["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                                <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=39&id=<?php echo DonusumleriGeriDondur($yonetici["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
                    <td width="750">Kayıtlı Yönetici Bulunmamaktadır.</td>
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