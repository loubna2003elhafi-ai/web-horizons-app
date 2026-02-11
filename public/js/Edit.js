// Toggle Search Bar
function toggleSearch() {
    const searchBar = document.getElementById("searchBar");
    searchBar.style.display = searchBar.style.display === "block" ? "none" : "block";
  }
  
  // Toggle Mobile Menu
  function toggleMenu() {
    const navLinks = document.querySelector(".nav-links ul");
    navLinks.classList.toggle("show");
  }
  