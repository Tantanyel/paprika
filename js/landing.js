$(document).ready(function (e) {
    $('body').slidepage(".pimp", ".centerland", ".layer");
})

function menu(){
    if($('.menu').css("display")=="none"){
        $('.menu').css({"display":"block"});
        $('.icomenu').addClass("icomenuactive");
        $('.menu').animate({"opacity":"1"},300);
        $('body').css({"overflow":"hidden"});
    }else{
        $('.icomenu').removeClass("icomenuactive");
        $('body').css({"overflow":"auto"});
        $('.menu').animate({"opacity":"0"},300,function(){
            $('.menu').css({"display":"none"});
        });
    }
}

function soobmes(str) {
    $(".formsend").append('<p class="oksend">'+str+'</p>');
    setTimeout(function() {
        $(".oksend").animate({opacity:"0"},300, function () {
            $(".oksend").remove();
        });
    }, 3000);
}

function sendmes(obj) {
    var name = encodeURIComponent($(".formsend #names").val());
    var email = encodeURIComponent($(".formsend #emails").val());
    var text = encodeURIComponent($(".formsend #texts").val());
    if(name==""||email==""||text==""){
        soobmes("Некоторые поля не заполнены");
    }else{
        $.ajax({
            type: "POST",
            url: "../templates/ajax_mess.php",
            data: "param="+name+"|"+email+"|"+text,
            success: function (data) {
                if(data=="ok"){
                    soobmes("Спасибо за ваше сообщение<br>Мы обязательно его прочитаем");
                    $(".formsend #names").val("");
                    $(".formsend #emails").val("");
                    $(".formsend #texts").val("");
                }
                if(data=="time"){
                    soobmes("Нельзя так часто отправлять сообщения<br>Подождите пожалуйста 1 час");
                }
            }
        });
    }
}