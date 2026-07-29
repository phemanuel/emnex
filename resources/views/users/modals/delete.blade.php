<div class="modal fade"
     id="deleteUserModal"
     tabindex="-1">


<div class="modal-dialog modal-dialog-centered modal-sm">


<div class="modal-content">


<div class="modal-header">


<h5 class="modal-title text-danger">

<i class="bi bi-trash me-2"></i>

Delete User

</h5>


<button type="button"
        class="btn-close"
        onclick="closeDeleteUserModal()">

</button>


</div>





<div class="modal-body text-center">


<div class="mb-3">


<i class="bi bi-exclamation-triangle text-warning"
   style="font-size:40px;"></i>


</div>



<p class="mb-0">


Are you sure you want to delete this user?


</p>



<input type="hidden"
       id="delete_user_id">


</div>






<div class="modal-footer justify-content-center">


<button type="button"
        class="btn btn-light"
        onclick="closeDeleteUserModal()">

Cancel

</button>




<button type="button"
        class="btn btn-danger"
        onclick="deleteUser()">

Delete

</button>


</div>



</div>


</div>


</div>