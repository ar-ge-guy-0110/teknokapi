<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=26" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;DESTEK İÇERİKLERİ</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Soru</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="soru" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Cevap</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><textarea name="cevap" class="beaubigwriting"></textarea></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Destek İçeriğini Kaydet" class="beaubgreen"></td>
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