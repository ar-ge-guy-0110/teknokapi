<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" height="100"><h2>BANKA HESAPLARIMIZ</h2></td>
    </tr>
    <tr>
        <td align="left" height="50" style="border-bottom: 1px dashed #3cccb9">Ödemeleriniz İçin Çalışmakta Olduğumuz Tüm Banka Hesap Bilgileri Aşağıdadır.</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="left">
            <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                <?php 
                    $sorgu_bankalar = $veritaConn -> prepare("SELECT * FROM banka_hesaplarimiz");
                    $sorgu_bankalar -> execute();
                    $banka_sayisi = $sorgu_bankalar -> rowCount();
                    $banka_kayitlari = $sorgu_bankalar -> fetchAll(PDO::FETCH_ASSOC);

                    $banka_yazdir_dongu_sayisi = 1;
                    $banka_yazdir_sutun_adedi = 3;

                    foreach($banka_kayitlari as $banka_kayit){
                        if(($banka_yazdir_dongu_sayisi > $banka_yazdir_sutun_adedi) or ($banka_yazdir_dongu_sayisi == 1)){
                            echo "<tr>";
                        }
                ?>
                <td width="348">
                    <table align="center" border="0" cellpadding="0" cellspacing="0"  style="border: 1px dashed #3cccb9; margin-bottom: 10px">
                        <tr height="40">
                            <td colspan="4" align="center"><img src="<?php echo DonusumleriGeriDondur($banka_kayit["BankaLogosu"]); ?>" border="0" width="294" height="33"></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td width="80">Banka Adı</td>
                            <td width="10">:</td>
                            <td width="253"><?php echo DonusumleriGeriDondur($banka_kayit["BankaAdi"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>Konum</td>
                            <td>:</td>
                            <td><?php echo DonusumleriGeriDondur($banka_kayit["KonumSehir"])." / ".DonusumleriGeriDondur($banka_kayit["KonumUlke"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>Şube</td>
                            <td>:</td>
                            <td><?php echo DonusumleriGeriDondur($banka_kayit["SubeAdi"])." / ".DonusumleriGeriDondur($banka_kayit["SubeKodu"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>Birim</td>
                            <td>:</td>
                            <td><?php echo DonusumleriGeriDondur($banka_kayit["ParaBirimi"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>Hesap Adı</td>
                            <td>:</td>
                            <td><?php echo DonusumleriGeriDondur($banka_kayit["HesapSahibi"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>Hesap No</td>
                            <td>:</td>
                            <td><?php echo DonusumleriGeriDondur($banka_kayit["HesapNumarasi"]); ?></td>
                        </tr>
                        <tr height="25">
                            <td width="5">&nbsp;</td>
                            <td>IBAN No</td>
                            <td>:</td>
                            <td><?php echo IbanBicimlendir(DonusumleriGeriDondur($banka_kayit["IbanNumarasi"])); ?></td>
                        </tr>
                    </table>
                </td>
                <?php
                    if($banka_yazdir_dongu_sayisi < $banka_yazdir_sutun_adedi){
                        

                    
                ?>
                <td width="20">&nbsp;</td>
                <?php
                        }
                        if($banka_yazdir_dongu_sayisi > $banka_yazdir_sutun_adedi){
                            echo "</tr>";

                        }
                        $banka_yazdir_dongu_sayisi++;
                        if($banka_yazdir_dongu_sayisi > $banka_yazdir_sutun_adedi){
                            $banka_yazdir_dongu_sayisi = 1;
                        }
                    }
                ?>
                <tr>



                </tr>
            </table>
        </td>
    </tr>
</table>