<!-- Activity Timeline -->
<div class="card mb-6">
    <h5 class="card-header">Paramètre: <span class="fs-6 text-primary">{{$user->lastname}} {{$user->firstname}}</span></h5> <hr class="m-0 p-0">
    <div class="card-body pt-0">
        <ul class="timeline mb-0 mt-2">
            <li class="nav-item mb-3">
                <a class="nav-link waves-effect waves-light @if(request()->routeIs('backend.users.show')) text-primary @endif" href="{{ route('backend.users.show', $user->token) }}">
                    <i class="icon-base ri ri-store-2-line icon-sm me-2"></i>
                    <span class="align-middle">Détails</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link waves-effect waves-light @if(request()->routeIs('backend.users.blogs')) text-primary @endif" href="{{ route('backend.users.blogs', $user->token) }}">
                    <i class="icon-base ri ri-store-2-line icon-sm me-2"></i>
                    <span class="align-middle">Blogs ({{$user->blogs->count()}})</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link waves-effect waves-light @if(request()->routeIs('backend.users.comments')) text-primary @endif" href="{{ route('backend.users.comments', $user->token) }}">
                    <i class="icon-base ri ri-store-2-line icon-sm me-2"></i>
                    <span class="align-middle">Commentaires ({{$user->comments->count()}})</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /Activity Timeline -->