@extends('platform.layouts.app')

@section('title', 'Storefronts | EMNEX Control Center')
@section('page_context', 'Storefronts')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Online Commerce
        </span>

        <h1>
            Storefronts
        </h1>

        <p>
            Monitor the public stores connected to EMNEX and see
            their current operational state.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Total storefronts
        </span>

        <strong>
            {{ number_format($storefronts->total()) }}
        </strong>

    </div>

</section>


<div class="pc-storefront-grid">

    @forelse($storefronts as $storefront)

        <article class="pc-storefront-card">

            <div class="pc-storefront-card-top">

                <div class="pc-storefront-symbol">
                    <i class="bi bi-shop-window"></i>
                </div>

                <span
                    class="pc-status-pill {{ strtolower($storefront->status) }}"
                >
                    {{ $storefront->status }}
                </span>

            </div>


            <div class="pc-storefront-card-body">

                <span class="pc-storefront-company">
                    {{ $storefront->company?->name ?? 'Unknown company' }}
                </span>

                <h2>
                    {{ $storefront->name }}
                </h2>

                <span class="pc-storefront-slug">
                    /store/{{ $storefront->slug }}
                </span>

            </div>


            <div class="pc-storefront-stats">

                <div>

                    <span>
                        Online orders
                    </span>

                    <strong>
                        {{ number_format(
                            $orderCounts[$storefront->company_id] ?? 0
                        ) }}
                    </strong>

                </div>


                <div>

                    <span>
                        Enabled
                    </span>

                    <strong>
                        {{ $storefront->enabled_at?->format('d M Y') ?? '—' }}
                    </strong>

                </div>

            </div>


            <div class="pc-storefront-card-footer">

                <a
                    href="{{ route(
                        'platform.companies.show',
                        $storefront->company_id
                    ) }}"
                    class="pc-text-link"
                >
                    View company
                    <i class="bi bi-arrow-up-right"></i>
                </a>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    target="_blank"
                    class="pc-storefront-open"
                >
                    Open store
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>

            </div>

        </article>

    @empty

        <div class="pc-empty-state pc-empty-grid">
            No storefronts have been configured yet.
        </div>

    @endforelse

</div>


<div class="pc-pagination">
    {{ $storefronts->links() }}
</div>

@endsection