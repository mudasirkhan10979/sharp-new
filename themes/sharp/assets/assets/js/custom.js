// Register the plugins with GSAP
gsap.registerPlugin(ScrollTrigger, ScrollSmoother);


ScrollSmoother.create({
    wrapper: '#smooth-wrapper',
    content: '#smooth-content',
    smooth: 1.5,
    effects: true,
  });

$(function() {

  let cards = gsap.utils.toArray(".service-item");

  let stickDistance = 0;

  let firstCardST = ScrollTrigger.create({
    trigger: cards[0],
    start: "center center"
  });

  let lastCardST = ScrollTrigger.create({
    trigger: cards[cards.length-1],
    start: "center center"
  });

  cards.forEach((card, index) => {

    var scale = 1 - (cards.length - index) * 0.025;
    let scaleDown = gsap.to(card, {scale: scale, 'transform-origin': '"50% '+ (lastCardST.start + stickDistance) +'"' });

    ScrollTrigger.create({
      trigger: card,
      start: "center center",
      end: () => lastCardST.start + stickDistance,
      pin: true,
      markers: false,
      pinSpacing: false,
      ease: "none",
      animation: scaleDown,
      toggleActions: "restart none none reverse"
    });
  });

});

// Apply 3D rotation on scroll
  gsap.fromTo(".popular-cate-title", 
    { rotationX: 100, opacity: 0 },  // starting angle
    { 
      rotationX: 0, 
      opacity: 1,
      ease: "power1.out",
      scrollTrigger: {
        trigger: ".popular-cate-title",
        start: "top 80%",     // adjust to trigger earlier or later
        end: "top 30%",
        scrub: true
      }
    }
  );

// Text animation
gsap.registerPlugin(SplitText);

const segmenter = new Intl.Segmenter("zh", { granularity: "word" });

document.fonts.ready.then(() => {
  gsap.set(".h-b-title", { opacity: 1 });

  // 1. Get original text
  const el = document.querySelector(".h-b-title");
  const text = el.textContent;

  // 2. Segment text into words
  const segments = [...segmenter.segment(text)].map(s => s.segment);

  // 3. Wrap each word in a span
//   el.innerHTML = segments.map(w => `<span class="word">${w}</span>`).join("");

  // 4. Animate with GSAP
  gsap.from(".h-b-title span", {
    y: 50,
    opacity: 0,
    stagger: 0.1,
    ease: "back"
  });
});


// //



// Your animation configs
const textAnimations = [
  {
    elements: ".f-pro-title h2",
    trigger: ".f-pro-title",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".t-list-item-cont h4, .t-list-item-cont p",
    trigger: ".t-list-item-cont",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".service-item-text h3, .service-item-text p",
    trigger: ".service-item-text",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".our-news-header-inn",
    trigger: ".our-news-header-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".nav-tabs nav-item",
    trigger: ".nav-tabs",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".news-item-text h4, .news-item-text .news-date span",
    trigger: ".news-item-text",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".news-detail-link a",
    trigger: ".news-detail-link",
    direction: "y",
    stagger: 0.2,
    start: "top 100%",
    end: "bottom 0%",
  },
  {
    elements: ".support-title-sec h2, .support-title-sec p",
    trigger: ".support-title-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  {
    elements: ".support-item-text h4, .support-item-text p",
    trigger: ".support-item-text",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".support-item-link a",
    trigger: ".support-item-link",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".j-item-txt h3, .j-item-txt p",
    trigger: ".j-item-txt",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".about-list h3, .about-list a",
    trigger: ".about-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".category-list h3, .category-list a",
    trigger: ".category-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".appliance-list h3, .appliance-list a",
    trigger: ".appliance-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".solution-list h3, .solution-list a",
    trigger: ".solution-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".tech-list h3, .tech-list a",
    trigger: ".tech-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".support-list h3, .support-list a",
    trigger: ".support-list",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".footer-social h4",
    trigger: ".footer-social",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".f-sub-form h4, .f-sub-form .subscrib-btn",
    trigger: ".f-sub-form",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".f-copyright-inn a",
    trigger: ".f-copyright-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".cat-banner-title h1",
    trigger: ".cat-banner-title",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".cate-slider-title h2",
    trigger: ".cat-banner-title",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".feature-c-item-text .m-p-label, .feature-c-item-text h3, .feature-c-item-text p, .feature-c-item-text .m-p-link",
    trigger: ".feature-c-item-text",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".pro-slider-top h1",
    trigger: ".pro-slider-top",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".filter-sec h2, .filter-sec a",
    trigger: ".filter-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".single-detail-sec .product-no, .single-detail-sec .detail-cat, .single-detail-sec h1",
    trigger: ".single-detail-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".detail-fea-wrap h2",
    trigger: ".detail-fea-wrap",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
];

// card animation

gsap.from(".c-slider-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".cate-slider-list-inn", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.from(".pro-slider-img-wrap", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: "#pro-listing-slider", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.from("select", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".filter-wrap", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.from(".detail-shopslider", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".filter-wrap", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.from(".list-item-wrap", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".listing-item-sec", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.from(".detail-fea-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".detail-fea-inner", 
    start: "top 80%",           
    toggleActions: "play none none reverse"
  }
});

gsap.utils.toArray(".feature-cate-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none reverse"
    }
  });
});





// Safe loop through animations
textAnimations.forEach((config) => {
  const el = document.querySelector(config.elements);
  if (el) {
    animateTextElements(config); // Run animation only if element exists
  }
});


function animateTextElements(config) {
  // Example GSAP usage (adjust to your needs)
  gsap.from(config.elements, {
    y: config.direction === "y" ? 50 : 0,
    x: config.direction === "x" ? 50 : 0,
    opacity: 0,
    stagger: config.stagger,
    scrollTrigger: {
      trigger: config.trigger,
      start: config.start,
      end: config.end,
      toggleActions: "play none none reverse",
    },
  });
}



function safeAnimate(selector, callback) {
  const elements = document.querySelectorAll(selector);
  if (elements.length > 0) {
    callback(elements);
  }
}
safeAnimate(".t-list-item-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});

safeAnimate(".p-list-item-inn", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});

safeAnimate(".news-item-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});

safeAnimate(".footer-social", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 80%",
        end: "bottom 10%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});

safeAnimate(".footer-logo", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 100%",
        end: "bottom 0%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});

safeAnimate(".detail-banner-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none reverse",
        markers: false,
        },
        x: 0,
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power2.out",
    }
    );
});






// Gsap ends



// main menu js
$(document).ready(function(){
    $(".main-nav-left > ul > li a img").click(function(e){
        e.preventDefault(); 
        $(this)
        .parent("a")        
        .siblings(".subnav") 
        .slideToggle(500);
    });

    $(".mobile-menu > ul li a img").click(function(e){
        e.preventDefault(); 
        $(this)
        .parent("a")        
        .siblings(".dropdown") 
        .slideToggle(500);
    });

    $(".mobile-menu .hamburger .open").click(function(e){
        e.preventDefault(); 
        
        $(this).parent(".hamburger") 
        .siblings(".mobile-menu > ul") 
        .slideDown(500);
        // $('.hamburger').addClass('navclose');
            setTimeout(() => {
            $('.hamburger').addClass('navclose');
        }, 300);
    });
    $(".mobile-menu .hamburger .close-x").click(function(e){
        e.preventDefault(); 
            
        $(this).parent(".hamburger")
        .siblings(".mobile-menu > ul") 
        .slideUp(500);
        $('.hamburger').removeClass('navclose');
    });
});

// menu js ends


jQuery(document).ready(function() {
const listnextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const listprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#pro-listing-slider').owlCarousel({
    loop: true,
    margin: 121,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        listprevIcon,
        listnextIcon
    ],
    responsive: {
       
        0: {
            items: 2,
            margin:30
        },
        768: {
            items: 3,
            margin:50
        },
        1200: {
            items: 5.2
        }
    }
});
});

$(document).ready(function(){
            $('.detail-shopslider-thumbnails').not('.slick-initialized').slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.detail-shopslider',
                focusOnSelect: true,
                responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
            });            
            
            $('.detail-shopslider').not('.slick-initialized').slick({
                infinite: false,
                lazyLoad: 'ondemand',
                asNavFor: '.detail-shopslider-thumbnails',
            });
        });

$("#detail_multiple").select2({
  placeholder: "Details"
});

//Similar Products Slider
jQuery(document).ready(function() {
const simnextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const simprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#similar-pro-slider').owlCarousel({
    loop: true,
    margin: 20,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        simprevIcon,
        simnextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
});
});


jQuery(document).ready(function() {

jQuery('.cate-slider-list-inn').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

});


jQuery(document).ready(function(){
    var $head_container = jQuery('.category-slider .container');
    // var head_margin = $head_container.css('padding-left'); 
    // jQuery(".cate-slider-listing").css({"padding-left": head_margin});
    if ($(window).width() > 1200) {
    var head_margin = $head_container.css('padding-left');
    jQuery(".cate-slider-listing").css({"padding-left": head_margin});
} else {
    var head_margin = $head_container.css('margin-left');
    jQuery(".cate-slider-listing").css({"padding-left": head_margin});
}

});


jQuery(document).ready(function() {

jQuery('.certif-rch-slider-inn').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: true,
  responsive: [
    {
      breakpoint: 1180,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

});


 jQuery(document).ready(function(){
    var $head_container = jQuery('.certificate-research-inn .container');
        var head_margin = $head_container.css('margin-left'); 
        jQuery(".certif-rch-slider").css({"padding-left": head_margin});
    });


//casestudies slider
jQuery(document).ready(function() {
const casenextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const caseprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#caseslider').owlCarousel({
    loop: true,
    margin: 30,
    stagePadding: 85,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        caseprevIcon,
        casenextIcon
    ],
    responsive: {
       
        0: {
            items: 1,
            stagePadding: 50
        },
        768: {
            items: 2
        },
        1200: {
            items: 3
        }
    }
});
});

//Product Lifecycle slider
jQuery(document).ready(function() {
const lifenextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const lifeprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#lifecycleslider').owlCarousel({
    loop: true,
    margin: 15,
    stagePadding: 130,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        lifeprevIcon,
        lifenextIcon
    ],
    responsive: {
       
        0: {
            items: 1,
            stagePadding: 50,
        },
        768: {
            items: 2,
            stagePadding: 50
        },
        1200: {
            items: 3
        }
    }
});
});

//LCA reports slider
jQuery(document).ready(function() {
const lcanextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#lcareportslider').owlCarousel({
    loop: true,
    margin: 16,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        lcaprevIcon,
        lcanextIcon
    ],
    responsive: {
       
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1200: {
            items: 3
        }
    }
});
});

//Partners slider
jQuery(document).ready(function() {
const lcanextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#partnerlogoslider').owlCarousel({
    loop: true,
    margin: 40,
    stagePadding: 70,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        lcaprevIcon,
        lcanextIcon
    ],
    responsive: {
       
        0: {
            items: 1
        },
        768: {
            items: 3
        },
        1200: {
            items: 5
        }
    }
});
});

// 
jQuery(document).ready(function(){
    var $head_container = jQuery('header .container');
    var head_margin = $head_container.css('padding-right'); 
    jQuery(".caseslider-wrap").css({"margin-left": head_margin});
    jQuery("#caseslider .owl-nav").css({"right": head_margin});
    jQuery("#lifecycleslider .owl-nav").css({"right": head_margin});
    jQuery(".pro-lifecycle-wrap").css({"margin-left": head_margin});
    jQuery("#partnerlogoslider .owl-nav").css({"right": head_margin});
    jQuery(".listing-slider-wrap").css({"padding-left": head_margin});
    jQuery(".listing-slider-wrap .owl-nav").css({"right": head_margin});

});

jQuery(document).ready(function(){
  var $head_container = jQuery('.sc-contact-inn .container');
  var head_margin = $head_container.css('margin-left'); 
  jQuery(".sc-contact-listing").css({"padding-left": head_margin});
    
});

jQuery(document).ready(function(){
  var $head_container = jQuery('.customer-feedbacks-inn .container');
  var head_margin = $head_container.css('margin-left'); 
  jQuery(".customer-feedbacks-inn .cust-feedbacks-listing").css({"padding-left": head_margin});  
  
});


// Service Center slider
jQuery(document).ready(function() {
const lcanextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('.sc-contact-list-inn').owlCarousel({
    loop: true,
    margin: 20,
    // stagePadding: 70,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        lcaprevIcon,
        lcanextIcon
    ],
    responsive: {
       
        0: {
            items: 1
        },
        768: {
            items: 1.5
        },
        991: {
            items: 1.8
        },
        1200: {
            items: 2.5
        }
    }
});
});


// Customer Feedback


jQuery(document).ready(function() {
const lcanextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('.cust-feedbacks-list-inn').owlCarousel({
    loop: true,
    margin: 20,
    // stagePadding: 70,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    navText: [
        lcaprevIcon,
        lcanextIcon
    ],
    responsive: {
       
        0: {
            items: 1
        },
        768: {
            items: 1.5
        },
        991: {
            items: 1.8
        },
        1200: {
            items: 2.5
        }
    }
});
});