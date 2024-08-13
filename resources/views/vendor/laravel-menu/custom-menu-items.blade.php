@foreach ($items as $item)
    <li @lm_attrs($item) @if ($item->hasChildren()) class="nav-item"  @endif @lm_endattrs>
        <a
            @if($item->parent !== null) @lm_attrs($item)  @else @lm_attrs($item->link) @endif
                class="nav-link menu-arrow"
                @if ($item->hasChildren()) data-bs-toggle="collapse" @endif
            @lm_endattrs
            href="{!! $item->url() !!}">
            {!! $item->title !!}
            @if ($item->hasChildren())
                @if($item->parent !== null)
                    <i class="right-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.52389 4.02951C5.69475 3.85865 5.97176 3.85865 6.14261 4.02951L9.64261 7.52951C9.81347 7.70036 9.81347 7.97737 9.64261 8.14823L6.14261 11.6482C5.97176 11.8191 5.69475 11.8191 5.52389 11.6482C5.35304 11.4774 5.35304 11.2004 5.52389 11.0295L8.71453 7.83887L5.52389 4.64823C5.35304 4.47737 5.35304 4.20036 5.52389 4.02951Z" fill="currentColor" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </i>
                @endif
            @endif
        </a>
        @if ($item->hasChildren())
            <ul class="iq-header-sub-menu list-unstyled collapse">
                @include('vendor.laravel-menu.custom-menu-items', ['items' => $item->children()])
            </ul>
        @endif
    </li>
@endforeach
