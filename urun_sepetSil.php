<?php
    //uye sadece kendi id si olan sepeti silebilir olmali !!!
    if((isset($_SESSION["kullanici_email"]))){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_sepetSatirSil = $veritaConn -> prepare("DELETE FROM sepet WHERE id = ? AND uyeId = ? LIMIT 1");
            $sorgu_sepetSatirSil -> execute([$gelen_id, $kullanici["id"]]);
            $sepetSatirSilSayi = $sorgu_sepetSatirSil -> rowCount();

            if($sepetSatirSilSayi > 0){
                header("Location:index.php?SO=61"); // TAMAM
                exit();
            }else{
                header("Location:index.php");
                exit();
            }
        }else{
            header("Location:index.php");
            exit();
        }

    }else{
        header("Location:index.php");
        exit();
    }
?>