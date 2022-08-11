class GallerySwiper {
  elem = "";
  postSwiper = null;
  list = [];
  images = [];

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

  creditGen(data) {
    if (data?.web || data?.credit) {
      const credit = document.createElement("span");
      credit.className = "photo-credit";
      if (data?.web) {
        credit.innerHTML = `<a href="${data.web}" target="_blank"><i class="fas fa-globe"></i> Photo Source</a>`;
      } else if (data?.credit) {
        credit.innerHTML = `<i class="far fa-copyright"></i> ${data.credit}`;
      }
      return credit;
    }
    return null;
  }

  createSwiper() {
    $(this.elem + " .swiper-wrapper").text("");
    this.images.forEach((data, index) => {
      const image = document.createElement("img");
      image.className = "contain";
      image.src = data["2048"];
      image.style.cssText = "filter: brightness(100%)";

      const contain = document.createElement("div");
      contain.className = "swiper-slide";
      contain.appendChild(image);

      const credit = this.creditGen(data);
      if(credit){
        contain.appendChild(credit);
      }

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

  get_image_id(url) {
    let exp = url.split(/%2F|\.s|\.m|\.l|\.jpg/i);
    if (!!exp[1] ? exp[1].length == 32 : false) {
      return exp[1];
    } else {
      return false;
    }
  }

  /**
   *
   * @param {Array<string>} list
   */
  async init() {
    const images = await Promise.all(
      this.list
        .map((url) => {
          return this.get_image_id(url);
        })
        .map(
          async (id) =>
            await firebase.database().ref(`photoDB/${id}`).once("value")
        )
        .map(async (data) => (await data).val())
    );
    this.images = images;

    $(this.elem + " .post-gallery").text("");
    images.forEach((data, index) => {
      const image = document.createElement("img");
      image.src = data["320"];
      const container = document.createElement("div");
      container.className = "photo";
      container.appendChild(image);
      container.addEventListener("click", () => {
        this.changeSlide(index);
      });

      const credit = this.creditGen(data)
      if(credit){
        container.appendChild(credit);
      }

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
