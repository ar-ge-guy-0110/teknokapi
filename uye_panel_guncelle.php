<?php
    if(isset($_SESSION["kullanici_email"])){
        ?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="500" valign="top">
            <form action="index.php?SO=42" method="post">
                <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td><h3>Hesabım > Üyelik Bilgileri</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Aşağıdan Üyelik Bilgilerini Görüntüleyebilir Veya Güncelleyebilirsin.</td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> E-Posta Adresi (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="mail" name="EpostaAdresi" class="beauslot" value="<?php echo $kullanici_email; ?>"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Şifre (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="password" name="Sifre" class="beauslot" value="eskisifre"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Şifre Tekrarı (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="password" name="SifreTekrar" class="beauslot" value="eskisifre"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İsim ve Soyisim (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="IsimSoyisim" class="beauslot" value="<?php echo $kullanici_tamisim; ?>"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Telefon Numarası (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="TelefonNumarasi" maxlength="11" class="beauslot" value="<?php echo $kullanici_telno; ?>"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Cinsiyet (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left">
                            <select name="Cinsiyet" class="beaucombobox2">
                                <option value="">Lütfen Seçiniz</option>
                                <option value="Erkek" <?php if($kullanici_cinsiyet == "Erkek"){echo "selected";}?>>Erkek</option>
                                <option value="Kadin" <?php if($kullanici_cinsiyet == "Kadin"){echo "selected";}?>>Kadın</option>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td align="center"><input type="submit" value="Güncelle" class="beaubgreen"></td>
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
