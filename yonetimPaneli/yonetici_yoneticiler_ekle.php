<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=38" method="post">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;YÖNETİCİ AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="5" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Kullanıcı Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kullaniciAdi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Şifre</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="sifre" class="beauslot" value=""></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Tam İsim</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="adiSoyadi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">E-Posta Adresi</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="ePostaAdresi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Telefon Numarası</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="telNo" class="beauslot" value="" maxlength="11"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Yöneticiyi Kaydet" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>