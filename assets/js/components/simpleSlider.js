//////////////////////////////////////
// Simple Slider
//////////////////////////////////////

var sliders = document.querySelectorAll('.hw-ss');
var sliderControls = document.querySelectorAll('.hw-simple-slider-control');
var sliderCount = 0;

sliders.forEach((slider) => {
    if (slider.dataset.slider == '0') {
        slider.classList.add('hw-active-slider');
        sliderCount = 0;
    }
});

sliderControls.forEach((control) => {
    control.addEventListener('click', () => {
        if (control.dataset.toggle == 'next') {
            if (sliderCount < sliders.length - 1) {
                sliderCount++;
                clearSliders();
                activeSlider(sliderCount);
            } else {
                sliderCount = 0;
                clearSliders();
                activeSlider(sliderCount);
            }
        } else if (control.dataset.toggle == 'back') {
            if (sliderCount > 0) {
                sliderCount -= 1;
                clearSliders();
                activeSlider(sliderCount);
            } else {
                sliderCount = sliders.length - 1;
                clearSliders();
                activeSlider(sliderCount);
            }
        }
    });
});

function clearSliders() {
    sliders.forEach((slider) => {
        slider.classList.remove('hw-active-slider');
    });
}

function activeSlider(sliderCount) {
    sliders[sliderCount].classList.add('hw-active-slider');
}
