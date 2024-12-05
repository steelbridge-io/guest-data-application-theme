document.getElementById('menu-toggle').addEventListener('click', function() {
    var navMenu = document.querySelector('#site-navigation ul');

    if (navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');

        // Wait for the animation to complete before setting display to none
        setTimeout(function() {
            navMenu.style.display = 'none';
        }, 1000);

    } else {
        navMenu.style.display = 'flex';
        setTimeout(function() {
            navMenu.classList.add('active');
        }, 10); // Small timeout to ensure 'display: flex;' is applied before 'active' class
    }
});