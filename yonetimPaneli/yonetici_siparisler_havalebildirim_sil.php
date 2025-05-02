<?php
//Giren yoneticimi?
if(!isset($_SESSION["kullanici_Yonetici"])){
    header("Location:index.php?SOAE=0");
    exit();
}
//bosmu dolumu + filtre
if(isset($_GET["id"])){
    $gelen_id = SVE_BASIC_INPUT($_GET["id"], 10, false, true, true);
}else{
    $gelen_id = "";
}
//gereklilerin boş olmaması gerek
if(($gelen_id == "")){
    $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen verileri tam olarak giriniz.";
    $_SESSION["mesaj_aciklama_y"] = "Lütfen verileri tam girerek işlemi yeniden başlatınız.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=61'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}
//sil
$sorgu_havaleSil = $veritaConn ->  prepare("DELETE FROM havale_bildirimleri WHERE id = ? LIMIT 1");
$sorgu_havaleSil -> execute([$gelen_id]);
$queryErrInfo = $sorgu_havaleSil -> errorInfo();
if($queryErrInfo[0] != "00000"){
    $_SESSION["mesaj_ana_y"] = "Hata. Havale Bildirimi Silinemedi.";
    $_SESSION["mesaj_aciklama_y"] = "Beklenmeyen bir sorun oluştu, lütfen tekrar deneyiniz veya sistem yöneticisine başvurunuz.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=61'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}
header("Location:index.php?SOAE=1&SOAI=61");
exit();
?>