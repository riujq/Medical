window.addEventListener('DOMContentLoaded', () => {
    const popModal = document.getElementById("popModal");
    const mypopModal = bootstrap.Modal.getOrCreateInstance(popModal);
    if(sessionStorage.getItem(mypopModal)!='true'){
        mypopModal.show();
    }
    sessionStorage.setItem(mypopModal,'true');
})