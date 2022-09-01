;
(function ($) {
    $.fn.slidepage = function (pimp, center, layer) {
        var pag = 0;
        var maxp = $(layer).length - 1;
        var pos = 0;
        var stopit = false;
        var topmenu = false;

        var myElement = document.getElementById('center');
        var mc = new Hammer(myElement);

        mc.get('pan').set({
            direction: Hammer.DIRECTION_ALL
        });
        var wmob = $("html").hasClass("desktop");
        if(!wmob){
            console.log(wmob);
            mc.on("panup", function (ev) {
                mob("up");
            });

            mc.on("pandown", function (ev) {
                mob("down");
            });
        }

        function mob(nap) {
            if (!stopit) {
                if (nap=="down") {
                    if (pag > 0) {
                        pag--;
                        activepimp()
                        stopit = true;
                        animtop();
                        $(center).animate({
                            scrollTop: frameHeight() * pag
                        }, 400, 'swing', function () {
                            stopit = false;
                        });
                    }
                }
                if (nap=="up") {
                    if (pag < maxp) {
                        pag++;
                        activepimp()
                        stopit = true;
                        animtop();
                        $(center).animate({
                            scrollTop: frameHeight() * pag
                        }, 400, 'swing', function () {
                            stopit = false;
                        });
                    }
                }
            }
        }

        function frameHeight() {
            var frameHeight;
            if (self.innerWidth) {
                frameHeight = self.innerHeight;
            } else if (document.documentElement && document.documentElement.clientWidth) {
                frameHeight = document.documentElement.clientHeight;
            } else if (document.body) {
                frameHeight = document.body.clientHeight;
            } else {
                frameHeight = 480;
            }
            return frameHeight;
        }

        function activepimp() {
            var ch = '.punct > a:nth-child(' + (pag+1) + ')';
            $('.punct > a').removeClass("activepimp");
            $(ch).addClass("activepimp");
        }


        var elem = document.getElementById('center');

        if (elem.addEventListener) {
            if ('onwheel' in document) {
                elem.addEventListener("wheel", page);
            } else if ('onmousewheel' in document) {
                elem.addEventListener("mousewheel", page);
            } else {
                elem.addEventListener("MozMousePixelScroll", page);
            }
        } else {
            elem.attachEvent("onmousewheel", page);
        }

        function animtop() {
            if (!topmenu) {
                if (pag > 0) {
                    $(".topmenu").animate({
                        "top": "0",
                    }, 400, function () {
                        topmenu = true;
                    });
                }
            } else {
                if (pag == 0) {
                    $(".topmenu").animate({
                        "top": "-100px",
                    }, 400, function () {
                        topmenu = false;
                    });
                }
            }
        }


        function page(e) {
            e.preventDefault();
            var delta = e.deltaY || e.detail || e.wheelDelta;
            if (!stopit) {
                if (delta<0) {
                    if (pag > 0) {
                        pag--;
                        activepimp()
                        stopit = true;
                        delta = 0;
                        animtop();
                        $(center).animate({
                            scrollTop: frameHeight() * pag
                        }, 400, 'swing', function () {
                            stopit = false;
                        });
                    }
                }else{
                    if (pag < maxp) {
                        pag++;
                        activepimp()
                        stopit = true;
                        delta = 0;
                        animtop();
                        $(center).animate({
                            scrollTop: frameHeight() * pag
                        }, 400, 'swing', function () {
                            stopit = false;
                        });
                    }
                }
            }
        }

        $(pimp).click(function () {
            var oldpag = pag;
            pag = Number($(this).attr("slid"));
            var speed = 400;
            if (oldpag > pag) {
                speed = 400 * (oldpag - pag);
            }
            if (oldpag < pag) {
                speed = 400 * (pag - oldpag);
            }
            stopit = true;
            $(center).animate({
                scrollTop: frameHeight() * pag
            }, speed, 'swing', function () {
                stopit = false;
            });
            activepimp();
        });
    }
}(jQuery, document));