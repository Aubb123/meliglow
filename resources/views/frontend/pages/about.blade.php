@extends('frontend/layouts/master')

@section('title', 'À propos de ' . config('app.name'))

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'À propos de ' . config('app.name')])

    <br>

    @include('frontend/layouts/partials/_about')

    @include('frontend/layouts/partials/_choosing')

    @include('frontend/layouts/partials/_testimonial')

@endsection

