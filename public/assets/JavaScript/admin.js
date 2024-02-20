window.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
    datatablesSimple = document.getElementById('datatablesSimple');
    let dataTable = new simpleDatatables.DataTable(datatablesSimple, {
        perPageSelect: [5, 10, 20, ["Tout", -1]],
        labels: {
            placeholder: "Recherher...",
            perPage: "Lignes par page",
            noRows: "Aucun donnée trouvée",
            info: "Affichage de {start} à {end} sur {rows} lignes",
            noResults: "Aucun résultat ne correspond à votre requête de recherche",
        }
    });
    let modalTitle = document.querySelector(".modal-title");
    let modalBody = document.querySelector(".modal-body");
    let modalFooter = document.querySelector(".modal-footer");
    let myModal = document.querySelector("#myModal"); 
    let Modal = bootstrap.Modal.getOrCreateInstance(myModal);         
    let tab=document.querySelector('#datatablesSimple');  
    let add=document.querySelector('.btn-success')
    if(add)
    {
        add.addEventListener('click',e =>{
            e.preventDefault()
            loadUrl(add.getAttribute('href'))
        })
    }
    tab.querySelectorAll('a').forEach(a => {
        a.addEventListener('click',e =>{
            e.preventDefault()
            loadUrl(a.getAttribute('href'))
        })
    })
    async function loadUrl(url){
        let ajaxUrl= url+'?'+'&ajax=1'
        const response = await fetch(ajaxUrl,{
            headers:{
                'X-Requested-with':'XMLHttpRequest'
            }
        })
        if(response.status >= 200 && response.status < 300 )
        {
            const data = await response.json()
            modalTitle.innerText=data.title
            modalBody.innerHTML= data.content
            modalFooter.innerHTML= data.foot
            if(document.querySelector(".modal-footer a"))
            {
                document.querySelector(".modal-footer a").href=url
            }
            else
            {
                history.replaceState({},'',url)
            }
            Modal.show(); 
        }
        else
        {
            console.error(response)
        }
    }
});