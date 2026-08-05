<div class="table-responsive product-table-wrapper">

    <table class="table product-table align-middle">


        <thead>

            <tr>

                <th>
                    Product
                </th>

                <th>
                    Category
                </th>

                <th>
                    Selling Price
                </th>

                <th>
                    Stock
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


        @forelse($products as $product)


            <tr>


                {{-- Product --}}
                <td>


                    <div class="product-info">


                        <img src="{{ $product->imageUrl() }}"
                             class="product-image"
                             alt="{{ $product->name }}">



                        <div class="product-details">


                            <button type="button"
                                    class="product-name-btn"
                                    onclick="Products.openInspector({{ $product->id }})">

                                {{ $product->name }}

                            </button>



                            <small>

                                Code:
                                {{ $product->product_code }}

                            </small>


                            @if($product->sku)

                                <small>

                                    SKU:
                                    {{ $product->sku }}

                                </small>

                            @endif



                        </div>


                    </div>


                </td>





                {{-- Category --}}
                <td>


                    <span class="product-category">

                        {{ $product->category?->name ?? '-' }}

                    </span>


                </td>





                {{-- Selling Price --}}
                <td>


                    <strong class="product-price">

                        {{ number_format($product->selling_price,2) }}

                    </strong>


                </td>





                {{-- Stock --}}
                <td>


                    @php

                        $stock = $product->totalStock();

                    @endphp



                    <div class="stock-wrapper">


                        <span>

                            {{ number_format($stock,2) }}

                        </span>



                        @if($product->isOutOfStock())


                            <span class="badge stock-danger">

                                Out Of Stock

                            </span>



                        @elseif($product->isLowStock())


                            <span class="badge stock-warning">

                                Low Stock

                            </span>



                        @else


                            <span class="badge stock-success">

                                In Stock

                            </span>



                        @endif



                    </div>


                </td>





                {{-- Status --}}
                <td>


                    @if($product->status)


                        <span class="badge status-active">

                            Active

                        </span>



                    @else


                        <span class="badge status-inactive">

                            Inactive

                        </span>



                    @endif


                </td>







                {{-- Actions --}}
                <td class="text-end">


                    <div class="dropdown">


                        <button class="btn btn-sm action-btn"
                                type="button"
                                data-bs-toggle="dropdown">


                            <i class="bi bi-three-dots-vertical"></i>


                        </button>



                        <ul class="dropdown-menu dropdown-menu-end">


                            <li>


                                <button class="dropdown-item"
                                        onclick="Products.openInspector({{ $product->id }})">


                                    <i class="bi bi-eye me-2"></i>

                                    View


                                </button>


                            </li>





                            <li>


                                <button class="dropdown-item"
                                        onclick="Products.edit({{ $product->id }})">


                                    <i class="bi bi-pencil me-2"></i>

                                    Edit


                                </button>


                            </li>





                            <li>


                                <button class="dropdown-item"
                                        onclick="Products.openStatusModal(
                                            {{ $product->id }},
                                            {{ $product->status ? 'true':'false' }}
                                        )">


                                    <i class="bi bi-toggle-on me-2"></i>


                                    {{ $product->status ? 'Disable':'Enable' }}


                                </button>


                            </li>





                            <li>
                                <hr class="dropdown-divider">
                            </li>




                            <li>


                                <button class="dropdown-item text-danger"
                                        onclick="Products.openDeleteModal({{ $product->id }})">


                                    <i class="bi bi-trash me-2"></i>

                                    Delete


                                </button>


                            </li>



                        </ul>


                    </div>


                </td>




            </tr>



        @empty


            <tr>


                <td colspan="6">


                    <div class="product-empty-state">


                        <i class="bi bi-box-seam"></i>


                        <h5>
                            No products found
                        </h5>


                        <p>
                            Start by creating your first product.
                        </p>



                    </div>


                </td>


            </tr>


        @endforelse



        </tbody>


    </table>


</div>





{{-- Pagination --}}

@if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)


<div class="product-pagination">


    {{ $products->links() }}


</div>


@endif