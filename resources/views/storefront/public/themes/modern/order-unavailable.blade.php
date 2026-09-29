@extends('storefront.public.layouts.app')

@section('title', 'Order unavailable')

@section('content')

<div class="sf-order-error-page">

    <div class="container">

        <div class="sf-order-error-shell">

            <div class="sf-order-error-icon">

                <i class="bi bi-receipt"></i>

            </div>


            <span class="sf-order-error-kicker">
                Order unavailable
            </span>


            <h1>
                We couldn’t find this order
            </h1>


            <p>
                The order link may be invalid, expired, or the order may no longer be available.
            </p>


            <div class="sf-order-error-actions">

                @if($storefront)

                    <a
                        href="{{ route(
                            'storefront.public.home',
                            [
                                'storefrontSlug' =>
                                    $storefront->slug
                            ]
                        ) }}"
                        class="sf-order-primary-action"
                    >
                        <i class="bi bi-shop"></i>
                        Return to store
                    </a>

                @endif


                <button
                    type="button"
                    class="sf-order-secondary-action"
                    onclick="history.back()"
                >
                    <i class="bi bi-arrow-left"></i>
                    Go back
                </button>

            </div>


            <div class="sf-order-error-note">

                <i class="bi bi-info-circle"></i>

                <span>
                    If you completed a payment and believe this is an error,
                    contact the store with your payment reference.
                </span>

            </div>

        </div>

    </div>

</div>


<style>
.sf-order-error-page {
    min-height: 68vh;
    display: flex;
    align-items: center;
    padding: 60px 0;
    background:
        radial-gradient(
            circle at 50% 0%,
            rgba(37, 99, 235, .06),
            transparent 42%
        ),
        #ffffff;
}

.sf-order-error-shell {
    max-width: 560px;
    margin: 0 auto;
    text-align: center;
}

.sf-order-error-icon {
    width: 76px;
    height: 76px;
    margin: 0 auto 22px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #475569;
    font-size: 30px;
}

.sf-order-error-kicker {
    display: block;
    margin-bottom: 8px;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.sf-order-error-shell h1 {
    margin: 0 0 10px;
    color: #0f172a;
    font-size: 30px;
    font-weight: 700;
    letter-spacing: -.03em;
}

.sf-order-error-shell > p {
    max-width: 460px;
    margin: 0 auto;
    color: #64748b;
    font-size: 14px;
    line-height: 1.7;
}

.sf-order-error-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 28px;
}

.sf-order-primary-action,
.sf-order-secondary-action {
    min-height: 44px;
    padding: 0 18px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: .18s ease;
}

.sf-order-primary-action {
    border: 1px solid #0f172a;
    background: #0f172a;
    color: #ffffff;
}

.sf-order-primary-action:hover {
    background: #1e293b;
    color: #ffffff;
}

.sf-order-secondary-action {
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #334155;
    cursor: pointer;
}

.sf-order-secondary-action:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
}

.sf-order-error-note {
    max-width: 480px;
    margin: 30px auto 0;
    padding: 14px 16px;
    border: 1px solid #e8edf3;
    border-radius: 12px;
    display: flex;
    align-items: flex-start;
    gap: 9px;
    background: #f8fafc;
    color: #64748b;
    text-align: left;
    font-size: 11px;
    line-height: 1.6;
}

.sf-order-error-note i {
    margin-top: 2px;
    color: #64748b;
}


@media (max-width: 575.98px) {

    .sf-order-error-page {
        min-height: 62vh;
        padding: 42px 0;
    }

    .sf-order-error-shell h1 {
        font-size: 24px;
    }

    .sf-order-error-actions {
        flex-direction: column;
    }

    .sf-order-primary-action,
    .sf-order-secondary-action {
        width: 100%;
    }

}
</style>

@endsection