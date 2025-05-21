<style>

* {
  box-sizing: border-box;
  font-family: "Arial", sans-serif; /* Font chữ */

}

img {
  vertical-align: middle;
  
}

.container {
  position: relative;
  /* padding-top: 80px; */
  text-align: center;
}

.mySlides {
  display: none;
  width: 80%;
  height: 60%;
}

.cursor {
  cursor: pointer;
}

.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
  background-color: rgba(29, 29, 29, 0.67);
}

.next {
  right: 5px;
  border-radius: 3px 3px 3px 3px;
}
.prev {
  left: 5px;
  border-radius: 3px 3px 3px 3px;
}

.prev:hover,
.next:hover {
  background-color: rgba(94, 94, 94, 0.67);
}

.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

.caption-container {
  font-size: 80%;
  width: 80%;
  text-align: center;
  background-color: rgba(255, 255, 255, 0);
  padding: 10px 100px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 16.66%;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}
</style>

<!-- <h2 style="text-align:center; color: white; padding: ;">Xe nổi bậc</h2> -->
<br>
<br>
<br>
<div class="container">
  <div class="mySlides">
    <div class="numbertext">1 / 6</div>
    <img src="HInhAnh/Xe/xe69.jpg" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">2 / 6</div>
    <img src="HInhAnh/Xe/xe63.jpg" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">3 / 6</div>
    <img src="HInhAnh/Xe/xe12.jpg" style="width:100%">
  </div>
    
  <div class="mySlides">
    <div class="numbertext">4 / 6</div>
    <img src="HInhAnh/Xe/xe46.jpg" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">5 / 6</div>
    <img src="HInhAnh/Xe/xe75.jpg" style="width:100%">
  </div>
    
  <div class="mySlides">
    <div class="numbertext">6 / 6</div>
    <img src="HInhAnh/Xe/xe08.jpg" style="width:100%">
  </div>
    
  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>

  <div class="caption-container" >
    <p id="caption"></p>
  </div>

  <div class="row">
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe69.jpg" style="width:100%" onclick="currentSlide(1)" alt="Ferrari LaFerrari">
    </div>
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe63.jpg" style="width:100%" onclick="currentSlide(2)" alt="Roll-Royce Phantom II">
    </div>
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe12.jpg" style="width:100%" onclick="currentSlide(3)" alt="Porsche Cayenne">
    </div>
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe46.jpg" style="width:100%" onclick="currentSlide(4)" alt="Mercedes-Benz CLA">
    </div>
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe75.jpg" style="width:100%" onclick="currentSlide(5)" alt="Ferrari 458">
    </div>    
    <div class="column">
      <img class="demo cursor" src="HInhAnh/Xe/xe08.jpg" style="width:100%" onclick="currentSlide(6)" alt="Lamborghini Urus">
    </div>
  </div>
</div>


<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>
    
