@extends('layouts.app')

@section('title', 'Nouveau Projet')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Creer un projet</h2>
        <a href="{{ route('projects.index') }}" class="text-sm font-bold text-gray-500 hover:text-red-500 transition">Annuler</a>
    </div>

    <form id="submitform" class="flex flex-col gap-4">
        @csrf

        <div class="flex flex-col">
            <label for="client_id" class="font-bold text-gray-700 mb-1 text-sm">Client</label>
            <select id="client_id" name="client_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                <option value="">-- Selectionner un client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                @endforeach
            </select>
            <span id="client_error" class="hidden text-red-500 text-xs mt-1 font-bold">Veuillez choisir un client</span>
        </div>

        <div class="flex flex-col">
            <label for="titre" class="font-bold text-gray-700 mb-1 text-sm">Nom du projet</label>
            <input type="text" id="titre" name="titre" placeholder="Ex: Migration Cloud" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <span id="titre_error" class="hidden text-red-500 text-xs mt-1 font-bold">Le nom du projet est obligatoire</span>
        </div>

        <div class="flex flex-col">
            <label for="description" class="font-bold text-gray-700 mb-1 text-sm">Description / Contexte</label>
            <textarea id="description" name="description" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="enveloppe" class="font-bold text-gray-700 mb-1 text-sm">Heures incluses</label>
                <input type="number" id="enveloppe" name="enveloppe" placeholder="Ex: 50" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <span id="enveloppe_error" class="hidden text-red-500 text-xs mt-1 font-bold">Indiquez un nombre d'heures</span>
            </div>

            <div class="flex flex-col">
                <label for="taux" class="font-bold text-gray-700 mb-1 text-sm">Taux horaire H. Supp</label>
                <input type="number" id="taux" name="taux" placeholder="Ex: 500" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <span id="taux_error" class="hidden text-red-500 text-xs mt-1 font-bold">Indiquez le taux horaire</span>
            </div>
        </div>

        <button type="submit" id="submit-btn" class="mt-4 bg-blue-600 text-white p-4 rounded-lg font-bold text-lg hover:bg-blue-700 shadow-md transform active:scale-95 transition">
            Enregistrer le projet
        </button>

        <div id="success" class="hidden mt-4 bg-green-500 text-white p-4 rounded-lg text-center font-bold shadow">
            Projet cree avec succes
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#submitform');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let hasErrors = false;
            const fields = [
                { id: 'client_id', error: 'client_error' },
                { id: 'titre', error: 'titre_error' },
                { id: 'enveloppe', error: 'enveloppe_error' },
                { id: 'taux', error: 'taux_error' }
            ];

            fields.forEach(field => {
                const input = document.querySelector('#' + field.id);
                const errorSpan = document.querySelector('#' + field.error);

                const isEmpty = input.value.trim() === '';
                const isNegative = input.type === 'number' && Number(input.value) <= 0;

                if (isEmpty || isNegative) {
                    errorSpan.classList.remove('hidden');
                    hasErrors = true;
                } else {
                    errorSpan.classList.add('hidden');
                }
            });

            if (!hasErrors) {
                const formData = new FormData(form);

                fetch("{{ route('projects.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('#submit-btn').classList.add('hidden');
                        document.querySelector('#success').classList.remove('hidden');

                        setTimeout(() => {
                            window.location.href = "{{ route('projects.index') }}";
                        }, 1200);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        });
    });
</script>
@endsection
