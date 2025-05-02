<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANNER AYARLARI</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=19" style="color: #171717; text-decoration: none;">Yeni Banner Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_bannerlar = $veritaConn -> prepare("SELECT * FROM banner ORDER BY id DESC");
        $sorgu_bannerlar -> execute();
        $sorguSayi = $sorgu_bannerlar -> rowCount();
        if($sorguSayi > 0){
            $bannerlar = $sorgu_bannerlar -> fetchAll(PDO::FETCH_ASSOC);
            foreach($bannerlar as $banner){
    ?>
    <tr height="40">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td width="175" align="left">
                        <img src="../<?php echo DonusumleriGeriDondur($banner["bannerResmi"]); ?>" border="0" height="30">
                    </td>
                    <td width="575" align="left">
                        <table width="575" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr height="20">
                                <td width="50" align="left"><b>Banner Adı</b></td>
                                <td width="10" align="left"><b>:</b></td>
                                <td width="150" align="left"><?php echo DonusumleriGeriDondur($banner["bannerAdi"]); ?></td>
                                <td width="50" align="left"><b>Banner Yeri</b></td>
                                <td width="10" align="left"><b>:</b></td>
                                <td width="125" align="left"><?php echo DonusumleriGeriDondur($banner["bannerAlani"]); ?></td>
                                <td width="50" align="left"><b>Gösterim Sayısı</b></td>
                                <td width="10" align="left"><b>:</b></td>
                                <td width="50" align="left"><?php echo DonusumleriGeriDondur($banner["gosterimSayisi"]); ?></td>
                            </tr>
                            <tr height="20">
                                <td colspan="9">
                                    <table width="575" align="right" border="0" cellpadding="0" cellspacing="0">
                                        <tr height="20">
                                            <td width="425">&nbsp;</td>
                                            <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=22&id=<?php echo DonusumleriGeriDondur($banner["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                                            <td width="70" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=22&id=<?php echo DonusumleriGeriDondur($banner["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle</a></td>
                                            <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=21&id=<?php echo DonusumleriGeriDondur($banner["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                                            <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=21&id=<?php echo DonusumleriGeriDondur($banner["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
                    <td width="750">Kayıtlı Banner bulunmamaktadır.</td>
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