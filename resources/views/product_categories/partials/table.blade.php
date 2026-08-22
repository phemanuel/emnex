<div class="category-table-responsive">


    <table class="table emnex-table align-middle">


        <thead>

            <tr>


                <th>
                    Code
                </th>


                <th>
                    Category Name
                </th>


                <th>
                    Parent
                </th>


                <th>
                    Products
                </th>


                <th>
                    Status
                </th>


                <th>
                    Created
                </th>


                <th class="text-end">
                    Actions
                </th>


            </tr>


        </thead>



        <tbody>



        @forelse($categories as $category)


            <tr>


                <!-- =====================================================
                    CATEGORY CODE
                ====================================================== -->

                <td>


                    <span class="category-code">

                        {{ $category->category_code ?? '-' }}

                    </span>


                </td>





                <!-- =====================================================
                    CATEGORY NAME
                ====================================================== -->


                <td>


                    <div class="category-name-cell">


                        <div class="category-avatar">

                            <i class="bi bi-tag"></i>

                        </div>



                        <div>


                            <strong>

                                {{ $category->name }}

                            </strong>



                            @if($category->description)

                                <small>

                                    {{ Str::limit($category->description, 45) }}

                                </small>

                            @endif


                        </div>



                    </div>


                </td>





                <!-- =====================================================
                    PARENT CATEGORY
                ====================================================== -->


                <td>


                    @if($category->parent)

                        <span class="text-muted">

                            {{ $category->parent->name }}

                        </span>


                    @else

                        <span class="text-muted">

                            Main Category

                        </span>


                    @endif



                </td>





                <!-- =====================================================
                    PRODUCTS COUNT
                ====================================================== -->


                <td>


                    <span class="badge bg-light text-dark">

                        {{ $category->products_count ?? 0 }}

                    </span>


                </td>





                <!-- =====================================================
                    STATUS
                ====================================================== -->


                <td>


                    @if($category->status)


                        <span class="badge bg-success-subtle text-success">

                            Active

                        </span>


                    @else


                        <span class="badge bg-danger-subtle text-danger">

                            Inactive

                        </span>


                    @endif



                </td>


                <!-- =====================================================
                    CREATED DATE
                ====================================================== -->


                <td>


                    {{ $category->created_at?->format('d M Y') }}


                </td>

                <!-- =====================================================
                    ACTIONS
                ====================================================== -->


                <td class="text-end">


                    <div class="dropdown">


                        <button 
                            class="btn btn-sm btn-light"
                            data-bs-toggle="dropdown"
                        >

                            <i class="bi bi-three-dots"></i>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">


                            <li>

                                @permission('categories.view')

                                <button 
                                    class="dropdown-item"
                                    onclick="ProductCategories.openInspector({{ $category->id }})"
                                >

                                    <i class="bi bi-eye"></i>

                                    View

                                </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('categories.update')

                                <button 
                                    class="dropdown-item"
                                    onclick="ProductCategories.edit({{ $category->id }})"
                                >

                                    <i class="bi bi-pencil"></i>

                                    Edit

                                </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('categories.update')

                                @if($category->status)

                                    <button
                                        class="dropdown-item text-warning"
                                        onclick="ProductCategories.openStatusModal(
                                            {{ $category->id }},
                                            'Disable',
                                            '{{ $category->name }}'
                                        )"
                                    >

                                        <i class="bi bi-power"></i>

                                        Disable

                                    </button>

                                @else

                                    <button
                                        class="dropdown-item text-success"
                                        onclick="ProductCategories.openStatusModal(
                                            {{ $category->id }},
                                            'Enable',
                                            '{{ $category->name }}'
                                        )"
                                    >

                                        <i class="bi bi-check-circle"></i>

                                        Enable

                                    </button>

                                @endif

                                @endpermission

                            </li>


                            @permission('categories.delete')

                            <li>

                                <hr class="dropdown-divider">

                            </li>

                            <li>

                                <button 
                                    class="dropdown-item text-danger"
                                    onclick="ProductCategories.openDeleteModal(
                                        {{ $category->id }},
                                        '{{ $category->name }}'
                                    )"
                                >

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </button>

                            </li>

                            @endpermission


                        </ul>


                    </div>


                </td>



            </tr>


        @empty



            <tr>


                <td 
                    colspan="7"
                    class="text-center py-5"
                >


                    <div class="category-empty-state">


                        <i class="bi bi-tags"></i>


                        <h5>
                            No Categories Found
                        </h5>


                        <p>
                            Create your first product category.
                        </p>


                    </div>


                </td>


            </tr>



        @endforelse



        </tbody>


    </table>


</div>





<!-- =====================================================
    PAGINATION
====================================================== -->


@if($categories->hasPages())


<div class="mt-3">


    {{ $categories->links() }}


</div>


@endif
