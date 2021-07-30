jQuery(document).ready(function($){
    var output = {};
    function jsonConcat(o1, o2) {
        for (var key in o2) {
         o1[key] = o2[key];
        }
        return o1;
    }
    $('.slicksliding').each(function (e) {
        if ($(this).hasClass("infinite")) {
            output = jsonConcat(output, {infinite: true});
        }else{
            output = jsonConcat(output, {infinite: false});
        }
        if ($(this).hasClass("dots")) {
            output = jsonConcat(output, {dots: true});
        }else{
            output = jsonConcat(output, {dots: false});
        }
        if ($(this).hasClass("arrows")) {
            output = jsonConcat(output, {arrows: true});
        }else{
            output = jsonConcat(output, {arrows: false});
        }
        if ($(this).hasClass("autoplay")) {
            output = jsonConcat(output, {autoplay: true});
        }else{
            output = jsonConcat(output, {autoplay: false});
        }
        if ($(this).hasClass("fade")) {
            output = jsonConcat(output, {fade: true, cssEase: linear});
        }else{
            output = jsonConcat(output, {fade: false});
        }
        if ($(this).hasClass("rtl")) {
            output = jsonConcat(output, {rtl: true});
        }else{
            output = jsonConcat(output, {rtl: false});
        }
        if ($(this).attr("class").indexOf("slidesToShow") > 0) {
            var str = $(this).attr("class");
            var nb = Number((str.substr(str.indexOf("slidesToShow") + "slidesToShow".length + 1, 2)));
            output = jsonConcat(output, {slidesToShow: nb});
        }
        if ($(this).attr("class").indexOf("slidesToScroll") > 0) {
            var str = $(this).attr("class");
            var nb = Number((str.substr(str.indexOf("slidesToScroll") + "slidesToScroll".length + 1, 2)));
            output = jsonConcat(output, {slidesToScroll: nb});
        }
        if ($(this).attr("class").indexOf("speed") > 0) {
            var str = $(this).attr("class");
            var nb = Number((str.substr(str.indexOf("speed") + "speed".length + 1, 2)));
            output = jsonConcat(output, {speed: nb * 100});
        }

        $('.slicksliding').slick(output);
    });
    // $('.your-class').slick({
    //     slidesToShow: 2
    // });
    // $('.your-class').slick({
    //     infinite: false
    // });
  });