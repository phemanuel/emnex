<div class="card inventory-report-card inventory-filter-card mb-4">

    <div class="card-body">

        <div class="inventory-filter-header">

            <div>
                <h5 class="inventory-filter-title">
                    Inventory Filters
                </h5>

                <p class="inventory-filter-description">
                    Select the inventory period, branch, product, and stock conditions.
                </p>
            </div>

            <button
                type="button"
                class="btn btn-light btn-sm"
                id="inventoryResetBtn"
            >
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                Reset
            </button>

        </div>

        <div class="row g-3">

            {{-- Period --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryDatePreset"
                    class="form-label"
                >
                    Period
                </label>

                <select
                    class="form-select"
                    id="inventoryDatePreset"
                >
                    <option value="this_month">
                        This Month
                    </option>

                    <option value="last_month">
                        Last Month
                    </option>

                    <option value="this_year">
                        This Year
                    </option>

                    <option value="last_30_days">
                        Last 30 Days
                    </option>

                    <option value="last_90_days">
                        Last 90 Days
                    </option>

                    <option value="custom">
                        Custom Range
                    </option>
                </select>

            </div>

            {{-- Date From --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryDateFrom"
                    class="form-label"
                >
                    Date From
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="inventoryDateFrom"
                    name="date_from"
                >

            </div>

            {{-- Date To --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryDateTo"
                    class="form-label"
                >
                    Date To
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="inventoryDateTo"
                    name="date_to"
                >

            </div>

            {{-- Branch --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryBranch"
                    class="form-label"
                >
                    Branch
                </label>

                <select
                    class="form-select"
                    id="inventoryBranch"
                    name="branch_id"
                >

                    @if(count($filters['branches']))

                        @if(count($filters['branches']) > 1)

                            <option value="">
                                All Branches
                            </option>

                        @endif

                        @foreach($filters['branches'] as $branch)

                            <option value="{{ $branch['id'] }}">
                                {{ $branch['name'] }}
                            </option>

                        @endforeach

                    @else

                        <option value="">
                            No Branch Available
                        </option>

                    @endif

                </select>

            </div>

            {{-- Product --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryProduct"
                    class="form-label"
                >
                    Product
                </label>

                <select
                    class="form-select"
                    id="inventoryProduct"
                    name="product_id"
                >

                    <option value="">
                        All Products
                    </option>

                    @foreach($filters['products'] as $product)

                        <option
                            value="{{ $product['id'] }}"
                            data-category-id="{{ $product['category_id'] ?? '' }}"
                        >
                            {{ $product['name'] }}

                            @if(!empty($product['sku']))
                                — {{ $product['sku'] }}
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Category --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryCategory"
                    class="form-label"
                >
                    Category
                </label>

                <select
                    class="form-select"
                    id="inventoryCategory"
                    name="category_id"
                >

                    <option value="">
                        All Categories
                    </option>

                    @foreach($filters['categories'] as $category)

                        <option value="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Movement Type --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryMovementType"
                    class="form-label"
                >
                    Movement Type
                </label>

                <select
                    class="form-select"
                    id="inventoryMovementType"
                    name="movement_type"
                >

                    <option value="">
                        All Movements
                    </option>

                    @foreach($filters['movement_types'] as $movement)

                        <option value="{{ $movement['value'] }}">
                            {{ $movement['label'] }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Stock Status --}}
            <div class="col-12 col-md-6 col-xl-3">

                <label
                    for="inventoryStockStatus"
                    class="form-label"
                >
                    Stock Status
                </label>

                <select
                    class="form-select"
                    id="inventoryStockStatus"
                    name="stock_status"
                >

                    <option value="">
                        All Stock
                    </option>

                    @foreach($filters['stock_statuses'] as $status)

                        <option value="{{ $status['value'] }}">
                            {{ $status['label'] }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <div class="inventory-filter-footer">

            <div
                class="inventory-filter-summary"
                id="inventoryFilterSummary"
            >
                Current inventory with movement activity for the selected period.
            </div>

            <button
                type="button"
                class="btn btn-primary"
                id="inventoryApplyBtn"
            >
                <i class="bi bi-funnel me-1"></i>
                Apply Filters
            </button>

        </div>

    </div>

</div>

