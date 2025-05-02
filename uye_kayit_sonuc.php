<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'frameworks/PHPMailer/src/Exception.php';
    require 'frameworks/PHPMailer/src/PHPMailer.php';
    require 'frameworks/PHPMailer/src/SMTP.php';
    //CONTROL 1
    if(isset($_POST["EpostaAdresi"])){
        $gelen_email = Guvenlik($_POST["EpostaAdresi"]);
    }else{
        $gelen_email = "";
    }
    if(isset($_POST["Sifre"])){
        $gelen_sifre = Guvenlik($_POST["Sifre"]);
    }else{
        $gelen_sifre = "";
    }
    if(isset($_POST["SifreTekrar"])){
        $gelen_sifretekrar = Guvenlik($_POST["SifreTekrar"]);

    }else{
        $gelen_sifretekrar = "";
    }
    if(isset($_POST["IsimSoyisim"])){
        $gelen_tamisim = Guvenlik($_POST["IsimSoyisim"]);
    }else{
        $gelen_tamisim = "";
    }
    if(isset($_POST["TelefonNumarasi"])){
        $gelen_telno = Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $gelen_telno = "";
    }
    if(isset($_POST["Cinsiyet"])){
        $gelen_cinsiyet = Guvenlik($_POST["Cinsiyet"]);
    }else{
        $gelen_cinsiyet = "";
    }
    if(isset($_POST["SozlesmeOnay"])){
        $gelen_sozlesmeonay = Guvenlik($_POST["SozlesmeOnay"]);
    }else{
        $gelen_sozlesmeonay = 0;
    }
    //CONTROL 2
    if(($gelen_email != "") and ($gelen_sifre != "") and ($gelen_sifretekrar != "") and ($gelen_tamisim != "") and ($gelen_telno != "") and ($gelen_cinsiyet != "") and ($gelen_sozlesmeonay != "")){
        if($gelen_sozlesmeonay == 0){
            header("Location:index.php?SO=29");
            exit();
        }else{
            if($gelen_sifre != $gelen_sifretekrar){
                header("Location:index.php?SO=28");
                exit();
            }else{
                $sorgu_kullanici_kontrol = $veritaConn -> prepare("SELECT uye_email FROM uyeler WHERE uye_email = ? OR uye_telno = ?");
                $sorgu_kullanici_kontrol -> execute([$gelen_email, $gelen_telno]);
                $kullanicisayisi = $sorgu_kullanici_kontrol -> rowCount();
                if($kullanicisayisi > 0){
                    header("Location:index.php?SO=27");
                }
                else{
                    for($i = 0;$i < 1;){
                        $aktivasyonkodu = AktivasyonKoduUret();
                        $sorgu_aktivasyonkodu_kontrol = $veritaConn -> prepare("SELECT uye_aktivasyon_kodu FROM uyeler WHERE uye_aktivasyon_kodu = ?");
                        $sorgu_aktivasyonkodu_kontrol -> execute([$aktivasyonkodu]);
                        $sorgu_aktivasyonkodu_sayisi = $sorgu_aktivasyonkodu_kontrol -> rowCount();
                        if($sorgu_aktivasyonkodu_sayisi == 0){
                            $i = 1;
                        }
                    }
                    $md5lisifre = md5($gelen_sifre);
                    $sorgu_uye_ekle = $veritaConn -> prepare("INSERT INTO uyeler(uye_email, uye_sifre, uye_tamisim, uye_telno, uye_cinsiyet, uye_durum, uye_kayit_tarihi, uye_kayit_ip_adresi, uye_aktivasyon_kodu) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $sorgu_uye_ekle -> execute([$gelen_email, $md5lisifre, $gelen_tamisim, $gelen_telno, $gelen_cinsiyet, 0, $zamanDamgasi, $ip_adresi, $aktivasyonkodu]);
                    $sorgu_uye_ekle_say = $sorgu_uye_ekle -> rowCount();
                    if($sorgu_uye_ekle_say > 0){
                        //Create an instance; passing `true` enables exceptions
                        $mail = new PHPMailer(true);

                        try {
                            //Server settings
                            $mail->SMTPDebug = SMTP::DEBUG_OFF;
                            $mail->isSMTP();
                            $mail->Host = DonusumleriGeriDondur($site_email_host_adresi);
                            $mail->SMTPAuth = true;
                            $mail->CharSet = "UTF-8";
                            $mail->Username = DonusumleriGeriDondur($site_email_adresi);
                            $mail->Password = DonusumleriGeriDondur($site_email_sifresi);
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            //Recipients
                            $mail->setFrom(DonusumleriGeriDondur($site_email_adresi), DonusumleriGeriDondur($site_adi));
                            $mail->addAddress(DonusumleriGeriDondur($gelen_email), DonusumleriGeriDondur($gelen_tamisim));
                            $mail->addReplyTo(DonusumleriGeriDondur($site_email_adresi), DonusumleriGeriDondur($site_adi));
                            //$mail->addCC('cc@example.com');
                            //$mail->addBCC('bcc@example.com');

                            //Attachments
                            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = DonusumleriGeriDondur($site_adi) . " - Yeni Üyelik Aktivasyonu";
                            $mesaj = "Merhaba Sayın " . $gelen_tamisim . "<br /><br />";
                            $mesaj .= "Sitemize yapmış olduğunuz üyelik kaydını tamamlamak için lütfen <a href='" . $site_linki . "/uye_kayit_aktivasyon.php?AktivasyonKodu=" . $aktivasyonkodu . "&EPosta=" . $gelen_email ."'>buraya tıklayınız</a>.<br /><br />";
                            $mesaj .= "Saygılarımızla, iyi çalışmalar...<br />";
                            $mesaj .= $site_adi;
                            $mail->MsgHTML($mesaj);
                            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();
                            echo 'Message has been sent';
                            header("Location:index.php?SO=24");
                            exit();
                        } catch (Exception $e) {
                            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            $_SESSION["mesaj_ana"] = "Hata. Aktivasyon Kodu E-Posta Hesabınıza Gönderilemedi.";
                            $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz veya yöneticilerle iletişime geçiniz.";
                            $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                            $_SESSION["resim_yolu"] = "resimler/hata.png";
                            header("Location:index.php?SO=33");
                            exit();
                        }
                    }else{
                        header("Location:index.php?SO=25");
                        exit();
                    }
                }
            }
        }

    }else{
        header("Location:index.php?SO=26");
        exit();
    }
?>