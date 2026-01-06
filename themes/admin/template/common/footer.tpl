 </div>
 </div>

 <script src="/themes/admin/vendors/js/vendor.bundle.base.js"></script>



 <script src="/themes/admin/js/off-canvas.js"></script>
 <script src="/themes/admin/js/hoverable-collapse.js"></script>
 <script src="/themes/admin/js/misc.js"></script>

 <script src="/themes/admin/js/dashboard.js"></script>
 <script src="/themes/admin/js/custom.js"></script>
 <script src="/themes/admin/js/wp_script.js"></script>

 <script>
    jQuery(document).ready(function() {
       jQuery('.menuinner ul.nav li.nav-item .nav-link').click(function() {
          var menuright_width = jQuery(this).next(".menuright").width() + 50;
          jQuery('.rightcontent').css('padding-left', menuright_width);
       });
       // jQuery(".menuinner li.nav-item .nav-link").click(function() {
       //    jQuery('.nav-link.active').not(this).removeClass('active');
       //    jQuery('.nav-link').not(this).next().removeClass('side_menu_open');
       //    jQuery(this).next().toggleClass('side_menu_open');
       //    jQuery(this).toggleClass('active');
       // })
       $(function() {
          $(".menuinner li.nav-item .nav-link").on("click", function(e) {
            jQuery('.nav-link.active').not(this).removeClass('active');
            jQuery('.nav-link').not(this).next().removeClass('side_menu_open');
            jQuery(this).next().toggleClass('side_menu_open');
            jQuery(this).toggleClass('active');
           e.stopPropagation()
           });
             $(document).on("click", function(e) {
              if ($(e.target).is(".menuinner") === false) {
               jQuery('.nav-link.active').removeClass('active');
               jQuery('.nav-link').next().removeClass('side_menu_open');
            }
         });
       });
       jQuery('.menuinner .bottom_menu-sidebar li.nav-item .nav-link').click(function() {
          var fullsidebar_width = jQuery("nav.sidebarleft").width();
          jQuery('.rightcontent').css('padding-left', fullsidebar_width);
       });
    });
 </script>
 <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> -->
 <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

 <script>
    $('#menu_default a[href]').on('click', function() {
       sessionStorage.setItem('menu', $(this).attr('href'));
    });

    if (!sessionStorage.getItem('menu')) {
       $('#menu_default #dashboard').addClass('active');
    } else {

       $('#menu_default a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().addClass('active');
    }
    $('#menu_default a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').find('.nav-link').addClass('active');
 </script>

 <script>
    $("input[name='sort_order']").on("input", function(e) {
       var inputValue = $(this).val();
       if (inputValue.startsWith("-") || inputValue == '0') {
          inputValue = inputValue.substr(1);
          $(this).val(inputValue);
       }
       if (inputValue === "" || isNaN(inputValue)) {
          $(this).val("");
       }
    });

  
 </script>

 </body>

 </html>