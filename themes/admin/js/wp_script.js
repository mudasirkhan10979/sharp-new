$(document).ready(function() {
    $('.nav-item').each(function() {
        const menuRight = $(this).find('.menuright');
        const navLink = $(this).find('.nav-link');
        navLink.append(menuRight);
    });
});
// $(document).ready(function() {
//     $('.nav-link').hover(
//         function() {
//             $(this).find('.menuright').stop(true, true).slideDown(200);
//         },
//         function() {
//             $(this).find('.menuright').stop(true, true).slideUp(200);
//         }
//     );
// });
$(document).ready(function() {
    $('.nav-link').click(function() {
        $('.menuright').not($(this).find('.menuright')).slideUp(200);
        $(this).find('.menuright').stop(true, true).slideToggle(200);
    });
});

$(document).ready(function () {
    var currentUrl = window.location.href;
    $('.menuright a').each(function () {
        if (this.href === currentUrl) {
            $(this).closest('.nav-link').addClass('active');
            $(this).closest('.menuright').css('display', 'block');
            $(this).closest('li').addClass('new_menu_active');
        }
    });
});