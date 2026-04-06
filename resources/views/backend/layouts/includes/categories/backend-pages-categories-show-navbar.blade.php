<div class="nav-align-top">
    <ul class="nav nav-pills d-flex flex-wrap gap-2 mb-4">
        <li class="nav-item">
            <a class="@if(request()->routeIs('backend.categories.show')) badge bg-primary @else badge bg-label-primary @endif" href="{{ route('backend.categories.show', $categorie->token) }}">
                <i class="icon-base ri ri-link-m icon-sm me-2"></i>Détails
            </a>
            <a class="@if(request()->routeIs('backend.categories.blogs')) badge bg-primary @else badge bg-label-primary @endif" href="{{ route('backend.categories.blogs', $categorie->token) }}">
                <i class="icon-base ri ri-link-m icon-sm me-2"></i>Blogs
            </a>
        </li>
    </ul>
    <div class="card mb-3">
        <div class="card-body">
            <div class="card academy-content shadow-none border">
                <div class="pt-3">
                    <div class="container">
                        <h5><b>Catégorie:</b> <a  href="{{ route('backend.categories.show', $categorie->token) }}" class="text-primary">{{$categorie->name}}</a></h5>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>
