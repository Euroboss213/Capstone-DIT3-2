    const scrollBtn = document.getElementById("scrollTopBtn");

    window.onscroll = () => {
      scrollBtn.style.display = window.scrollY > 200 ? "block" : "none";
    };

    scrollBtn.onclick = () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    };