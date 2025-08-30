// Menunggu hingga seluruh halaman HTML dimuat sebelum menjalankan script
document.addEventListener("DOMContentLoaded", () => {
  // --- JavaScript untuk toggle menu mobile ---
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  }

  // --- JavaScript untuk menandai navigasi aktif saat scroll ---
  // (Hanya berjalan di halaman utama yang memiliki sections)
  const sections = document.querySelectorAll("section");
  const navLinks = document.querySelectorAll(".nav-link");

  if (sections.length > 0 && navLinks.length > 0) {
    window.addEventListener("scroll", () => {
      let current = "";
      sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        if (window.pageYOffset >= sectionTop - 150) {
          current = section.getAttribute("id");
        }
      });

      navLinks.forEach((link) => {
        link.classList.remove("active");
        if (link.getAttribute("href") === "#" + current) {
          link.classList.add("active");
        }
      });
    });
  }
});
