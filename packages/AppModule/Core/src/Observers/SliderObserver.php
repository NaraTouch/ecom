<?php

namespace AppModule\Core\Observers;

use Illuminate\Support\Facades\Storage;

class SliderObserver
{
    /**
     * Handle the Slider "deleted" event.
     *
     * @param  \AppModule\Core\Contracts\Slider $slider
     * @return void
     */
    public function deleted($slider)
    {
        Storage::delete($slider->path);
    }
}