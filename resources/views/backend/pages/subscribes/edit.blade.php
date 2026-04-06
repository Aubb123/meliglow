@extends('backend/layouts/app')

@section('title')
    dashboard/subscribes/edit
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-12">
                <div class="card">
                    <h5 class="card-header">Formulaire de modification</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.subscribes.update', $subscribe->token) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" class="form-control" id="email" placeholder="exemple@gmail.com" value="{{ old('email', $subscribe->email) }}" disabled>
                                        <label for="email">Libellé</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="etat" id="etat" required>
                                            <option selected></option>
                                            <option class="text-secondary" value="0" {{ old('etat', $subscribe->etat) == '0' ? 'selected' : '' }}>Désabonnée</option>
                                            <option class="text-secondary" value="1" {{ old('etat', $subscribe->etat) == '1' ? 'selected' : '' }}>Abonnée</option>
                                        </select>                                        
                                        <label for="etat">État du compte</label>
                                        @error('etat') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Sauvegarder</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ Gamification Card -->
        </div>
    </div>
    <!-- / Content -->
@endsection()