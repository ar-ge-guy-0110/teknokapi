<form action="index.php?SO=15" method="POST">
    <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" height="100"><h2>SIK SORULAN SORULAR</h2></td>
        </tr>
        <tr>
            <td align="left" height="50" style="border-bottom: 1px dashed #3cccb9">Aklınıza takılabileceğini düşündüğümüz soruları bu sayfada cevapladık. Fakat farklı bir sorunuz varsa iletişim alanından bizlere iletiniz.</td>
        </tr>
        
        <tr height="30">
            <td>
                <?php
                    $sorgu_sorular = $veritaConn -> prepare("SELECT * FROM sorular");
                    $sorgu_sorular -> execute();
                    $sorusayisi = $sorgu_sorular -> rowCount();
                    $sorular = $sorgu_sorular -> fetchAll(PDO::FETCH_ASSOC);
                    foreach($sorular as $soru){

                ?>
                <div>
                    <div id="<?php echo $soru["id"] ?>" class="sorubox" onClick="$.CevapAc(<?php echo $soru["id"] ?>)">
                        <?php echo $soru["soru"] ?>
                    </div>
                    <div class="cevapbox" style="display: none;">
                        <?php echo $soru["cevap"] ?>
                    </div>
                </div>
                <?php
                    }
                ?>
            </td>
        </tr>
    </table>
</form>