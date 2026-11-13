/* Property Directory home page: one block per widget that needs JavaScript.
   Each block is self-contained and works on every instance of its widget on the page.
   Only widgets 2 (Swiper) and 6 (testimonials) need JS. */

/* ===== WIDGET 2: Latest properties (needs Swiper loaded first) ===== */
(function ($) {
  function initSwiper(root) {
    var el = root.querySelector(".wf-latest__slider");

    if (!el || el.swiper) {
      return;
    }

    var config = {
      slidesPerView: 1.12,
      spaceBetween: 12,
      speed: 600,

      navigation: {
        prevEl: root.querySelector(".wf-slider-btn--prev"),
        nextEl: root.querySelector(".wf-slider-btn--next"),
      },

      pagination: {
        el: root.querySelector(".wf-latest__dots"),
        clickable: true,
      },

      breakpoints: {
        621: {
          slidesPerView: 2,
          spaceBetween: 14,
        },

        901: {
          slidesPerView: 3,
          spaceBetween: 16,
        },
      },
    };

    /*
     * Normal frontend
     */
    if (typeof Swiper !== "undefined") {
      new Swiper(el, config);
    } else if (
      /*
       * Elementor preview
       *
       * Elementor may load Swiper asynchronously.
       */
      typeof elementorFrontend !== "undefined" &&
      elementorFrontend.utils &&
      elementorFrontend.utils.swiper
    ) {
      var asyncSwiper = elementorFrontend.utils.swiper;

      new asyncSwiper(el, config).then(function (swiper) {
        // Swiper initialized successfully
      });
    }
  }

  /*
   * =========================================================
   * NORMAL FRONTEND
   * =========================================================
   */

  function initFrontend() {
    document.querySelectorAll(".wf-latest").forEach(function (root) {
      initSwiper(root);
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initFrontend);
  } else {
    initFrontend();
  }

  /*
   * =========================================================
   * ELEMENTOR
   * =========================================================
   */

  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/wf_hp_latest_properties.default",
      function ($element) {
        console.log($element[0]);
        var root = $element[0].querySelector(".elementor-widget-container");
        console.log(root);

        if (root) {
          initSwiper(root);
        }
      },
    );
  });
})(jQuery);

/* ===== WIDGET 6: Client testimonials (no library) ===== */
(function () {
  function init() {
    document.querySelectorAll(".wf-testimonials").forEach(function (root) {
      var track = root.querySelector(".wf-t__track");
      var prev = root.querySelector(".wf-t__prev");
      var next = root.querySelector(".wf-t__next");
      var dotsBox = root.querySelector(".wf-t__dots");
      if (!track || !track.children.length) return;
      var dots = [],
        ticking = false;

      function step() {
        var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
        return track.children[0].getBoundingClientRect().width + gap;
      }
      function max() {
        return track.scrollWidth - track.clientWidth;
      }
      function build() {
        var n = Math.max(1, Math.round(max() / step()) + 1);
        dotsBox.innerHTML = "";
        dots = [];
        for (var i = 0; i < n; i++) {
          var b = document.createElement("button");
          b.type = "button";
          b.className = "wf-t__dot";
          b.setAttribute("aria-label", "Go to testimonial " + (i + 1));
          b.addEventListener(
            "click",
            (function (i) {
              return function () {
                track.scrollTo({ left: i * step() });
              };
            })(i),
          );
          dotsBox.appendChild(b);
          dots.push(b);
        }
        update();
      }
      function update() {
        var i =
          max() - track.scrollLeft < 2
            ? dots.length - 1
            : Math.round(track.scrollLeft / step());
        dots.forEach(function (d, k) {
          d.classList.toggle("is-active", k === i);
        });
        if (prev) prev.disabled = track.scrollLeft < 2;
        if (next) next.disabled = max() - track.scrollLeft < 2;
      }
      track.addEventListener(
        "scroll",
        function () {
          if (ticking) return;
          ticking = true;
          requestAnimationFrame(function () {
            update();
            ticking = false;
          });
        },
        { passive: true },
      );
      if (prev)
        prev.addEventListener("click", function () {
          track.scrollBy({ left: -step() });
        });
      if (next)
        next.addEventListener("click", function () {
          track.scrollBy({ left: step() });
        });
      window.addEventListener("resize", build);
      build();
    });
  }
  if (document.readyState === "loading")
    document.addEventListener("DOMContentLoaded", init);
  else init();
})();

(function () {
  console.log("wf-home-js");
})();
