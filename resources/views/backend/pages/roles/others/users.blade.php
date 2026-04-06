@extends('backend/layouts/app')

@section('title')
    dashboard/roles/users
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            @include('backend/layouts/includes/roles/backend-pages-roles-show-aside')

            <div class="col-12 col-lg-9">
                <div class="card mb-6">
                    @include('backend/layouts/includes/users/backend-pages-users-index-table')
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Autres informations</h5>
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