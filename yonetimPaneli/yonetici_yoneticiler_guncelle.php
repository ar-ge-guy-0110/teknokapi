<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

    if($gelen_id != ""){
        $sorgu_yonetici = $veritaConn -> prepare("SELECT * FROM yoneticiler WHERE id = ? LIMIT 1");
        $sorgu_yonetici -> execute([$gelen_id]);
        $sorguSayisi = $sorgu_yonetici -> rowCount();
        if($sorguSayisi > 0){
            $yonetici = $sorgu_yonetici -> fetch(PDO::FETCH_ASSOC);
            $yoneticiKullaniciAdi = $yonetici["kullaniciAdi"];
            $yoneticiTamIsim = $yonetici["adiSoyadi"];
            $yoneticiEPostaAdresi = $yonetici["ePostaAdresi"];
            $yoneticiTelNo = $yonetici["telNo"];
?>
<form action="index.php?SOAE=1&SOAI=41&id=<?php echo $gelen_id; ?>" method="post">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;YÖNETİCİ AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="5" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Kullanıcı Adı</td>
                        <td width="20">:</td>
                        <td width="500"><?php echo DonusumleriGeriDondur($yoneticiKullaniciAdi); ?></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Şifre</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="sifre" class="beauslot" value=""></textarea></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Tam İsim</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="adiSoyadi" class="beauslot" value="<?php echo DonusumleriGeriDondur($yoneticiTamIsim); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">E-Posta Adresi</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="ePostaAdresi" class="beauslot" value="<?php echo DonusumleriGeriDondur($yoneticiEPostaAdresi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Telefon Numarası</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><input type="text" name="telNo" class="beauslot" value="<?php echo DonusumleriGeriDondur($yoneticiTelNo); ?>" maxlength="11"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Yöneticiyi Güncelle" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Yönetici Bilgilerine Erişilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=40&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Yönetici Bilgilerine Erişilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=40&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>