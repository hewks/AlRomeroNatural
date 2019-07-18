function createMainSliders(sliderId) {
    var sliderCount = [0,1,2]
    var newSlider = new SimpleSliders(sliderId,sliderCount);
    newSlider.createInitSliders();
    newSlider.activateSliders();
}

document.addEventListener("DOMContentLoaded", function (e) {
    var sliderId = 'hw-simple-slider';
    createMainSliders(sliderId);
});