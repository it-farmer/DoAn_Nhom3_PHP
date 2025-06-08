//--------------------------------------Login / Register--------------------------------------------
// Hiển thị Login
function showLogin() {
    document.getElementById('login').style.display = 'flex';
}

// Ẩn Login
function closeLogin() {
    const loginContainer = document.getElementById('login');
    loginContainer.classList.add('ani_out');

    loginContainer.addEventListener('animationend', function handler() {
        loginContainer.style.display = 'none';
        loginContainer.classList.remove('ani_out');
        loginContainer.removeEventListener('animationend', handler); // Xóa listener để tránh lặp
    }, { once: true }); // { once: true } đảm bảo listener chỉ chạy một lần
}

function signup() {
    var x = document.getElementById("log_form");
    var y = document.getElementById("reg_form");

    x.style.left = "-500px";
    y.style.left = "0px";
}

function signin() {
    var x = document.getElementById("log_form");
    var y = document.getElementById("reg_form");

    x.style.left = "0px";
    y.style.left = "500px";
}

// -------------------------Home Page--------------------------------------
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;
let currentIndex = 0;
let isAnimating = false;

function updateSlides() {
    slides.forEach((slide, index) => {
        slide.className = 'slide'; // Reset

        if(slide.classList.contains('hidden')){
            slide.classList.add('posaready');
        } else if (index === currentIndex) {
            slide.classList.add('pos0', 'active');
        } else if (index === (currentIndex + 1) % totalSlides) {
            slide.classList.add('pos1', 'active');
        } else if (index === (currentIndex + 2) % totalSlides) {
            slide.classList.add('pos2', 'active');
        } else if (index === (currentIndex + 3) % totalSlides) {
            slide.classList.add('pos3', 'active');
        } else if (index === (currentIndex + 4) % totalSlides) {
            slide.classList.add('pos4', 'active');
        } else {
            slide.classList.add('hidden');
            setTimeout(() => {
                // Kiểm tra lại để đảm bảo slide vẫn không thuộc các vị trí hiện tại
                if (
                    index !== currentIndex &&
                    index !== (currentIndex + 1) % totalSlides &&
                    index !== (currentIndex + 2) % totalSlides &&
                    index !== (currentIndex + 3) % totalSlides &&
                    index !== (currentIndex + 4) % totalSlides
                ) {
                    slide.classList.add('posready');
                }
            }, 2000);
        }
    });
}

function changeSlide(direction) {
    if (isAnimating) return;
    isAnimating = true;
    currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
    updateSlides();
    setTimeout(() => { isAnimating = false; }, 500);
}

function autoSlide() {
    changeSlide(1);
}

updateSlides();
setInterval(autoSlide, 3000);

//------------------BTN TO HEADER-----------------
window.onscroll = function () {
    var button = document.getElementById('btn_header_page');

    if (document.documentElement.scrollTop > 500) {
        button.style.opacity = 1;
    } else {
        button.style.opacity = 0;
    }
};