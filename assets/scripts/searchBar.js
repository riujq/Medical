const searchBar = () =>{
    document.querySelector('.rechercher')?.addEventListener('click', event => {
        event.preventDefault();
        document.getElementById("search")?.classList.toggle("d-none");
    });
}

export default searchBar