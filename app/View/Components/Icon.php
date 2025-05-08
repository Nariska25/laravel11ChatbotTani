<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * The name of the icon.
     *
     * @var string
     */
    public $name;
    public $id;
    public $class;

    public function __construct($name, $id = null, $class = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.icon');
    }
}
