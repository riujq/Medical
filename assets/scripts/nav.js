const nav = () => {
     document.querySelector('#navbarSideCollapse')?.addEventListener('click', () => {
        document.querySelector('.offcanvas-collapse')?.classList.toggle('open')
        document.querySelector('.hamburger')?.classList.toggle('hamburger--open')
      })
  }

export default nav;