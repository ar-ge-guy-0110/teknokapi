<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=20" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANNER AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Banner Alanı</td>
                        <td width="20">:</td>
                        <td width="500">
                            <select name="bannerAlani" class="beaucombobox2">
                                <option value="">Lütfen Seçiniz</option>
                                <option value="anasayfa">Ana Sayfa</option>
                                <option value="menualti">Menü Altı</option>
                                <option value="urundetay">Ürün Detay</option>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banner Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bannerAdi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td>Banner Resmi</td>
                        <td>:</td>
                        <td><input type="file" name="bannerResmi"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Banner'i Kaydet" class="beaubgreen"></td>
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