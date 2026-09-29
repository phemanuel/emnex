@extends(
    'storefront.public.themes.modern.layout'
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

<section class="modern-category-header">

    <div class="modern-container">


        {{-- Breadcrumb --}}

        <div class="modern-breadcrumb">

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


        {{-- Main Heading --}}

        <div class="modern-category-heading">

            <div class="modern-category-heading-copy">

                <span class="modern-category-eyebrow">
                    Category
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
                        Browse available products in
                        {{ $category->name }}.
                    </p>

                @endif

            </div>


            <div class="modern-category-count">

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
    SUBCATEGORIES
============================================================= --}}

@if($category->children->count())

<section class="modern-subcategories">

    <div class="modern-container">


        <div class="modern-subcategory-heading">

            <span>
                Explore further
            </span>

            <h2>
                Browse subcategories
            </h2>

        </div>


        <div class="modern-subcategory-grid">

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
                    class="modern-subcategory-card"
                >

                    <span class="modern-subcategory-icon">

                        {{ strtoupper(
                            mb_substr(
                                $child->name,
                                0,
                                1
                            )
                        ) }}

                    </span>


                    <span class="modern-subcategory-copy">

                        <strong>
                            {{ $child->name }}
                        </strong>

                        <small>
                            View products
                        </small>

                    </span>


                    <i class="bi bi-arrow-up-right"></i>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif



{{-- ============================================================
    PRODUCTS
============================================================= --}}

<section class="modern-category-products">

    <div class="modern-container">


        {{-- Results Header --}}

        <div class="modern-results-header">


            <div>

                <span>
                    Products
                </span>

                <h2>
                    {{ $category->name }}
                </h2>

            </div>


            <div class="modern-results-summary">

                <i class="bi bi-grid"></i>

                <span>

                    Showing

                    <strong>
                        {{ $products->count() }}
                    </strong>

                    of

                    <strong>
                        {{ $products->total() }}
                    </strong>

                </span>

            </div>

        </div>



        {{-- Product Area --}}

        @if($products->count())

            <div class="modern-category-layout">


                {{-- Desktop Sidebar --}}

                <aside class="modern-category-sidebar">


                    <div class="modern-sidebar-card">

                        <span class="modern-sidebar-label">
                            Shopping in
                        </span>

                        <strong>
                            {{ $category->name }}
                        </strong>


                        @if($category->description)

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $category->description,
                                    110
                                ) }}
                            </p>

                        @endif

                    </div>



                    @if($category->children->count())

                        <div class="modern-sidebar-card">

                            <span class="modern-sidebar-label">
                                Subcategories
                            </span>


                            <div class="modern-sidebar-links">

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



                    <div class="modern-sidebar-help">

                        <span>
                            <i class="bi bi-shield-check"></i>
                        </span>

                        <div>

                            <strong>
                                Shop confidently
                            </strong>

                            <p>
                                Availability shown reflects
                                current online stock.
                            </p>

                        </div>

                    </div>

                </aside>



                {{-- Product Grid --}}

                <div class="modern-category-results">

                    <div class="modern-product-grid">

                        @foreach(
                            $products
                            as $product
                        )

                            @include(
                                'storefront.public.themes.modern.partials.product-card',
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

                        <div class="modern-pagination">

                            {{ $products->links() }}

                        </div>

                    @endif

                </div>

            </div>


        @else

            <div class="modern-category-empty">

                <span class="modern-category-empty-icon">

                    <i class="bi bi-box-seam"></i>

                </span>


                <span class="modern-category-empty-label">
                    Empty category
                </span>


                <h2>
                    Nothing here yet.
                </h2>


                <p>
                    There are currently no products available
                    in {{ $category->name }}.
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