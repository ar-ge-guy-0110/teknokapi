<?php
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){

        
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="500" valign="top">
            <form action="index.php?SO=51&urunid=<?php echo $gelen_id; ?>" method="post">
                <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td><h3>Hesabım > Yorum Yap</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Satın Almış Olduğun Ürün İle Alakalı Yorumunu Aşağıdan Belirtebilirsin.</td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Puanlama (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left">
                            <table width="460" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="84"><img src="resimler/rating/ratingOneStar.png" width="84px" height="11px" border="0"></td>
                                    <td width="10">&nbsp;</td>
                                    <td width="84"><img src="resimler/rating/ratingTwoStar.png" width="84px" height="11px" border="0"></td>
                                    <td width="10">&nbsp;</td>
                                    <td width="84"><img src="resimler/rating/ratingThreeStar.png" width="84px" height="11px" border="0"></td>
                                    <td width="10">&nbsp;</td>
                                    <td width="84"><img src="resimler/rating/ratingFourStar.png" width="84px" height="11px" border="0"></td>
                                    <td width="10">&nbsp;</td>
                                    <td width="84"><img src="resimler/rating/ratingFiveStar.png" width="84px" height="11px" border="0"></td>
                                </tr>
                                <tr>
                                <td width="84" align="center"><input type="radio" name="Puan" value="1"></td>
                                <td width="10">&nbsp;</td>
                                <td width="84" align="center"><input type="radio" name="Puan" value="2"></td>
                                <td width="10">&nbsp;</td>
                                <td width="84" align="center"><input type="radio" name="Puan" value="3"></td>
                                <td width="10">&nbsp;</td>
                                <td width="84" align="center"><input type="radio" name="Puan" value="4"></td>
                                <td width="10">&nbsp;</td>
                                <td width="84" align="center"><input type="radio" name="Puan" value="5"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Yorum Metni (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><textarea  class="beaubigwriting2" name="yorum"></textarea></td>
                    </tr>
                    <tr height="40">
                        <td align="center"><input type="submit" value="Yorumu Gönder" class="beaubgreen"></td>
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
            $_SESSION["mesaj_ana"] = "Hata. Üye Sipariş Bilgileri Yok.";
            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/hata.png";
            header("Location:index.php?SO=33"); // HATA
            exit();
        }
    }else{
        header("Location:index.php");
        exit();
    }
?>