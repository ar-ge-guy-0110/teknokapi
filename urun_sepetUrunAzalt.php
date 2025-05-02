<?php
    if((isset($_SESSION["kullanici_email"]))){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }

        if($gelen_id != ""){
            $sorgu_sepetUrunAzalt = $veritaConn -> prepare("UPDATE sepet SET urunAdedi = (urunAdedi - 1) WHERE id = ? AND uyeId = ? LIMIT 1");
            $sorgu_sepetUrunAzalt -> execute([$gelen_id, $kullanici["id"]]);
            $sepetUrunAzaltSayi = $sorgu_sepetUrunAzalt -> rowCount();

            if($sepetUrunAzaltSayi > 0){
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