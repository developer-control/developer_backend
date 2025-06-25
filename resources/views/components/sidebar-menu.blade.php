@foreach ($sidebars as $key => $sidebar)
    @isset($sidebar['group'])
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ $sidebar['group'] }}</h6>
        </li>
    @endisset

    @foreach ($sidebar['menu'] as $menu)
        @isset($menu['submenu'])
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle {{ request()->routeIs($menu['active']) ? 'active' : '' }}"
                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="fas fa-user-cog fs-6"></span>
                    </div>
                    <span class="nav-link-text ms-1">{{ $menu['label'] }}</span>
                </a>
                <ul class="dropdown-menu bg-transparent mt-0 {{ request()->routeIs($menu['active']) ? 'show' : '' }}"
                    aria-labelledby="dropdownMenuButton">
                    @foreach ($menu['submenu'] as $submenu)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($submenu['active']) ? 'active' : '' }}"
                                href="{{ route($submenu['route']) }}">
                                <span class="fas fa-dot-circle ms-2 me-4"></span>
                                <span class="nav-link-text ms-1">{{ $submenu['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs($menu['active'])) active @endif" href="{{ route($menu['route']) }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="{{ $menu['icon'] }} fs-6"></span>
                    </div>
                    <span class="nav-link-text ms-1">{{ $menu['label'] }}</span>
                </a>
            </li>
        @endisset
    @endforeach
@endforeach
