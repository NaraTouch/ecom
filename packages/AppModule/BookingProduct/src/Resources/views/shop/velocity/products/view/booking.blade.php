@if ($product->type == 'booking')

    @if ($bookingProduct = app('\AppModule\BookingProduct\Repositories\BookingProductRepository')->findOneByField('product_id', $product->id))

        @push('css')
            <link rel="stylesheet" href="{{ app_asset('css/velocity-booking.css') }}">
        @endpush

        <accordian :title="'{{ __('bookingproduct::app.shop.products.booking-information') }}'" :active="true">
            <div slot="header">
                <h3 class="no-margin display-inbl">
                    {{ __('bookingproduct::app.shop.products.booking-information') }}
                </h3>
                <i class="rango-arrow"></i>
            </div>

            <div slot="body">
                <booking-information></booking-information>        
            </div>
        </accordian>

        @push('scripts')

            <script type="text/x-template" id="booking-information-template">
                <div class="booking-information">

                    @if ($bookingProduct->location != '')
                        <div class="booking-info-row">
                            <span class="icon bp-location-icon"></span>
                            <span class="title">{{ __('bookingproduct::app.shop.products.location') }}</span>
                            <span class="value">{{ $bookingProduct->location }}</span>
                            <a href="https://maps.google.com/maps?q={{ $bookingProduct->location }}" target="_blank">View on Map</a>
                        </div>
                    @endif

                    @include ('bookingproduct::shop.products.view.booking.' . $bookingProduct->type, ['bookingProduct' => $bookingProduct])

                </div>
            </script>

            <script>
                Vue.component('booking-information', {
                    template: '#booking-information-template',

                    inject: ['$validator'],

                    data: function() {
                        return {
                            showDaysAvailability: false
                        }
                    }
                });
            </script>
        
        @endpush

    @endif

@endif