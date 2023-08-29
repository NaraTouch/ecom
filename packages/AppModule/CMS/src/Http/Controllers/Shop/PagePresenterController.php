<?php

namespace AppModule\CMS\Http\Controllers\Shop;

use AppModule\CMS\Http\Controllers\Controller;
use AppModule\CMS\Repositories\CmsRepository;

class PagePresenterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\CMS\Repositories\CmsRepository  $cmsRepository
     * @return void
     */
    public function __construct(protected CmsRepository $cmsRepository)
    {
    }

    /**
     * To extract the page content and load it in the respective view file
     *
     * @param  string  $urlKey
     * @return \Illuminate\View\View
     */
    public function presenter($urlKey)
    {
        $page = $this->cmsRepository->findByUrlKeyOrFail($urlKey);

        return view('shop::cms.page')->with('page', $page);
    }
}