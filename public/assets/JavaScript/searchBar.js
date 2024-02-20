window.addEventListener('DOMContentLoaded', () => {
    let search=document.getElementById("search"); 
    search.style.display = 'none';
    const rechercher = document.querySelector('.rechercher');
    rechercher.addEventListener('click', event => {
        event.preventDefault();
        if(search.style.display == 'none'){
            search.style.display = '';
        }
        else{
            search.style.display = 'none';
        }
    });
});
