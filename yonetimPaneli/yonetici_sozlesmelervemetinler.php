<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=5" method="post">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="145px">
            <td bgcolor="#338DFF" style="color: #171717;"><h3>&nbsp;SÖZLEŞMELER VE METİNLER</h3></td>
        </tr>
        <tr height="10"><td style="font-size: 10px;">&nbsp;</td></tr>
        <tr>
            <td>
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230" valign="top">Hakkımızda Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_hakkimizda" class="beaubigwriting"><?php echo DonusumleriGeriDondur($Hakkimizda_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Üyelik Sözleşmesi Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_uyeliksozlesmesi" class="beaubigwriting"><?php echo DonusumleriGeriDondur($UyelikSozlesmesi_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Kullanım Koşulları Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_kullanimkosullari" class="beaubigwriting"><?php echo DonusumleriGeriDondur($KullanimKosullari_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Gizlilik Sözleşmesi Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_gizliliksozlesmesi" class="beaubigwriting"><?php echo DonusumleriGeriDondur($GizlilikSozlesmesi_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Mesafeli Satış Sözleşmesi Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_mesafelisatissozlesmesi" class="beaubigwriting"><?php echo DonusumleriGeriDondur($MesafeliSatisSozlesmesi_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Teslimat Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_teslimat" class="beaubigwriting"><?php echo DonusumleriGeriDondur($Teslimat_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">İptal & İade & Değişim Metni</td>
                        <td width="20" valign="top">:</td>
                        <td width="500" valign="top"><textarea name="metin_iptaliadedegisim" class="beaubigwriting"><?php echo DonusumleriGeriDondur($IptaliadeDegisim_Metni); ?></textarea></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Metinleri Kaydet" class="beaubgreen"></td>
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