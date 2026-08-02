<!-- =====================================================
    DELETE CONFIRMATION MODAL
====================================================== -->


<div 
    class="modal fade"
    id="categoryDeleteModal"
    tabindex="-1"
>


<div class="modal-dialog modal-dialog-centered">


<div class="modal-content status-modal">



<div class="status-modal-header">


<div class="status-icon bg-danger-subtle text-danger">

    <i class="bi bi-trash"></i>

</div>



<div>

<h5 class="mb-1">

    Delete Category?

</h5>


<p class="mb-0">

    This action cannot be undone.

</p>


</div>


</div>





<div class="modal-body text-center">


<input
    type="hidden"
    id="deleteCategoryId"
>


<p class="text-muted">

You are about to delete:

</p>



<h5 
    id="deleteCategoryName"
    class="category-name"
>

</h5>



<p class="small text-muted mt-3">

The category will be moved to trash and can be restored later.

</p>



</div>






<div class="modal-footer justify-content-center">


<button

    type="button"

    class="btn btn-light px-4"

    data-bs-dismiss="modal"

>

Cancel

</button>




<button

    type="button"

    class="btn btn-danger px-4"

    onclick="ProductCategories.confirmDelete()"

>

Delete Category

</button>


</div>




</div>


</div>


</div>