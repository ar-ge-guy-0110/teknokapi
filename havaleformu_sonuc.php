<?php
    //CONTROL 1
    if(isset($_POST["IsimSoyisim"])){
        $gelen_isimsoyisim = Guvenlik($_POST["IsimSoyisim"]);
    }else{
        $gelen_isimsoyisim = "";
    }
    if(isset($_POST["EpostaAdresi"])){
        $gelen_eposta = Guvenlik($_POST["EpostaAdresi"]);
    }else{
        $gelen_eposta = "";
    }
    if(isset($_POST["TelefonNumarasi"])){
        $gelen_telno = Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $gelen_telno = "";
    }
    if(isset($_POST["BankaSecimi"])){
        $gelen_bankasecimi = Guvenlik($_POST["BankaSecimi"]);
    }else{
        $gelen_bankasecimi = "";
    }
    if(isset($_POST["Aciklama"])){
        $gelen_aciklama = Guvenlik($_POST["Aciklama"]);
    }else{
        $gelen_aciklama = "";
    }
    //CONTROL 2
    if(($gelen_isimsoyisim != "") and ($gelen_eposta != "") and ($gelen_telno != "") and ($gelen_bankasecimi != "")){
        $sorgu_ekle_havaleBildirimi = $veritaConn -> prepare("INSERT INTO havale_bildirimleri(banka_id, AdiSoyadi, EmailAdresi, TelNo, Aciklama, IslemTarihi, Durum) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $sorgu_ekle_havaleBildirimi -> execute([$gelen_bankasecimi, $gelen_isimsoyisim, $gelen_eposta, $gelen_telno, $gelen_aciklama, $zamanDamgasi, 0]);
        $sorgu_havaleBildirimi_Kontrol = $sorgu_ekle_havaleBildirimi -> rowCount();
        if($sorgu_havaleBildirimi_Kontrol > 0){
            header("Location:index.php?SO=11");
            exit();
        }else{
            header("Location:index.php?SO=12");
            exit();
        }

    }else{
        header("Location:index.php?SO=13");
        exit();
    }
?>