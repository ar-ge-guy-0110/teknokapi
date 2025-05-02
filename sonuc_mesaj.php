<?php
    if(($_SESSION["mesaj_ana"] != "") and ($_SESSION["mesaj_aciklama"] != "") and ($_SESSION["mesaj_yonlendirme"] != "") and ($_SESSION["resim_yolu"] != "")){
        $_SESSION["mesaj_ana"] = $_SESSION["mesaj_ana"];
        $_SESSION["mesaj_aciklama"] = $_SESSION["mesaj_aciklama"];
        $_SESSION["mesaj_yonlendirme"] = $_SESSION["mesaj_yonlendirme"];
        $_SESSION["resim_yolu"] = $_SESSION["resim_yolu"];
    ?>
        <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="75">
                <td>&nbsp;</td>
            </tr>
            <tr height="100">
                <td align="center"><img src="<?php echo $_SESSION["resim_yolu"]; ?>" border="0" width="100" height="100"></td>
            </tr>
            <tr height="50">
                <td align="center" height="50"><?php echo $_SESSION["mesaj_ana"]; ?></td>
            </tr>
            <tr>
                <td align="center"><?php echo $_SESSION["mesaj_aciklama"]; ?></td>
            </tr>
            <tr>
                <td align="center" class="beaulink1"><?php echo $_SESSION["mesaj_yonlendirme"]; ?></td>
            </tr>
        </table>
    <?php
    }else{
        header("Location:index.php");
        exit();
    }
?>