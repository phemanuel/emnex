<div
    class="modal fade"
    id="discountModal"
    tabindex="-1"
    aria-labelledby="discountModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <!-- ============================= -->
            <!-- Header -->
            <!-- ============================= -->

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="discountModalLabel">

                        New Discount

                    </h5>

                    <small class="text-muted">

                        Create or update promotional discounts.

                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>

            </div>

            <!-- ============================= -->
            <!-- Form -->
            <!-- ============================= -->

            <form id="discountForm">

                @csrf

                <input
                    type="hidden"
                    id="discountId">

                <input
                    type="hidden"
                    id="formMethod"
                    value="POST">

                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Discount Name -->

                        <div class="col-md-12">

                            <label
                                for="name"
                                class="form-label">

                                Discount Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                maxlength="255"
                                placeholder="Enter discount name">

                        </div>

                        <!-- Type -->

                        <div class="col-md-6">

                            <label
                                for="type"
                                class="form-label">

                                Discount Type

                            </label>

                            <select
                                class="form-select"
                                id="type"
                                name="type">

                                <option value="Percentage">

                                    Percentage

                                </option>

                                <option value="Fixed">

                                    Fixed Amount

                                </option>

                            </select>

                        </div>

                        <!-- Value -->

                        <div class="col-md-6">

                            <label
                                for="value"
                                class="form-label">

                                Discount Value

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="value"
                                name="value"
                                min="0"
                                step="0.01"
                                placeholder="0.00">

                        </div>

                        <!-- Start Date -->

                        <div class="col-md-6">

                            <label
                                for="start_date"
                                class="form-label">

                                Start Date

                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="start_date"
                                name="start_date">

                        </div>

                        <!-- End Date -->

                        <div class="col-md-6">

                            <label
                                for="end_date"
                                class="form-label">

                                End Date

                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="end_date"
                                name="end_date">

                        </div>

                        <!-- Automatic -->

                        <div class="col-md-12">

                            <div class="form-check form-switch mt-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="is_automatic"
                                    name="is_automatic">

                                <label
                                    class="form-check-label"
                                    for="is_automatic">

                                    Automatically apply this discount when applicable.

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ============================= -->
                <!-- Footer -->
                <!-- ============================= -->

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveDiscountBtn">

                        <i class="bi bi-check-circle me-2"></i>

                        Save Discount

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>