$(document).ready(function (e) {

    if($('*').is('#bigprice')) {
        pricecartbig();
        var colc = $('.cartitem').length;
        if(colc==0){
            $('.knoform,.itogo').remove();
        }
    }

    function tovnul(){
        setTimeout(function() {
            $('.numitem .price').each(function() {
                $(this).removeClass("pricered");
            });
        }, 1000);
    }

    $(".price").change(function() {
        var pric = parseInt($(this).parents(".cartparam").children('.cartprice').attr("num"));
        var maxkol = $(this).parents(".numitem").attr("col");
        var kol = $(this).val();
        if (kol<1) {
            kol = 1;
            $(this).val(kol);
        }
        if (kol>maxkol) {
            kol = maxkol;
            $(this).val(kol);
            $(this).addClass('pricered');
            tovnul();
        }
        var npric = kol*pric;
        $(this).parents(".cartparam").children('.cartprice').text(npric+" руб");
        pricecartbig();
    });

    $(".mi").click(function() {
        var pric = parseInt($(this).parents(".cartparam").children('.cartprice').attr("num"))
        var kol = $(this).parents(".numitem").children('.price').val();
        kol--;
        if (kol<1) {
            kol = 1;
        }
        $(this).parents(".numitem").children('.price').val(kol);
        var npric = kol*pric;
        $(this).parents(".cartparam").children('.cartprice').text(npric+" руб");
        pricecartbig();
    });
    $(".pl").click(function() {
        var pric = parseInt($(this).parents(".cartparam").children('.cartprice').attr("num"))
        var kol = $(this).parents(".numitem").children('.price').val();
        var maxkol = $(this).parents(".numitem").attr("col");
        kol++;
        if (kol>maxkol) {
            kol = maxkol;
            $(this).parents(".numitem").children('.price').addClass('pricered');
            tovnul();
        }
        $(this).parents(".numitem").children('.price').val(kol);
        var npric = kol*pric;
        $(this).parents(".cartparam").children('.cartprice').text(npric+" руб");
        pricecartbig();
    });

    $(".slider").owlCarousel({
        center: true,
        loop: true,
        margin: 0,
        items: 1,
    });
    $(".photos").owlCarousel({
        center: true,
        margin: 0,
        items: 1,
    });
    $(".righta").click(function () {
        $(".slider").trigger('next.owl.carousel');
    })
    $(".lefta").click(function () {
        $(".slider").trigger('prev.owl.carousel');
    })
    $(".pprod a").each(function () {
        if($(this).attr("col")){
            $(this).css({"background":$(this).attr("col")});
        }
        if($(this).attr("raz")){
            $(this).text($(this).attr("raz"));
        }
    });
    $(".pcart a").each(function () {
        if($(this).attr("col")){
            $(this).css({"background":$(this).attr("col")});
        }
        if($(this).attr("raz")){
            $(this).text($(this).attr("raz"));
        }
    });
    $(".pprod a").click(function () {
        if($(this).attr("col")){
            $(".pprod a[col]").removeClass("actprod");
            $(this).addClass("actprod");
        }
    })
    $("#firazm").each(function() {
        chrazm(this);
    });
    if(!$("a").is(".pprod a[raz]")){
        $("#cart").css({'display': 'none'});
    }
})

function chphoto(num) {
    $(".photos").trigger('to.owl.carousel', num - 1);
}

function menu() {
    if ($('.menu').css("display") == "none") {
        $('.menu').css({
            "display": "block"
        });
        $('.icomenu').addClass("icomenuactive");
        $('.menu').animate({
            "opacity": "1"
        }, 300);
        $('body').css({
            "overflow": "hidden"
        });
    } else {
        $('.icomenu').removeClass("icomenuactive");
        $('body').css({
            "overflow": "auto"
        });
        $('.menu').animate({
            "opacity": "0"
        }, 300, function () {
            $('.menu').css({
                "display": "none"
            });
        });
    }
}

function clozeall(str){
    if ($(str).css("display") == "none") {
        $(str).css({
            "display": "block"
        });
        $(str).animate({
            "opacity": "1"
        }, 300);
        $('body').css({
            "overflow": "hidden"
        });
    } else {
        $('body').css({
            "overflow": "auto"
        });
        $(str).animate({
            "opacity": "0"
        }, 300, function () {
            $(str).css({
                "display": "none"
            });
        });
    }
}

function faqopn(obj) {
    var str = $(obj).parents(".faq").children("a");
    var pol = $(obj).parents(".faq").find("p");
    var css = $(obj).parents(".faq").find("p").css("display");
    if (css == "none") {
        $(str).text("–");
    } else {
        $(str).text("+");
    }
    $(pol).slideToggle(300);
}

function revopn(obj) {
    var pol = $(obj).parents(".otvetm").find("p");
    var css = $(obj).parents(".otvetm").find("p").css("display");
    if (css == "none") {
        $(obj).addClass("active");
    } else {
        $(obj).removeClass("active");
    }
    $(pol).slideToggle(300);
}

function scrollrev() {
	var height=$(".revtcont").offset();
	$("body").animate({"scrollTop":height.top-140},300); 
}

window.onscroll = function () {
    if ($("body").scrollTop() > 50) {
        $(".fmenu").addClass("fmenusc");
        $(".logo").addClass("logosc");
        $(".icomenu").addClass("icomenusc");
        $(".corz").addClass("corsc");
        $(".fav").addClass("favsc");
    } else {
        $(".fmenu").removeClass("fmenusc");
        $(".logo").removeClass("logosc");
        $(".icomenu").removeClass("icomenusc");
        $(".corz").removeClass("corsc");
        $(".fav").removeClass("favsc");
    }
}

function more(str) {
    $(".show").remove();
    var count = $(".katalogitem .itemcont").length;
    $.ajax({
        type: "POST",
        url: "../templates/ajax_more.php",
        data: "count=" + count + "&type="+str,
        success: function (data) {
            $(".katalogitem").append(data);
        }
    });
}

function favorite(id,obj) {
    $.ajax({
        type: "POST",
        url: "../templates/count.php",
        data: "type=fav&id="+id,
        success: function (data) {
            var arr = data.split(',');
            $(".fav span").text(arr[1]);
            if(arr[0]=="addfav"){
                $(obj).addClass('activei');
            }
            if(arr[0]=="delfav"){
                $(obj).removeClass('activei');
            }
            if($(obj).attr('id')=="favprod"){
                if(arr[0]=="addfav"){
                    $(obj).children('i').text('Убрать из избранного');
                    $(obj).children('img').attr('src', 'img/heartactive.png');
                }
                if(arr[0]=="delfav"){
                    $(obj).children('i').text('Добавить в избранное');
                    $(obj).children('img').attr('src', 'img/heartb.png');
                }
            }
        }
    });
}

function cart(id,raz,obj) {
    $.ajax({
        type: "POST",
        url: "../templates/count.php",
        data: "type=cart&param="+id+","+raz,
        success: function (data) {
            var arr = data.split(',');
            $(".corz span").text(arr[1]);
            if(arr[0]=="addcart"){
                $(obj).parents(".itemcont").children('.itemkn').children('.corzitem').addClass('activei');
                $(obj).parents(".corztable").fadeToggle(200);
            }
        }
    });
}

function cartcatalog(obj){
    $(obj).parents(".itemcont").children('.corztable').fadeToggle(200);
}

function chrazm(obj) {
    $(".pprod a[raz]").removeClass("actprod");
    $("#cart").css({'display': 'none'});
    $(obj).addClass("actprod");
    var num = $(obj).attr("num");
    var razm = $(obj).index(".pprod a[raz]");
    $("#cart").attr('razm', razm);
    if(num<6){
        $("#cart").css({'display': 'block'});
        $(".colit").css({'display':'block'});
        $(".colit").text('Наличие ограничено');
    }
    if(num<3){
        $("#cart").css({'display': 'block'});
        $(".colit").css({'display':'block'});
        $(".colit").text('Последний товар');
    }
    if(num<1){
        $("#cart").css({'display': 'none'});
        $(".colit").css({'display':'block'});
        $(".colit").text('Нет в наличии');
    }
    if(num>6){
        $("#cart").css({'display': 'block'});
        $(".colit").css({'display':'none'});
        $(".colit").text('');
    }
}

function addcartprod(id,obj) {
    var raz = $(obj).attr("razm");
    $.ajax({
        type: "POST",
        url: "../templates/count.php",
        data: "type=cart&param="+id+","+raz,
        success: function (data) {
            var arr = data.split(',');
            $(".corz span").text(arr[1]);
            if(arr[0]=="addcart"){
                clozeall('.corzdob');
            }
        }
    });
}

function clozerevsoob() {
    $(".revsoob").remove();
}

function pricecartbig() {
    var bigpric = 0;
    $(".cartprice").each(function() {
        bigpric+=parseInt($(this).text());
    });
    $("#bigprice").text(bigpric+" руб");

    var arrcarti = [];
    $('.cartitem').each(function(index) {
        var numc = $(this).attr("num");
        var colc = $(this).find('.price').val();
        var razc = $(this).find('a[raz]').attr("num");

        var all = numc+","+razc+","+colc;
        arrcarti.push(all);
    });
    arrcarti = arrcarti.join('|');
    $("#tovar").val(arrcarti);
}

function delcart(obj){
    var numicart = 1+$(obj).parents(".cartitem").index();
    $.ajax({
        type: "POST",
        url: "../templates/delete.php",
        data: "id="+numicart,
        success: function (data) {
            $(obj).parents(".cartitem").remove();
            var colc = $('.cartitem').length;
            $('.corz span').text(colc);
            pricecartbig();
            if(colc==0){
                $('.knoform,.itogo').remove();
            }
        }
    });
}


