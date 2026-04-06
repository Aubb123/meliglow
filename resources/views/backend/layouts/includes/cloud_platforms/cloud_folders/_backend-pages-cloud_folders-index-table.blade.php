@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des dossiers cloud</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="{{ route('backend.cloud_folders.create', $platform->token) }}">
            <i class="icon-base ri ri-add-line me-1"></i> Ajouter un dossier
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
                    <th>Token</th>
                    <th>Nom du dossier</th>
                    <th>Plateforme</th>
                    <th>Chemin</th>
                    <th>Dossier parent</th>
                    <th>ID Cloud</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cloud_folders as $folder)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><code style="font-size: 0.78rem;">{{ $folder->token }}</code></td>
                    <td>
                        <a href="{{ route('backend.cloud_folders.show', $folder->token) }}">
                            <i class="icon-base ri ri-folder-line me-1 text-warning"></i>
                            {{ $folder->folder_name }}
                        </a>
                    </td>
                    <td>
                        @if($folder->cloudPlatform)
                            <a href="{{ route('backend.cloud_platforms.show', $folder->cloudPlatform->token) }}" class="badge bg-primary text-decoration-none">
                                <i class="icon-base ri ri-cloud-line me-1"></i>
                                {{ $folder->cloudPlatform->label }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($folder->path)
                            <span class="font-monospace" style="font-size: 0.8rem;">
                                <i class="icon-base ri ri-route-line me-1 text-muted"></i>
                                {{ $folder->path }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($folder->parentFolder)
                            <a href="{{ route('backend.cloud_folders.show', $folder->parentFolder->token) }}" class="badge bg-secondary text-decoration-none">
                                <i class="icon-base ri ri-folder-parent-line me-1"></i>
                                {{ Str::limit($folder->parentFolder->folder_name, 25) }}
                            </a>
                        @else
                            <span class="badge bg-label-success">Dossier racine</span>
                        @endif
                    </td>
                    <td>
                        @if($folder->folder_id)
                            <code style="font-size: 0.78rem;">{{ Str::limit($folder->folder_id, 20) }}</code>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($folder->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>
                        <form method="POST" id="delete-form-{{ $folder->token }}" action="{{ route('backend.cloud_folders.destroy', $folder->token) }}">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('backend.cloud_folders.show', $folder->token) }}" class="btn btn-sm btn-warning">
                                <i class="icon-base ri ri-eye-line icon-12px me-1"></i>
                            </a>
                        </form>
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