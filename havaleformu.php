<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="500" valign="top">
            <form action="index.php?SO=10" method="post">
                <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td><h3>Havale Bildirim Formu</h3></td>
                    </tr>
                    <tr height="30">
                        <td valign="top" style="border-bottom: 1px dashed #3cccb9;">Tamamlanmış Olan Ödeme İşleminizi Aşağıdaki Formdan İletiniz.</td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> İsim ve Soyisim (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="IsimSoyisim" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> E-Posta Adresi (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="mail" name="EpostaAdresi" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Telefon Numarası (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><input type="text" name="TelefonNumarasi" maxlength="11" class="beauslot"></td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Ödeme Yapılan Banka (*)</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left">
                            <select name="BankaSecimi" class="beaucombobox">
                                <?php 
                                    $sorgu_bankalar = $veritaConn -> prepare("SELECT * FROM banka_hesaplarimiz ORDER BY BankaAdi ASC");
                                    $sorgu_bankalar -> execute();
                                    $banka_sayisi = $sorgu_bankalar -> rowCount();
                                    $banka_kayitlari = $sorgu_bankalar -> fetchAll(PDO::FETCH_ASSOC);
                                    foreach($banka_kayitlari as $banka_kayit){
                                ?>
                                <option value="<?php echo DonusumleriGeriDondur($banka_kayit["id"]); ?>"><?php echo DonusumleriGeriDondur($banka_kayit["BankaAdi"]); ?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr height="30">
                        <td valign="bottom" align="left"> Açıklama</td>
                    </tr>
                    <tr height="30">
                        <td valign="top" align="left"><textarea name="Aciklama" class="beaubigwriting"></textarea></td>
                    </tr>
                    <tr height="40">
                        <td align="center"><input type="submit" value="Bildirimi Gönder" class="beaubgreen"></td>
                    </tr>
                </table>
            </form>
        </td>
        <td width="20">&nbsp;</td>
        <td width="545" valign="top">
            <table width="545" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr height="40">
                    <td colspan="2"><h3>İşleyiş</h3></td>
                </tr>
                <tr height="30">
                    <td valign="top" style="border-bottom: 1px dashed #3cccb9;" colspan="2">Havale / EFT İşlemlerinin Kontrolü.</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr height="30">
                    <td align="left" width="34"><img src="resimler/icons/bank.png" border="0" style="margin-top: -4px;"></td>
                    <td align="left"><b>Havale / EFT İşlemi</b></td>
                </tr>
                <tr>
                    <td colspan="2">Müşteri tarafından öncelikle banka hesaplarımız sayfasında bulunan herhangi bir hesaba ödeme işlemi gerçekleştirilir.</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr height="30">
                    <td align="left" width="34"><img src="resimler/icons/declaration.png" border="0" style="margin-top: -4px;"></td>
                    <td align="left"><b>Bildirim İşlemi</b></td>
                </tr>
                <tr>
                    <td colspan="2">Ödeme işleminizi tamamladıktan sonra "Havale Bildirim Formu" sayfasından müşteri yapmış olduğu ödeme için bildirim formunu doldurarak on-line olarak gönderir.</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr height="30">
                    <td align="left" width="34"><img src="resimler/icons/control-system.png" border="0" style="margin-top: -4px;"></td>
                    <td align="left"><b>Kontroller</b></td>
                </tr>
                <tr>
                    <td colspan="2">"Havale Bildirim Formu"'nuz tarafımıza ulaştığı anda ilgili departman tarafından yapmış olduğunuz havale / EFT işlemi ilgili banka üzerinden kontrol edilir.</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr height="30">
                    <td align="left" width="34"><img src="resimler/icons/management.png" border="0" style="margin-top: -4px;"></td>
                    <td align="left"><b>Onay / Red</b></td>
                </tr>
                <tr>
                    <td colspan="2">Havale bildirimi geçerli ise yani hesaba ödeme geçmiş ise, yönetici ilgili ödeme onayını vererek, siparişiniz teslimat birimine iletilir.</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr height="30">
                    <td align="left" width="34"><img src="resimler/icons/fast-delivery.png" border="0" style="margin-top: -4px;"></td>
                    <td align="left"><b>Siparişi Hazırlama & Teslimat</b></td>
                </tr>
                <tr>
                    <td colspan="2">Yönetici ödeme onayından sonra sayfamız üzerinden vermiş olduğunuz sipariş en kısa sürede hazırlanarak kargoya teslim edilir ve tarafınıza ulaştırılır.</td>
                </tr>
            </table>
        </td>
    </tr>
</table>