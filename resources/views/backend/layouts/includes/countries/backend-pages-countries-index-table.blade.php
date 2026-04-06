@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des pays</h5>
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
                    <th>Drapeau</th>
                    <th>Nom</th>
                    <th>Code ISO</th>
                    <th>Indicatif</th>
                    <th>Continent</th>
                    <th>Actif ?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($countries as $country)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-center">
                        <img style="width: 40px; height: 30px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" src="{{ asset(getEnvFolder() . $country->path_img )}}" alt="{{ $country->name }}" title="{{ $country->name }}">
                    </td>
                    <td>
                        <a href="{{ route('backend.countries.show', $country->token) }}">
                            {{$country->name}}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-label-info me-1">{{$country->code}}</span>
                        <span class="badge bg-label-secondary">{{$country->code_2}}</span>
                    </td>
                    <td><span class="badge bg-label-success">{{$country->phone_code}}</span></td>
                    <td>
                        <a href="{{ route('backend.continents.show', $country->continent->token) }}" class="badge bg-primary">
                            {{$country->continent->name}}
                        </a>
                    </td>
                    <td>
                        @if($country->is_active == false)
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                        @if($country->is_active == true)
                            <span class="badge bg-success">Actif</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" id="delete-form-{{$country->token}}" action="#">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.countries.show', $country->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <a href="{{ route('backend.countries.edit', $country->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$country->token}}', 'Êtes-vous sûr de vouloir supprimer ce pays ?')">
                                <i class="icon-base ri ri-delete-bin-6-line icon-12px me-1"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="text-center">
                        <strong>Total : {{ $countries->count() }} pays</strong>
                    </td>
                </tr>
            </tfoot>
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
                order: [[2, 'asc']], // Tri par nom de pays par défaut
            });
        });
    </script>
@endsection()