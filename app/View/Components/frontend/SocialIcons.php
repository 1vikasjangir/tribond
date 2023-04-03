<?php

namespace App\View\Components\frontend;

use Illuminate\View\Component;

class SocialIcons extends Component
{
    public $title = "";
    public $type = "";
    public $class = "";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $type, $class)
    {
        //
        $this->title = $title;
        $this->type = $type;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.social-icons');
    }
}
