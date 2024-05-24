import Modal from './modal.js'

const popModal = () =>{
    const popModal = document.getElementById("popModal");
    if(popModal) {
        const mypopModal = Modal.getOrCreateInstance(popModal);
        if(sessionStorage.getItem(mypopModal)!='true'){
            mypopModal.show();
        }
        sessionStorage.setItem(mypopModal,'true');
    }
}

export default popModal
