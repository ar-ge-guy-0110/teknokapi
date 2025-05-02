<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

    if($gelen_id != ""){
        $sorgu_bankaHesaplari = $veritaConn -> prepare("SELECT * FROM banka_hesaplarimiz WHERE id = ? LIMIT 1");
        $sorgu_bankaHesaplari -> execute([$gelen_id]);
        $bankaSayisi = $sorgu_bankaHesaplari -> rowCount();
        if($bankaSayisi > 0){
            $banka = $sorgu_bankaHesaplari -> fetch(PDO::FETCH_ASSOC);
            $bankaLogosu = $banka["BankaLogosu"];
            $bankaAdi = $banka["BankaAdi"];
            $bankaKonumSehir = $banka["KonumSehir"];
            $bankaKonumUlke = $banka["KonumUlke"];
            $bankaSubeAdi = $banka["SubeAdi"];
            $bankaSubeKodu = $banka["SubeKodu"];
            $bankaParaBirimi = $banka["ParaBirimi"];
            $bankaHesapSahibi = $banka["HesapSahibi"];
            $bankaHesapNumarasi = $banka["HesapNumarasi"];
            $bankaIbanNumarasi = $banka["IbanNumarasi"];


?>
<form action="index.php?SOAE=1&SOAI=8&id=<?php echo DonusumleriGeriDondur($gelen_id); ?>" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANKA HESAP AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td>Banka Logosu</td>
                        <td>:</td>
                        <td><input type="file" name="bankaLogosu"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaAdi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Şube Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaSubeAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaSubeAdi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banka Şube Kodu</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bankaSubeKodu" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaSubeKodu); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Bankanın Bulunduğu Şehir</td>
                        <td>:</td>
                        <td><input type="text" name="bankaSehir" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaKonumSehir); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Bankanın Bulunduğu Ülke</td>
                        <td>:</td>
                        <td><input type="text" name="bankaUlke" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaKonumUlke); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Hesabın Para Birimi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaParaBirimi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaParaBirimi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap Sahibi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapSahibi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaHesapSahibi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap Numarasi</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapNumarasi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaHesapNumarasi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Hesap IBAN Kodu</td>
                        <td>:</td>
                        <td><input type="text" name="bankaHesapIban" class="beauslot" value="<?php echo DonusumleriGeriDondur($bankaIbanNumarasi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Banka Hesabını Güncelle" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabına Erişilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=7&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Banka Hesabına Erişilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=7&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>