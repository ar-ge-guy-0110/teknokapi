<?php
//Giren yoneticimi?
if(!isset($_SESSION["kullanici_Yonetici"])){
    header("Location:index.php?SOAE=0");
    exit();
}
//bosmu dolumu + filtre
if(isset($_GET["siparisno"])){
    $siparisNo = SVE_BASIC_INPUT($_GET["siparisno"], 10, false, true, true);
}else{
    $siparisNo = "";
}
//gereklilerin boş olmaması gerek
if(($siparisNo == "")){
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
//siparisi siparisle baglantili seyleriyle silmemiz gerek
$sorgu_siparisBilgiler = $veritaConn -> prepare("SELECT id, urun_id, urun_siparisAdedi, urun_variantSecimi, urun_variantId FROM siparisler WHERE siparis_no = ?");
$sorgu_siparisBilgiler -> execute([$siparisNo]);
$siparisler = $sorgu_siparisBilgiler -> fetchAll(PDO::FETCH_ASSOC);
if(!$siparisler){
    $_SESSION["mesaj_ana_y"] = "Hata. Sipariş bilgileri çekilemedi.";
    $_SESSION["mesaj_aciklama_y"] = "Beklenmeyen bir sorun oluştu, lütfen tekrar deneyiniz veya sistem yöneticisine başvurunuz.";
    $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
    $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
    header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
    exit();
}
foreach($siparisler as $siparisteki){
    $siparisteki_id = $siparisteki["id"];
    $siparisteki_urunId = $siparisteki["urun_id"];
    $siparisteki_urunAdedi = $siparisteki["urun_siparisAdedi"];
    $siparisteki_urunVariantSecimi = $siparisteki["urun_variantSecimi"];
    $siparisteki_urun_variantId = $siparisteki["urun_variantId"];

    //1
    $sorgu_urunGuncelle = $veritaConn -> prepare("UPDATE urunler, urunler_variantlar SET urunler.urun_toplamSatisSayisi = urunler.urun_toplamSatisSayisi - ?, urunler_variantlar.variant_stokAdet = urunler_variantlar.variant_stokAdet + ? WHERE urunler.id = urunler_variantlar.urun_id AND urunler.id = ? AND urunler_variantlar.id = ? LIMIT 1");
    $sorgu_urunGuncelle -> execute([$siparisteki_urunAdedi, $siparisteki_urunAdedi, $siparisteki_urunId, $siparisteki_urun_variantId]);
    $queryErrInfo = $sorgu_urunGuncelle -> errorInfo();
    if($queryErrInfo[0] != "00000"){
        $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Silinme İşlemi Sırasında Ürün Stoğu Eski Haline Getirilemedi.";
        $_SESSION["mesaj_aciklama_y"] = "Beklenmeyen bir sorun oluştu, lütfen tekrar deneyiniz veya sistem yöneticisine başvurunuz.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }

    $sorgu_siparisSil = $veritaConn ->  prepare("DELETE FROM siparisler WHERE id = ? LIMIT 1");
    $sorgu_siparisSil -> execute([$siparisteki_id]);
    $queryErrInfo = $sorgu_siparisSil -> errorInfo();
    if($queryErrInfo[0] != "00000"){
        $_SESSION["mesaj_ana_y"] = "Hata. Sipariş Silinemedi.";
        $_SESSION["mesaj_aciklama_y"] = "Beklenmeyen bir sorun oluştu, lütfen tekrar deneyiniz veya sistem yöneticisine başvurunuz.";
        $_SESSION["mesaj_yonlendirme_y"] = "Sayfaya geri dönmek için lütfen buraya <a href='index.php?SOAE=1&SOAI=54'><b>tıklayınız.</b></a>";
        $_SESSION["resim_yolu_y"] = "../resimler/hata.png";
        header("Location:index.php?SOAE=1&SOAI=3"); //soae 1 = yönetici ana sayfası (base)
        exit();
    }
}
header("Location:index.php?SOAE=1&SOAI=54");
exit();
?>