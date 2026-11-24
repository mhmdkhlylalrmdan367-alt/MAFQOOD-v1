<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Melbedran\RolePermession\Support\AbilityManager;
use Illuminate\Support\Facades\Auth;
class Nav extends Component
{
    /**
     * Create a new component instance.
     */
    public $items;
    public function __construct(AbilityManager $abilities)
    {
        //
        $user = Auth::guard('admin')->user();
        $this->items = $abilities->filterNav(config('nav', []), $user);

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav',[
            'items' => $this->items
        ]);
    }
}
