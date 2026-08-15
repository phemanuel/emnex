{{-- ==========================================================
    CREATE / EDIT STOCK COUNT MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="stockCountFormModal"
    tabindex="-1"
    aria-labelledby="stockCountFormModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title fw-semibold"
                        id="stockCountFormModalLabel"
                    >
                        New Stock Count
                    </h5>

                    <p
                        class="text-muted small mb-0"
                        id="stockCountFormModalDescription"
                    >
                        Create a new inventory counting session.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="stockCountForm">

                <div class="modal-body">

                    <input
                        type="hidden"
                        id="stockCountId"
                        name="id"
                    >


                    {{-- Branch --}}

                    <div class="mb-3">

                        <label
                            for="stockCountFormBranch"
                            class="form-label fw-semibold"
                        >
                            Branch
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select"
                            id="stockCountFormBranch"
                            name="branch_id"
                            required
                        >

                            <option value="">
                                Select branch
                            </option>

                            @foreach ($branches as $branch)

                                <option value="{{ $branch->id }}">
                                    {{ $branch->name }}
                                </option>

                            @endforeach

                        </select>

                        <div
                            class="invalid-feedback"
                            id="stockCountBranchError"
                        ></div>

                    </div>


                    {{-- Count Date --}}

                    <div class="mb-3">

                        <label
                            for="stockCountFormDate"
                            class="form-label fw-semibold"
                        >
                            Count Date
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="stockCountFormDate"
                            name="count_date"
                            value="{{ now()->format('Y-m-d') }}"
                            required
                        >

                        <div
                            class="invalid-feedback"
                            id="stockCountDateError"
                        ></div>

                    </div>


                    {{-- Notes --}}

                    <div class="mb-0">

                        <label
                            for="stockCountFormNotes"
                            class="form-label fw-semibold"
                        >
                            Notes
                        </label>

                        <textarea
                            class="form-control"
                            id="stockCountFormNotes"
                            name="notes"
                            rows="4"
                            placeholder="Add any notes about this stock count..."
                        ></textarea>

                        <div
                            class="invalid-feedback"
                            id="stockCountNotesError"
                        ></div>

                    </div>

                </div>


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
                        id="stockCountSaveButton"
                    >

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="stockCountSaveSpinner"
                            role="status"
                            aria-hidden="true"
                        ></span>

                        <i
                            class="bi bi-check2-circle"
                            id="stockCountSaveIcon"
                        ></i>

                        <span id="stockCountSaveText">
                            Create Stock Count
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>