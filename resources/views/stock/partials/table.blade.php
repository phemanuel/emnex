<div class="table-responsive">


    <table class="table stock-table align-middle">


        <thead>

            <tr>


                <th>
                    Product
                </th>


                <th>
                    SKU
                </th>


                <th>
                    Category
                </th>


                <th>
                    Branch
                </th>


                <th>
                    Quantity
                </th>

                <th>
                   Unit Price
                </th>


                <th>
                    Available
                </th>


                <th>
                    Reorder Level
                </th>


                <th>
                    Status
                </th>


                <th class="text-end">
                    Action
                </th>


            </tr>

        </thead>





        <tbody>


        @forelse($stocks as $stock)


            <tr>


                {{-- PRODUCT --}}

                <td>


                    <div class="d-flex align-items-center gap-3">


                        <div class="stock-product-avatar">


                            @if(
                                $stock->product->image
                            )

                                <img
                                src="{{ asset('uploads/products/'.$stock->product->image) }}">


                            @else


                                <i class="bi bi-box"></i>


                            @endif


                        </div>




                        <div>


                            <div class="fw-semibold">


                                {{ $stock->product->name }}


                            </div>



                            <small class="text-muted">


                                {{ $stock->product->barcode ?? '-' }}


                            </small>


                        </div>


                    </div>


                </td>





                {{-- SKU --}}

                <td>

                    {{ $stock->product->sku ?? '-' }}

                </td>





                {{-- CATEGORY --}}

                <td>

                    {{ 
                        $stock->product->category->name ?? '-'
                    }}

                </td>





                {{-- BRANCH --}}

                <td>

                    {{ $stock->branch->name ?? '-' }}

                </td>





                {{-- QUANTITY --}}

                <td>


                    <strong>

                        {{ number_format($stock->quantity,2) }}

                    </strong>


                </td>

                {{-- UNIT PRICE --}}

                <td>


                    <strong>

                        {{ number_format($stock->product->selling_price,2) }}

                    </strong>


                </td>





                {{-- AVAILABLE --}}

                <td>


                    {{ number_format(
                        $stock->available_quantity,
                        2
                    ) }}


                </td>





                {{-- REORDER --}}

                <td>


                    {{ number_format(
                        $stock->reorder_level,
                        2
                    ) }}


                </td>





                {{-- STATUS --}}

                <td>


                    @if(
                        $stock->isOutOfStock()
                    )


                        <span class="badge bg-danger-subtle text-danger">

                            Out Of Stock

                        </span>



                    @elseif(
                        $stock->isLowStock()
                    )


                        <span class="badge bg-warning-subtle text-warning">

                            Low Stock

                        </span>



                    @else


                        <span class="badge bg-success-subtle text-success">

                            Available

                        </span>



                    @endif



                </td>







                {{-- ACTION --}}

                <td class="text-end">


                    <div class="dropdown">


                        <button

                            class="btn btn-light btn-sm"

                            data-bs-toggle="dropdown"

                        >

                            <i class="bi bi-three-dots"></i>

                        </button>





                        <ul class="dropdown-menu dropdown-menu-end">



                            @permission('stock.view')

                                <li>

                                    <button
                                        class="dropdown-item stock-view-btn"
                                        data-id="{{ $stock->id }}"
                                    >

                                        <i class="bi bi-eye me-2"></i>

                                        View Details

                                    </button>

                                </li>

                            @endpermission





                            <!-- <li>


                                <button

                                class="dropdown-item stock-adjust-btn"

                                data-product="{{ $stock->product_id }}"

                                data-branch="{{ $stock->branch_id }}"

                                data-quantity="{{ $stock->quantity }}"

                                >


                                    <i class="bi bi-sliders me-2"></i>


                                    Adjust Stock


                                </button>


                            </li> -->



                        </ul>


                    </div>


                </td>




            </tr>



        @empty



            <tr>


                <td colspan="9">


                    <div class="stock-empty-state">


                        <i class="bi bi-box-seam"></i>


                        <h6>

                            No stock records found

                        </h6>


                        <p>

                            Stock will appear here when products are added.

                        </p>


                    </div>


                </td>


            </tr>




        @endforelse



        </tbody>


    </table>


</div>




<div class="mt-3">


    {{ $stocks->links() }}


</div>