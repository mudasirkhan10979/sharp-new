jQuery(document).ready(function () {
    var x = true;
    $('.card890 .slider').click(function () {
        
        if (x == true) {
            $(".card890 .slider .node890").css('transform', 'translatex(26px)');
        }
        if (x == false) {
            $(".card890 .slider .node890").css('transform', 'translatex(0px)');
        }
        x = !x;
    });
});
  




