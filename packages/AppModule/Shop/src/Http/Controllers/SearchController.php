<?php

namespace AppModule\Shop\Http\Controllers;

use AppModule\Product\Repositories\ProductRepository;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Product\Repositories\ProductRepository  $productRepository
     * @return void
     */
    public function __construct(protected productRepository $productRepository)
    {
        parent::__construct();
    }

    /**
     * Index to handle the view loaded with the search results
     * 
     * @return \Illuminate\View\View 
     */
    public function index()
    {
        $results = [];

        request()->query->add([
            'name'  => request('term'),
            'sort'  => 'created_at',
            'order' => 'desc',
        ]);

        $results = $this->productRepository->getAll();

        return view($this->_config['view'])->with('results', $results->count() ? $results : null);
    }
}
