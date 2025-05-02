<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

    if($gelen_id != ""){
        $sorgu_menu = $veritaConn -> prepare("SELECT * FROM menuler WHERE id = ? LIMIT 1");
        $sorgu_menu -> execute([$gelen_id]);
        $sorguSayisi = $sorgu_menu -> rowCount();
        if($sorguSayisi > 0){
            $menu = $sorgu_menu -> fetch(PDO::FETCH_ASSOC);
            $menuUrunTur = $menu["urun_tur"];
            $menuAd = $menu["menu_ad"];
?>
<form action="index.php?SOAE=1&SOAI=35&id=<?php echo $gelen_id; ?>" method="post">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;MENÜ AYARLARI</h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                        <td width="230">Ürün Türü</td>
                        <td width="20">:</td>
                        <td width="500"><?php echo $menuUrunTur; ?></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Menü Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="menuAdi" class="beauslot" value="<?php echo $menuAd; ?>"></td>
                    </tr>
                    <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Menüyü Güncelle" class="beaubgreen"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Menü Bilgilerine Erişilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=34&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Menü Bilgilerine Erişilemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=34&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>