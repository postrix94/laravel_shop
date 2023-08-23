import '../admin/jquery/jquery.min';


$(document).ready(function(){
    const quantityProduct = parseInt($('#quantity_product').val());
    const btnAddProduct = $("#addProduct");
    const productsEl = $('#products');

    $('.count').prop('disabled', true);

    $(document).on('click','.plus',function(){
        let productCounter = parseInt($('.count').val());

        (productCounter < quantityProduct)
            ? $('.count').val(productCounter + 1 )
            : alert("Максимальное кол-во товара");
    });

    $(document).on('click','.minus',function(){
        $('.count').val(parseInt($('.count').val()) - 1 );
        if ($('.count').val() == 0) {
            $('.count').val(1);
        }
    });

    btnAddProduct.on('click', function (e) {
        const countProduct = $('input[name="qty"]').val();
        $('input[name="quantity"]').val(countProduct);

        const form =  btnAddProduct.closest('form')
        if(form) {
            form.submit();
        }
    });


    productsEl.on('click', function (e) {
       e.preventDefault();


});
});
