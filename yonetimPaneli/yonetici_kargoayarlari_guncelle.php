<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

    if($gelen_id != ""){
        $sorgu_kargoFirmalari = $veritaConn -> prepare("SELECT * FROM kargo_firmalar WHERE id = ? LIMIT 1");
        $sorgu_kargoFirmalari -> execute([$gelen_id]);
        $kargoFirmasiSayisi = $sorgu_kargoFirmalari -> rowCount();
        if($kargoFirmasiSayisi > 0){
            $kargoFirmasi = $sorgu_kargoFirmalari -> fetch(PDO::FETCH_ASSOC);
            $kargoFirmasiLogosu = $kargoFirmasi["logo"];
            $kargoFirmasiAdi = $kargoFirmasi["ad"];
?>
<form action="index.php?SOAE=1&SOAI=17&id=<?php echo DonusumleriGeriDondur($gelen_id); ?>" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;KARGO FİRMASI AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td>Kargo Firması Logosu</td>
                        <td>:</td>
                        <td><input type="file" name="kargoFirmasiLogosu"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Kargo Firması Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kargoFirmasiAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($kargoFirmasiAdi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Kargo Firmasını Güncelle" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Kargo Firmasının Bilgilerine Erişilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=16&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Kargo Firmasının Bilgilerine Erişilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=16&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>