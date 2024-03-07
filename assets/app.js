/*
 *lib import 
 */
 import 'bootstrap';
 import 'bootstrap/dist/css/bootstrap.min.css';
 import 'bootstrap-icons/font/bootstrap-icons.min.css';
 import 'simple-datatables/dist/style.min.css';
 import './styles/simple-datatables.css';
/*
 *css import 
 */
import './styles/bandef.css';
import './styles/career.css';
import './styles/home.css';
import './styles/produit.css';
import './styles/theme.css';
/*
 *js import 
 */
import searchBar from './scripts/searchBar.js';
import popModal from './scripts/popModal.js';
import singleProduit from './scripts/singleProduit.js';
import theme from './scripts/theme.js';
import admin from './scripts/admin.js';

theme();
window.addEventListener('DOMContentLoaded', () => {
    popModal();
    searchBar();
    singleProduit();
    admin();
});

