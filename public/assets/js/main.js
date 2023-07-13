const logo_link = document.getElementById('logo');
const logo = logo_link.querySelector('img');

logo_link.addEventListener('click', event => {
    event.preventDefault();

    logo.classList.add('animate__animated', 'animate__bounce', 'animate__fast');
    logo_sound.play();

    // Once the animation ends, remove it's classes so that it can be re-animated again
    logo.addEventListener('animationend', () => {
        logo.classList.remove('animate__animated', 'animate__bounce');
    });
});

Livewire.on('totalCostsCalculated', () => {
    const calculate = document.getElementById('calculate');
    const calculation = document.getElementById('calculation');

    calculate.addEventListener('animationend', () => {
        // Totally remove it from the DOM as changing it's display seems to cause some issues
        // when we want to "reset" the calculation and then fade it back in (due to Livewire's DOM diffing)
        calculate.remove();

        calculation.style.display = 'block';
        calculation.classList.add('animate__animated', 'animate__fadeIn');
    });
});

Livewire.on('caculationReset', () => {
    const calculate = document.getElementById('calculate');
    calculate.classList.add('animate__animated', 'animate__fadeIn', 'animate__slow');
});