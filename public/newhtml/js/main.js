// country select js
function changeLang(langCode, flagPath) {
  document.getElementById("headerLangText").textContent = langCode;
  document.getElementById("headerLangFlag").src = flagPath;
}

function SendExactlySelect(langCode, flagPath) {
  document.getElementById("sendLangText").textContent = langCode;
  document.getElementById("sendLangFlag").src = flagPath;
}

function RecipientGetsSelect(langCode, flagPath) {
  document.getElementById("RecipientLangText").textContent = langCode;
  document.getElementById("RecipientLangFlag").src = flagPath;
}

function BankTransferSelect(langCode, flagPath) {
  document.getElementById("BankTransferLangText").textContent = langCode;
  document.getElementById("RecipientLangFlag").src = flagPath;
}

// textillate animation js
// $(function () {
//   $(".tlt").textillate({
//     in: { effect: "fadeInLeft" },
//     out: { effect: "fadeOutRight" },
//     loop: true,
//   });
// });
// $(".tlt").textillate({
//   in: {
//     effect: "fadeInLeft",
//     delayScale: 1.5,
//     delay: 50,
//     sync: false,
//   },
// });
// document.querySelectorAll(".word").forEach((span) => {
//   if (!span.textContent.trim()) {
//     span.remove();
//   }
// });

// slick testimonials slider js
$(document).ready(function () {
  $(".testimonial-slider").slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: $(".prev-arrow"),
    nextArrow: $(".next-arrow"),
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
});

// text animation js start

// remove empty spans created by Textillate
document.querySelectorAll(".word").forEach((span) => {
  if (!span.textContent.trim()) {
    span.remove();
  }
});

// Trigger textillate when element is in viewport
const observer = new IntersectionObserver(
  function (entries, observer) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        $(entry.target).textillate({
          in: {
            effect: "fadeInLeft",
            delayScale: 1.0,
            delay: 50,
            sync: false,
          },
          out: {
            effect: "fadeOutRight",
          },
          loop: true,
        });
        observer.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.5 }
);

// Observe all tlt elements
document.querySelectorAll(".tlt").forEach((el) => {
  observer.observe(el);
});
