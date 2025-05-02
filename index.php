<?php
    session_start(); ob_start();
    require_once("ayarlar/ayar.php");
    require_once("ayarlar/fonksiyonlar.php");
    require_once("ayarlar/site_sayfalari.php");

    if(isset($_REQUEST["SO"])){
        $so_value = SayiliIcerikleriFiltrele($_REQUEST["SO"]);
    }else{
        $so_value = 0;
    }

    if(isset($_REQUEST["SF"])){
        $sf_value = SayiliIcerikleriFiltrele($_REQUEST["SF"]);
    }else{
        $sf_value = 1;
    }
?>
<!doctype html>
    <html lang="tr-TR">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta http-equiv="Content-Language" content="tr">
            <meta charset="utf8">
            <meta name="Robots" content="index, follow">
            <meta name="googlebot" content="index, follow">
            <meta name="revisit-after" content="7 Days">
            <title><?php echo DonusumleriGeriDondur($site_title); ?></title>
            <link type="image/png" rel="icon" href="<?php echo DonusumleriGeriDondur($site_logosu); ?>">
            <meta name="description" content="<?php echo DonusumleriGeriDondur($site_description); ?>">
            <meta name="keywords" content="<?php echo DonusumleriGeriDondur($site_keywords); ?>">
            <base href="/teknokapi/">
            <script type="text/javascript" src="frameworks/JQuery/jquery-3.6.0.min.js" language="javascript"></script>
            <link type="text/css" rel="stylesheet" href="ayarlar/stil.css">
            <script type="text/javascript" src="ayarlar/fonksiyonlar.js" language="javascript"></script>
        </head>
        <body>
            <table width="1065" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40" bgcolor="#353745">
                    <td>
                        <img src="resimler/banner_kargo_bedava.png" width="1065" border="0">
                    </td>
                </tr>
                <tr height="110">
                    <td>
                        <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr bgcolor="#3cccb9">
                                <td>&nbsp;</td>
                                <?php
                                    if(isset($_SESSION["kullanici_email"])){
                                        ?>
                                <td width="20"><a href="hesabim"><img src="resimler/button/user.png" border="0" style="margin-top: 5px;"></a></td>
                                <td width="68" class="beaumenu1"><a href="hesabim">Hesabım</a></td>
                                <td width="20"><a href="cikis"><img src="resimler/button/log-out.png" border="0" style="margin-top: 5px;"></a></td>
                                <td width="85" class="beaumenu1"><a href="cikis">Çıkış Yap</a></td>
                                <td width="20"><a href="sepetim"><img src="resimler/button/online-shopping.png" border="0" style="margin-top: 5px;"></a></td>
                                <td width="103" class="beaumenu1"><a href="sepetim">Alışveriş Sepeti</a></td>
                                        <?php
                                    }else{
                                        ?>
                                <td width="20"><a href=""><img src="resimler/button/log-in.png" border="0" style="margin-top: 5px;"></a></td>
                                <td width="68" class="beaumenu1"><a href="giris">Giriş Yap</a></td>
                                <td width="20"><a href=""><img src="resimler/button/enter.png" border="0" style="margin-top: 5px;"></a></td>
                                <td width="85" class="beaumenu1"><a href="uye-ol">Yeni Üye Ol</a></td>
                                        <?php
                                    }
                                ?>
                            </tr>
                        </table>
                        <table width="1065" height="80" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr bgcolor="#fff">
                                <td width="64"><a href="web"><img width="64" height="64" border="0" align="middle" src="<?php echo DonusumleriGeriDondur($site_logosu); ob_start(); ?>"></a></td>
                                <td>
                                    <table width="1001" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="beaumenu2" width="593">&nbsp;</td>
                                            <td class="beaumenu2" width="102"><a href="web">Ana Sayfa</a></td>
                                            <td class="beaumenu2" width="102"><a href="kolyeler">Kolyeler</a></td>
                                            <td class="beaumenu2" width="102"><a href="taki-setleri">Takı Setleri</a></td>
                                            <td class="beaumenu2" width="102"><a href="bileklikler">Bileklikler</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <?php
                                        if((!$so_value) or ($so_value == "") or ($so_value == 0) or ($so_value > $lastcode)){
                                            include($pagecode[0]);
                                        }else{
                                            include($pagecode[$so_value]);
                                        }
                                    ?>
                                    <br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr height="210">
                    <td>
                        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#f9f9f9">
                            <tr height="30">
                                <td width="250" style="border-bottom: 1px dashed #3cccb9;">&nbsp;<b>Kurumsal</b></td>
                                <td width="22">&nbsp;</td>
                                <td width="250" style="border-bottom: 1px dashed #3cccb9;"><b>Üyelik & Hizmetler</b></td>
                                <td width="22">&nbsp;</td>
                                <td width="250" style="border-bottom: 1px dashed #3cccb9;"><b>Sözleşmeler</b></td>
                                <td width="21">&nbsp;</td>
                                <td width="250" style="border-bottom: 1px dashed #3cccb9;"><b>Bizi Takip Edin</b></td>
                            </tr>
                            <tr height="30">
                                <td class="beaumenu3">&nbsp;<a href="hakkimizda">Hakkımızda</a></td>
                                <td>&nbsp;</td>
                                <?php
                                    if(isset($_SESSION["kullanici_email"])){
                                        ?>
                                <td class="beaumenu3"><a href="hesabim">Hesabım</a></td>
                                        <?php
                                    }else{
                                        ?>
                                <td class="beaumenu3"><a href="giris">Giriş Yap</a></td>
                                        <?php
                                    }
                                ?>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="uyelik-sozlesmesi">Üyelik Sözleşmesi</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_facebook); ?>" target="_blank"><img src="resimler/icons/facebook.png" border="0" style="margin-top: 5px"></a></td>
                                            <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_facebook); ?>" target="_blank">Facebook</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td class="beaumenu3">&nbsp;<a href="banka-hesaplarimiz">Banka Hesaplarımız</a></td>
                                <td>&nbsp;</td>
                                <?php
                                    if(isset($_SESSION["kullanici_email"])){
                                        ?>
                                <td class="beaumenu3"><a href="cikis">Çıkış Yap</a></td>
                                        <?php
                                    }else{
                                        ?>
                                <td class="beaumenu3"><a href="uye-ol">Yeni Üye Ol</a></td>
                                        <?php
                                    }
                                ?>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="kullanim-kosullari">Kullanım Koşulları</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_twitter); ?>" target="_blank"><img src="resimler/icons/twitter.png" border="0" style="margin-top: 5px"></a></td>
                                                <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_twitter); ?>" target="_blank">Twitter</a></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td class="beaumenu3">&nbsp;<a href="havale-bildirim-formu">Havale Bildirim Formu</a></td>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="sorular">Sık Sorulan Sorular</a></td>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="gizlilik">Gizlilik Sözleşmesi</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_linkedin); ?>" target="_blank"><img src="resimler/icons/linkedin.png" border="0" style="margin-top: 5px"></a></td>
                                                <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_linkedin); ?>" target="_blank">LinkedIn</a></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td class="beaumenu3">&nbsp;<a href="kargom-nerede">Kargo Nerede?</a></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="mesafeli-satis-sozlesmesi">Mesafeli Satış Sözleşmesi</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_pinterest); ?>" target="_blank"><img src="resimler/icons/pinterest-social-logo.png" border="0" style="margin-top: 5px"></a></td>
                                                <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_pinterest); ?>" target="_blank">Pinterest</a></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td class="beaumenu3">&nbsp;<a href="iletisim">İletişim</a></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="teslimat">Teslimat</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_instagram); ?>" target="_blank"><img src="resimler/icons/instagram.png" border="0" style="margin-top: 5px"></a></td>
                                                <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_instagram); ?>" target="_blank">Instagram</a></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="beaumenu3"><a href="iptal-iade-degisim">İptal & İade & Değişim</a></td>
                                <td>&nbsp;</td>
                                <td>
                                    <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20"><a href="<?php echo DonusumleriGeriDondur($soslink_youtube); ?>" target="_blank"><img src="resimler/icons/youtube.png" border="0" style="margin-top: 5px"></a></td>
                                                <td width="230" class="beaumenu3"><a href="<?php echo DonusumleriGeriDondur($soslink_youtube); ?>" target="_blank">YouTube</a></td>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr height="30">
                    <td>
                        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center"><?php echo DonusumleriGeriDondur($site_copyright_metni); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr height="30">
                    <td>
                        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <img src="resimler/banka_sertifika/rapidssl.png" border="0" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/secure-shopping.png" border="0" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/3dsecure.png" border="0" style="margin-left: 5px">
                                    <br/>
                                    <img src="resimler/banka_sertifika/garanti_bonus_card.png" border="0" width="41" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/maximum_card.png" border="0" width="41" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/world_card.png" border="0" width="61" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/cardfinans_card.png" border="0" width="61" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/axess_card.png" border="0" width="41" height="24" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/paraf_card.png" border="0" width="31" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/visa_card.png" border="0" width="41" height="12" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/master_card.png" border="0" width="37" height="24" style="margin-left: 5px">
                                    <img src="resimler/banka_sertifika/american_express_card.png" border="0" width="41" height="24" style="margin-left: 5px">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </body>
    </html>
<?php
    $veritaConn = null;
    ob_end_flush();
?>