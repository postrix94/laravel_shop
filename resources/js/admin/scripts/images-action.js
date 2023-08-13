import axios from "axios";
$(document).ready(function () {
    const productImagesWrapper = $('#productImagesWrapper');
    productImagesWrapper.on('click',onClickDeleteImageProduct);

    function onClickDeleteImageProduct(e) {
        e.preventDefault();

       const bntDelete = $(e.target);
       const route = bntDelete.data('route');

       if(!route) return;

        let isDeleteImage = confirm('Удалить изображение?');

        if(!isDeleteImage) return;


        axios.delete(route, {
            responseType: 'json',
        })
            .then(res=> {
                bntDelete.parent().parent().remove();
            })
            .catch(error => {
                console.log(error)
            });
    }
});
