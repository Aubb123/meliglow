@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des plateformes cloud</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="#">
            <i class="icon-base ri ri-add-line me-1"></i> {{ config('app.name') }}
        </a>
    </div>
</div>
<!--  -->
<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Libellé</th>
                    <th>Nom</th>
                    <th>Api-key</th>
                    <th>API Endpoint</th>
                    <th>Statut</th>
                    <th>Description</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cloudPlatforms as $platform)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $platform->label }}</td>
                    <td>
                        <a href="{{ route('backend.cloud_platforms.show', $platform->token) }}">
                            <strong>{{ $platform->name }}</strong>
                        </a>
                    </td>
                    <td>
                        @if($platform->api_key)
                            <span class="badge bg-secondary">{{ Str::limit($platform->api_key, 15) }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($platform->api_endpoint)
                            <a href="{{ $platform->api_endpoint }}" target="_blank">
                                {{ Str::limit($platform->api_endpoint, 40) }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($platform->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        {{ $platform->description ? Str::limit($platform->description, 50) : '—' }}
                    </td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($platform->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>
                        <a href="{{ route('backend.cloud_platforms.show', $platform->token) }}" class="btn btn-sm btn-warning">
                            <i class="icon-base ri ri-eye-line icon-12px me-1"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--  -->

@section('script')
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.print.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>' +
                     '<"row"<"col-md-12"tr>>' +
                     '<"row"<"col-md-5"l><"col-md-7"p>>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection()