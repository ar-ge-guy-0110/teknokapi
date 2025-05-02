<?php
    if(isset($_SESSION["kullanici_email"])){
        ?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3"><hr /></td>
    </tr>
    <tr>
        <td colspan="3">
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
        <td colspan="3"><hr /></td>
    </tr>
    <tr>
        <td width="500" valign="top">
            <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td ><h3>Hesabım > Üyelik Bilgileri</h3></td>
                </tr>
                <tr height="30">
                    <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Aşağıdan Üyelik Bilgilerini Görüntüleyebilir Veya Güncelleyebilirsin.</td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>İsim - Soyisim</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo $kullanici_tamisim; ?></td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>Cinsiyet</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo $kullanici_cinsiyet; ?></td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>E-Posta Adresi</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo $kullanici_email; ?></td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>Telefon Numarası</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo $kullanici_telno; ?></td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>Kayıt Tarihi</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo timestamp2time($kullanici_kayit_tarihi); ?></td>
                </tr>
                <tr height="30">
                    <td valign="bottom" align="left"> <b>Kayıt IP Adresi</b></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="left"><?php echo $kullanici_kayit_ip_adresi; ?></td>
                </tr>
                <tr height="30">
                    <td valign="top" align="center"><a href="index.php?SO=41" class="beauanchorgreen">Bilgilerimi Güncellemek İstiyorum</a></td>
                </tr>
            </table>
        </td>
        <td width="20">&nbsp;</td>
        <td width="545" valign="top">
            <table width="545" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td><h3>Reklam</h3></td>
                </tr>
                <tr height="30">
                    <td valign="top" style="border-bottom: 1px dashed #3cccb9;" >YesimTaki.Com Reklamları</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><img src="resimler/Logo.svg" border="0" width="545" height="410"></td>
                </tr>
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