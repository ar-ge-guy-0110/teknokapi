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
    if(isset($_POST["Sifre"])){
        $gelen_sifre = Guvenlik($_POST["Sifre"]);
    }else{
        $gelen_sifre = "";
    }

    if(($gelen_email != "") and ($gelen_sifre != "")){
        $md5lisifre = md5($gelen_sifre);

        $sorgu_kullanici_kontrol = $veritaConn -> prepare("SELECT uye_email, uye_sifre, uye_durum, uye_tamisim, uye_aktivasyon_kodu FROM uyeler WHERE uye_email = ? AND uye_sifre = ? AND uye_silinme_durumu = ?");
        $sorgu_kullanici_kontrol -> execute([$gelen_email, $md5lisifre, 0]);
        $kullanicisayisi = $sorgu_kullanici_kontrol -> rowCount();
        $kullanici_kayit = $sorgu_kullanici_kontrol -> fetch(PDO::FETCH_ASSOC);

        if($kullanicisayisi > 0){
            if($kullanici_kayit["uye_durum"] == 1){
                $_SESSION["kullanici_email"] = $gelen_email;

                if($_SESSION["kullanici_email"] == $gelen_email){
                    //GIRIŞ YAP-------------------------------------------------------------------------------------------- HERE!!!
                    header("Location:index.php?SO=40");
                    exit();
                }else{
                    $_SESSION["mesaj_ana"] = "Hata. Üye Girişi Yapılamadı.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Üye giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=32'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }else{
                //TEKRAR AKTIVASYON LINKI OLUSTUR...
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
                    $mail->Subject = DonusumleriGeriDondur($site_adi) . " - Yeni Üyelik Aktivasyonu";
                    $mesaj = "Merhaba Sayın " . $kullanici_kayit["uye_tamisim"] . "<br /><br />";
                    $mesaj .= "Sitemize yapmış olduğunuz üyelik kaydını tamamlamak için lütfen <a href='" . $site_linki . "/uye_kayit_aktivasyon.php?AktivasyonKodu=" . $kullanici_kayit["uye_aktivasyon_kodu"] . "&EPosta=" . $kullanici_kayit["uye_email"] ."'>buraya tıklayınız</a>.<br /><br />";
                    $mesaj .= "Saygılarımızla, iyi çalışmalar...<br />";
                    $mesaj .= $site_adi;
                    $mail->MsgHTML($mesaj);
                    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'
                    $mail->send();
                    echo 'Message has been sent';
                    $_SESSION["mesaj_ana"] = "Dikkat. Üye Aktivasyonu Yapılmamış.";
                    $_SESSION["mesaj_aciklama"] = "Üye giriş formu dahilinde yazmış olduğunuz bilgiler ile eşleşen üye kaydının aktivasyon işlemi yapılmamış.<br />Üyeliğinizi aktif etmek için gerekli olan mail e-posta adresinize yeniden gönderilmiştir.";
                    $_SESSION["mesaj_yonlendirme"] = "Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/dikkat.png";
                    header("Location:index.php?SO=33");
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $_SESSION["mesaj_ana"] = "Hata. Üye Girişi Yapılamadı.";
                    $_SESSION["mesaj_aciklama"] = "İşlem sırasında beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
                    $_SESSION["mesaj_yonlendirme"] = "Üye giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=32'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
                    $_SESSION["resim_yolu"] = "resimler/hata.png";
                    header("Location:index.php?SO=33");
                    exit();
                }
            }
        }else{
            $_SESSION["mesaj_ana"] = "Dikkat. Eşleşen Üye Kaydı Bulunamadı.";
            $_SESSION["mesaj_aciklama"] = "Üye giriş formu dahilinde yazmış olduğunuz bilgiler ile eşleşen herhangi bir kayıt bulunamadı.";
            $_SESSION["mesaj_yonlendirme"] = "Üye giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=32'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
            $_SESSION["resim_yolu"] = "resimler/bilinmeyen.png";
            header("Location:index.php?SO=33");
            exit();
        }
    }else{
        $_SESSION["mesaj_ana"] = "Dikkat. Üye Giriş Formunda Eksik Veri Girişi.";
        $_SESSION["mesaj_aciklama"] = "Üye giriş formu dahilinde lütfen gerekli alanları doldurarak tekrar deneyiniz.";
        $_SESSION["mesaj_yonlendirme"] = "Üye giriş sayfasına geri dönmek için lütfen buraya <a href='index.php?SO=32'><b>tıklayınız.</b></a>.<br /> Ana sayfaya dönmek için lütfen buraya <a href='index.php'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu"] = "resimler/dikkat.png";
        header("Location:index.php?SO=33");
        exit();
    }
?>