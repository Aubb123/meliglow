<div class="col-12 col-lg-3">
    <div class="card p-6">
        <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
            <h5 class="mb-4">
                Détails role:
                <span class="fs-6 text-primary">{{$role->label}}</span>
            </h5>
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item mb-1">
                    <a class="nav-link waves-effect waves-light @if(request()->routeIs('backend.roles.show')) active @endif" href="{{ route('backend.roles.show', $role->token) }}">
                    <i class="icon-base ri ri-store-2-line icon-sm me-2"></i>
                    <span class="align-middle">Détails</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link waves-effect waves-light @if(request()->routeIs('backend.roles.users')) active @endif" href="{{ route('backend.roles.users', $role->token) }}">
                    <i class="icon-base ri ri-store-2-line icon-sm me-2"></i>
                    <span class="align-middle">Comptes ({{$role->users->count()}})</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>