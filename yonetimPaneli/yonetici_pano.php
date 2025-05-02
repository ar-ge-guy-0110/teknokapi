<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        $sayi_tumSiparisler = 0;
        $sayi_bekleyenSiparis = 0;
        $sayi_tamamlananSiparis = 0;

        $sayi_havaleBildirimleri = 0;

        $sayi_bankaHesaplari = 0;

        $sayi_menuler = 0;

        $sayi_urunler = 0;

        $sayi_uyeler = 0;

        $sayi_yoneticiler = 0;

        $sayi_kargocu = 0;

        $sayi_banner = 0;

        $sayi_yorum = 0;

        $sayi_soru = 0;

        //$sorgu_siparisSayisi = $veritaConn -> prepare("SELECT id, COUNT(*) AS total, SUM(CASE WHEN siparis_onayDurum = 1 AND siparis_kargoDurum = 1 THEN 1 ELSE 0 END) AS tamamlanan_siparisler, SUM(CASE WHEN siparis_onayDurum = 0 AND siparis_kargoDurum = 0 THEN 1 ELSE 0 END) AS bekleyen_siparisler FROM siparisler GROUP BY id");
        $sorgu_siparisSayisi = $veritaConn -> prepare("SELECT  
        COUNT(DISTINCT siparis_no) AS total, 
        COUNT(DISTINCT CASE WHEN siparis_onayDurum = 1 AND siparis_kargoDurum = 1 THEN siparis_no END) AS tamamlanan_siparisler, 
        COUNT(DISTINCT CASE WHEN siparis_onayDurum = 0 AND siparis_kargoDurum = 0 THEN siparis_no END) AS bekleyen_siparisler 
        FROM siparisler");
        $sorgu_siparisSayisi -> execute();
        $siparisSayilari = $sorgu_siparisSayisi -> fetch(PDO::FETCH_ASSOC);
        if($siparisSayilari){
            $sayi_tumSiparisler = $siparisSayilari["total"];
            $sayi_bekleyenSiparis = $siparisSayilari["bekleyen_siparisler"];
            $sayi_tamamlananSiparis = $siparisSayilari["tamamlanan_siparisler"];
        }

        $sorgu_havaleBildirimSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM havale_bildirimleri");
        $sorgu_havaleBildirimSayisi -> execute();
        $havaleBildirimSayisi = $sorgu_havaleBildirimSayisi -> fetch(PDO::FETCH_ASSOC);
        if($havaleBildirimSayisi)
            $sayi_havaleBildirimleri = $havaleBildirimSayisi["total"];
        
        $sorgu_bankaHesaplariSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM banka_hesaplarimiz");
        $sorgu_bankaHesaplariSayisi -> execute();
        $bankaHesaplariSayisi = $sorgu_bankaHesaplariSayisi -> fetch(PDO::FETCH_ASSOC);
        if($bankaHesaplariSayisi)
            $sayi_bankaHesaplari = $bankaHesaplariSayisi["total"];
        
        $sorgu_menuSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM menuler");
        $sorgu_menuSayisi -> execute();
        $menuSayisi = $sorgu_menuSayisi -> fetch(PDO::FETCH_ASSOC);
        if($menuSayisi)
            $sayi_menuler = $menuSayisi["total"];
        
        $sorgu_urunSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM urunler");
        $sorgu_urunSayisi -> execute();
        $urunSayisi = $sorgu_urunSayisi -> fetch(PDO::FETCH_ASSOC);
        if($urunSayisi)
            $sayi_urunler = $urunSayisi["total"];

        $sorgu_uyelerSayi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM uyeler");
        $sorgu_uyelerSayi -> execute();
        $uyeSayisi = $sorgu_uyelerSayi -> fetch(PDO::FETCH_ASSOC);
        if($uyeSayisi)
            $sayi_uyeler = $uyeSayisi["total"];

        $sorgu_yoneticiSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM yoneticiler");
        $sorgu_yoneticiSayisi -> execute();
        $yoneticiSayisi = $sorgu_yoneticiSayisi -> fetch(PDO::FETCH_ASSOC);
        if($yoneticiSayisi)
            $sayi_yoneticiler = $yoneticiSayisi["total"];

        $sorgu_kargocuSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM kargo_firmalar");
        $sorgu_kargocuSayisi -> execute();
        $kargocuSayisi = $sorgu_kargocuSayisi -> fetch(PDO::FETCH_ASSOC);
        if($kargocuSayisi)
            $sayi_kargocu = $kargocuSayisi["total"];

        $sorgu_bannerSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM banner");
        $sorgu_bannerSayisi -> execute();
        $bannerSayisi = $sorgu_bannerSayisi -> fetch(PDO::FETCH_ASSOC);
        if($bannerSayisi)
            $sayi_banner = $bannerSayisi["total"];

        $sorgu_yorumSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM yorumlar");
        $sorgu_yorumSayisi -> execute();
        $yorumSayisi = $sorgu_yorumSayisi -> fetch(PDO::FETCH_ASSOC);
        if($yorumSayisi)
            $sayi_yorum = $yorumSayisi["total"];

        $sorgu_soruSayisi = $veritaConn -> prepare("SELECT COUNT(id) AS total FROM sorular");
        $sorgu_soruSayisi -> execute();
        $soruSayisi = $sorgu_soruSayisi -> fetch(PDO::FETCH_ASSOC);
        if($soruSayisi)
            $sayi_soru = $soruSayisi["total"];
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr height="70">
        <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;PANO</h3></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr height="35">
        <td colspan="2">
            <table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Bekleyen Siparişler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_bekleyenSiparis; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Tamamlanan Siparişler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_tamamlananSiparis; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Tüm Siparişler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_tumSiparisler; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10">
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr height="35">
        <td colspan="2">
            <table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Havale Bildirimleri</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_havaleBildirimleri; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Banka Hesapları</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_bankaHesaplari; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Menü Sayısı</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_menuler; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10">
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr height="35">
        <td colspan="2">
            <table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Ürünler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_urunler; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Üyeler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_uyeler; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Yöneticiler</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_yoneticiler; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10">
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr height="35">
        <td colspan="2">
            <table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Kargolar</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_kargocu; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Bannerlar</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_banner; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Yorumlar</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_yorum; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10">
        <td style="font-size: 10px;">&nbsp;</td>
    </tr>
    <tr height="35">
        <td colspan="2">
            <table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="50">
                    <td width="243" style="border: 1px solid #CCC;">
                        <table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="30">
                                <td align="center" style="font-size: 18px">Destek İçerikleri</td>
                            </tr>
                            <tr height="40">
                                <td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $sayi_soru; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="10">&nbsp;</td>
                    <td width="243">&nbsp;</td>
                    <td width="10">&nbsp;</td>
                    <td width="243">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>