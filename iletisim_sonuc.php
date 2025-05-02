<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'frameworks/PHPMailer/src/Exception.php';
    require 'frameworks/PHPMailer/src/PHPMailer.php';
    require 'frameworks/PHPMailer/src/SMTP.php';

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
    if(isset($_POST["Mesaj"])){
        $gelen_mesaj = Guvenlik($_POST["Mesaj"]);
    }else{
        $gelen_mesaj = "";
    }
    //CONTROL 2
    if(($gelen_isimsoyisim != "") and ($gelen_eposta != "") and ($gelen_telno != "") and ($gelen_mesaj != "")){
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
            $mail->addAddress(DonusumleriGeriDondur($site_email_adresi), DonusumleriGeriDondur($site_adi));
            $mail->addReplyTo(DonusumleriGeriDondur($gelen_eposta), DonusumleriGeriDondur($gelen_isimsoyisim));
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = DonusumleriGeriDondur($site_adi) . " - " . "İletişim Formu Mesajı - " . DonusumleriGeriDondur($gelen_isimsoyisim);
            $mail->MsgHTML(DonusumleriGeriDondur($gelen_eposta) . ", Şunu Yazdı:<br />" . DonusumleriGeriDondur($gelen_mesaj) . "<br /><br />İletişim: " . DonusumleriGeriDondur($gelen_telno));
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
            header("Location:index.php?SO=18");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location:index.php?SO=19");
            exit();
        }
    }else{
        header("Location:index.php?SO=20");
        exit();
    }
?>