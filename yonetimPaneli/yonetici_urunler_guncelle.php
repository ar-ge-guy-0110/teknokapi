<?php
    /* yapilacaklar
    urun turu değismemeli sadece ayni ürün türünün altindaki menüleri secebilmeli +
    ürün adı degistirilebilir zaten siparişlerde değişmiyecek +
    ürün fiyatı degistirilebilr +
    para birimi degistirilebilir +
    kdv orani degistirlebilr +
    kargo ücredi +
    ürün açıklaması +
    ürün resimleri baska bi sayfada acilsin ordan islemler yapılsın ekle haric sil güncelle + -
    varyant başlıgı güncellenebilir +
    varyanlar da başka bir sayfada acilsin ordan işlemler yapılsın ekle haric sil güncelle + -
    */
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if($gelen_id == ""){
            $_SESSION["mesaj_ana_y"] = "Hata. Ürün Bilgileri Alınamadı.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
        //ürün bilgilerini cekelim
        $sorgu_urunBilgileri = $veritaConn -> prepare("SELECT urunler.*, menuler.menu_ad FROM urunler JOIN menuler ON menuler.id = urunler.menuId WHERE urunler.id = ?");
        $sorgu_urunBilgileri -> execute([$gelen_id]);
        $queryErrInfo = $sorgu_urunBilgileri -> errorInfo();
        if($queryErrInfo[0] != "00000"){
            $_SESSION["mesaj_ana_y"] = "Hata. Ürün Bilgileri Alınamadı.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
        $urun = $sorgu_urunBilgileri -> fetch(PDO::FETCH_ASSOC);
        $yerel_urun_turu = DonusumleriGeriDondur($urun["urun_tur"]);
        $urunAdi = DonusumleriGeriDondur($urun["urun_ad"]);
        $urunMenuAdi = DonusumleriGeriDondur($urun["menu_ad"]);
        $urunMenuId = DonusumleriGeriDondur($urun["menuId"]);
        $urunTuru = DonusumleriGeriDondur($urun["urun_tur"]);
        $urunParaBirimi = DonusumleriGeriDondur($urun["urun_paraBirimi"]);
        $urunFiyati = DonusumleriGeriDondur($urun["urun_fiyat"]);
        $urunKDVOrani = DonusumleriGeriDondur($urun["urun_kdvOrani"]);
        $urunKargoUcreti = DonusumleriGeriDondur($urun["urun_kargoUcreti"]);
        $urunAciklamasi = DonusumleriGeriDondur($urun["urun_aciklama"]);
        $urunVaryantBasligi = DonusumleriGeriDondur($urun["urun_variantBasligi"]);
        $urun_resimBir = DonusumleriGeriDondur($urun["urun_resimBir"]);
        $urun_resimIki = DonusumleriGeriDondur($urun["urun_resimIki"]);
        $urun_resimUc = DonusumleriGeriDondur($urun["urun_resimUc"]);
        $urun_resimDort = DonusumleriGeriDondur($urun["urun_resimDort"]);
        /*
        if($urunParaBirimi == "USD"){
            $urunHesaplanmisFiyat = $urunFiyati * $kurUSD;
        }else if($urunParaBirimi == "EUR"){
            $urunHesaplanmisFiyat = $urunFiyati * $kurEuro;
        }else{
            $urunHesaplanmisFiyat = $urunFiyati;
        }
        */
        $urunToplamSatisAdedi = DonusumleriGeriDondur($urun["urun_toplamSatisSayisi"]);
        $urunToplamYorumSayisi = DonusumleriGeriDondur($urun["urun_yorumSayisi"]);
        $urunToplamPuanSayisi = DonusumleriGeriDondur($urun["urun_toplamYorumPuani"]);
        $urunToplamGoruntulenmeSayisi = DonusumleriGeriDondur($urun["urun_goruntulenmeSayisi"]);
        //--
        //ürün varyantlarini cekelim
        $sorgu_urunVaryantlari = $veritaConn -> prepare("SELECT * FROM urunler_variantlar WHERE urun_id = ?");
        $sorgu_urunVaryantlari -> execute([$gelen_id]);
        $queryErrInfo = $sorgu_urunVaryantlari -> errorInfo();
        if($queryErrInfo[0] != "00000"){
            $_SESSION["mesaj_ana_y"] = "Hata. Ürün Varyant Bilgileri Alınamadı.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=48'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
        $urunVaryantlari = $sorgu_urunVaryantlari -> fetchAll(PDO::FETCH_ASSOC);
        //--
        //--
        $touken = CreateFormToken();
        $_SESSION["touken"] = $touken;
        //--
?>
<form action="index.php?SOAE=1&SOAI=53&id=<?php echo $gelen_id; ?>" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;<?php echo $urunTuru . " -> " . $urunMenuAdi; ?></h3></td>
            <td width="200" bgcolor="#338DFF" align="right">&nbsp;</td>
        </tr>
        <tr height="10">
            <td colspan="2" style="font-size: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="750" align="right" border="0" cellpadding="0" cellspacing="0" id="varyantArea">
                    <tr height="40">
                        <td width="230">Ürün Menüsü</td>
                        <td width="20">:</td>
                        <td width="500">
                            <select name="urunMenusu" class="beaucombobox2" required>
                                <option value="">Lütfen Seçiniz</option>
                                <?php
                                    $sorgu_menuler = $veritaConn -> prepare("SELECT * FROM menuler WHERE urun_tur = ? ORDER BY urun_tur ASC, menu_ad ASC");
                                    $sorgu_menuler -> execute([$urunTuru]);
                                    $sorguSayisi = $sorgu_menuler -> rowCount();
                                    if($sorguSayisi > 0){
                                        $menuler = $sorgu_menuler -> fetchAll(PDO::FETCH_ASSOC);
                                        foreach($menuler as $menu){
                                            $menuId = DonusumleriGeriDondur($menu["id"]);
                                            $urunTuru = DonusumleriGeriDondur($menu["urun_tur"]);
                                            $menuAdi = DonusumleriGeriDondur($menu["menu_ad"]);
                                ?>
                                <option value="<?php echo $menuId; ?>"<?php if($urunMenuId == $menuId){ echo " selected";} ?>><?php echo "(" . $urunTuru . ") " . $menuAdi; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">Ürün Adı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="urunAdi" class="beauslot" maxlength="255" value="<?php echo $urunAdi; ?>" required></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Ürün Fiyatı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="urunFiyati" class="beauslot" maxlength="10" id="u1" value="<?php echo $urunFiyati; ?>" required></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Para Birimi</td>
                        <td width="20">:</td>
                        <td width="500">
                            <select name="paraBirimi" class="beaucombobox2" required>
                                <option value="">Lütfen Seçiniz</option>
                                <option value="TRY"<?php if($urunParaBirimi == "TRY"){ echo "selected"; } ?>>Türk Lirası</option>
                                <option value="USD"<?php if($urunParaBirimi == "USD"){ echo "selected"; } ?>>Amerikan Doları</option>
                                <option value="EUR"<?php if($urunParaBirimi == "EUR"){ echo "selected"; } ?>>Euro</option>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">KDV Oranı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kDVOrani" class="beauslot" maxlength="2" id="u2" value="<?php echo $urunKDVOrani; ?>" required></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Kargo Ücreti</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kargoUcreti" class="beauslot" maxlength="10" id="u3" value="<?php echo $urunKargoUcreti; ?>" required></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Ürün Açıklaması</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><textarea name="urunAciklamasi" maxlength="1400" class="beaubigwriting" required><?php echo $urunAciklamasi; ?></textarea></td>
                    </tr>
                    <tr height="80">
                        <td valign="top">Ürün Resmi 1</td>
                        <td valign="top">:</td>
                        <td>
                            <img src="../resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun["urun_resimBir"]); ?>" border="0" width="60" height="80">
                            <input type="file" name="urunResmi[]">
                        </td>
                    </tr>
                    <tr height="80">
                        <td valign="top">Ürün Resmi 2</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <img src="../resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun["urun_resimIki"]); ?>" border="0" width="60" height="80">
                            <input type="file" name="urunResmi[]">
                        </td>
                    </tr>
                    <tr height="80">
                        <td valign="top">Ürün Resmi 3</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <img src="../resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun["urun_resimUc"]); ?>" border="0" width="60" height="80">
                            <input type="file" name="urunResmi[]">
                        </td>
                    </tr>
                    <tr height="80">
                        <td valign="top">Ürün Resmi 4</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <img src="../resimler/urun/<?php echo ConvertEng($yerel_urun_turu); ?>/<?php echo DonusumleriGeriDondur($urun["urun_resimDort"]); ?>" border="0" width="60" height="80">
                            <input type="file" name="urunResmi[]">
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">Varyant Başlığı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="varyantBasligi" maxlength="100" class="beauslot" value="<?php echo $urunVaryantBasligi; ?>" required></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Varyant Ekle - Sil</td>
                        <td width="500" align="left"><button type="button" class="add_button" width="20">+</button>&nbsp;<button type="button" class="remove_button" width="20">-</button></td>
                    </tr>
                    <?php
                        foreach($urunVaryantlari as $urunVaryanti){
                            $varyantId = $urunVaryanti["id"];
                            $varyantAdi = $urunVaryanti["variant_ad"];
                            $varyantStogu = $urunVaryanti["variant_stokAdet"];
                    ?>
                    <tr height="40">
                        <td colspan="3" align="left">
                            <table width="700" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="230">Varyant Adı</td>
                                    <td width="20">:</td>
                                    <td width="200"><input type="text" name="varyantAdi[]" maxlength="100" class="beauslot" value="<?php echo $varyantAdi; ?>"></td>
                                    <td width="20">&nbsp;</td>
                                    <td width="100">Varyant Stok Adedi</td>
                                    <td width="20">:</td>
                                    <td width="110"><input type="text" name="varyantStogu[]" maxlength="10" id="u2" class="beauslot" value="<?php echo $varyantStogu; ?>"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                    <input type="hidden" value="1" id="varyantBolumuSayisi">
                    <input type="hidden" value="<?php echo $touken; ?>" name="TT">
                    <tr height="40">
                        <td colspan="3" align="left">
                            <table width="700" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="230">Varyant Adı</td>
                                    <td width="20">:</td>
                                    <td width="200"><input type="text" name="varyantAdi[]"  maxlength="100" class="beauslot" value=""></td>
                                    <td width="20">&nbsp;</td>
                                    <td width="100">Varyant Stok Adedi</td>
                                    <td width="20">:</td>
                                    <td width="110"><input type="text" name="varyantStogu[]"  maxlength="10" id="u2" class="beauslot" value=""></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <tr height="40">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="Ürünü Kaydet" class="beaubgreen"></td>
                </tr>
            </td>
        </tr>
    </table>
</form>
<script>
    $('.add_button').on('click', AddVariant);
    $('.remove_button').on('click', RemoveVariant);

    function AddVariant(){
        var variantNumarasi = parseInt($('#varyantBolumuSayisi').val()) + 1;
        var yeniVariantBolumu = "<tr height='40' id='varyantArea" + variantNumarasi +  "'> <td colspan='3' align='left'> <table width='700' align='left' border='0' cellpadding='0' cellspacing='0'> <tr> <td width='230'>Varyant Adı</td> <td width='20'>:</td> <td width='200'><input type='text' name='varyantAdi[]' class='beauslot' value='' id='varyantAdi" + variantNumarasi + "'></td> <td width='20'>&nbsp;</td> <td width='100'>Varyant Stok Adedi</td> <td width='20'>:</td> <td width='110'><input type='text' name='varyantStogu[]' class='beauslot' value='' id='varyantStogu" + variantNumarasi + "'></td> </tr> </table> </td> </tr>";
        if(variantNumarasi <= 10){
            $('#varyantArea').append(yeniVariantBolumu);
            $('#varyantBolumuSayisi').val(variantNumarasi);
        }
    }
    function RemoveVariant(){
        var sonVariantNumarasi = $('#varyantBolumuSayisi').val();
        if(sonVariantNumarasi > 1){
            $('#varyantArea' + sonVariantNumarasi).remove();
            $('#varyantBolumuSayisi').val(sonVariantNumarasi - 1);
        }
    }

    setInputFilter(document.getElementById("u1"), function(value) {
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp.
    }, "Only digits and '.' are allowed");
    setInputFilter(document.getElementById("u2"), function(value) {
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp.
    }, "Only digits and '.' are allowed");
    setInputFilter(document.getElementById("u3"), function(value) {
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp.
    }, "Only digits and '.' are allowed");
</script>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>