<?php

namespace App\Http\Livewire\Traits;

use Jenssegers\Agent\Agent;

trait AgentLayoutTrait{

    public function getLayout()
    {
        $agent = new Agent();
        $layout = $agent->isMobile() ? 'layouts.mobile' : 'layouts.app';

        return $layout;
    }
}