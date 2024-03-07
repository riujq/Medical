import { Modal } from 'bootstrap';

const popModal = () =>{
    const popModal = document.getElementById("popModal");
    if(popModal) {
        const mypopModal = new Modal(popModal);
        if(sessionStorage.getItem(mypopModal)!='true'){
            mypopModal.show();
        }
        sessionStorage.setItem(mypopModal,'true');
    }
}

export default popModal
