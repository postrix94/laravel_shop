<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideNavLink extends Component
{
    public string $link;
    public string $name;
    public string|null $icon;
    /**
     * Create a new component instance.
     */
    public function __construct(string $link, string|null $icon = null, string $name)
    {
        $this->link = $link;
        $this->name = $name;
        $this->icon = $icon;
    }

    public function activeLink(): string{
        $isCurrentLink = request()->url() === $this->link;
        return $isCurrentLink
            ? 'active-item-sidebar'
            : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-nav-link');
    }
}
