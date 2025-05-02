$(document).ready(function(){
    $.CevapAc = function(soru_id){
        var islem_alani = "#" + soru_id;
        $(".cevapbox").slideUp();

        $(islem_alani).parent().find(".cevapbox").slideToggle();
    }

    $.ChangeTheBigImage = function(imagePath){
        $("#BigImage").attr("src", imagePath);
    }

    $.KrediKartiSecildi = function(){
        $(".BHAlan").css("display", "none");
        $(".KKAlan").css("display", "block");
    }

    $.BankaHavalesiSecildi = function(){
        $(".KKAlan").css("display", "none");
        $(".BHAlan").css("display", "block");
    }
});