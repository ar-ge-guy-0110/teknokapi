<?php
    if(isset($_SESSION["kullanici_email"])){
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
                    <td colspan="5"><h3>Hesabım > Adresler</h3></td>
                </tr>
                <tr height="30">
                    <td colspan="5" valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm Adreslerini Bu Alanda Görüntüleyebilir Veya Güncelleyebilirsin.</td>
                </tr>
                <tr height="50">
                    <td colspan="1" style="background: #3cccb9;color: #151515;font-weight: bold;" align="left">&nbsp;Adresler</td>
                    <td colspan="4" style="background: #3cccb9;color: #151515;font-weight: bold;" align="right"><a href="index.php?SO=45" style="text-decoration: none; color: #000000;">+ Yeni Adres Ekle</a>&nbsp;</td>
                </tr>
                <?php
                    $sorgu_adresGetir = $veritaConn -> prepare("SELECT * FROM uyeler_adresler WHERE uye_id = ? LIMIT 30");
                    $sorgu_adresGetir -> execute([$kullanici_id]);
                    $adresSayisi = $sorgu_adresGetir -> rowCount();
                    $adresler = $sorgu_adresGetir -> fetchAll(PDO::FETCH_ASSOC);

                    $renk_1 = "#F1F1F1";
                    $renk_2 = "#FFFFFF";
                    $satirSay = 1;
                    if($adresSayisi > 0){
                        foreach($adresler as $adres){
                            if($satirSay % 2 == 0){
                                $satirRengi = $renk_2;
                            }else{
                                $satirRengi = $renk_1;
                            }
                            $satirSay++;
                            ?>
                <tr height="50" bgcolor="<?php echo $satirRengi; ?>">
                    <td align="left"><?php echo $adres["tamisim"]; ?> - <?php echo $adres["adres"]; ?> - <?php echo $adres["ilce"]; ?> / <?php echo $adres["il"]; ?>, <?php echo $adres["ulke"]; ?> - <?php echo $adres["telno"]; ?></td>
                    <td width="25"><img src="resimler/button/updated.png" border="0" style="margin-top: 5px;"></td>
                    <td width="70"><a href="index.php?SO=47&id=<?php echo $adres["id"]; ?>" style="text-decoration: none; color: #646464;">Güncelle</a></td>
                    <td width="25"><img src="resimler/button/delete.png" border="0" style="margin-top: 5px;"></td>
                    <td width="25"><a href="index.php?SO=44&id=<?php echo $adres["id"]; ?>" style="text-decoration: none; color: #646464;">Sil</a></td>
                </tr>
                            <?php
                        }
                    }else{
                        ?>
                <tr height="50">
                    <td colspan="5" align="left"><b>Sisteme Kayıtlı Adresiniz Bulunmamaktadır.</b></td>
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