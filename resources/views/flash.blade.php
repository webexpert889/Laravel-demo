@if( Session::has( 'success' ))
    <div class="alert alert-success" role="alert">
        <i class="mdi mdi-check-all me-2"></i>{{ Session::get( 'success' ) }}
    </div>
@elseif( Session::has( 'error' ))
    <!-- here to 'withWarning()' -->
    <div class="alert alert-danger" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>{{ Session::get( 'warning' ) }}
    </div>
@endif
