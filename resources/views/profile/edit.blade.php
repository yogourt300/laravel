@extends('layouts.app')

@section('title', 'Profil')

@section('header')
    <h1 class="page-title">Profil</h1>
@endsection

@section('content')
<div class="profile-grid">
    <section class="panel panel--padded">
        @include('profile.partials.update-profile-information-form')
    </section>

    <section class="panel panel--padded">
        @include('profile.partials.update-password-form')
    </section>

    <section class="panel panel--padded">
        @include('profile.partials.delete-user-form')
    </section>
</div>
@endsection
