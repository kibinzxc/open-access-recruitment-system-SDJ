const track = document.getElementById('carouselTrack');
const container = document.getElementById('carouselContainer');

let cardIndex = 0;
const cardWidth = 320; // card + margin
const totalCards = track.children.length;
let visibleCards = Math.floor(window.innerWidth / cardWidth);

function updateCarousel() {
    visibleCards = Math.floor(window.innerWidth / cardWidth);
    const maxIndex = totalCards - visibleCards;
    cardIndex = (cardIndex <= maxIndex) ? cardIndex : 0;
    track.style.transform = `translateX(-${cardIndex * cardWidth}px)`;
}

let autoSlide = setInterval(() => {
    const maxIndex = totalCards - visibleCards;
    cardIndex = (cardIndex < maxIndex) ? cardIndex + 1 : 0;
    updateCarousel();
}, 3000);

container.addEventListener('mouseenter', () => clearInterval(autoSlide));

container.addEventListener('mouseleave', () => {
    autoSlide = setInterval(() => {
        const maxIndex = totalCards - visibleCards;
        cardIndex = (cardIndex < maxIndex) ? cardIndex + 1 : 0;
        updateCarousel();
    }, 3000);
});

window.addEventListener('resize', updateCarousel);
updateCarousel();