<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Projets totaux</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalProjects }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Projets actifs</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $activeProjects }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Tickets</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalTickets }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Heures saisies</p>
                    <p class="mt-2 text-3xl font-bold text-orange-600">{{ number_format($totalHours, 2) }} h</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 lg:col-span-2">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
                        <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Voir tous les tickets</a>
                    </div>

                    <div class="mt-4 space-y-4">
                        @forelse ($recentTickets as $ticket)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <div>
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $ticket->title }}
                                    </a>
                                    <p class="text-sm text-gray-500">
                                        {{ $ticket->project->name }} • {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <span class="text-sm font-semibold text-orange-600">{{ number_format($ticket->hours_spent, 2) }} h</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Aucun ticket enregistré pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Résumé business</h3>
                    <p class="mt-4 text-sm text-gray-500">Chiffre d'affaires théorique</p>
                    <p class="mt-2 text-3xl font-bold text-green-600">{{ number_format($totalRevenue, 2, ',', ' ') }} €</p>

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('projects.create') }}" class="block rounded-lg bg-blue-600 px-4 py-3 text-center font-semibold text-white hover:bg-blue-700">
                            Nouveau projet
                        </a>
                        <a href="{{ route('tickets.create') }}" class="block rounded-lg border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700 hover:bg-gray-50">
                            Nouveau ticket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
