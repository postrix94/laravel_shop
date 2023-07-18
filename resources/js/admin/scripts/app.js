$( document ).ready(function() {
    const categoriesTable = document.getElementById('categories');

    if(categoriesTable) {
        categoriesTable.addEventListener('click',deleteCategoryOnClick);
    }

    function deleteCategoryOnClick(e) {

        if(!e.target.hasAttribute('data-delete-category')) return null;
        e.preventDefault();

       const btnDelete = e.target;

       const isDeleteCategory = confirm(`Удалить категорию ${btnDelete.getAttribute('data-delete-category')}?`);
       if(!isDeleteCategory) return null;

       const formEl = btnDelete.closest('form')
        formEl.submit();
    }


});

