<?php

namespace App\View\Components\frontend;

use Illuminate\View\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $mobile = '';
    public $message = '';
    public $captcha = '';
    public $csrfHidden = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $email, $mobile, $message, $captcha, $csrfHidden)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->message = $message;
        $this->captcha = $captcha;
        $this->csrfHidden = $csrfHidden;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.contact-form');
    }
}
