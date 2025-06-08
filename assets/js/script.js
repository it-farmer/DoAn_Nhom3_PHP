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

// ------------------------------------User Detail------------------------------------------------
function showOptionsUser(){
    const options = document.getElementById('menuOptionsUser');

    if(options.style.display == 'none')
        options.style.display = 'block';
    else
        options.style.display = 'none';
}

function showContent(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    const navItems = document.querySelectorAll('.sidebar li');
    const report_hidden = document.querySelector('.reports-not-hidden');

    sections.forEach(section => {
        section.classList.remove('active');
        if (section.id === sectionId) {
            if(sectionId === 'reports'){
                report_hidden.classList.add('active');
            }
            section.classList.add('active');
        }
    });

    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.dataset.section === sectionId) {
            if(sectionId !== 'reports'){
                report_hidden.classList.remove('active');
            }
            item.classList.add('active');
        }
    });
}

function resetUserForm() {
    const form = document.getElementById('handle-form');
    form.reset();
    document.getElementById('action').value = 'add_user';
    document.getElementById('form-title').textContent = 'Thêm Nhân Viên';
    document.getElementById('form-btn').textContent = 'Thêm Nhân Viên';
}

function editUser(user) {
    showContent('add_user');
    document.getElementById('form-title').textContent = 'Sửa Nhân Viên';
    document.getElementById('form-btn').textContent = 'Cập Nhật Thông Tin Nhân Viên';
    document.getElementById('action').value = 'edit_user';
    document.getElementById('user_id').value = user.user_id;
    document.getElementById('fullname').value = user.fullname;
    document.getElementById('born').value = user.born;
    document.getElementById('gender').value = user.gender;
    document.getElementById('address').value = user.address;
    document.getElementById('phone').value = user.phone;
    document.getElementById('role_id').value = user.role_id;
    document.getElementById('username').value = user.username;
    document.getElementById('password').value = user.password;
}

// ------------------------------------Home Page--------------------------------------
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