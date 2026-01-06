$(document).ready(function() {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 50) { 
        $("header").addClass("fixed-nav");
    } else {
        $("header").removeClass("fixed-nav");
    }
  });

});



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
    trigger: cards[cards.length - 1],
    start: "center center"
  });

  cards.forEach((card, index) => {
    var scale = 1 - (cards.length - index) * 0.025;

    let scaleDown = gsap.to(card, { 
      scale: scale
    });

    ScrollTrigger.create({
      trigger: card,
      start: "center center",
      end: () => lastCardST.start + stickDistance,
      pin: true,
      markers: false,
      pinSpacing: false,
      ease: "none",
      animation: scaleDown,
      toggleActions: "restart none none none"
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

window.onload = function() {
  document.fonts.ready.then(() => {
    gsap.set(".h-b-title", { opacity: 1 });

    const el = document.querySelector(".h-b-title");
    const text = el.textContent;
    const segments = [...segmenter.segment(text)].map(s => s.segment);

    // el.innerHTML = segments.map(w => `<span class="word">${w}</span>`).join("");

    gsap.from(".h-b-title span", {
      y: 50,
      opacity: 0,
      stagger: 0.1,
      ease: "back",
      delay: 1
    });
  });
};


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
  // {
  //   elements: ".t-list-item-cont h4, .t-list-item-cont p",
  //   trigger: ".t-list-item-cont",
  //   direction: "y",
  //   stagger: 0.2,
  //   start: "top 60%",
  //   end: "bottom 20%",
  // },
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
    elements: ".our-news-header h2",
    trigger: ".our-news-header",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  // {
  //   elements: ".news-detail-link a",
  //   trigger: ".news-detail-link",
  //   direction: "y",
  //   stagger: 0.2,
  //   start: "top 100%",
  //   end: "bottom 0%",
  // },
  {
    elements: ".support-title-sec h2, .support-title-sec p",
    trigger: ".support-title-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 60%",
    end: "bottom 20%",
  },
  // {
  //   elements: ".support-item-text h4, .support-item-text p",
  //   trigger: ".support-item-text",
  //   direction: "y",
  //   stagger: 0.2,
  //   start: "top 70%",
  //   end: "bottom 20%",
  // },
  // {
  //   elements: ".support-item-link a",
  //   trigger: ".support-item-link",
  //   direction: "y",
  //   stagger: 0.2,
  //   start: "top 70%",
  //   end: "bottom 20%",
  // },
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
    elements: ".f-sub-form h4",
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
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".cate-slider-title h2",
    trigger: ".cat-banner-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".feature-c-item-text .m-p-label, .feature-c-item-text h3, .feature-c-item-text p, .feature-c-item-text .m-p-link",
    trigger: ".feature-c-item-text",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".pro-slider-top h1",
    trigger: ".pro-slider-top",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".filter-sec h2, .filter-sec a",
    trigger: ".filter-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".single-detail-sec .product-no, .single-detail-sec .detail-cat, .single-detail-sec h1",
    trigger: ".single-detail-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".detail-fea-wrap h2",
    trigger: ".detail-fea-wrap",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".download-res-top h2",
    trigger: ".download-res-top",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".similar-pro-sec h2",
    trigger: ".similar-pro-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".support-top h2, .support-top .sup-top-desc",
    trigger: ".support-top",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".csr-cmp-title h2",
    trigger: ".csr-cmp-title",
    direction: "y",
    stagger: 0.2,
    start: "top 90%",
    end: "bottom 0%",
  },
  {
    elements: ".plasma-overview-title h2",
    trigger: ".plasma-overview-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".plasma-overview-text h4, .plasma-overview-text p",
    trigger: ".plasma-overview-text",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".certif-rch-title h2",
    trigger: ".certif-rch-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".sharp-history-title h2",
    trigger: ".sharp-history-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".smef-profile-content .smef-prf-sub, .smef-profile-content h4, .smef-profile-content h2, .smef-profile-content .smef-txt-cnt",
    trigger: ".smef-profile-content",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".philosophy-sec-inn h2, .philosophy-sec-inn h3, .philosophy-sec-inn p",
    trigger: ".philosophy-sec-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".m-director-txt h2, .m-director-txt h3, .m-director-txt p, .m-director-txt span",
    trigger: ".m-director-txt",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".case-slider-sec h2",
    trigger: ".case-slider-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".csr-report-inner h2, .csr-report-inner h3, .csr-report-inner .csr-txt-wrap",
    trigger: ".csr-report-inner",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".pro-lifecycle-top h2, .pro-lifecycle-top .esg-desc",
    trigger: ".pro-lifecycle-top",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".lca-reports-inner h2",
    trigger: ".lca-reports-inner",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".faq-detail-sec h2, .faq-detail-sec .faq-desc, .faq-detail-sec a",
    trigger: ".faq-detail-sec",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".sustain-reports-desc h2, .sustain-reports-desc .sustain-reports-txt",
    trigger: ".sustain-reports-desc",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".partner-logos-top h2, .partner-logos-top .partner-desc",
    trigger: ".partner-logos-top",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".casestudy-gallery h1, .casestudy-gallery .case-category",
    trigger: ".casestudy-gallery",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".gal-bottom-inner h2, .gal-bottom-inner .gal-botton-txt",
    trigger: ".gal-bottom-inner",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".case-desc-inner h2, .case-desc-inner h4, .case-desc-inner .casedesc-txt, .case-desc-inner .casedt-detail",
    trigger: ".case-desc-inner",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".pp-news-item-cont-inn h3, .pp-news-item-cont-inn .pp-n-date, .pp-news-item-cont-inn .pp-n-txt, .pp-news-item-cont-inn .pp-n-link",
    trigger: ".pp-news-item-cont-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".n-e-detail-title-inn .n-e-d-date, .n-e-detail-title-inn h2, .n-e-detail-title-inn p",
    trigger: ".n-e-detail-title-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".ned-middle-cont h3, .ned-middle-cont p",
    trigger: ".ned-middle-cont",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".n-e-d-banner-text p",
    trigger: ".n-e-d-banner-text",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".ned-end-cont p, .ned-end-cont h3",
    trigger: ".ned-end-cont",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".related-ne-title h2",
    trigger: ".related-ne-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".e-b-left h2, .e-b-left p",
    trigger: ".e-b-left",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".company-culture-inn h2, .company-culture-inn h3, .company-culture-inn p",
    trigger: ".company-culture-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
{
    elements: ".career-detail-content h2, .career-detail-content h3, .career-detail-content p, .career-detail-content li",
    trigger: ".career-detail-content",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },

  {
    elements: ".apply-now-inn h2, .apply-now-inn h4, .apply-now-inn p",
    trigger: ".apply-now-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
{
    elements: ".download-cdesc h2, .download-cdesc .download-ctxt",
    trigger: ".download-cdesc",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".contact-detail-title h2, .contact-detail-title p, .contact-detail-title .map-contact-info-link",
    trigger: ".contact-detail-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".support-faq-txt-inn h2, .support-faq-txt-inn .supp-faq-txt-link, .support-faq-txt-inn p",
    trigger: ".support-faq-txt-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".sp-assist-txt-inn h2, .sp-assist-txt-inn p, .sp-assist-txt-inn .supp-faq-txt-link",
    trigger: ".sp-assist-txt-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
 {
    elements: ".pro-warrenty-title h2, .pro-warrenty-title p",
    trigger: ".pro-warrenty-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".pro-warrenty-txt-cont p",
    trigger: ".pro-warrenty-txt-cont",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".our-location-title p, .our-location-title h2",
    trigger: ".our-location-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".faq-title-inn h2",
    trigger: ".faq-title-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".privacy-p-title h2",
    trigger: ".privacy-p-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".privacy-p-content-inn h3, .privacy-p-content-inn p",
    trigger: ".privacy-p-content-inn",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".s-center-list-title h2, .s-center-list-title p",
    trigger: ".s-center-list-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".get-in-touch-title h2, .get-in-touch-title p",
    trigger: ".get-in-touch-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".vr-assistant-txt h2, .vr-assistant-txt p",
    trigger: ".vr-assistant-txt",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".sc-contact-title h2",
    trigger: ".sc-contact-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },
  {
    elements: ".cust-feedbacks-title h2",
    trigger: ".cust-feedbacks-title",
    direction: "y",
    stagger: 0.2,
    start: "top 70%",
    end: "bottom 20%",
  },


];

// card animation

// gsap.from(".c-slider-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".cate-slider-list-inn", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

// gsap.from(".pro-slider-img-wrap", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: "#pro-listing-slider", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

gsap.from("select", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".filter-wrap", 
    start: "top 80%",           
    toggleActions: "play none none none"
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
    toggleActions: "play none none none"
  }
});

// gsap.from(".list-item-wrap", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".listing-item-sec", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

// gsap.from(".detail-fea-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".detail-fea-inner", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

gsap.from(".benefit-content", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".benefits-sec", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".col-md-4", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".download-res-wrap", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".owl-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".similar-pro-wrap", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".support-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".support-sec", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".about-brand-txt", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".about-brand-contant", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".brand-sustain-inner", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".brand-sustainability", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".news-list-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".tab-news-list-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".abt-play-img", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".abt-plasma-play-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".certif-slide-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".certif-rch-slider-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".sharp-hst-slider-list", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".sharp-history-slider-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

// gsap.from(".caseslider-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".caseslider-wrap", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

// gsap.from(".lifeslider-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".pro-lifecycle-wrap", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

// gsap.from(".download-res-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".download-res-wrap", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

// gsap.from(".partner-logo-item", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".partner-logos-wrap", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

gsap.from(".case-gallery-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".case-gallery-inner", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".news-list-related-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".related-news-list-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".benefit-item", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".benefit-item-wrap", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".col-auto", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".j-post-form-filter", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

// gsap.from(".form-control", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".apply-now-form", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

gsap.from(".ap-file-upload-inn", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".ap-file-upload", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

// gsap.from(".loct-item-inn", {
//   y: 50,                
//   opacity: 0,           
//   duration: 1,          
//   ease: "power2.out",
//   stagger: 0.1,         
//   scrollTrigger: {
//     trigger: ".o-l-cant-info-inn", 
//     start: "top 80%",           
//     toggleActions: "play none none none"
//   }
// });

gsap.from(".map-contact-wrap-inn", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".map-contact-wrap", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".downlaod-center-filter-inn", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".download-center-filter", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".p-tab-menu-inn", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".pages-tab-menu", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".o-locat-map-sec", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".o-location-map-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from("table", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".s-center-table", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".get-in-touch-form", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".get-in-touch-inn", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});

gsap.from(".faq-detail-sec", {
  y: 50,                
  opacity: 0,           
  duration: 1,          
  ease: "power2.out",
  stagger: 0.1,         
  scrollTrigger: {
    trigger: ".faqs-sec", 
    start: "top 80%",           
    toggleActions: "play none none none"
  }
});


gsap.utils.toArray(".job-post-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
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
      toggleActions: "play none none none"
    }
  });
});

gsap.utils.toArray(".accordion-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});


gsap.utils.toArray(".news-list-tab-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});

gsap.utils.toArray(".cd-key-point").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});

gsap.utils.toArray(".download-center-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});

gsap.utils.toArray(".soure-code-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});

gsap.utils.toArray(".u-menual-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 90%",
      toggleActions: "play none none none"
    }
  });
});

// gsap.utils.toArray(".sc-contact-item").forEach(card => {
//   gsap.from(card, {
//     y: 50,
//     opacity: 0,
//     duration: 1,
//     ease: "power2.out",
//     scrollTrigger: {
//       trigger: card,
//       start: "top 90%",
//       toggleActions: "play none none none"
//     }
//   });
// });

// gsap.utils.toArray(".cust-feedbacks-item").forEach(card => {
//   gsap.from(card, {
//     y: 50,
//     opacity: 0,
//     duration: 1,
//     ease: "power2.out",
//     scrollTrigger: {
//       trigger: card,
//       start: "top 90%",
//       toggleActions: "play none none none"
//     }
//   });
// });

gsap.utils.toArray(".p-cat-list-item").forEach(card => {
  gsap.from(card, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: "power2.out",
    scrollTrigger: {
      trigger: card,
      start: "top 80%",
      toggleActions: "play none none none"
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
      toggleActions: "play none none none",
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
      toggleActions: "play none none none",
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
// safeAnimate(".t-list-item-img", (elements) => {
//     gsap.fromTo(
//     elements,
//     { x: 0, y: 100, opacity: 0 },
//     {
//         scrollTrigger: {
//         trigger: elements,
//         start: "top 70%",
//         end: "bottom 20%",
//         toggleActions: "play none none none",
//         markers: false,
//         },
//         x: 0,
//         y: 0,
//         opacity: 1,
//         duration: 1,
//         ease: "power2.out",
//     }
//     );
// });

// safeAnimate(".p-list-item-inn", (elements) => {
//     gsap.fromTo(
//     elements,
//     { x: 0, y: 100, opacity: 0 },
//     {
//         scrollTrigger: {
//         trigger: elements,
//         start: "top 70%",
//         end: "bottom 20%",
//         toggleActions: "play none none reverse",
//         markers: false,
//         },
//         x: 0,
//         y: 0,
//         opacity: 1,
//         duration: 1,
//         ease: "power2.out",
//     }
//     );
// });

safeAnimate(".benefit-sec-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

// safeAnimate(".footer-social", (elements) => {
//     gsap.fromTo(
//     elements,
//     { x: 0, y: 100, opacity: 0 },
//     {
//         scrollTrigger: {
//         trigger: elements,
//         start: "top 80%",
//         end: "bottom 10%",
//         toggleActions: "play none none none",
//         markers: false,
//         },
//         x: 0,
//         y: 0,
//         opacity: 1,
//         duration: 1,
//         ease: "power2.out",
//     }
//     );
// });

safeAnimate(".footer-logo", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 100%",
        end: "bottom 0%",
        toggleActions: "play none none none",
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
        toggleActions: "play none none none",
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

safeAnimate(".about-brand-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".csr-cmp-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".csr-cmp-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".philosophy-img-inn", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".philosophy-txt-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".m-director-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".csr-report-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".csr-detail-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".sustain-reports-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".casedt-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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
safeAnimate(".pp-news-img-inn", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".n-e-d-banner-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".ned-middle-img-inn", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".ned-imgs", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".cmp-culture-cnt-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".download-cimg", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".sp-assist-img-inn", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".pro-warrenty-img", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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

safeAnimate(".pro-warrenty-img-sec", (elements) => {
    gsap.fromTo(
    elements,
    { x: 0, y: 100, opacity: 0 },
    {
        scrollTrigger: {
        trigger: elements,
        start: "top 70%",
        end: "bottom 20%",
        toggleActions: "play none none none",
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
    // $(".main-nav-left > ul > li a img").click(function(e){
    //     e.preventDefault(); 
    //     $(this)
    //     .parent("a")        
    //     .siblings(".subnav") 
    //     .slideToggle(500);
    // });
    $(".main-nav-left > ul > li a img").click(function(e) {
    e.preventDefault();

    let $subnav = $(this).parent("a").siblings(".subnav");

    // Close all other submenus
    $(".main-nav-left .subnav").not($subnav).slideUp(500);

    // Toggle the clicked one
    $subnav.slideToggle(500);
});
$(document).click(function(e) {
    if (!$(e.target).closest(".main-nav-left").length) {
        $(".main-nav-left .subnav").slideUp(500);
    }
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
const listnextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const listprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] #pro-listing-slider').owlCarousel({
    loop: false,
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
            items: 4
        }
    }
});
});


jQuery(document).ready(function() {
const listnextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const listprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] #pro-listing-slider').owlCarousel({
    loop: false,
    rtl: true,
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
            items: 4
        }
    }
});
});

$(document).ready(function () {

  const $thumbs = $('.detail-shopslider-thumbnails');
  const thumbCount = $thumbs.children().length;

  // MAIN SLIDER (always slick)
  $('.detail-shopslider').not('.slick-initialized').slick({
      infinite: false,
      lazyLoad: 'ondemand',
      arrows: false
  });

  // ONLY use slick for thumbnails when more than 4
  if (thumbCount > 4) {
      $thumbs.addClass('is-slick');

      $('.detail-shopslider').slick('slickSetOption', 'asNavFor', '.detail-shopslider-thumbnails', true);

      $thumbs.not('.slick-initialized').slick({
          infinite: false,
          slidesToShow: 4,
          slidesToScroll: 1,
          asNavFor: '.detail-shopslider',
          focusOnSelect: true,
          draggable: true,
          swipeToSlide: true
      });
  }

});



// $(document).ready(function () {

//   const thumbCount = $('.detail-shopslider-thumbnails').children().length;

//   $('.detail-shopslider').not('.slick-initialized').slick({
//       infinite: false,
//       lazyLoad: 'ondemand',
//       asNavFor: thumbCount > 4 ? '.detail-shopslider-thumbnails' : null,
//       arrows: false,
//       draggable: true,
//       swipeToSlide: true
//   });

//   if (thumbCount > 4) {
//       $('.detail-shopslider-thumbnails').not('.slick-initialized').slick({
//           infinite: false,
//           slidesToShow: 4,
//           slidesToScroll: 1,
//           focusOnSelect: true,
//           arrows: false,
//           draggable: true,
//           swipeToSlide: true,
//           responsive: [
//               { breakpoint: 1280, settings: { slidesToShow: 3 }},
//               { breakpoint: 768, settings: { slidesToShow: 2 }}
//           ]
//       });
//   }

// });





$("#detail_multiple").select2({
  placeholder: "Details"
});

//Similar Products Slider
jQuery(document).ready(function() {
const simnextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const simprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

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

jQuery('html[lang="en"] .cate-slider-list-inn').slick({
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

jQuery(document).ready(function() {

jQuery('html[lang="ar"] .cate-slider-list-inn').slick({
  infinite: true,
  rtl: true,
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

jQuery('html[lang="en"] .certif-rch-slider-inn').slick({
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

jQuery(document).ready(function() {

jQuery('html[lang="ar"] .certif-rch-slider-inn').slick({
  infinite: true,
  rtl: true,
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

// jQuery(document).ready(function(){
//   var $head_container = jQuery('.partner-logos-sec .container');
//   var head_margin = $head_container.css('margin-left'); 
//   jQuery(".partner-logos-wrap").css({"padding-left": head_margin});
// });


//casestudies slider
jQuery(document).ready(function() {
const casenextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const caseprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('#caseslider').owlCarousel({
  loop: false,
  margin: 30,
  // stagePadding: 85,
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
          margin: 0,
          stagePadding: 10
      },
      768: {
          items: 2,
          stagePadding: 10
      },
      1200: {
          items: 3
      }
  }
});
});

//Product Lifecycle slider
jQuery(document).ready(function() {
const lifenextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lifeprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] #lifecycleslider').owlCarousel({
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

jQuery(document).ready(function() {
const lifenextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const lifeprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] #lifecycleslider').owlCarousel({
    loop: true,
    margin: 15,
    rtl: true,
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
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] #lcareportslider').owlCarousel({
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

jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] #lcareportslider').owlCarousel({
    loop: true,
    rtl: true,
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
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] #partnerlogoslider').owlCarousel({
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


jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] #partnerlogoslider').owlCarousel({
    loop: true,
    rtl: true,
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
    // jQuery("#lifecycleslider .owl-nav").css({"right": head_margin});
    // jQuery(".pro-lifecycle-wrap").css({"margin-left": head_margin});
    // jQuery("#partnerlogoslider .owl-nav").css({"right": head_margin});
    // jQuery(".listing-slider-wrap").css({"padding-left": head_margin});
    // jQuery(".listing-slider-wrap .owl-nav").css({"right": head_margin});

});

jQuery(document).ready(function(){
  var $head_container = jQuery('html[lang="en"] header .container');
  var head_margin = $head_container.css('padding-right'); 
  jQuery("#partnerlogoslider .owl-nav").css({"right": head_margin});
  jQuery("#lifecycleslider .owl-nav").css({"right": head_margin});
});

jQuery(document).ready(function(){
  var $head_container = jQuery('html[lang="ar"] header .container');
  var head_margin = $head_container.css('padding-right'); 
  jQuery("#partnerlogoslider .owl-nav").css({"left": head_margin});
  jQuery("#lifecycleslider .owl-nav").css({"left": head_margin});
});
jQuery(document).ready(function(){
    var $head_container = jQuery('.pro-lifecycle-sec .container');
    var head_margin = $head_container.css('padding-left'); 
    jQuery(".pro-lifecycle-wrap").css({"padding-left": head_margin});

});

jQuery(document).ready(function($){
  function applyResponsiveStyles() {
    if ($(window).width() <= 1024) {
      var $head_container = $('.pro-slider-top .container');
      var head_margin = $head_container.css('margin-left'); 
      
      $("html[lang='en'] .listing-slider-wrap .owl-nav").css({"right": head_margin});
      $("html[lang='en'] .listing-slider-wrap").css({"padding-left": head_margin});
    } else {
      // Reset styles if needed
      var $head_container = $('.pro-slider-top .container');
      var head_padding = $head_container.css('padding-left'); 

      $("html[lang='en'] .listing-slider-wrap .owl-nav").css({"right": head_padding});
      $("html[lang='en'] .listing-slider-wrap").css({"padding-left": head_padding});
    }
  }

  applyResponsiveStyles();
  $(window).resize(applyResponsiveStyles);
});


jQuery(document).ready(function($){
  function applyResponsiveStyles() {
    if ($(window).width() <= 1024) {
      var $head_container = $('.pro-slider-top .container');
      var head_margin = $head_container.css('margin-left'); 
      
      $("html[lang='ar'] .listing-slider-wrap .owl-nav").css({"left": head_margin});
      $("html[lang='ar'] .listing-slider-wrap").css({"padding-left": head_margin});
    } else {
      // Reset styles if needed
      var $head_container = $('.pro-slider-top .container');
      var head_padding = $head_container.css('padding-left'); 

      $("html[lang='ar'] .listing-slider-wrap .owl-nav").css({"left": head_padding});
      $("html[lang='ar'] .listing-slider-wrap").css({"padding-left": head_padding});
    }
  }

  applyResponsiveStyles();
  $(window).resize(applyResponsiveStyles);
});


jQuery(document).ready(function(){
  var $head_container = jQuery('.sc-contact-inn .container');
  var head_margin = $head_container.css('margin-left'); 
  jQuery("html[lang='en'] .sc-contact-listing").css({"padding-left": head_margin});
});

jQuery(document).ready(function(){
  var $head_container = jQuery('.sc-contact-inn .container');
  var head_margin = $head_container.css('margin-right'); 
  jQuery("html[lang='ar'] .sc-contact-listing").css({"padding-right": head_margin});
});

jQuery(document).ready(function(){
  var $head_container = jQuery('.customer-feedbacks-inn .container');
  var head_margin = $head_container.css('margin-left'); 
  jQuery(".customer-feedbacks-inn .cust-feedbacks-listing").css({"padding-left": head_margin});  
  
});


// Service Center slider
jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] .sc-contact-list-inn').owlCarousel({
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

jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] .sc-contact-list-inn').owlCarousel({
    loop: true,
    margin: 20,
    rtl: true,
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
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

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


// feature product slider

jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] .tab-cont-inn').owlCarousel({
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
            items: 2
        },
        991: {
            items: 3
        },
        1200: {
            items: 3
        }
    }
});
});

jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="ar"] .tab-cont-inn').owlCarousel({
    loop: true,
    margin: 20,
    rtl: true,
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
            items: 2
        },
        991: {
            items: 3
        },
        1200: {
            items: 3
        }
    }
});
});


jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';

jQuery('html[lang="en"] .detail-fea-inner').owlCarousel({
    loop: false,
    margin: 20,
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
            items: 1,
            margin: 0,
        },
        768: {
            items: 2
        },
        991: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
});
});

jQuery(document).ready(function() {
const lcanextIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-left.svg" alt="left">';
const lcaprevIcon = '<img src="/themes/sharp/assets/images/pro-list-icon-right.svg" alt="right">';

jQuery('html[lang="ar"] .detail-fea-inner').owlCarousel({
    loop: false,
    margin: 20,
    rtl: true,
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
            items: 1,
            margin: 0,
        },
        768: {
            items: 2
        },
        991: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
});
});

// benefits

// jQuery(document).ready(function() {
// const lcanextIcon = '<img src="assets/images/pro-list-icon-right.svg" alt="right">';
// const lcaprevIcon = '<img src="assets/images/pro-list-icon-left.svg" alt="left">';

// jQuery('.benefit-item-list').owlCarousel({
//     loop: true,
//     margin: 20,
//     dots: true,
//     nav: false,
//     autoplay: true,
//     autoplayTimeout: 4000,
//     autoplayHoverPause: true,
//     navText: [
//         lcaprevIcon,
//         lcanextIcon
//     ],
//     items: 1,
    // responsive: {
       
    //     0: {
    //         items: 1
    //     },
    //     768: {
    //         items: 2
    //     },
    //     991: {
    //         items: 3
    //     },
    //     1200: {
    //         items: 4
    //     }
    // }
// });
// });



jQuery('html[lang="en"] .home-banner').owlCarousel({
    loop: true,
    items: 1,
    dots: false,
    nav: false,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
});

jQuery('html[lang="ar"] .home-banner').owlCarousel({
    loop: true,
    rtl: true,
    items: 1,
    dots: false,
    nav: false,
    autoplay: false,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
});