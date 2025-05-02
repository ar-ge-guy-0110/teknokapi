<?php
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_GET["id"])){
            $gelen_id = $_GET["id"];
        }else{
            $gelen_id = "";
            $_SESSION["mesaj_ana"] = "Hata. Adres Kaydı Formu İçin Kullanıcı Tanımlayıcı Sayı Alınamadı.";
            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/hata.png";
            header("Location:index.php?SO=33"); //HATA
            exit();
        }


        $sorgu_adres = $veritaConn -> prepare("SELECT * FROM uyeler_adresler WHERE id = ? AND uye_id = ? LIMIT 1");
        $sorgu_adres -> execute([$gelen_id, $kullanici_id]);
        $sorgu_adres_kontrol = $sorgu_adres -> rowCount();
        $uye_adres = $sorgu_adres -> fetch(PDO::FETCH_ASSOC);

        if($sorgu_adres_kontrol > 0){
        
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="500" valign="top">
            <form action="index.php?SO=48&id=<?php echo $_GET['id']; ?>" method="post">
                <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td><h3>Hesabım > Adresler</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Tüm adreslerini görüntüleyebilir ve güncelleyebilirsin.</td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İsim ve Soyisim (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="IsimSoyisim" value="<?php echo $uye_adres['tamisim']; ?>" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Adres (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Adres" value="<?php echo $uye_adres['adres']; ?>" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İlçe (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Ilce" value="<?php echo $uye_adres['ilce']; ?>" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İl (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Il" value="<?php echo $uye_adres['il']; ?>" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Ülke (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="Ulke" value="<?php echo $uye_adres['ulke']; ?>" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Telefon Numarası (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="TelNo" value="<?php echo $uye_adres['telno']; ?>" maxlength="11" class="beauslot"></td>
                    </tr>
                    <tr height="40">
                        <td align="center"><input type="submit" value="Adresi Güncelle" class="beaubgreen"></td>
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
            $_SESSION["mesaj_ana"] = "Hata. Adres Kaydı Formunda Bilinmeyen Hata.";
            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/hata.png";
            header("Location:index.php?SO=33"); //HATA
            exit();
        }
    }else{
        header("Location:index.php");
        exit();
        ?>
        <?php
    }
?>
