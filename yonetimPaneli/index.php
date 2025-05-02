<?php
    session_start(); ob_start();
    require_once("../ayarlar/ayar.php");
    require_once("../ayarlar/fonksiyonlar.php");
    require_once("../frameworks/Verot/src/class.upload.php");
    require_once("../ayarlar/yonetimSayfalariDis.php");
    require_once("../ayarlar/yonetimSayfalariIc.php");

    if(isset($_REQUEST["SOAE"])){
        $soae_value = SayiliIcerikleriFiltrele($_REQUEST["SOAE"]);
        $whichSo = 1;
    }else{
        $soae_value = 0;
    }

    if(isset($_REQUEST["SOAI"])){
        $soai_value = SayiliIcerikleriFiltrele($_REQUEST["SOAI"]);
        $whichSo = 2;
    }else{
        $soai_value = 0;
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
            <meta name="Robots" content="noindex, nofollow, noarchive">
            <meta name="googlebot" content="noindex, nofollow, noarchive">
            <meta name="revisit-after" content="7 Days">
            <title><?php echo DonusumleriGeriDondur($site_title); ?></title>
            <link type="image/png" rel="icon" href="../<?php echo DonusumleriGeriDondur($site_logosu); ?>">
            <script type="text/javascript" src="../frameworks/JQuery/jquery-3.6.0.min.js" language="javascript"></script>
            <link type="text/css" rel="stylesheet" href="../ayarlar/stilYonetim.css">
            <script type="text/javascript" src="../ayarlar/fonksiyonlar.js" language="javascript"></script>
            <script type="text/javascript" src="../ayarlar/fonksiyonlary.js" language="javascript"></script>
        </head>
        <body>
        <table width="1065" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="100%">
                <td align="center">
                    <?php
                        if(empty($_SESSION["kullanici_Yonetici"])){
                            if((!$soae_value) or ($soae_value == "") or ($soae_value == 0) or ($soae_value > $lastcodeAdEx)){
                                include($pagecodeAdEx[0]);
                            }else{
                                include($pagecodeAdEx[$soae_value]);
                            }
                        }else{
                            /*
                            if((!$soai_value) or ($soai_value == "") or ($soai_value == 0) or ($soai_value > $lastcodeAdIn)){
                                include($pagecodeAdIn[1]);
                            }else{
                                include($pagecodeAdIn[$soai_value]);
                            }
                            */
                            if((!$soae_value) or ($soae_value == "") or ($soae_value == 0) or ($soae_value > $lastcodeAdEx)){
                                include($pagecodeAdEx[1]);
                            }else{
                                include($pagecodeAdEx[$soae_value]);
                            }
                        }
                    ?>
                </td>
            </tr>
        </table>
        </body>
    </html>
<?php
    $veritaConn = null;
    ob_end_flush();
?>