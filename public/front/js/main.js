gsap.registerPlugin(ScrollTrigger);

ScrollTrigger.matchMedia({
  "(min-width: 992px)": function () {
    initCards(-140);
  },
  "(max-width: 991.55px)": function () {
    initCards(-85);
  },
});

function initCards(offsetTop) {
  const wrappers = document.querySelectorAll(".included-box-items");
  const total = wrappers.length;

  wrappers.forEach((wrapper, index) => {
    const card = wrapper.querySelector(".included-box-item");

    if (index === total - 1) {
      gsap.set(card, { opacity: 1, scale: 1 });
      return;
    }

    const endValue = index === total - 2 ? "center top" : "bottom top";

    gsap
      .timeline({
        scrollTrigger: {
          trigger: wrapper,
          start: `top+=${offsetTop} top`,
          end: endValue,
          scrub: true,
          pin: true,
          pinSpacing: false,
        },
      })
      .set(card, { opacity: 1, scale: 1 })
      .to(card, { opacity: 0, scale: 0.6, ease: "none" }, 0.01);
  });
}
