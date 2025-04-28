const images = [
    "../assets/landing-bg.png",
    "../assets/landing-bg2.png",
    "../assets/landing-bg3.png",
    "../assets/landing-bg4.png"
];

let currentIndex = 0;

function showImage(index) {
    const img = document.getElementById('slider-image');
    img.src = images[index];
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
}

// Auto-slide every 3 seconds
setInterval(nextImage, 3000);
