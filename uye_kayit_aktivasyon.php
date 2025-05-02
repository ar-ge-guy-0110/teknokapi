<?php
    require_once("ayarlar/ayar.php");
    require_once("ayarlar/fonksiyonlar.php");

    if(isset($_REQUEST["AktivasyonKodu"])){
        $aktivasyonKodu = Guvenlik($_REQUEST["AktivasyonKodu"]);
    }else{
        $aktivasyonKodu = "";
    }
    if(isset($_REQUEST["EPosta"])){
        $eposta = Guvenlik($_REQUEST["EPosta"]);
    }else{
        $eposta = "";
    }

    if(($aktivasyonKodu != "") and ($eposta != "")){

        $sorgu_kontrol = $veritaConn -> prepare("SELECT * FROM uyeler WHERE uye_email = ? AND uye_aktivasyon_kodu = ? AND uye_durum = ?");
        $sorgu_kontrol -> execute([$eposta, $aktivasyonKodu, 0]);
        $sorgu_kontrol_satir_say = $sorgu_kontrol -> rowCount();

        if($sorgu_kontrol_satir_say > 0){
            $sorgu_uye_durum_guncelle = $veritaConn -> prepare("UPDATE uyeler SET uye_durum = ? WHERE uye_email = ? AND uye_aktivasyon_kodu = ?");
            $sorgu_uye_durum_guncelle -> execute([1, $eposta, $aktivasyonKodu]);
            $sorgu_uye_durum_guncelle_satir_say = $sorgu_uye_durum_guncelle -> rowCount();

            if($sorgu_uye_durum_guncelle_satir_say > 0){
                header("Location:index.php?SO=31");
            }else{
                header("Location:index.php?SO=0");
                exit();
            }
        }else{
            header("Location:index.php?SO=0");
            exit();
        }
    }else{
        header("Location:index.php?SO=0");
        exit();
    }
?>