<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_banner = $veritaConn -> prepare("SELECT * FROM banner WHERE id = ? LIMIT 1");
            $sorgu_banner -> execute([$gelen_id]);
            $bannerSayisi = $sorgu_banner -> rowCount();
            if($bannerSayisi > 0){
                $banner = $sorgu_banner -> fetch(PDO::FETCH_ASSOC);
                $bannerAlani = $banner["bannerAlani"];
                $bannerAdi = $banner["bannerAdi"];
?>
<form action="index.php?SOAE=1&SOAI=23&id=<?php echo DonusumleriGeriDondur($gelen_id); ?>" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;BANNER AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td width="230">Banner Alanı</td>
                        <td width="20">:</td>
                        <td width="500">
                            <select name="bannerAlani" class="beaucombobox2">
                                <option value="">Lütfen Seçiniz</option>
                                <option value="anasayfa" <?php if($bannerAlani == "Ana Sayfa"){echo "selected";} ?>>Ana Sayfa</option>
                                <option value="menualti" <?php if($bannerAlani == "Menü Altı"){echo "selected";} ?>>Menü Altı</option>
                                <option value="urundetay" <?php if($bannerAlani == "Ürün Detay"){echo "selected";} ?>>Ürün Detay</option>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">Banner Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="bannerAdi" class="beauslot" value="<?php echo DonusumleriGeriDondur($bannerAdi); ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>Banner Resmi</td>
                        <td>:</td>
                        <td><input type="file" name="bannerResmi"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Banner'i Güncelle" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Banner'in Bilgilerine Erişilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=22&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Banner'in Bilgilerine Erişilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=22&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>