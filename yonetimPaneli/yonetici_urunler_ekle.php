<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
?>
<form action="index.php?SOAE=1&SOAI=50" method="post" enctype="multipart/form-data">
    <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="70">
            <td width="560" bgcolor="#338DFF" style="color: #171717;" align="left"><h3>&nbsp;ÜRÜNLER</h3></td>
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
                            <select name="urunMenusu" class="beaucombobox2">
                                <option value="">Lütfen Seçiniz</option>
                                <?php
                                    $sorgu_menuler = $veritaConn -> prepare("SELECT * FROM menuler ORDER BY urun_tur ASC, menu_ad ASC");
                                    $sorgu_menuler -> execute();
                                    $sorguSayisi = $sorgu_menuler -> rowCount();
                                    if($sorguSayisi > 0){
                                        $menuler = $sorgu_menuler -> fetchAll(PDO::FETCH_ASSOC);
                                        foreach($menuler as $menu){
                                            $menuId = DonusumleriGeriDondur($menu["id"]);
                                            $urunTuru = DonusumleriGeriDondur($menu["urun_tur"]);
                                            $menuAdi = DonusumleriGeriDondur($menu["menu_ad"]);
                                ?>
                                <option value="<?php echo $menuId; ?>"><?php echo "(" . $urunTuru . ") " . $menuAdi; ?></option>
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
                        <td width="500"><input type="text" name="urunAdi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Ürün Fiyatı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="urunFiyati" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Para Birimi</td>
                        <td width="20">:</td>
                        <td width="500">
                            <select name="paraBirimi" class="beaucombobox2">
                                <option value="">Lütfen Seçiniz</option>
                                <option value="TRY">Türk Lirası</option>
                                <option value="USD">Amerikan Doları</option>
                                <option value="EUR">Euro</option>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td width="230">KDV Oranı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kDVOrani" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Kargo Ücreti</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="kargoUcreti" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230" valign="top">Ürün Açıklaması</td>
                        <td width="20" valign="top">:</td>
                        <td width="500"><textarea name="urunAciklamasi" class="beaubigwriting"></textarea></td>
                    </tr>
                    <tr height="40">
                        <td>Ürün Resmi 1</td>
                        <td>:</td>
                        <td><input type="file" name="urunResmi[]"></td>
                    </tr>
                    <tr height="40">
                        <td>Ürün Resmi 2</td>
                        <td>:</td>
                        <td><input type="file" name="urunResmi[]"></td>
                    </tr>
                    <tr height="40">
                        <td>Ürün Resmi 3</td>
                        <td>:</td>
                        <td><input type="file" name="urunResmi[]"></td>
                    </tr>
                    <tr height="40">
                        <td>Ürün Resmi 4</td>
                        <td>:</td>
                        <td><input type="file" name="urunResmi[]"></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Varyant Başlığı</td>
                        <td width="20">:</td>
                        <td width="500"><input type="text" name="varyantBasligi" class="beauslot" value=""></td>
                    </tr>
                    <tr height="40">
                        <td width="230">Varyant Ekle - Sil</td>
                        <td width="500" align="left"><button type="button" class="add_button" width="20">+</button>&nbsp;<button type="button" class="remove_button" width="20">-</button></td>
                    </tr>
                    <input type="hidden" value="1" id="varyantBolumuSayisi">
                    <tr height="40">
                        <td colspan="3" align="left">
                            <table width="700" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="230">Varyant Adı</td>
                                    <td width="20">:</td>
                                    <td width="200"><input type="text" name="varyantAdi[]" class="beauslot" value="" id=></td>
                                    <td width="20">&nbsp;</td>
                                    <td width="100">Varyant Stok Adedi</td>
                                    <td width="20">:</td>
                                    <td width="110"><input type="text" name="varyantStogu[]" class="beauslot" value=""></td>
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
</script>
<?php
    }else{
        header("Location:index.php?SOAE=0");
        exit();
    }
?>