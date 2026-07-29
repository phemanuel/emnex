<div class="modal fade"
     id="editUserModal"
     tabindex="-1">


<div class="modal-dialog modal-lg modal-dialog-centered">


<div class="modal-content">


<form id="editUserForm">


<input type="hidden"
       id="edit_user_id"
       name="user_id">



<div class="modal-header">


<h5 class="modal-title">

<i class="bi bi-pencil-square me-2"></i>

Edit User

</h5>



<button type="button"
        class="btn-close"
        data-bs-dismiss="modal">

</button>


</div>





<div class="modal-body">


<div class="row g-3">



<div class="col-md-6">


<label class="form-label">

First Name

</label>


<input type="text"
       id="edit_first_name"
       name="first_name"
       class="form-control">


</div>





<div class="col-md-6">


<label class="form-label">

Last Name

</label>


<input type="text"
       id="edit_last_name"
       name="last_name"
       class="form-control">


</div>





<div class="col-md-6">


<label class="form-label">

Email

</label>


<input type="email"
       id="edit_email"
       name="email"
       class="form-control">


</div>





<div class="col-md-6">


<label class="form-label">

Username

</label>


<input type="text"
       id="edit_username"
       name="username"
       class="form-control">


</div>





<div class="col-md-6">


<label class="form-label">

Role

</label>


<select class="form-select"
        id="edit_role_id"
        name="role_id">


<option value="">

Select Role

</option>


@foreach($roles as $role)


<option value="{{ $role->id }}">

{{ $role->displayLabel() }}

</option>


@endforeach


</select>


</div>





<div class="col-md-6">


<label class="form-label">

Branch

</label>


<select class="form-select"
        id="edit_branch_id"
        name="branch_id">


<option value="">

Select Branch

</option>


@foreach($branches as $branch)


<option value="{{ $branch->id }}">

{{ $branch->name }}

</option>


@endforeach


</select>


</div>





<div class="col-md-6">


<label class="form-label">

Phone

</label>


<input type="text"
       id="edit_phone"
       name="phone"
       class="form-control">


</div>





<div class="col-md-6">


<label class="form-label">

Status

</label>


<select class="form-select"
        id="edit_status"
        name="status">


<option value="1">

Active

</option>


<option value="0">

Disabled

</option>


</select>


</div>




</div>


</div>






<div class="modal-footer">


<button type="button"
        class="btn btn-light"
        data-bs-dismiss="modal">

Cancel

</button>



<button type="submit"
        class="btn btn-primary">

Update User

</button>


</div>



</form>


</div>


</div>


</div>