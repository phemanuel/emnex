@extends('storefront.public.layouts.app')


@section(
    'title',
    $category->name .
    ' | ' .
    $storefront->name
)


@section('content')


<section class="shop-category-hero">

    <div class="shop-shell">


        <div class="shop-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>

            <span>/</span>

            <span>
                {{ $category->name }}
            </span>

        </div>


        <div class="shop-category-hero-grid">


            <div>

                <span class="shop-eyebrow">
                    Category
                </span>

                <h1>
                    {{ $category->name }}
                </h1>

            </div>


            @if($category->description)

                <p>
                    {{ $category->description }}
                </p>

            @endif


        </div>

    </div>

</section>


@if($category->children->count())

<section class="shop-subcategory-section">

    <div class="shop-shell">

        <div class="shop-subcategory-list">

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

</section>

@endif


<section class="shop-category-products">

    <div class="shop-shell">


        <div class="shop-section-heading shop-section-heading-line">

            <div>

                <span>
                    Collection
                </span>

                <h2>
                    {{ $category->name }}
                </h2>

            </div>


            <p>

                {{ $products->total() }}

                {{ Str::plural(
                    'item',
                    $products->total()
                ) }}

            </p>

        </div>


        @if($products->count())

            <div class="shop-product-grid">

                @foreach(
                    $products as $product
                )

                    @include(
                        'storefront.public.partials.product-card',
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

                <div class="shop-pagination">

                    {{ $products->links() }}

                </div>

            @endif


        @else

            <div class="shop-empty">

                <span>
                    No products
                </span>

                <h3>
                    Nothing in this category yet.
                </h3>

                <p>
                    Try another category or check back later.
                </p>

            </div>

        @endif


    </div>

</section>


@endsection