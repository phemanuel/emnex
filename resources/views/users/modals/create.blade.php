<div class="modal fade"
     id="createUserModal"
     tabindex="-1">


<div class="modal-dialog modal-lg modal-dialog-centered">


<div class="modal-content">


<form id="createUserForm">


<div class="modal-header">


<h5 class="modal-title">

<i class="bi bi-person-plus me-2"></i>

Create User

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
name="first_name"
class="form-control">

</div>



<div class="col-md-6">

<label class="form-label">
Last Name
</label>

<input type="text"
name="last_name"
class="form-control">

</div>



<div class="col-md-6">

<label class="form-label">
Email
</label>

<input type="email"
name="email"
class="form-control">

</div>



<div class="col-md-6">

<label class="form-label">
Username
</label>

<input type="text"
name="username"
class="form-control">

</div>



<div class="col-md-6">

<label class="form-label">
Role
</label>

<select name="role_id"
class="form-select">


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


<select name="branch_id"
class="form-select">


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
name="phone"
class="form-control">


</div>



<div class="col-md-6">

<label class="form-label">
Password
</label>


<input type="password"
name="password"
class="form-control">


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

Save User

</button>


</div>


</form>


</div>


</div>


</div>