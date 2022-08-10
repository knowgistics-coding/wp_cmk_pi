class GallerySwiper {
  elem = "";
  postSwiper = null;
  list = [];

  /**
   *
   * @param {string} elem
   * @param {Array<string>} list
   */
  constructor(elem, list) {
    if ($(elem).length > 0) {
      this.elem = elem;
    } else {
      console.error("Gallery Element not found");
    }
    if (list && list.length) {
      this.list = list;
    } else {
      console.error("List empty");
    }
  }

  createSwiper() {
    $(this.elem + " .swiper-wrapper").text("");
    this.list.forEach((url, index) => {
      const image = document.createElement("img");
      image.className = "contain";
      image.src = url;
      image.style.cssText = "filter: brightness(100%)";

      const contain = document.createElement("div");
      contain.className = "swiper-slide";
      contain.appendChild(image);

      $(this.elem + " .swiper-wrapper").append(contain);
    });

    this.postSwiper = new Swiper(this.elem + " .swiper-container", {
      speed: 600,
      loop: true,
      centeredSlides: true,
      grabCursor: true,
      lazy: true,
      pagination: { el: ".swiper-pagination", dynamicBullets: true },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      scrollbar: { el: ".swiper-scrollbar" },
    });
  }

  changeSlide(index) {
    $("body").css("overflow", "hidden");
    $(this.elem + " .post-swiper").css("display", "block");
    if (Boolean(this.postSwiper) === false) {
      this.createSwiper();
    }
    this.postSwiper.slideTo(index + 1);
  }

  /**
   *
   * @param {Array<string>} list
   */
  init() {
    $(this.elem + " .post-gallery").text("");
    this.list.forEach((url, index) => {
      const image = document.createElement("img");
      image.src = url;
      const container = document.createElement("div");
      container.className = "photo";
      container.appendChild(image);
      container.addEventListener("click", () => {
        this.changeSlide(index);
      });

      $(this.elem + " .post-gallery").append(container);
    });

    const icon = document.createElement("i");
    icon.className = "fas fa-times";
    const closebtn = document.createElement("button");
    closebtn.className = "swiper-close";
    closebtn.appendChild(icon);
    closebtn.addEventListener("click", () => {
      $(this.elem + " .post-swiper").css("display", "none");
      $("body").css("overflow", "auto");
    });

    $(this.elem + " .swiper-container").append(closebtn);
  }
}
