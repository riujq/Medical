const iconTheme = document.querySelector('.iconTheme');
const getStoredTheme = () => localStorage.getItem('theme')?localStorage.getItem('theme'):'light';

const setTheme = theme => {
  document.documentElement.setAttribute('data-bs-theme', theme); 
  localStorage.setItem('theme', theme);
}

export const LoadTheme = () => {
    const theme = getStoredTheme();
    document.documentElement.setAttribute('data-bs-theme', theme);
    ('light' != theme )?iconTheme?.classList.add('bi-moon-stars-fill'):iconTheme?.classList.add('bi-sun-fill');  
}

export const switchTheme = () => {
  document.querySelector('.theme')?.addEventListener('click', (e) => {
    e.preventDefault();
    const theme = document.documentElement.getAttribute('data-bs-theme');
    if ('light' == theme ){
      iconTheme?.classList.replace('bi-sun-fill','bi-moon-stars-fill');
      setTheme('dark');
    }else{
      iconTheme?.classList.replace('bi-moon-stars-fill','bi-sun-fill');
      setTheme('light');
    }
  })
}
