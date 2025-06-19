// Slidshow for Images
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("imgs");

    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length;
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Update the display property based on the number of slides
    if (slides.length <= 3) {
        slides[slideIndex - 1].style.display = "inline-block";
    } else {
        slides[slideIndex - 1].style.display = "inline-block";
        slides[slideIndex % slides.length].style.display = "none";
        slides[(slideIndex + 1) % slides.length].style.display = "none";
    }
}