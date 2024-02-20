window.addEventListener('DOMContentLoaded', () => {
    let i;
    let qty = document.querySelector('#quantity');
    document.querySelector('#plus').addEventListener('click', (e) => {
            e.preventDefault();
            i = parseInt(qty.value);
            i++;
            if(i>100 || isNaN(i)){
                i=100;
            }
             qty.value=i;
        });
    document.querySelector('#moins').addEventListener('click', (e) => {
            e.preventDefault();
            i = parseInt(qty.value);
            i--;
            if(i<1 || isNaN(i)){
                i=1;
            }
             qty.value=i;
        });
    qty.addEventListener('input', (e) => {
        i = parseInt(e.currentTarget.value);
        if(i<0 || i>100 || isNaN(i)){
            i=1;
        }
        e.currentTarget.value=i;
    });
});