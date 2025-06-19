// Scroll-to-top button logic
const scrollBtn = document.getElementById("scrollTopBtn");

window.onscroll = () => {
  scrollBtn.style.display = window.scrollY > 300 ? "block" : "none";
};

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: "smooth" });
}

// Highlight current page
const current = location.pathname.split("/").pop();
document.querySelectorAll("nav a").forEach(link => {
  if (link.getAttribute("href") === current) {
    link.classList.add("active");
  }
});

// Dropdown toggle logic
const dropdown = document.querySelector(".dropdown");
const dropdownLink = document.querySelector(".dropdown-toggle");

dropdownLink.addEventListener("click", e => {
  e.preventDefault();
  dropdown.classList.toggle("open");
});

// Close dropdown when clicking outside
document.addEventListener("click", e => {
  if (!dropdown.contains(e.target)) {
    dropdown.classList.remove("open");
  }
});

// Modal popup for Indigency
const openIndigency = document.getElementById('openIndigency');
const indigencyModal = document.getElementById('indigencyModal');
const closeIndigencyBtn = indigencyModal?.querySelector('.close-btn');

openIndigency?.addEventListener('click', e => {
  e.preventDefault();
  indigencyModal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
});

closeIndigencyBtn?.addEventListener('click', () => {
  indigencyModal.style.display = 'none';
  document.body.style.overflow = '';
});

window.addEventListener('click', e => {
  if (e.target === indigencyModal) {
    indigencyModal.style.display = 'none';
    document.body.style.overflow = '';
  }
});

// Modal popup for Residency
const openResidency = document.getElementById('openResidency');
const residencyModal = document.getElementById('residencyModal');
const closeResidencyBtn = residencyModal?.querySelector('.close-btn');

openResidency?.addEventListener('click', e => {
  e.preventDefault();
  residencyModal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
});

closeResidencyBtn?.addEventListener('click', () => {
  residencyModal.style.display = 'none';
  document.body.style.overflow = '';
});

window.addEventListener('click', e => {
  if (e.target === residencyModal) {
    residencyModal.style.display = 'none';
    document.body.style.overflow = '';
  }
});

// Modal popup for Permit
const openPermit = document.getElementById('openPermit');
const permitModal = document.getElementById('permitModal');
const closePermitBtn = permitModal?.querySelector('.close-btn');

openPermit?.addEventListener('click', e => {
  e.preventDefault();
  permitModal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
});

closePermitBtn?.addEventListener('click', () => {
  permitModal.style.display = 'none';
  document.body.style.overflow = '';
});

window.addEventListener('click', e => {
  if (e.target === permitModal) {
    permitModal.style.display = 'none';
    document.body.style.overflow = '';
  }
});

// Modal popup for Good Moral
const openGoodMoral = document.getElementById('openGoodMoral');
const goodMoralModal = document.getElementById('goodMoralModal');
const closeGoodMoralBtn = goodMoralModal?.querySelector('.close-btn');

openGoodMoral?.addEventListener('click', e => {
  e.preventDefault();
  goodMoralModal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
});

closeGoodMoralBtn?.addEventListener('click', () => {
  goodMoralModal.style.display = 'none';
  document.body.style.overflow = '';
});

window.addEventListener('click', e => {
  if (e.target === goodMoralModal) {
    goodMoralModal.style.display = 'none';
    document.body.style.overflow = '';
  }
});