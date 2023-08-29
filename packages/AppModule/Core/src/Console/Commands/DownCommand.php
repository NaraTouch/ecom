<?php

namespace AppModule\Core\Console\Commands;

use Illuminate\Foundation\Console\DownCommand as OriginalCommand;
use AppModule\Core\Models\Channel;

class DownCommand extends OriginalCommand
{
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->downAllChannels();

        parent::handle();
    }

    /**
     * Update all channels.
     *
     * @return mixed
     */
    protected function downAllChannels()
    {
        $this->comment('All channels are down.');

        return Channel::query()->update(['is_maintenance_on' => 1]);
    }
}
