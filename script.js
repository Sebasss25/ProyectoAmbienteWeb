function animateCount(element, target) {
    let current = 0;
    const increment = target / 50;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            clearInterval(timer);
            current = target;
        }
        element.textContent = Math.floor(current);
    }, 20);
}

document.addEventListener("DOMContentLoaded", function () {
    animateCount(document.getElementById('mascotasCount'), 124);
    animateCount(document.getElementById('adopcionesCount'), 89);
    animateCount(document.getElementById('campaniasCount'), 1);
    animateCount(document.getElementById('voluntariosCount'), 1);
});