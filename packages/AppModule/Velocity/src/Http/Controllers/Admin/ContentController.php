<?php

namespace AppModule\Velocity\Http\Controllers\Admin;

use AppModule\Velocity\DataGrids\ContentDataGrid;
use AppModule\Velocity\Repositories\ContentRepository;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Velocity\Repositories\ContentRepository  $contentRepository
     * @return void
     */
    public function __construct(protected ContentRepository $contentRepository)
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
            return app(ContentDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $params = request()->all();

        if (isset($params['products'])) {
            $params['products'] = json_encode($params['products']);
        }

        $this->contentRepository->create($params);

        session()->flash('success', trans('velocity::app.admin.contents.create-successs'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = $this->contentRepository->findOrFail($id);

        return view($this->_config['view'], compact('content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AppModule\Product\Http\Requests\ProductForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $params = request()->all();

        if (isset($params[$params['locale']]['products'])) {
            $params[$params['locale']]['products'] = json_encode($params[$params['locale']]['products']);
        }

        $content = $this->contentRepository->update($params, $id);

        session()->flash('success', trans('velocity::app.admin.contents.update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = $this->contentRepository->findOrFail($id);

        try {
            $this->contentRepository->delete($id);

            return response()->json(['message' => trans('velocity::app.admin.contents.delete-success')]);
        } catch (\Exception $e) {}

        return response()->json(['message' => trans('velocity::app.admin.contents.delete-failed')], 400);
    }

    /**
     * Mass delete the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $contentIds = explode(',', request()->input('indexes'));

        foreach ($contentIds as $contentId) {

            $content = $this->contentRepository->find($contentId);

            if (isset($content)) {
                $this->contentRepository->delete($contentId);
            }
        }

        session()->flash('success', trans('velocity::app.admin.contents.mass-delete-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * To mass update the content.
     *
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        $contentIds = explode(',', request()->input('indexes'));
        
        $updateOption = request()->input('update-options');

        foreach ($contentIds as $contentId) {
            $content = $this->contentRepository->find($contentId);

            $content->update(['status' => $updateOption]);
        }

        session()->flash('success', trans('velocity::app.admin.contents.mass-update-success'));

        return redirect()->back();
    }
}
