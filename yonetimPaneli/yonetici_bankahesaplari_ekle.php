<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=11" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANKA HESAP AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td>Banka Logosu</td>
                        <td>:</td>
                        <td><input type="file" name="bankaLogosu"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaAdi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Şube Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaSubeAdi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Şube Kodu</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaSubeKodu" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Bankanın Bulunduğu Şehir</td>
                        <td>:</td>
                        <td><input type="text" name="bankaSehir" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Bankanın Bulunduğu Ülke</td>
                        <td>:</td>
                        <td><input type="text" name="bankaUlke" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Hesabın Para Birimi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaParaBirimi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap Sahibi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapSahibi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap Numarasi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapNumarasi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap IBAN Kodu</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapIban" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Banka Hesabını Kaydet" class="beaubgreen"></td>
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