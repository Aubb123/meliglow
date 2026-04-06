@extends('backend/layouts/app')

@section('title') Roles - Détails @endsection()


@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
    
            @include('backend/layouts/includes/roles/backend-pages-roles-show-aside')

            <div class="col-12 col-lg-9">
                <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title m-0">Détails role:</h5>
                    </div>
                    <div class="card-body mt-3">
                    <ul class="timeline pb-0 mb-0">
                        <li class="timeline-item timeline-item-transparent border-primary">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-2">
                                    <h6 class="mb-0">{{$role->label}}</h6>
                                </div>
                                <p class="mt-1 mb-2">{!! $role->description !!}</p>
                            </div>
                            <div class="">
                                <a href="{{ route('backend.roles.show', $role->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                                <a href="{{ route('backend.roles.edit', $role->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Autres informations</h5>        
                    <hr class="m-0 p-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="defaultInput" class="form-label">Créer le:</label>
                            <input id="defaultInput" class="form-control" type="text" value="{{ mb_convert_case(\Carbon\Carbon::parse($role->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Autres informations</h5>        
                    <hr class="m-0 p-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="defaultInput" class="form-label">Dernière modification:</label>
                            <input id="defaultInput" class="form-control" type="text" value="{{ mb_convert_case(\Carbon\Carbon::parse($role->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->
@endsection()