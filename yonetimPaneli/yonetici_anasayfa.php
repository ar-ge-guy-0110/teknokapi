<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<table width="1065" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="100%">
        <td width="300" align="center" bgcolor="#56C1F3" valign="top">
            <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="145">
                    <td align="center"><a href="index.php?SOAE=1&SOAI=0"><img src="../<?php echo $site_logosu; ?>" width="125" height="125" border="0"></a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=54">&nbsp;SİPARİŞLER (X/X)</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=61">&nbsp;HAVALE BİLDİRİMLERİ (X/X)</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=48">&nbsp;ÜRÜNLER</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=42">&nbsp;ÜYELER</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=46">&nbsp;YORUMLAR</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=1">&nbsp;SİTE AYARLARI</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=30">&nbsp;MENÜLER</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=6">&nbsp;BANKA HESABI AYARLARI</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=12">&nbsp;KARGO AYARLARI</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=18">&nbsp;BANNER AYARLARI</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=4">&nbsp;SÖZLEŞMELER VE METİNLER</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=24">&nbsp;DESTEK İÇERİKLERİ</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=1&SOAI=36">&nbsp;YÖNETİCİLER</a></td>
                </tr>
                <tr height="50">
                    <td align="left" style="border-bottom: 1px dashed #FFF;" class="beaumenulink"><a href="index.php?SOAE=4">&nbsp;ÇIKIŞ</a></td>
                </tr>
            </table>
        </td>
        <td width="5" align="center" bgcolor="$FF0000" valign="top">&nbsp;</td>
        <td width="760" align="center" valign="top">
            <?php
                if((!$soai_value) or ($soai_value == "") or ($soai_value == 0) or ($soai_value > $lastcodeAdIn)){
                    include($pagecodeAdIn[0]);
                }else{
                    include($pagecodeAdIn[$soai_value]);
                }
            ?>
        </td>
    </tr>
</table>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>