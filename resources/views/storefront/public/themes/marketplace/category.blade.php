@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    $category->name .
    ' | ' .
    $storefront->name
)


@section('content')


{{-- ============================================================
    CATEGORY HEADER
============================================================= --}}

<section class="marketplace-category-header">

    <div class="marketplace-container">


        {{-- Breadcrumb --}}

        <div class="marketplace-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>


            <i class="bi bi-chevron-right"></i>


            <span>
                {{ $category->name }}
            </span>

        </div>



        <div class="marketplace-category-header-grid">


            <div class="marketplace-category-title">


                <span class="marketplace-category-label">

                    <i class="bi bi-grid"></i>

                    Department

                </span>


                <h1>
                    {{ $category->name }}
                </h1>


                @if($category->description)

                    <p>
                        {{ $category->description }}
                    </p>

                @else

                    <p>
                        Browse available products
                        in {{ $category->name }}.
                    </p>

                @endif

            </div>



            <div class="marketplace-category-count">


                <strong>

                    {{ number_format(
                        $products->total()
                    ) }}

                </strong>


                <span>

                    {{ \Illuminate\Support\Str::plural(
                        'product',
                        $products->total()
                    ) }}

                </span>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    CHILD CATEGORY RAIL
============================================================= --}}

@if($category->children->count())

<section class="marketplace-subcategory-rail">

    <div class="marketplace-container">

        <div class="marketplace-subcategory-rail-inner">


            <span class="marketplace-subcategory-rail-label">

                <i class="bi bi-diagram-3"></i>

                Browse sections

            </span>



            <div class="marketplace-subcategory-rail-links">

                @foreach(
                    $category->children
                    as $child
                )

                    <a
                        href="{{ route(
                            'storefront.public.category',
                            [
                                'storefrontSlug' =>
                                    $storefront->slug,

                                'categoryCode' =>
                                    $child->category_code,
                            ]
                        ) }}"
                    >

                        {{ $child->name }}

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endif



{{-- ============================================================
    CATEGORY PRODUCTS
============================================================= --}}

<section class="marketplace-category-products">

    <div class="marketplace-container">


        {{-- ====================================================
            PRODUCT HEADER
        ===================================================== --}}

        <div class="marketplace-results-heading">


            <div>

                <span>
                    Product catalogue
                </span>


                <h2>
                    {{ $category->name }}
                </h2>


                <p>

                    Showing

                    <strong>
                        {{ $products->count() }}
                    </strong>

                    of

                    <strong>
                        {{ $products->total() }}
                    </strong>

                    products

                </p>

            </div>



            <div class="marketplace-results-status">

                <span>

                    <i class="bi bi-box-seam"></i>

                    Live availability

                </span>

            </div>

        </div>



        @if($products->count())


            <div class="marketplace-category-layout">


                {{-- =============================================
                    DEPARTMENT SIDEBAR
                ============================================== --}}

                <aside class="marketplace-category-sidebar">


                    <div class="marketplace-sidebar-card">


                        <span class="marketplace-sidebar-label">
                            Current department
                        </span>


                        <strong>
                            {{ $category->name }}
                        </strong>


                        @if($category->description)

                            <p>

                                {{ \Illuminate\Support\Str::limit(
                                    $category->description,
                                    120
                                ) }}

                            </p>

                        @endif

                    </div>



                    @if($category->children->count())

                        <div class="marketplace-sidebar-card">


                            <span class="marketplace-sidebar-label">
                                Sections
                            </span>


                            <div class="marketplace-sidebar-links">

                                @foreach(
                                    $category->children
                                    as $child
                                )

                                    <a
                                        href="{{ route(
                                            'storefront.public.category',
                                            [
                                                'storefrontSlug' =>
                                                    $storefront->slug,

                                                'categoryCode' =>
                                                    $child->category_code,
                                            ]
                                        ) }}"
                                    >

                                        <span>
                                            {{ $child->name }}
                                        </span>


                                        <i class="bi bi-chevron-right"></i>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @endif



                    <div class="marketplace-sidebar-help">


                        <span>

                            <i class="bi bi-shield-check"></i>

                        </span>


                        <div>

                            <strong>
                                Shop current stock
                            </strong>


                            <p>
                                Availability shown reflects
                                current online inventory.
                            </p>

                        </div>

                    </div>

                </aside>



                {{-- =============================================
                    PRODUCT RESULTS
                ============================================== --}}

                <div class="marketplace-category-results">


                    <div class="marketplace-product-grid">

                        @foreach(
                            $products
                            as $product
                        )

                            @include(
                                'storefront.public.themes.marketplace.partials.product-card',
                                [
                                    'product' =>
                                        $product,

                                    'storefront' =>
                                        $storefront,

                                    'currencySymbol' =>
                                        $currencySymbol,
                                ]
                            )

                        @endforeach

                    </div>



                    @if($products->hasPages())

                        <div class="marketplace-pagination">

                            {{ $products->links() }}

                        </div>

                    @endif

                </div>

            </div>


        @else


            {{-- =================================================
                EMPTY STATE
            ================================================== --}}

            <div class="marketplace-category-empty">


                <span class="marketplace-category-empty-icon">

                    <i class="bi bi-box-seam"></i>

                </span>


                <span class="marketplace-category-empty-label">
                    No products
                </span>


                <h2>
                    Nothing in this category yet.
                </h2>


                <p>
                    Try another department or check back
                    later for newly available products.
                </p>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                >

                    Browse all products

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        @endif

    </div>

</section>


@endsection