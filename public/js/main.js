/*==================== SCROLL SECTIONS ACTIVE LINK ====================*/
const sections = document.querySelectorAll("section[id]");

function scrollActive() {
  const scrollY = window.pageYOffset;

  sections.forEach((current) => {
    const sectionHeight = current.offsetHeight;
    const sectionTop = current.offsetTop - 50;
    let sectionId = current.getAttribute("id");

    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
      document.querySelector(".custom__canvas a[href*=" + sectionId + "]").classList.add("active");
    } else {
      document.querySelector(".custom__canvas a[href*=" + sectionId + "]").classList.remove("active");
    }
  });
}
window.addEventListener("scroll", scrollActive);

/*==================== CHANGE BACKGROUND HEADER ====================*/
function scrollHeader() {
  const nav = document.getElementById("header");
  // When the scroll is greater than 200 viewport height, add the scroll-header class to the header tag
  if (this.scrollY >= 5) nav.classList.add("scroll-header");
  else nav.classList.remove("scroll-header");
}
window.addEventListener("scroll", scrollHeader);

/*==================== SHOW SCROLL UP ====================*/
function scrollUp() {
  const scrollUp = document.getElementById("scroll-up");
  // When the scroll is higher than 560 viewport height, add the show-scroll class to the a tag with the scroll-top class
  if (this.scrollY >= 560) scrollUp.classList.add("show-scroll");
  else scrollUp.classList.remove("show-scroll");
}
window.addEventListener("scroll", scrollUp);

/*==================== DARK LIGHT THEME ====================*/
const themeButtons = document.querySelectorAll(".change-theme");
const darkTheme = "dark";
const lightTheme = "light";
const iconTheme = "uil-sun";

// Previously selected topic (if user selected)
const selectedThemes = localStorage.getItem("selected-theme");
const selectedIcon = localStorage.getItem("selected-icon");

// We validate if the user previously chose a topic
if (selectedThemes) {
  document.documentElement.setAttribute("data-theme", selectedThemes);
  themeButtons.forEach(button => {
    const icon = button.querySelector("i");
    const span = button.querySelector("span");
    if (icon) {
      icon.classList[selectedIcon === "uil-moon" ? "add" : "remove"](iconTheme);
    }
    if (span) {
      span.textContent = selectedThemes === darkTheme ? "Tema Terang" : "Tema Gelap";
    }
  });
}

// Activate / deactivate the theme manually with the button
themeButtons.forEach(button => {
  button.addEventListener("click", () => {
    const currentTheme = document.documentElement.getAttribute("data-theme") === darkTheme ? lightTheme : darkTheme;
    document.documentElement.setAttribute("data-theme", currentTheme);
    
    // Toggle ikon dan teks
    themeButtons.forEach(btn => {
      const icon = btn.querySelector("i");
      const span = btn.querySelector("span");
      if (icon) {
        icon.classList.toggle(iconTheme);
      }
      if (span) {
        span.textContent = currentTheme === darkTheme ? "Tema Terang" : "Tema Gelap";
      }
    });

    // Simpan tema dan ikon yang dipilih pengguna ke localStorage
    localStorage.setItem("selected-theme", currentTheme);
    localStorage.setItem("selected-icon", button.querySelector("i").classList.contains(iconTheme) ? "uil-moon" : "uil-sun");
  });
});