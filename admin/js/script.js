$(document).ready(function (e) {
	$(".categoria input,.brends input").change(function() {
		obncatalog();
		obnbrend();
	})
	$(".addr input").change(function() {
		obnadr();
	})

	$("#photo").change(function() {
		var fil = this.files;
		loadphoto(fil);
		$('<div class="loading"><img src="img/loading.svg"></div>').insertBefore($(".file"));
		$('.file').css({
			display: 'none'
		});
	})
	if($("div").is(".photo")){
		obnphoto();
	}
	if($("div").is(".photolook")){
		obnphoto();
	}
});

function clozeall(str) {
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

function clozesoob() {
	$(".soob").css({
		"animation": "none"
	});
	$(".soob").animate({
		"right": "-400px"
	}, 300, function () {
		$(".soob").remove();
	});
}

function deletecat(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "cat=1&id=" + id,
		success: function (data) {
			if(data="catdel"){
				$(".categoria[num="+id+"]").remove();
			}
		}
	});
}
function deletecart(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "cart=1&id=" + id,
		success: function (data) {
			if(data="cartdel"){
				$(".zakaz[num="+id+"]").remove();
			}
		}
	});
}
function vipcart(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "cartv=1&id=" + id,
		success: function (data) {
			if(data="cartv"){
				$("#svip").css('display', 'inline-block');
				$("#bvip").css('display', 'none');
			}
		}
	});
}
function deletelook(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "look=1&id=" + id,
		success: function (data) {
			if(data="lookdel"){
				$(".categoria[num="+id+"]").remove();
			}
		}
	});
}
function deleteb(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "brend=1&id=" + id,
		success: function (data) {
			if(data="bdel"){
				$(".brends[num="+id+"]").remove();
			}
		}
	});
}

function deleteitem(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "item=1&id=" + id,
		success: function (data) {
			if(data="catdel"){
				$(".prod[num="+id+"]").remove();
			}
		}
	});
}

function deletelookp(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "lookp=1&id=" + id,
		success: function (data) {
			if(data="lookpdel"){
				$(".look[num="+id+"]").remove();
			}
		}
	});
}

function obncatalog() {
	var arrstr=null;
	$(".categoria").each(function() {
		var id = $(this).attr("num");
		var num = $(this).children("#num").val();
		var name = $(this).children("#name").val();
		var str= id+","+num+","+name;
		arrstr+="|"+str;
	});
	$("#hidcat").val(arrstr);
}

function obnbrend() {
	var arrstr=null;
	$(".brends").each(function() {
		var id = $(this).attr("num");
		var num = $(this).children("#num").val();
		var name = $(this).children("#name").val();
		var str= id+","+num+","+name;
		arrstr+="|"+str;
	});
	$("#hidbrend").val(arrstr);
}

function obnadr() {
	var arrstr=null;
	$(".addr").each(function() {
		var id = $(this).attr("num");
		var adr = $(this).children("#adr").val();
		var map = $(this).children("#map").val();
		var str= id+"}"+adr+"}"+map;
		arrstr+="|"+str;
	});
	$("#hidadr").val(arrstr);
}

function loadphoto(fil) {
	var data = new FormData();
	$.each( fil, function( key, value ){
		data.append( key, value );
	});
	$.ajax({
		url: 'photoload.php?uploadfiles',
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(respond){
			var url = respond.files;
			url = String(url);
			var img = url.split('admin/')[1];
			$('.loading').remove();
			$('<div class="img"><img src="'+img+'"><a onclick="delphoto(this)">Удалить</a></div>').insertBefore($(".file"));
			obnphoto();
		}
	});
}

function obnphoto() {
	var colph = $("img").length;
	var look = false;
	if($("div").is("#lookp")){
		var look = true;
	}
	if(colph<5&&!look||colph<1&&look){
		$('.file').css({
			display: 'inline-block'
		});
	}else{
		$('.file').css({
			display: 'none'
		});
	}
	var arrphoto=null;
	$(".img").each(function() {
		var img = $(this).children("img").attr("src");
		arrphoto+="|"+img;
	});
	$("#hidadd").val(arrphoto);
}

function delphoto(obj) {
	$(obj).parent(".img").remove();
	obnphoto();
}

function opencol(id) {
	$.ajax({
		type: "POST",
		url: "ajax_col.php",
		data: "open=1&id=" + id,
		success: function (data) {
			if(data!="nodost"){
				$(".contcolred").remove();
				$(data).appendTo(".colred");
				clozeall('.colred');
			}
		}
	});
}

function izmcol(id,obj) {
	var str = "";
	$(".contcolred").children('input').each(function() {
		str=str+$(this).val()+",";
	});
	$.ajax({
		type: "POST",
		url: "ajax_col.php",
		data: "izm=1&id=" +id+"&col="+str,
		success: function (data) {
			if(data="okizm"){
				location.reload();
			}
		}
	});
}


function filtertradeinp(obj) {
	var textinp = $(obj).val()
	var reg = new RegExp(textinp, "i");
	sortinp(".prod ", reg);
}

function filtertrlook(obj) {
	var textinp = $(obj).val()
	var reg = new RegExp(textinp, "i");
	sortinp(".look ", reg);
}

function sortinp(str, reg) {
	$(str).each(function () {
		$(this).css({
			"display": "none"
		});
		var nameitem = $(this).find(".find").text();
		var fin = nameitem.search(reg);
		if (fin != -1) {
			$(this).css({
				"display": "inline-block"
			});
		}
	});
}

function delmes(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "mes=1&id=" + id,
		success: function (data) {
			if(data="mesdel"){
				$(".soobuser[num="+id+"]").remove();
			}
		}
	});
}
function deleteadr(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "adr=1&id=" + id,
		success: function (data) {
			if(data="adrdel"){
				$(".addr[num="+id+"]").remove();
			}
		}
	});
}

function deletefaq(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "faq=1&id=" + id,
		success: function (data) {
			if(data="faqdel"){
				$(".addr[num="+id+"]").remove();
			}
		}
	});
}

function delrev(id) {
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: "rev=1&id=" + id,
		success: function (data) {
			if(data="revdel"){
				$(".soobuser[num="+id+"]").remove();
			}
		}
	});
}
