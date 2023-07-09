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

    protected function checkCurrentLink(): array {
        $isCurrentLink = request()->url() === $this->link;
        $iconClasses = $isCurrentLink
            ? 'bg-gradient-to-tl from-purple-700 to-pink-500 font-white text-white'
            : '';
        $linkClasses = $isCurrentLink
            ? 'shadow-soft-xl bg-white'
            : '';

        return [$iconClasses, $linkClasses];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        list($iconClasses, $linkClasses) = $this->checkCurrentLink();
        return view('components.side-nav-link',compact('iconClasses', 'linkClasses'));
    }
}
