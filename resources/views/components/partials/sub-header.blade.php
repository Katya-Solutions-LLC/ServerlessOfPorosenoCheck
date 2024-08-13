

<div class="iq-navbar-header navs-bg-color" style="height: 120px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="px-4">
                        <h2>{{ __($module_title ?? '') }}</h2>
                    </div>
                    <div>
                      @if (!isset($global_booking))
                        @endif
                      @yield('banner-button')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
    </div>
</div>
