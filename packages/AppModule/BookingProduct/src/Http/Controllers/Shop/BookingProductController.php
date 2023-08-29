<?php

namespace AppModule\BookingProduct\Http\Controllers\Shop;

use AppModule\BookingProduct\Http\Controllers\Controller;
use AppModule\BookingProduct\Repositories\BookingProductRepository;
use AppModule\BookingProduct\Helpers\DefaultSlot as DefaultSlotHelper;
use AppModule\BookingProduct\Helpers\AppointmentSlot as AppointmentSlotHelper;
use AppModule\BookingProduct\Helpers\RentalSlot as RentalSlotHelper;
use AppModule\BookingProduct\Helpers\EventTicket as EventTicketHelper;
use AppModule\BookingProduct\Helpers\TableSlot as TableSlotHelper;

class BookingProductController extends Controller
{
    /**
     * @return array
     */
    protected $bookingHelpers = [];

    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\BookingProduct\Repositories\BookingProductRepository  $bookingProductRepository
     * @param  \AppModule\BookingProduct\Helpers\DefaultSlot $defaultSlotHelper
     * @param  \AppModule\BookingProduct\Helpers\AppointmentSlot  $appointmentSlotHelper
     * @param  \AppModule\BookingProduct\Helpers\RentalSlot  $rentalSlotHelper
     * @param  \AppModule\BookingProduct\Helpers\EventTicket   $EventTicketHelper
     * @param  \AppModule\BookingProduct\Helpers\TableSlot  $tableSlotHelper
     * @return void
     */
    public function __construct(
        protected BookingProductRepository $bookingProductRepository,
        DefaultSlotHelper $defaultSlotHelper,
        AppointmentSlotHelper $appointmentSlotHelper,
        RentalSlotHelper $rentalSlotHelper,
        EventTicketHelper $eventTicketHelper,
        TableSlotHelper $tableSlotHelper
    )
    {
        $this->bookingHelpers['default'] = $defaultSlotHelper;

        $this->bookingHelpers['appointment'] = $appointmentSlotHelper;

        $this->bookingHelpers['rental'] = $rentalSlotHelper;

        $this->bookingHelpers['event'] = $eventTicketHelper;

        $this->bookingHelpers['table'] = $tableSlotHelper;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingProduct = $this->bookingProductRepository->find(request('id'));

        return response()->json([
            'data' => $this->bookingHelpers[$bookingProduct->type]->getSlotsByDate($bookingProduct, request()->get('date')),
        ]);
    }
}