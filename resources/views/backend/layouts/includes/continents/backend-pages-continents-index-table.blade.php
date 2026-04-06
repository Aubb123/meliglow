@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des continents</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="#">
            {{ config('app.name') }}
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
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Population</th>
                    <th>Superficie (km²)</th>
                    <th>Ordre</th>
                    <th>Actif ?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($continents as $continent)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{ route('backend.continents.show', $continent->token) }}">
                            @if($continent->path_img)
                                <img style="width: 40px; height: 40px; border-radius: 100px;" src="{{ asset(getEnvFolder() . $continent->path_img )}}" alt="">
                            @endif
                            {{$continent->name}}
                        </a>
                    </td>
                    <td><span class="badge bg-label-info">{{$continent->code}}</span></td>
                    <td>{{ $continent->population ? number_format($continent->population, 0, ',', ' ') : 'N/A' }}</td>
                    <td>{{ $continent->area ? number_format($continent->area, 2, ',', ' ') : 'N/A' }}</td>
                    <td><span class="badge bg-secondary">{{$continent->sort_order}}</span></td>
                    <td>
                        @if($continent->is_active == false)
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                        @if($continent->is_active == true)
                            <span class="badge bg-success">Actif</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" id="delete-form-{{$continent->token}}" action="#">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.continents.show', $continent->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <a href="{{ route('backend.continents.edit', $continent->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$continent->token}}', 'Êtes-vous sûr de vouloir supprimer ce continent ?')">
                                <i class="icon-base ri ri-delete-bin-6-line icon-12px me-1"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <!-- Totale population et superficie -->
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="1"><strong><b>Total</b></strong></td>
                    <td><strong><b>{{ $continents->sum('population') ? number_format($continents->sum('population'), 0, ',', ' ') : 'N/A' }}</b></strong></td>
                    <td><strong><b>{{ $continents->sum('area') ? number_format($continents->sum('area'), 2, ',', ' ') : 'N/A' }}</b></strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>' +
                    '<"row"<"col-md-12"tr>>' +
                    '<"row"<"col-md-5"l><"col-md-7"p>>',
            });
        });
    </script>
@endsection()