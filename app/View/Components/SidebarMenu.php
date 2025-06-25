<?php

namespace App\View\Components;

use App\Utils\MenuBuilder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarMenu extends Component
{
    public array $sidebars;
    /**
     * Create a new component instance.
     */
    public function __construct(MenuBuilder $menuBuilder)
    {
        $this->sidebars = self::filterSidebarByPermission($menuBuilder->listAllMenu());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-menu');
    }
    function filterSidebarByPermission(array $sidebars): array
    {
        return collect($sidebars)->map(function ($sidebar) {
            $menus = collect($sidebar['menu'] ?? [])->map(function ($menu) {
                if (!isset($menu['can'])) {
                    return null;
                }

                // Filter sub_menu jika ada
                if (isset($menu['submenu'])) {
                    $menu['submenu'] = collect($menu['submenu'])->filter(function ($sub) {
                        return collect($sub['can'] ?? [])
                            ->some(fn($perm) => request()->user()->hasOfficePermissionTo($perm));
                    })->values()->all();

                    // Jika tidak ada submenu yang lolos can, jangan tampilkan menu utama
                    return count($menu['submenu']) > 0 ? $menu : null;
                }

                return collect($menu['can'] ?? [])
                    ->some(fn($perm) => request()->user()->hasOfficePermissionTo($perm)) ? $menu : null;
            })->filter()->values()->all();

            return count($menus) > 0 ? [
                'group' => $sidebar['group'] ?? null,
                'menu' => $menus,
            ] : null;
        })->filter()->values()->all();
    }
}
