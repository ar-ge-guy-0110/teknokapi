<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=2" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="145px">
            <td bgcolor="#338DFF" style="color: #171717;"><h3>&nbsp;SİTE AYARLARI</h3></td>
        </tr>
        <tr height="10"><td style="font-size: 10px;">&nbsp;</td></tr>
        <tr>
            <td>
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Site Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="siteAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_adi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Başlığı</td>
                        <td>:</td>
                        <td><input type="text" name="siteBasligi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_title); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Açıklaması</td>
                        <td>:</td>
                        <td><input type="text" name="siteAciklamasi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_description); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Anahtar Kelimeleri</td>
                        <td>:</td>
                        <td><input type="text" name="siteAnahtarKelimeler" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_keywords); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Telif Hakları Metni</td>
                        <td>:</td>
                        <td><input type="text" name="siteTelifHaklariMetni" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_copyright_metni); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Logosu</td>
                        <td>:</td>
                        <td><input type="file" name="siteLogosu"></td>
                    </tr>
                    <tr height="40">
                        <td>Site Linki</td>
                        <td>:</td>
                        <td><input type="text" name="siteLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_linki); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site E-Posta Adresi</td>
                        <td>:</td>
                        <td><input type="text" name="siteEPostaAdresi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_email_adresi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site E-Posta Şifresi</td>
                        <td>:</td>
                        <td><input type="password" name="siteEPostaSifresi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_email_sifresi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Site E-Posta Host Adresi</td>
                        <td>:</td>
                        <td><input type="text" name="siteEPostaHostAdresi" class="beauslot" value="<?php echo DonusumleriGeriDondur($site_email_host_adresi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Facebook Linki</td>
                        <td>:</td>
                        <td><input type="text" name="FacebookLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_facebook); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Twitter Linki</td>
                        <td>:</td>
                        <td><input type="text" name="TwitterLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_twitter); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>LinkedIn Linki</td>
                        <td>:</td>
                        <td><input type="text" name="LinkedInLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_linkedin); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Pinterest Linki</td>
                        <td>:</td>
                        <td><input type="text" name="PinterestLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_pinterest); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Instagram Linki</td>
                        <td>:</td>
                        <td><input type="text" name="InstagramLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_instagram); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>YouTube Linki</td>
                        <td>:</td>
                        <td><input type="text" name="YoutubeLinki" class="beauslot" value="<?php echo DonusumleriGeriDondur($soslink_youtube); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Dolar Kuru</td>
                        <td>:</td>
                        <td><input type="text" name="dolarKuru" class="beauslot" value="<?php echo DonusumleriGeriDondur($kurUSD); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Euro Kuru</td>
                        <td>:</td>
                        <td><input type="text" name="euroKuru" class="beauslot" value="<?php echo DonusumleriGeriDondur($kurEuro); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Ücretsiz Kargo Barajı</td>
                        <td>:</td>
                        <td><input type="text" name="ucretsizKargoBaraji" class="beauslot" value="<?php echo DonusumleriGeriDondur($ucretsizKargoBaraji); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Sanal Pos Api Client ID</td>
                        <td>:</td>
                        <td><input type="text" name="vposapi_ClientID" class="beauslot" value="<?php echo DonusumleriGeriDondur($clientId); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Sanal Pos Api StoreKey</td>
                        <td>:</td>
                        <td><input type="text" name="vposapi_StoreKey" class="beauslot" value="<?php echo DonusumleriGeriDondur($storekey); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Sanal Pos Api Kullanıcı Adı</td>
                        <td>:</td>
                        <td><input type="text" name="vposapi_KullaniciAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($BAPIName); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Sanal Pos Api Şifre</td>
                        <td>:</td>
                        <td><input type="password" name="vposapi_Sifre" class="beauslot" value="<?php echo DonusumleriGeriDondur($BAPIPassword); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Ayarları Kaydet" class="beaubgreen"></td>
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