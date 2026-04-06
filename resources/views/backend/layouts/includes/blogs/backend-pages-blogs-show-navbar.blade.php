<div class="nav-align-top">
    <ul class="nav nav-pills d-flex flex-wrap gap-2 mb-4">
        <li class="nav-item">
            <a class="@if(request()->routeIs('backend.blogs.show')) badge bg-primary @else badge bg-label-primary @endif" href="{{ route('backend.blogs.show', $blog->token) }}">
                <i class="icon-base ri ri-link-m icon-sm me-2"></i>Détails
            </a>
        </li>
        <li class="nav-item">
            <a class="@if(request()->routeIs('backend.blogs.comments')) badge bg-primary @else badge bg-label-primary @endif" 
            href="{{ route('backend.blogs.comments', $blog->token) }}">
                <i class="icon-base ri ri-link-m icon-sm me-2"></i>Commentaire(s)
            </a>
        </li>
    </ul>
    <div class="card mb-3">
        <div class="card-body">
            <div class="card academy-content shadow-none border">
                <div class="pt-3">
                    <div class="container">
                        <h5><b>Blog:</b> <a href="{{ route('backend.blogs.show', $blog->token) }}" class="text-primary">{{$blog->title}}</a></h5>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>