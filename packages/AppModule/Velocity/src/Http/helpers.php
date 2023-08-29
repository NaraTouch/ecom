<?php

if (! function_exists('velocity')) {
    /**
     * Velocity helper.
     *
     * @return \AppModule\Velocity\Velocity
     */
    function velocity()
    {
        return app()->make(\AppModule\Velocity\Velocity::class);
    }
}
