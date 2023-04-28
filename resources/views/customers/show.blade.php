<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dettagli cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <div class="my-2">
                                <span class="font-bold">Nome:</span> {{ $customer->name }}
                            </div>
                            <div class="my-2">
                                <span class="font-bold">Cognome:</span> {{ $customer->surname }}
                            </div>
                            <div class="my-2">
                                <span class="font-bold">Email:</span> {{ $customer->email }}
                            </div>
                            <div class="my-2">
                                <span class="font-bold">Stato:</span> {{ $customer->status }}
                            </div>
                            <div class="my-2">
                                <span class="font-bold">Creato il:</span> {{ $customer->created_at->format('d/m/Y H:i:s') }}
                            </div>
                            <div class="my-2">
                                <span class="font-bold">Aggiornato il:</span> {{ $customer->updated_at->format('d/m/Y H:i:s') }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary mr-2">Modifica</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
