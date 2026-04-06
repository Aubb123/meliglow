@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des comptes</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="{{ route('backend.users.create') }}">
            Créer
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
                    <th>Nom complet</th>
                    <th>E-mail</th>
                    <th>Pays</th>
                    <th>Sexe</th>
                    <th>État</th>
                    <th>Rôle</th>
                    <th>Confirmer ?</th>
                    <th>Comment(s)</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{ route('backend.users.show', $user->token) }}">
                            <img style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;" src="{{ $user->getCoverImageUrl()['url_img'] }}" alt="">
                            {{$user->lastname}} {{$user->firstname}}
                        </a>
                    </td>
                    <td>{{$user->email}}</td>
                    <td><a href="{{ route('backend.countries.show', $user->country->token) }}" class="badge bg-secondary">{{$user->country->name}}</a></td>
                    <td>
                        @if($user->getSexeFrAttribute() == 'Homme')
                            <span class="badge text-bg-primary">HOMME</span>
                        @endif
                        @if($user->getSexeFrAttribute() == 'Femme')
                            <span class="badge text-bg-secondary">FEMME</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active == false)
                            <span class="badge rounded-pill text-bg-danger">Compte désactivé</span>
                        @endif
                        @if($user->is_active == true)
                            <span class="badge rounded-pill text-bg-success">Compte actif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('backend.roles.show', $user->role->token) }}" class="text-info">
                            {{ $user->role->label }}
                        </a>
                    </td>
                    <td>
                        @if($user->email_verified_at == null)
                            <span class="text-danger">Non confirmer </span>
                        @endif
                        @if($user->email_verified_at !== null)
                            <span class="text-success">Email confirmer</span>
                        @endif
                    </td>
                    <td><a href="{{ route('backend.users.comments', $user->token) }}" class="badge bg-label-primary">{{$user->comments ? $user->comments->count() : 0}} Comment(s)</a></td>
                    <td>
                        
                        <form method="POST" id="delete-form-{{$user->token}}" action="{{ route('backend.users.destroy', $user->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.users.show', $user->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <a href="{{ route('backend.users.edit', $user->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$user->token}}', 'Êtes-vous sûr de vouloir supprimer ce compte ?')">
                                <i class="icon-base ri ri-delete-bin-6-line icon-12px me-1"></i>
                            </button>
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