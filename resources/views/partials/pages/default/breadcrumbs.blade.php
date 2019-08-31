<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="inner" style="transform: translateY(0px); opacity: 1;">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $url => $title)
            <li><a href="{{ $url }}" class="active">{{ $title }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

