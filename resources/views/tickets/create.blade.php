@extends('layouts.app')

@section('title', 'Nouveau Ticket')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Créer un Ticket</h2>
        <a href="{{ route('tickets.index') }}" class="text-sm font-bold text-gray-500 hover:text-red-500 transition">Annuler</a>
    </div>

    <form id="submitform" class="flex flex-col gap-4">
        @csrf
        {{-- Projet --}}
        <div class="flex flex-col">
            <label for="project_id" class="font-bold text-gray-700 mb-1 text-sm">Projet Associé</label>
            <select id="project_id" name="project_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                <option value="">-- Sélectionner le projet --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <span id="project_error" class="titanic text-red-500 text-xs mt-1 font-bold">⚠ Veuillez choisir un projet</span>
        </div>

        {{-- Titre du Ticket --}}
        <div class="flex flex-col">
            <label for="title" class="font-bold text-gray-700 mb-1 text-sm">Titre du ticket</label>
            <input type="text" id="title" name="title" placeholder="Ex: Debug menu responsive" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <span id="title_error" class="titanic text-red-500 text-xs mt-1 font-bold">⚠ Le titre du ticket est obligatoire</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Heures --}}
            <div class="flex flex-col">
                <label for="hours_spent" class="font-bold text-gray-700 mb-1 text-sm">Temps passé (h)</label>
                <input type="number" step="0.25" id="hours_spent" name="hours_spent" placeholder="Ex: 2.5" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <span id="hours_error" class="titanic text-red-500 text-xs mt-1 font-bold">⚠ Indiquez le temps passé</span>
            </div>

            {{-- Type --}}
            <div class="flex flex-col">
                <label for="type" class="font-bold text-gray-700 mb-1 text-sm">Type</label>
                <select id="type" name="type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="inclus">Inclus (Contrat)</option>
                    <option value="facturable">Facturable</option>
                </select>
            </div>
        </div>

        {{-- Description --}}
        <div class="flex flex-col">
            <label for="description" class="font-bold text-gray-700 mb-1 text-sm">Description du travail</label>
            <textarea id="description" name="description" rows="3" placeholder="Détaillez votre intervention..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        <button type="submit" id="submit-btn" class="mt-4 bg-blue-600 text-white p-4 rounded-lg font-bold text-lg hover:bg-blue-700 shadow-md transform active:scale-95 transition">
            Enregistrer le ticket
        </button>

        <div id="success" class="titanic mt-4 bg-green-500 text-white p-4 rounded-lg text-center font-bold shadow">
            ✓ Ticket créé avec succès !
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#submitform');
        
        form.addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            let hasErrors = false;
            // On adapte les IDs à vérifier
            const fields = [
                { id: 'project_id', error: 'project_error' },
                { id: 'title', error: 'title_error' },
                { id: 'hours_spent', error: 'hours_error' }
            ];

            fields.forEach(field => {
                const input = document.querySelector('#' + field.id);
                const errorSpan = document.querySelector('#' + field.error);
                
                const isEmpty = input.value.trim() === "";
                const isNegative = input.type === 'number' && input.value <= 0;

                if (isEmpty || isNegative) {
                    errorSpan.classList.remove('titanic');
                    hasErrors = true;
                } else {
                    errorSpan.classList.add('titanic');
                }
            });

            if (!hasErrors) {
                const formData = new FormData(form);

                fetch("{{ route('tickets.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json' // Crucial pour recevoir du JSON
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('#submit-btn').classList.add('titanic');
                        document.querySelector('#success').classList.remove('titanic');
                        
                        setTimeout(() => {
                            window.location.href = "{{ route('tickets.index') }}";
                        }, 1500);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        });
    });
</script>

{{-- N'oublie pas d'ajouter cette classe dans ton CSS si elle n'y est pas --}}
<style>
    .titanic { display: none; }
</style>
@endsection