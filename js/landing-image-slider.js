const images = [
    "../assets/landing-bg.png",
    "../assets/landing-bg2.png",
    "../assets/landing-bg3.png",
    "../assets/landing-bg4.png"
];

let currentIndex = 0;

function showImage(index) {
    const img = document.getElementById("slider-image");
    const dots = document.querySelectorAll(".dot");
    
    currentIndex = (index + images.length) % images.length;
    img.src = images[currentIndex];

    dots.forEach(dot => dot.classList.remove("active"));
    dots[currentIndex].classList.add("active");
}

function nextImage() {
    showImage(currentIndex + 1);
}

function prevImage() {
    showImage(currentIndex - 1);
}

function currentImage(index) {
    showImage(index);
}
setInterval(nextImage, 5000);