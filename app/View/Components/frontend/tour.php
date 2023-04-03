<?php

namespace App\View\Components\frontend;

use Illuminate\View\Component;

class tour extends Component
{
    public $videoTours = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($videoTours)
    {
        //
        $this->videoTours = $videoTours;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.tour')->with('videoTours');
    }
}
