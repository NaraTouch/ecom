<?php

namespace AppModule\Admin\Http\Controllers\Sales;

use Illuminate\Http\Request;
use AppModule\Admin\Http\Controllers\Controller;
use AppModule\Sales\Repositories\OrderRepository;
use AppModule\Sales\Repositories\InvoiceRepository;
use AppModule\Sales\Repositories\ShipmentRepository;
use AppModule\Sales\Repositories\OrderTransactionRepository;
use AppModule\Admin\DataGrids\OrderTransactionsDataGrid;
use AppModule\Payment\Facades\Payment;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \AppModule\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @param  \AppModule\Sales\Repositories\ShipmentRepository $shipmentRepository
     * @param  \AppModule\Sales\Repositories\OrderTransactionRepository  $orderTransactionRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected ShipmentRepository $shipmentRepository,
        protected OrderTransactionRepository $orderTransactionRepository
    )
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(OrderTransactionsDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Display a form to save the tranaction.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $payment_methods = Payment::getSupportedPaymentMethods();

        return view($this->_config['view'], compact('payment_methods'));
    }

    /**
     * Save the transaction.
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'invoice_id'     => 'required',
            'payment_method' => 'required',
            'amount'         => 'required|numeric',
        ]);

        $invoice = $this->invoiceRepository->where('increment_id', $request->invoice_id)->first();

        if (! $invoice) {
            session()->flash('error', trans('admin::app.sales.transactions.response.invoice-missing'));

            return redirect()->back();
        }

        $transactionAmtBefore = $this->orderTransactionRepository->where('invoice_id', $invoice->id)->sum('amount');
        
        $transactionAmtFinal = $request->amount + $transactionAmtBefore;

        if ($invoice->state == 'paid') {
            session()->flash('info', trans('admin::app.sales.transactions.response.already-paid'));

            return redirect(route('admin.sales.transactions.index'));
        }

        if ($transactionAmtFinal > $invoice->base_grand_total) {
            session()->flash('info', trans('admin::app.sales.transactions.response.transaction-amount-exceeds'));

            return redirect(route('admin.sales.transactions.create'));
        }
        
        if ($request->amount <= 0) {
            session()->flash('info', trans('admin::app.sales.transactions.response.transaction-amount-zero'));

            return redirect(route('admin.sales.transactions.create'));
        }

        $order = $this->orderRepository->find($invoice->order_id);

        $randomId = random_bytes(20);

        $this->orderTransactionRepository->create([
            'transaction_id' => bin2hex($randomId),
            'type'           => $request->payment_method,
            'payment_method' => $request->payment_method,
            'invoice_id'     => $invoice->id,
            'order_id'       => $invoice->order_id,
            'amount'         => $request->amount,
            'status'         => 'paid',
            'data'           => json_encode([
                'paidAmount' => $request->amount,
            ]),
        ]);

        $transactionTotal = $this->orderTransactionRepository->where('invoice_id', $invoice->id)->sum('amount');

        if ($transactionTotal >= $invoice->base_grand_total) {
            $shipments = $this->shipmentRepository->where('order_id', $invoice->order_id)->first();

            if (isset($shipments)) {
                $this->orderRepository->updateOrderStatus($order, 'completed');
            } else {
                $this->orderRepository->updateOrderStatus($order, 'processing');
            }

            $this->invoiceRepository->updateState($invoice, 'paid');
        }

        session()->flash('success', trans('admin::app.sales.transactions.response.transaction-saved'));

        return redirect(route('admin.sales.transactions.index'));
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $transaction = $this->orderTransactionRepository->findOrFail($id);

        $transData = json_decode(json_encode(json_decode($transaction['data'])), true);

        $transactionDetailsData = $this->convertIntoSingleDimArray($transData);

        return view($this->_config['view'], compact('transaction', 'transactionDetailsData'));
    }

    /**
     * Convert transaction details data into single dim array.
     *
     * @param array $data
     * @return array
     */
    public function convertIntoSingleDimArray($transData)
    {
        static $detailsData = [];

        foreach ($transData as $key => $data) {
            if (is_array($data)) {
                $this->convertIntoSingleDimArray($data);
            } else {
                $skipAttributes = ['sku', 'name', 'category', 'quantity'];

                if (gettype($key) == 'integer' || in_array($key, $skipAttributes)) {
                    continue;
                }

                $detailsData[$key] = $data;
            }
        }

        return $detailsData;
    }
}
