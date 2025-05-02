<?php
    if(($_SESSION["mesaj_ana_y"] != "") and ($_SESSION["mesaj_aciklama_y"] != "") and ($_SESSION["mesaj_yonlendirme_y"] != "") and ($_SESSION["resim_yolu_y"] != "")){
        $_SESSION["mesaj_ana_y"] = $_SESSION["mesaj_ana_y"];
        $_SESSION["mesaj_aciklama_y"] = $_SESSION["mesaj_aciklama_y"];
        $_SESSION["mesaj_yonlendirme_y"] = $_SESSION["mesaj_yonlendirme_y"];
        $_SESSION["resim_yolu_y"] = $_SESSION["resim_yolu_y"];
    ?>
        <table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="75">
                <td>&nbsp;</td>
            </tr>
            <tr height="100">
                <td align="center"><img src="<?php echo $_SESSION["resim_yolu_y"]; ?>" border="0" width="100" height="100"></td>
            </tr>
            <tr height="50">
                <td align="center" height="50"><?php echo $_SESSION["mesaj_ana_y"]; ?></td>
            </tr>
            <tr>
                <td align="center"><?php echo $_SESSION["mesaj_aciklama_y"]; ?></td>
            </tr>
            <tr>
                <td align="center" class="beaulink1"><?php echo $_SESSION["mesaj_yonlendirme_y"]; ?></td>
            </tr>
        </table>
    <?php
    }else{
        header("Location:index.php");
        exit();
    }
?>