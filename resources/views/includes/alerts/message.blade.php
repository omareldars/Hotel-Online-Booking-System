<div>
    @if (Session::has('error'))
    <div class="alert round bg-danger alert-icon-left alert-dismissible mb-0" role="alert">
        <span class="alert-icon"><i class="fas fa-thumbs-down"></i></span>
        {{ Session::get('error') }}
    </div>
    @endif


    @if (Session::has('success'))
    <div class="alert round bg-success alert-icon-left alert-dismissible mb-0" role="alert">
        <span class="alert-icon"><i class="far fa-thumbs-up"></i></span>
        {{ Session::get('success') }}
    </div>
    @endif

</div>
