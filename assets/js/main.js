document.addEventListener('DOMContentLoaded', () => {
  const navToggle = document.querySelector('.nav-toggle');
  const menu = document.getElementById('primary-menu');

  if (navToggle && menu) {
    navToggle.addEventListener('click', () => {
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!expanded));
      menu.setAttribute('aria-expanded', String(!expanded));
    });
  }

  const links = document.querySelectorAll('a[href^="#"]');
  links.forEach(link => {
    link.addEventListener('click', event => {
      const targetId = link.getAttribute('href').slice(1);
      const target = document.getElementById(targetId);
      if (target) {
        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
        if (navToggle && menu && window.innerWidth <= 900) {
          navToggle.setAttribute('aria-expanded', 'false');
          menu.setAttribute('aria-expanded', 'false');
        }
      }
    });
  });
});
