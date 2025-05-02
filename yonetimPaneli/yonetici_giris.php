<?php
if(empty($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=2" method="post">
    <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #000; padding: 20px;">
        <tr height="40">
            <td align="left" width="150">Kullanıcı Adı</td>
            <td align="left" width="50">:</td>
            <td align="left" width="240"><input type="text" name="yKullanici" class="beauslot"></td>
            <td align="left" width="20">&nbsp;</td>
        </tr>
        <tr height="40">
            <td align="left">Şifre</td>
            <td align="left">:</td>
            <td align="left"><input type="password" name="ySifre" class="beauslot"></td>
            <td align="left">&nbsp;</td>
        </tr>
        <tr height="40">
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left"><input type="submit" value="Giriş Yap" class="beaubgreen"></td>
            <td align="left">&nbsp;</td>
        </tr>
    </table>
</form>
<?php
}
?>