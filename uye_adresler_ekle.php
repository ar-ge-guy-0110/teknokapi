<?php
    if(isset($_SESSION["kullanici_email"])){
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="500" valign="top">
            <form action="index.php?SO=46" method="post">
                <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td><h3>Hesabım > Adresler</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm adreslerini görüntüleyebilir ve güncelleyebilirsin.</td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İsim ve Soyisim (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="IsimSoyisim" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Adres (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Adres" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İlçe (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Ilce" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İl (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Il" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Ülke (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Ulke" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Telefon Numarası (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="TelNo" maxlength="11" class="beauslot"></td>
                    </tr>
                    <tr height="40">
                        <td align="center"><input type="submit" value="Adresi Kaydet" class="beaubgreen"></td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="20">&nbsp;</td>
        <td width="545" valign="top">
            <table width="545" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td><h3>Reklam</h3></td>
                </tr>
                <tr height="30">
                    <td valign="top" style="border-bottom: 1px dashed #3cccb9;">YesimTaki.Com Reklamları</td>
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
