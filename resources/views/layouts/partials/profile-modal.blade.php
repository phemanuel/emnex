{{-- =========================================================
     PROFILE MODAL
========================================================= --}}

<div
    class="modal fade"
    id="profileModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content account-modal">


            {{-- Header --}}
            <div class="modal-header">

                <div>

                    <h5 class="modal-title">

                        My Profile

                    </h5>

                    <small class="text-muted">

                        Manage your account information

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            {{-- Form --}}
            <form id="profileForm">

                @csrf


                <div class="modal-body">


                    {{-- Profile Avatar --}}
                    <div class="profile-modal-header">

                        <div class="profile-modal-avatar">

                            {{ strtoupper(
                                substr(
                                    auth()->user()->first_name ?? 'U',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div>

                            <h6 class="mb-1">

                                {{ auth()->user()->first_name }}
                                {{ auth()->user()->last_name }}

                            </h6>

                            <span class="text-muted">

                                {{ auth()->user()->role?->name ?? 'User' }}

                            </span>

                        </div>

                    </div>



                    {{-- First Name --}}
                    <div class="mb-3">

                        <label
                            for="profileFirstName"
                            class="form-label"
                        >
                            First Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="profileFirstName"
                            name="first_name"
                            value="{{ auth()->user()->first_name }}"
                            required
                        >

                    </div>



                    {{-- Last Name --}}
                    <div class="mb-3">

                        <label
                            for="profileLastName"
                            class="form-label"
                        >
                            Last Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="profileLastName"
                            name="last_name"
                            value="{{ auth()->user()->last_name }}"
                            required
                        >

                    </div>



                    {{-- Email --}}
                    <div class="mb-3">

                        <label
                            for="profileEmail"
                            class="form-label"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="profileEmail"
                            name="email"
                            value="{{ auth()->user()->email }}"
                            required
                        >

                    </div>



                    {{-- Role --}}
                    <div class="mb-3">

                        <label class="form-label">

                            Role

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ auth()->user()->role?->name ?? 'User' }}"
                            readonly
                        >

                    </div>



                    {{-- Branch --}}
                    <div class="mb-0">

                        <label class="form-label">

                            Branch

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ auth()->user()->branch?->name ?? 'All Branches' }}"
                            readonly
                        >

                    </div>


                </div>



                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveProfileBtn"
                    >

                        <i class="bi bi-check2 me-1"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>