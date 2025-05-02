<?php
    if(isset($_SESSION["kullanici_email"])){
        if(isset($_GET["urunid"])){
            $gelen_urunid = Guvenlik($_GET["urunid"]);
        }else{
            $gelen_urunid = "";
        }

        if(isset($_POST["Puan"])){
            $gelen_puan = Guvenlik($_POST["Puan"]);
        }else{
            $gelen_puan = "";
        }

        if(isset($_POST["yorum"])){
            $gelen_yorum = Guvenlik($_POST["yorum"]);
        }else{
            $gelen_yorum = "";
        }

        if(($gelen_urunid != "") and ($gelen_puan != "") and ($gelen_yorum != "")){
            $sorgu_yorumYap = $veritaConn -> prepare("INSERT INTO yorumlar(urun_id, uye_id, puan, yorum_metni, yorum_tarihi, yorum_ip_adresi) VALUES(?, ?, ?, ?, ?, ?)");
            $sorgu_yorumYap -> execute([$gelen_urunid, $kullanici_id, $gelen_puan, $gelen_yorum, $zamanDamgasi, $ip_adresi]);
            $yorumKontrol = $sorgu_yorumYap -> rowCount();



            if($yorumKontrol > 0){
                $sorgu_urunSkorGuncelle = $veritaConn -> prepare("UPDATE urunler SET urun_yorumSayisi = urun_yorumSayisi + 1, urun_toplamYorumPuani = urun_toplamYorumPuani + ? WHERE id = ? LIMIT 1");
                $sorgu_urunSkorGuncelle -> execute([$gelen_puan, $gelen_urunid]);
                $urunSkorKontrol = $sorgu_urunSkorGuncelle -> rowCount();

                if($urunSkorKontrol > 0){
                    $_SESSION["mesaj_ana"] = "Tebrikler. Yorum Kaydı Başarıyla Eklendi.";
                    $_SESSION["mesaj_aciklama"] = "İlgili ürün ile ilgili yorum yaptığınız için teşekkür ederiz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/tamam.png";
                    header("Location:index.php?SO=33");
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Ürün Puanı Eklenemedi.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana"] = "Hata. Yorum Eklenemedi.";
                $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu, lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu"] = "resimler/hata.png";
                header("Location:index.php?SO=33");
                exit();
            }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Üye Yorum Yapma Formunda Eksik Veri Girişi.";
            $_SESSION["mesaj_aciklama"] = "Üye Yorum Yapma Formu Dahilinde Lütfen Gerekli Alanları Doldurarak Tekrar Deneyiniz.";
            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/dikkat.png";
            header("Location:index.php?SO=33");
            exit();
        }
    }
?>