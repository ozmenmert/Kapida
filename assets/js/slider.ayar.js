$('#vertical-slider-slides').slick({
    arrows: true,
    dots: false, // Dots göstergelerini etkinleştir
    asNavFor: '#vertical-slider-thumb',
    slidesToShow: 1,
    autoplay: true,
    infinite: false, // Sonsuz döngüyü kapatıyoruz
    autoplaySpeed: 3000,
    touchMove: true,
    slidesToScroll: 1,
    slidesToShow: 1,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
});