<?php
    if(isset($_SESSION["kullanici_Yonetici"])){
        if(isset($_GET["id"])){
            $gelen_id = Guvenlik($_GET["id"]);
        }else{
            $gelen_id = "";
        }
        if(isset($_POST["sifre"])){
            $gelen_sifre = Guvenlik($_POST["sifre"]);
        }else{
            $gelen_sifre = "";
        }
        if(isset($_POST["adiSoyadi"])){
            $gelen_adiSoyadi = Guvenlik($_POST["adiSoyadi"]);
        }else{
            $gelen_adiSoyadi = "";
        }
        if(isset($_POST["ePostaAdresi"])){
            $gelen_ePostaAdresi = Guvenlik($_POST["ePostaAdresi"]);
        }else{
            $gelen_ePostaAdresi = "";
        }
        if(isset($_POST["telNo"])){
            $gelen_telNo = Guvenlik($_POST["telNo"]);
        }else{
            $gelen_telNo = "";
        }
        if(($gelen_id != "") and ($gelen_adiSoyadi != "") and ($gelen_ePostaAdresi != "") and ($gelen_telNo != "")){
            /*$sorgu_bilgileriDenetle = $veritaConn -> prepare("SELECT ePostaAdresi, telNo FROM yoneticiler WHERE ePostaAdresi = ? OR telNo = ? LIMIT 1");
            $sorgu_bilgileriDenetle -> execute([$gelen_kullaniciAdi, $gelen_ePostaAdresi, $gelen_telNo]);
            $ayniSonucSayisi = $sorgu_bilgileriDenetle -> rowCount();
            if($ayniSonucSayisi > 0){
                $ayniSonuc = 0;
            }*/
            //QUERYSYS-BEFOREACTS
            $bool_ePostaAdresiAyniVar = false;
            $bool_telNoAyniVar = false;

            $sorgu_kullanicininBilgileri = $veritaConn -> prepare("SELECT ePostaAdresi, telNo FROM yoneticiler WHERE id = ? LIMIT 1");
            $sorgu_kullanicininBilgileri -> execute([$gelen_id]);
            $kbSayisi = $sorgu_kullanicininBilgileri -> rowCount();
            if($kbSayisi > 0){
                $kullanicininBilgileri = $sorgu_kullanicininBilgileri -> fetch(PDO::FETCH_ASSOC);
                $kullanicinin_ePostaAdresi = $kullanicininBilgileri["ePostaAdresi"];
                $kullanicinin_telNo = $kullanicininBilgileri["telNo"];

                //input: ePostaAdresi
                $sorgu_ePostaAdresiDenetle = $veritaConn -> prepare("SELECT ePostaAdresi FROM yoneticiler WHERE ePostaAdresi = ? LIMIT 1");
                $sorgu_ePostaAdresiDenetle -> execute([$gelen_ePostaAdresi]);
                $ayniSonucSayisi = 0;
                $ayniSonucSayisi = $sorgu_ePostaAdresiDenetle -> rowCount();
                if($ayniSonucSayisi > 0){
                    $gelenleAyniEPostaAdresi = $sorgu_ePostaAdresiDenetle -> fetch(PDO::FETCH_ASSOC);
                    $gelenleAyniEPostaAdresi = $gelenleAyniEPostaAdresi["ePostaAdresi"];
                    if($gelenleAyniEPostaAdresi != $kullanicinin_ePostaAdresi){
                        $bool_ePostaAdresiAyniVar = true;
                    }
                }
                //input: telNo
                $sorgu_telNoDenetle = $veritaConn -> prepare("SELECT telNo FROM yoneticiler WHERE telNo = ? LIMIT 1");
                $sorgu_telNoDenetle -> execute([$gelen_telNo]);
                $ayniSonucSayisi = 0;
                $ayniSonucSayisi = $sorgu_telNoDenetle -> rowCount();
                if($ayniSonucSayisi > 0){
                    $gelenleAynitelNo = $sorgu_telNoDenetle -> fetch(PDO::FETCH_ASSOC);
                    $gelenleAynitelNo = $gelenleAynitelNo["telNo"];
                    if($gelenleAynitelNo != $kullanicinin_telNo){
                        $bool_telNoAyniVar = true;
                    }
                }
                //control if same
                if(($bool_ePostaAdresiAyniVar) or ($bool_telNoAyniVar)){
                    $_SESSION["mesaj_ana_y"] = "Dikkat. Yönetici Güncellenemedi.";
                    $_SESSION["mesaj_aciklama_y"] = "";
                    if($bool_ePostaAdresiAyniVar){
                        if(strlen($_SESSION["mesaj_aciklama_y"]) > 0){
                            $_SESSION["mesaj_aciklama_y"] .= "<br />";
                        }
                        $_SESSION["mesaj_aciklama_y"] .= "Aynı E-Posta Adresi";
                    }
                    if($bool_telNoAyniVar){
                        if(strlen($_SESSION["mesaj_aciklama_y"]) > 0){
                            $_SESSION["mesaj_aciklama_y"] .= "<br />";
                        }
                        $_SESSION["mesaj_aciklama_y"] .= "Aynı Telefon Numarası";
                    }
                    $_SESSION["mesaj_aciklama_y"] .= " Kullanılıyor.";
                    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=40&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
                    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                    exit();
                }else{
                    //QUERYSYS-ACT1
                    $string_sorgu_bas = "UPDATE yoneticiler SET ";
                    $string_sorgu_orta = "";
                    $string_sorgu_son = " WHERE";
                    $string_sorgu_hepsi = "";
                    $array_executable = array();

                    //QUERYSYS-ACT2
                    //input: sifre
                    if($gelen_sifre != ""){
                        $md5sifre = md5($gelen_sifre);
                        if(strlen($string_sorgu_orta) > 0){
                            $string_sorgu_orta .= ", ";
                        }
                        $string_sorgu_orta .= "sifre = ?";
                        $array_executable[count($array_executable)] = $md5sifre;
                    }
                    //input: adiSoyadi
                    if($gelen_adiSoyadi != ""){
                        if(strlen($string_sorgu_orta) > 0){
                            $string_sorgu_orta .= ", ";
                        }
                        $string_sorgu_orta .= "adiSoyadi = ?";
                        $array_executable[count($array_executable)] = $gelen_adiSoyadi;
                    }
                    //input: ePostaAdresi
                    if($gelen_ePostaAdresi != ""){
                        if(strlen($string_sorgu_orta) > 0){
                            $string_sorgu_orta .= ", ";
                        }
                        $string_sorgu_orta .= "ePostaAdresi = ?";
                        $array_executable[count($array_executable)] = $gelen_ePostaAdresi;
                    }
                    //input: telNo
                    if($gelen_telNo != ""){
                        if(strlen($string_sorgu_orta) > 0){
                            $string_sorgu_orta .= ", ";
                        }
                        $string_sorgu_orta .= "telNo = ?";
                        $array_executable[count($array_executable)] = $gelen_telNo;
                    }
                    //According to What?
                    $string_sorgu_son .= " id = ?";
                    $array_executable[count($array_executable)] = $gelen_id;
                    //echo "tamam tamam";
                    $string_sorgu_hepsi = $string_sorgu_bas . $string_sorgu_orta . $string_sorgu_son;
                    //QUERYSYS-ACT3
                    $sorgu_yoneticiGuncelle = $veritaConn -> prepare($string_sorgu_hepsi);
                    $sorgu_yoneticiGuncelle -> execute($array_executable);
                    header("Location:index.php?SOAE=1&SOAI=36");
                    exit();
                }
            }else{
                $_SESSION["mesaj_ana_y"] = "Hata. Yönetici Bilgileri Çekilemedi.";
                $_SESSION["mesaj_aciklama_y"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=40&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
                $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
                header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
                exit();
            }
        }else{
            $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen Bütün Alanları Doldurunuz.";
            $_SESSION["mesaj_aciklama_y"] = "Lütfen Bütün Alanları Doldurarak İşlemi Yeniden Yapınız.";
            $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=40&id=" . $gelen_id . "'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
            header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
            exit();
        }
    }else{
        header("Location:index.php?SOAE=0"); // giriş yaptır eğer session yoksa
        exit();
    }
?>