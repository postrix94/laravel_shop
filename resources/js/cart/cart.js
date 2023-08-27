import '../admin/jquery/jquery.min';
import axios from "axios";

$(document).ready(function () {
    const productsContainer = $("#products");

    productsContainer.on('click', function (e) {
        if (e.target.classList.contains('plus')) {
            const counterPlusBtn = e.target;
            const counterContainer = e.target.parentNode;
            const counterProductEl = counterContainer.querySelector(".count");
            const productContainer = counterPlusBtn.closest('.container_counter');
            const productSubtotalEl = productContainer.querySelector('.product_subtotal');


            const rowId = counterContainer.querySelector('input[name="row_id"]').value;
            const productId = counterContainer.querySelector('input[name="product_id"]').value;
            let quantityProduct = Number(counterPlusBtn.previousElementSibling.value);
            let counterProduct = Number(counterProductEl.value);


            if (counterProduct < quantityProduct) {
                counterProductEl.value = counterProduct + 1;
                updateCountProduct(productId, counterProductEl.value, rowId, productSubtotalEl);
            } else {
                alert("Максимальное кол-во товара");
            }
        }

        if (e.target.classList.contains('minus')) {
            const counterMinusBtn = e.target;
            const counterContainer = e.target.parentNode;
            const counterProductEl = counterContainer.querySelector(".count");
            const productContainer = counterMinusBtn.closest('.container_counter');
            const productSubtotalEl = productContainer.querySelector('.product_subtotal');
            const rowId = counterContainer.querySelector('input[name="row_id"]').value;
            const productId = counterContainer.querySelector('input[name="product_id"]').value;
            let counterProduct = Number(counterProductEl.value);

            counterProduct = counterProductEl.value = counterProduct - 1;

            if (counterProduct < 1) {
                counterProductEl.value = 1;
            }else {
                updateCountProduct(productId, counterProduct, rowId, productSubtotalEl);
            }
        }
    });


    function updateCountProduct(productId, productCount,rowId, productSubtotalEl) {
        axios.post(`cart/${productId}/count`, {
            productCount,rowId
        })
            .then(res => {
                if(res.status === 200) {
                    const product = res.data;
                    $(productSubtotalEl).html( `<b>Total: </b>${product.product_subtotal} uah`);
                    $("#subtotal").html(`${product.subtotal} uah`);
                    $("#tax").html(`${product.tax} uah`);
                    $("#total").html(`${product.total} uah`);
                }
            })
            .catch(error => alert('Ошибка ' + error.response.status));
    }


});
