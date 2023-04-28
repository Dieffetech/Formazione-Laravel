<x-app-layout>
<form method="POST" action="{{ route('customers.update', $customer->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required value="{{ $customer->name }}">
    </div>

    <div class="form-group">
        <label for="surname">Cognome</label>
        <input type="text" class="form-control" id="surname" name="surname" required value="{{ $customer->surname }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required value="{{ $customer->email }}">
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full"
                      type="password"
                      name="password"
                      autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                      type="password"
                      name="password_confirmation" autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="form-group">
        <label for="stato">Stato</label>
        <select class="form-control" id="stato" name="status" required>
            @foreach($customer->getStatus() as $key => $value)
                <option value="{{ $key }}" {{ $key == $customer->status ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success m-3 ">Aggiorna</button>
</form>

</x-app-layout>
