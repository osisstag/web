'use strict';



/**
 * add event on element
 */

const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
}



/**
 * navbar toggle
 */

const navbar = document.querySelector("[data-navbar]");
const navTogglers = document.querySelectorAll("[data-nav-toggler]");
const navLinks = document.querySelectorAll("[data-nav-link]");
const overlay = document.querySelector("[data-overlay]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  overlay.classList.toggle("active");
}

addEventOnElem(navTogglers, "click", toggleNavbar);

const closeNavbar = function () {
  navbar.classList.remove("active");
  overlay.classList.remove("active");
}

addEventOnElem(navLinks, "click", closeNavbar);



/**
 * header active when scroll down to 100px
 */

const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

const activeElem = function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
    backTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    backTopBtn.classList.remove("active");
  }
}

// addEventOnElem(window, "scroll", activeElem);
window.addEventListener("scroll", activeElem);

// PRELOAD

window.onbeforeunload = function () {
  window.scroll({
      top: 0,
      left: 0,
      behavior: 'instant'
  })
}

function ClosePreload() {
  gsap.to(".Preload", {
      duration: 2,
      delay: .5,
      opacity: 0,
      ease: Power4.easeInOut
  });

  setTimeout(function() {
      document.querySelector(".Preload").remove();
      document.body.classList.toggle("lockScroll");
      AOS.init(); 
  }, 2100)
}

function cooldown(func, delay) {
  let inCooldown = false;

  return function(...args) {
    if (!inCooldown) {
      func.apply(this, args);
      inCooldown = true;
      setTimeout(() => inCooldown = false, delay);
    }
  };
}

const startPage = cooldown(ClosePreload, 5000);
setTimeout(() => startPage(), 5000);

// COUNTDOWN

document.addEventListener("DOMContentLoaded", function() {
  const refreshInterval = 10000;

  function setupAutoRefresh(iframeId, countdownId) {
    const iframe = document.getElementById(iframeId);
    const countdownElem = document.getElementById(countdownId);
    let countdown = refreshInterval / 1000;

    function refreshIframe() {
      iframe.src = iframe.src;
      countdown = refreshInterval / 1000; 
    }

    function updateCountdown() {
      countdown--;
      countdownElem.textContent = `Next refresh in ${countdown} seconds`;
      if (countdown <= 0) {
        refreshIframe();
      }
    }

    setInterval(updateCountdown, 1000);
  }

  setupAutoRefresh("iframe1", "countdown1");
  setupAutoRefresh("iframe2", "countdown2");
  setupAutoRefresh("iframe3", "countdown3");
});

// VISI MISI

document.addEventListener("DOMContentLoaded", function() {
  const textContainer = document.getElementById("text-container");
  const texts = [
    {
      heading: "MISI OSIS SMAK SANTA AGNES 2023/2024",
      paragraph: "1. Mengadakan kegiatan yang mengembangkan bakat dan potensi siswa sehingga siswa/i SMA Katolik Santa Agnes Surabaya semakin berkualitas. \n2. Membuat program kerja yang menggandeng pihak luar dan meliput segala kegiatan sehingga SMA Katolik Santa Agnes Surabaya semakin dikenal. \n3. Membuka saran, kritik, evaluasi, dan ide - ide mengenai program kerja yang dilaksanakan oleh OSIS. \n4. Mempererat rasa persaudaraan antar pengurus OSIS dan juga antar siswa/i SMA Katolik Santa Agnes Surabaya."
    },
    {
      heading: "VISI OSIS SMAK SANTA AGNES 2023/2024",
      paragraph: "MENJADIKAN OSIS SMA KATOLIK SANTA AGNES SURABAYA SEBAGAI WADAH UNTUK MENGEMBANGKAN BAKAT, POTENSI SISWA, MEMPROMOSIKAN SEKOLAH DAN MENYALURKAN ASPIRASI."
    },
  ];
  let currentIndex = 1;

  const h1Element = textContainer.querySelector("h1.text-content");
  const pElement = document.getElementById("text-paragraph");

  textContainer.addEventListener("click", function(event) {
    const target = event.target;
    if (target === h1Element || target === pElement) {
      h1Element.classList.add("fade-out");
      pElement.classList.add("fade-out");

      setTimeout(() => {
        currentIndex = (currentIndex + 1) % texts.length;
        const currentText = texts[currentIndex];

        h1Element.textContent = currentText.heading;
        pElement.innerHTML = currentText.paragraph.replace(/\n/g, "<br>");

        h1Element.classList.remove("fade-out");
        pElement.classList.remove("fade-out");
      }, 500); 
    }
  });
});

