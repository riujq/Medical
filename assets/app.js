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
import './styles/nav.css';

/*
 *js import 
 */
import searchBar from './scripts/searchBar.js';
import popModal from './scripts/popModal.js';
import admin from './scripts/admin.js';
import nav from './scripts/nav.js';
import {LoadTheme,switchTheme} from './scripts/theme.js';

LoadTheme();
window.addEventListener('DOMContentLoaded', () => {
    switchTheme();
    popModal();
    searchBar();
    nav();
    admin();
});

