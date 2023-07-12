<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableRowCategories extends Component
{
    public string $slug;
    public string $name;
    public string|null $parent;
    public string|null $description;

    /**
     * Create a new component instance.
     */
    public function __construct($slug, $name, $parent, $description)
    {
        $this->slug = $slug;
        $this->name = $name;
        $this->parent = $parent;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-row-categories');
    }
}
