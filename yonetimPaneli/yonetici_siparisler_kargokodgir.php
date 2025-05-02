<?php
//Giren yoneticimi?
if(!isset($_SESSION["kullanici_Yonetici"])){
    header("Location:index.php?SOAE=0");
    exit();
}
//bosmu dolumu + filtre
if(isset($_POST["siparisKodu"])){
    $siparisNo = SVE_BASIC_INPUT($_POST["siparisKodu"], 10, false, true, true);
}else{
    $siparisNo = "";
}
if(isset($_POST["gonderiKodu"])){
    $gonderiKodu = SVE_BASIC_INPUT($_POST["gonderiKodu"], 100);
}else{
    $gonderiKodu = "";
}
//gereklilerin boş olmaması gerek
if(($siparisNo == "") or ($gonderiKodu == "")){
    $_SESSION["mesaj_ana_y"] = "Dikkat. Lütfen verileri tam olarak giriniz.";
    $_SESSION["mesaj_aciklama_y"] = "Lütfen verileri tam girerek işlemi yeniden başlatınız.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}
//siparişin tamamlanmamış olması gerek
$sorgu_siparisDenetle = $veritaConn -> prepare("SELECT siparis_no FROM siparisler WHERE siparis_onayDurum = 0 AND siparis_kargoDurum = 0 AND siparis_kargoGonderiKodu IS NOT NULL AND siparis_no = ?");
$sorgu_siparisDenetle -> execute([$siparisNo]);
$siparisSayisi = $sorgu_siparisDenetle -> fetchAll(PDO::FETCH_ASSOC);
if(!$siparisSayisi){
    $_SESSION["mesaj_ana_y"] = "Dikkat. Bu sipariş tamamlanmış.";
    $_SESSION["mesaj_aciklama_y"] = "Lütfen tamamlanmamış bir sipariş giriniz.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/dikkat.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}


$sorgu_siparisGuncelle = $veritaConn -> prepare("UPDATE siparisler SET siparis_onayDurum = ?, siparis_kargoDurum = ?, siparis_kargoGonderiKodu = ? WHERE siparis_no = ?");
$sorgu_siparisGuncelle -> execute([1, 1, $gonderiKodu, $siparisNo]);
$queryErrInfo = $sorgu_siparisGuncelle -> errorInfo();
if($queryErrInfo[0] != "00000"){
    $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Güncellenemedi.";
    $_SESSION["mesaj_aciklama_y"] = "Beklenmeyen bir sorun oluştu, lütfen tekrar deneyiniz veya sistem yöneticisine başvurunuz.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}
header("Location:index.php?SOAE=1&SOAI=56");
exit();
?>