const logo_link = document.getElementById('logo');
const logo = logo_link.querySelector('img');

logo_link.addEventListener('click', event => {
    event.preventDefault();

    logo.classList.add('animate__animated', 'animate__bounce', 'animate__fast');
    logo_sound.play();

    // Once the animation ends, remove it's classes so that it can be re-played.
    logo.addEventListener('animationend', () => {
        logo.classList.remove('animate__animated', 'animate__bounce');
    });
});

// Livewire v3 seems to dispatch component events before the DOM has been fully
// morphed/updated, causing errors. To prevent this, we'll hook into Livewire's
// morphing system to detect when the elements we want to manipulate have been
// added. Not the prettiest solution, but it works.
document.addEventListener('livewire:initialized', () => {
    Livewire.hook('morph.added', ({el}) => {
        const id = el.id;

        switch (true) {
            case id === 'calculation':
                const calculate = document.getElementById('calculate');

                calculate.addEventListener('animationend', () => {
                    calculate.remove();

                    el.style.display = 'block';
                    el.classList.add('animate__animated', 'animate__fadeIn');
                });

                break;

            case id === 'calculate':
                el.classList.add(
                    'animate__animated',
                    'animate__fadeIn',
                    'animate__slow',
                );

                break;
        }
    });
});
