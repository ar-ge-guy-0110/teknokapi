<?php
    //CONTROL 1
    if(isset($_POST["KargoTakipNo"])){
        $gelen_kargotakipno = SayiliIcerikleriFiltrele(Guvenlik($_POST["KargoTakipNo"]));
    }else{
        $gelen_kargotakipno = "";
    }
    //CONTROL 2
    if(($gelen_kargotakipno != "")){
        header("Location:https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code=" . $gelen_kargotakipno);
        exit();
    }else{
        header("Location:index.php?SO=14");
        exit();
    }
?>