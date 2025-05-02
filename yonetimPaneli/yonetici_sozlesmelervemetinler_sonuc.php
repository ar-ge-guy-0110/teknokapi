<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_POST["metin_hakkimizda"])){
            $gelen_metin_hakkimizda = Guvenlik($_POST["metin_hakkimizda"]);
        }else{
            $gelen_metin_hakkimizda = "";
        }
        if(isset($_POST["metin_uyeliksozlesmesi"])){
            $gelen_metin_uyeliksozlesmesi = Guvenlik($_POST["metin_uyeliksozlesmesi"]);
        }else{
            $gelen_metin_uyeliksozlesmesi = "";
        }
        if(isset($_POST["metin_kullanimkosullari"])){
            $gelen_metin_kullanimkosullari = Guvenlik($_POST["metin_kullanimkosullari"]);
        }else{
            $gelen_metin_kullanimkosullari = "";
        }
        if(isset($_POST["metin_gizliliksozlesmesi"])){
            $gelen_metin_gizliliksozlesmesi = Guvenlik($_POST["metin_gizliliksozlesmesi"]);
        }else{
            $gelen_metin_gizliliksozlesmesi = "";
        }
        if(isset($_POST["metin_mesafelisatissozlesmesi"])){
            $gelen_metin_mesafelisatissozlesmesi = Guvenlik($_POST["metin_mesafelisatissozlesmesi"]);
        }else{
            $gelen_metin_mesafelisatissozlesmesi = "";
        }
        if(isset($_POST["metin_teslimat"])){
            $gelen_metin_teslimat = Guvenlik($_POST["metin_teslimat"]);
        }else{
            $gelen_metin_teslimat = "";
        }
        if(isset($_POST["metin_iptaliadedegisim"])){
            $gelen_metin_iptaliadedegisim = Guvenlik($_POST["metin_iptaliadedegisim"]);
        }else{
            $gelen_metin_iptaliadedegisim = "";
        }
        if(($gelen_metin_hakkimizda != "") and ($gelen_metin_uyeliksozlesmesi != "") and ($gelen_metin_kullanimkosullari != "") and ($gelen_metin_gizliliksozlesmesi != "") and ($gelen_metin_mesafelisatissozlesmesi != "") and ($gelen_metin_teslimat != "") and ($gelen_metin_iptaliadedegisim != "")){
            $sorgu_metinleriGuncelle = $veritaConn -> prepare("UPDATE sozlesmeler_ve_metinler SET Hakkimizda_Metni = ?, UyelikSozlesmesi_Metni = ?, KullanimKosullari_Metni = ?, GizlilikSozlesmesi_Metni = ?, MesafeliSatisSozlesmesi_Metni = ?, Teslimat_Metni = ?, IptaliadeDegisim_Metni = ?");
            $sorgu_metinleriGuncelle -> execute([$gelen_metin_hakkimizda, $gelen_metin_uyeliksozlesmesi, $gelen_metin_kullanimkosullari, $gelen_metin_gizliliksozlesmesi, $gelen_metin_mesafelisatissozlesmesi, $gelen_metin_teslimat, $gelen_metin_iptaliadedegisim]);
            $guncellemeSayisi = $sorgu_metinleriGuncelle -> rowCount();
            
			$_SESSION["mesaj_ana_y"] = "Tebrikler. Metinler Başarıyla Güncellendi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem başarıyla tamamlandı.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=4'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/tamam.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
            /*
            $_SESSION["mesaj_ana_y"] = "Hata. Ayarlar Güncellenemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=1'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
            */
        }else{
            $_SESSION["mesaj_ana_y"] = "Hata. Metinler Güncellenemedi.";
            $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=4'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>