<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer') }}
        </h2>
        <x-nav-link :href="route('customers.create')" :active="request()->routeIs('customers.create')">
            {{ __('Aggiungi') }}
        </x-nav-link>
    </x-slot>

    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->surname }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->stato }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}">Modifica</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>


