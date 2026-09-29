@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    $category->name .
    ' | ' .
    $storefront->name
)


@section('content')


{{-- ================================================================
    CATEGORY HEADER
================================================================ --}}

<section class="bq-category-head">

    <div class="bq-shell">


        <div class="bq-breadcrumb">

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



        <div class="bq-category-head__main">

            <div>

                <span class="bq-eyebrow">
                    Collection
                </span>

                <h1>
                    {{ $category->name }}
                </h1>

            </div>


            <div class="bq-category-head__aside">

                @if($category->description)

                    <p>
                        {{ $category->description }}
                    </p>

                @endif

                <span>

                    {{ number_format(
                        $products->total()
                    ) }}

                    {{ Str::plural(
                        'item',
                        $products->total()
                    ) }}

                </span>

            </div>

        </div>

    </div>

</section>



{{-- ================================================================
    SUBCOLLECTIONS
================================================================ --}}

@if($category->children->count())

<section class="bq-category-subnav">

    <div class="bq-shell">

        <div class="bq-category-subnav__inner">

            <span class="bq-category-subnav__label">
                Explore
            </span>


            <div class="bq-category-subnav__links">

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



{{-- ================================================================
    PRODUCTS
================================================================ --}}

<section class="bq-category-products">

    <div class="bq-shell">


        <div class="bq-section-heading">

            <div>

                <span class="bq-eyebrow">
                    Browse
                </span>

                <h2>
                    {{ $category->name }}
                </h2>

            </div>


            <span class="bq-section-heading__meta">

                {{ number_format(
                    $products->total()
                ) }}

                {{ Str::plural(
                    'product',
                    $products->total()
                ) }}

            </span>

        </div>



        @if($products->count())

            <div class="bq-product-grid">

                @foreach(
                    $products
                    as $product
                )

                    @include(
                        'storefront.public.themes.boutique.partials.product-card',
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

                <div class="bq-pagination">

                    {{ $products->links() }}

                </div>

            @endif

        @else

            <div class="bq-empty">

                <i class="bi bi-bag"></i>

                <h3>
                    Nothing here yet.
                </h3>

                <p>
                    Try another collection or check back later.
                </p>

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#collections"
                    class="bq-button bq-button--dark"
                >
                    Browse collections
                </a>

            </div>

        @endif

    </div>

</section>


@endsection