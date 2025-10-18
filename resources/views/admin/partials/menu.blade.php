<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" class="btn btn-ghost {{ request()->routeIs('admin.dashboard') ? 'bg-orange-100' : '' }}">
    <i class="fas fa-home"></i>
    Dashboard
</a>

<!-- Dynamic Menus -->
@foreach($adminMenus as $menu)
    @if($menu->children->count() > 0)
        <!-- Parent Menu with Children -->
        <div class="dropdown dropdown-hover">
            <label tabindex="0" class="btn btn-ghost normal-case hover:bg-orange-100">
                @if($menu->title == 'Master')
                    <i class="fas fa-cog"></i>
                @elseif($menu->title == 'Events')
                    <i class="fas fa-calendar"></i>
                @else
                    <i class="fas fa-folder"></i>
                @endif
                {{ $menu->title }}
                <i class="fas fa-chevron-down ml-1"></i>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[9999]">
                @foreach($menu->children as $child)
                    <li>
                        <a href="{{ $child->url }}"
                           class="{{ request()->is(ltrim($child->url, '/')) || request()->is(ltrim($child->url, '/*')) ? 'active' : '' }}">
                            @if($child->title == 'All Events')
                                <i class="fas fa-calendar"></i>
                            @elseif($child->title == 'Create Event')
                                <i class="fas fa-plus-circle"></i>
                            @elseif($child->title == 'Category')
                                <i class="fas fa-tags"></i>
                            @elseif($child->title == 'Pages')
                                <i class="fas fa-file-alt"></i>
                            @elseif($child->title == 'Partners')
                                <i class="fas fa-handshake"></i>
                            @elseif($child->title == 'Highlight Events')
                                <i class="fas fa-star"></i>
                            @else
                                <i class="fas fa-chevron-right"></i>
                            @endif
                            {{ $child->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <!-- Single Menu Item -->
        <a href="{{ $menu->url }}" class="btn btn-ghost {{ request()->is(ltrim($menu->url, '/')) || request()->is(ltrim($menu->url, '/*')) ? 'bg-orange-100' : '' }}">
            @if($menu->title == 'Master')
                <i class="fas fa-cog"></i>
            @elseif($menu->title == 'Events')
                <i class="fas fa-calendar"></i>
            @elseif($menu->title == 'Settings')
                <i class="fas fa-cog"></i>
            @else
                <i class="fas fa-folder"></i>
            @endif
            {{ $menu->title }}
        </a>
    @endif
@endforeach