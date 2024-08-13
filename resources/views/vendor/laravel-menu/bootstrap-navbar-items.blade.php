@foreach ($items as $item)
  <?php
  if ($item->hasChildren()) {
      if (
          $item
              ->children()
              ->where('isActive', true)
              ->first() !== null
      ) {
          $active = 'active';
      } else {
          $active = '';
      }
  } else {
      $active = '';
  }
  ?>
  <li @lm_attrs($item) @if ($item->hasChildren()) class="nav-item" @endif @lm_endattrs>
      @if ($item->link)
          <a @lm_attrs($item->link)
              class="nav-link {{$item->isActive ? ' active' : ''}}"
              @if ($item->hasChildren())
                  data-bs-toggle="collapse" role="button"
                  aria-expanded="{{ $active != '' ? 'true' : 'false' }}" aria-controls="collapseExample"
              @endif
              @lm_endattrs href="{!! $item->url() !!}">
          {!! $item->title !!}
          @if ($item->hasChildren())
              <i class="right-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.52389 4.02951C5.69475 3.85865 5.97176 3.85865 6.14261 4.02951L9.64261 7.52951C9.81347 7.70036 9.81347 7.97737 9.64261 8.14823L6.14261 11.6482C5.97176 11.8191 5.69475 11.8191 5.52389 11.6482C5.35304 11.4774 5.35304 11.2004 5.52389 11.0295L8.71453 7.83887L5.52389 4.64823C5.35304 4.47737 5.35304 4.20036 5.52389 4.02951Z" fill="currentColor" stroke="currentColor" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              </i>
          @endif
          </a>
      @else
      <span class="navbar-text">{!! $item->title !!}</span>
      @endif
      @if ($item->hasChildren())
          <ul class="sub-nav collapse  {{ $active != '' ? 'show' : '' }}" id="{!! str_replace('#', '', $item->link->attr()['href'] ?? '') !!}"
              data-bs-parent="{!! $item->link->attr()['data-bs-parent'] ?? '#sidebar-menu' !!}">
              @include(config('laravel-menu.views.bootstrap-items'), ['items' => $item->children()])
          </ul>
      @endif
    </li>
    @if ($item->divider)
        <li {!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
