<x-app-layout>
    
    <div class="text-gray-900 bg-teal-50 min-h-screen">
        @include('header')
        
        <div class="w-full h-[91vh] flex items-center justify-center">
            <div class="text-center bg-white p-6 rounded w-1/4">
                <h1 class="text-xl font-bold mb-4">Modifier utilisateur N°{{$user->id}}</h1>
                
                <form method="POST" action="{{ route('users.update', $user->id) }}" class="mt-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-left">Nom</label>
                        <input id="name" class="block mt-1 w-full border-gray-300 rounded px-3 py-2 border" 
                               type="text" name="name" value="{{ $user->name }}" required autofocus />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-left">Email</label>
                        <input id="email" class="block mt-1 w-full border-gray-300 rounded px-3 py-2 border" 
                               type="email" name="email" value="{{ $user->email }}" required />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 text-left">Rôle</label>
                        <select name="role" id="role" class="block mt-1 w-full border-gray-300 rounded px-3 py-2 border"
                                onchange="toggleVendeurField(this.value)">
                            <option value="dc" {{ $user->role == 'dc' ? 'selected' : '' }}>DC</option>
                            <option value="df" {{ $user->role == 'df' ? 'selected' : '' }}>DAF</option>
                            <option value="dg" {{ $user->role == 'dg' ? 'selected' : '' }}>DG</option>
                            <option value="comp" {{ $user->role == 'comp' ? 'selected' : '' }}>Comp</option>
                            <option value="sup" {{ $user->role == 'sup' ? 'selected' : '' }}>Superviseur</option>
                            <option value="comm" {{ $user->role == 'comm' ? 'selected' : '' }}>Commercial</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 hidden" id="vendeurField">
                      
                        <label for="vendeur_id" class="block text-gray-700 text-left">Vendeur</label>
                        <select name="zone" id="vendeur_id" class="block mt-1 w-full border-gray-300 rounded px-3 py-2 border" >
                            <option value="">Sélectionner la Zone</option>
                            @foreach($commerciaux as $commercial)
                            <option value="{{ $commercial->vendeur }}" {{ $user->zone == $commercial->vendeur ? 'selected' : '' }}>
                                {{ $commercial->vendeur }}
                            </option>
                        @endforeach
y                        
                        </select>
                        @error('vendeur_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('users.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded">Retour</a>
                        <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
       function toggleVendeurField(role) {
    const vendeurField = document.getElementById('vendeurField');
    if (role === 'comm') {
        vendeurField.classList.remove('hidden');
    } else {
        vendeurField.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const initialRole = document.getElementById('role').value;
    toggleVendeurField(initialRole);
});

    </script>
</x-app-layout>