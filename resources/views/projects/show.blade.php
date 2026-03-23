@extends('layouts.app')

@section('title', 'Detail projet')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">Projet : {{ $project->name }}</h1>
            <p class="section-text">Client : {{ $project->client_name }}</p>
        </div>
        <a href="{{ route('projects.index') }}" class="button button--secondary">Retour a la liste</a>
    </div>

    <section class="stats-grid">
        <article class="stat-box">
            <p class="stat-box__label">Client</p>
            <p class="stat-box__value">{{ $project->client_name }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Enveloppe</p>
            <p class="stat-box__value">{{ $project->total_hours }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Consomme</p>
            <p class="stat-box__value">{{ number_format($heuresConsommees, 2) }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Restant</p>
            <p class="stat-box__value">{{ number_format($project->total_hours - $heuresConsommees, 2) }} h</p>
        </article>
    </section>

    <section class="panel panel--padded">
        <h2 class="section-title">Consultants rattaches</h2>
        <p class="section-text">{{ $project->consultants->pluck('name')->join(', ') ?: 'Aucun consultant rattache.' }}</p>
    </section>

    <section class="panel panel--padded">
        <h2 class="section-title">Description du projet</h2>
        <p class="section-text">{{ $project->description ?? 'Pas de description.' }}</p>
    </section>
</div>
@endsection
