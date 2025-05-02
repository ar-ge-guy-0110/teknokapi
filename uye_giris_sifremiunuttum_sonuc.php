<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'frameworks/PHPMailer/src/Exception.php';
    require 'frameworks/PHPMailer/src/PHPMailer.php';
    require 'frameworks/PHPMailer/src/SMTP.php';

    //SITE MESAJ SESSIONLARI
    $_SESSION["mesaj_ana"] = "";
    $_SESSION["mesaj_aciklama"] = "";
    $_SESSION["mesaj_yonlendirme"] = "";
    $_SESSION["resim_yolu"] = "";
    //

    if(isset($_POST["EpostaAdresi"])){
        $gelen_email = Guvenlik($_POST["EpostaAdresi"]);
    }else{
        $gelen_email = "";
    }
    if(isset($_POST["TelNo"])){
        $gelen_telno = Guvenlik($_POST["TelNo"]);
    }else{
        $gelen_telno = "";
    }

    if(($gelen_email != "") or ($gelen_telno != "")){
        $sorgu_kullanici_kontrol = $veritaConn -> prepare("SELECT * FROM uyeler WHERE (uye_email = ? OR uye_telno = ?) AND (uye_silinme_durumu = ?)");
        $sorgu_kullanici_kontrol -> execute([$gelen_email, $gelen_telno, 0]);
        $kullanicisayisi = $sorgu_kullanici_kontrol -> rowCount();
        $kullanici_kayit = $sorgu_kullanici_kontrol -> fetch(PDO::FETCH_ASSOC);

        if($kullanicisayisi > 0){
            //SIFRE SIFIRLAMA MAILI GONDER...

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
                    $mail->addAddress(DonusumleriGeriDondur($kullanici_kayit["uye_email"]), DonusumleriGeriDondur($kullanici_kayit["uye_tamisim"]));
                    $mail->addReplyTo(DonusumleriGeriDondur($site_email_adresi), DonusumleriGeriDondur($site_adi));
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com')
                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional nam
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = DonusumleriGeriDondur($site_adi) . " - Şifre Sıfırlama";
                    $mesaj = "Merhaba Sayın " . $kullanici_kayit["uye_tamisim"] . "<br /><br />";
                    $mesaj .= "Sitemiz üzerinde bulunan hesabınızın şifresini sıfırlamak için lütfen <a href='" . $site_linki . "/index.php?SO=37&AktivasyonKodu=" . $kullanici_kayit["uye_aktivasyon_kodu"] . "&EPosta=" . $kullanici_kayit["uye_email"] ."'>buraya tıklayınız</a>.<br /><br />";
                    $mesaj .= "Saygılarımızla, iyi çalışmalar...<br />";
                    $mesaj .= $site_adi;
                    $mail->MsgHTML($mesaj);
                    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'
                    $mail->send();
                    echo 'Message has been sent';

                    $_SESSION["mesaj_ana"] = "Tebrikler. Şifre Sıfırlama Mailiniz Gönderildi.";
                    $_SESSION["mesaj_aciklama"] = "Üyeliğinize ait hesabınızın şifresini sıfırlamak için lütfen e-mail adresinize gönderilen mail içerisindeki linke tıklayınız.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";  
                    $_SESSION["resim_yolu"] = "resimler/tamam.png";
                    header("Location:index.php?SO=33");
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $_SESSION["mesaj_ana"] = "Hata. Şifre Sıfırlama Maili Gönderilemedi.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Eşleşen Üye Kaydı Bulunamadı.";
            $_SESSION["mesaj_aciklama"] = "Üye şifre sıfırlama formu dahilinde yazmış olduğunuz bilgiler ile eşleşen herhangi bir kayıt bulunamadı.";
            $_SESSION["mesaj_yonlendirme"] = "Üye 'Şifremi Unuttum' sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=35'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/bilinmeyen.png";
            header("Location:index.php?SO=33");
            exit();
        }
    }else{
        $_SESSION["mesaj_ana"] = "Dikkat. Üye 'Şifremi Unuttum' Formunda Eksik Veri Girişi.";
        $_SESSION["mesaj_aciklama"] = "Üye 'Şifremi Unuttum' formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
        $_SESSION["mesaj_yonlendirme"] = "Üye 'Şifremi Unuttum' sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=35'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu"] = "resimler/dikkat.png";
        header("Location:index.php?SO=33");
        exit();
    }
?>