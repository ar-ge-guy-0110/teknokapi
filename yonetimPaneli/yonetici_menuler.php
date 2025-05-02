<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;MENÜ AYARLARI</h3></td>
        <td width="200" bgcolor="#338DFF" align="right"><a href="index.php?SOAE=1&SOAI=31" style="color: #171717; text-decoration: none;">Yeni Menü Ekle</a>&nbsp;</td>
    </tr>
    <tr height="10">
        <td colspan="2" style="font-size: 10px;">&nbsp;</td>
    </tr>
    <?php
        $sorgu_menuler = $veritaConn -> prepare("SELECT * FROM menuler ORDER BY urun_tur ASC");
        $sorgu_menuler -> execute();
        $sorguSayi = $sorgu_menuler -> rowCount();
        if($sorguSayi > 0){
            $menuler = $sorgu_menuler -> fetchAll(PDO::FETCH_ASSOC);
            foreach($menuler as $menu){
    ?>
    <tr height="40">
        <td colspan="2" style="border-bottom: 1px dashed #CCC;" valign="top">
            <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="30">
                    <td align="left" width="200"><b><?php echo $menu["urun_tur"]; ?></b></td>
                    <td align="left" width="400"><?php echo $menu["menu_ad"]; ?> (<?php echo $menu["urun_sayi"]; ?>)</td>
                    <td align="right" width="150">
                        <table width="150" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=34&id=<?php echo DonusumleriGeriDondur($menu["id"]) ?>"><img src="../resimler/button/refresh.png" border="0"></a></td>
                                <td width="70" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=34&id=<?php echo DonusumleriGeriDondur($menu["id"]) ?>" style="color: #00000FF; text-decoration: none;">Güncelle</a></td>
                                <td width="25" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=33&id=<?php echo DonusumleriGeriDondur($menu["id"]) ?>"><img src="../resimler/button/remove.png" border="0"></a></td>
                                <td width="30" valign="center" align="left"><a href="index.php?SOAE=1&SOAI=33&id=<?php echo DonusumleriGeriDondur($menu["id"]) ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
                    <td width="750">Kayıtlı Menü Bulunmamaktadır.</td>
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