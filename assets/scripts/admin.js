import { DataTable } from "simple-datatables"
import Modal from './modal.js'

const admin = () => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if(datatablesSimple) {
        new DataTable(datatablesSimple, {
            perPageSelect: [5, 10, 20, ["Tout", -1]],
            labels: {
                placeholder: "Recherher...",
                perPage: "Lignes par page",
                noRows: "Aucun donnée trouvée",
                info: "Affichage de {start} à {end} sur {rows} lignes",
                noResults: "Aucun résultat ne correspond à votre requête de recherche",
            }
        });
        let adminModal = Modal.getOrCreateInstance(document.querySelector("#myModal"));       
        datatablesSimple.querySelectorAll('.btn-del').forEach(a => {
            a.addEventListener('click',e =>{
                e.preventDefault();
                loadUrl(a.getAttribute('href'));
            })
        })
        async function loadUrl(url){
            let ajaxUrl= url+'?'+'&ajax=1'
            const r = await fetch(ajaxUrl,{
                headers:{
                    'X-Requested-with':'XMLHttpRequest'
                }
            })
            if(r.ok)
            {
                const data = await r.json();
                document.querySelector(".modal-title").innerText=data.title;
                document.querySelector(".modal-body").innerHTML= data.content;
                document.querySelector(".modal-footer a").href=url;
                adminModal.show(); 
            }
            else
            {
                console.error(r);
            }
        }
    }
}

export default admin