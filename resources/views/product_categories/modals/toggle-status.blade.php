<!-- =====================================================
    STATUS CONFIRMATION MODAL
====================================================== -->


<div 
    class="modal fade"
    id="categoryStatusModal"
    tabindex="-1"
>


<div class="modal-dialog modal-dialog-centered">


<div class="modal-content status-modal">





<div class="status-modal-header">


<div 
    class="status-icon"
    id="statusIcon"
>

    <i class="bi bi-shield-check"></i>

</div>


<div>


<h5 class="mb-1">

    Confirm Status Change

</h5>


<p class="mb-0">

    Review this action before continuing

</p>


</div>


</div>







<div class="modal-body text-center">


<input
    type="hidden"
    id="statusCategoryId"
>


<input
    type="hidden"
    id="statusAction"
>




<div class="status-message">


<p>

You are about to

<strong id="statusActionText"></strong>

this category:

</p>



<h5 
    id="statusCategoryName"
    class="category-name"
>

</h5>


</div>



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

    id="confirmStatusButton"

    class="btn btn-primary px-4"

    onclick="ProductCategories.confirmStatus()"

>

Confirm

</button>


</div>






</div>


</div>


</div>