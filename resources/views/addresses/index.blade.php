@extends('layouts.app')

@section('title', 'Alamat Saya')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Alamat Saya
                </h1>
                <a href="{{ route('addresses.create') }}"
                    class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg transition-all">
                    <i class="fas fa-plus mr-2"></i>Tambah Alamat
                </a>
            </div>

            @if ($addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($addresses as $address)
                        <div
                            class="bg-white rounded-lg shadow-md p-6 {{ $address->is_default ? 'ring-2 ring-purple-600' : '' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-bold text-lg text-gray-900">{{ $address->label }}</span>
                                        @if ($address->is_default)
                                            <span class="bg-purple-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                                <i class="fas fa-star mr-1"></i>Utama
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('addresses.edit', $address) }}"
                                        class="text-blue-600 hover:text-blue-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus alamat ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="space-y-1 mb-4">
                                <p class="font-semibold text-gray-900">{{ $address->recipient_name }}</p>
                                <p class="text-gray-600 text-sm">
                                    <i class="fas fa-phone mr-1"></i>{{ $address->phone }}
                                </p>
                                <p class="text-gray-600 text-sm mt-2">{{ $address->address }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->city }}, {{ $address->province }}
                                    {{ $address->postal_code }}</p>
                                @if ($address->notes)
                                    <p class="text-gray-500 text-xs italic mt-2">
                                        <i class="fas fa-sticky-note mr-1"></i>{{ $address->notes }}
                                    </p>
                                @endif
                            </div>

                            @if (!$address->is_default)
                                <form action="{{ route('addresses.set-default', $address) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-purple-600 hover:text-purple-800 text-sm font-semibold transition-colors">
                                        <i class="fas fa-star mr-1"></i>Jadikan Alamat Utama
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-map-marker-alt text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Alamat Tersimpan</h3>
                    <p class="text-gray-500 mb-6">Tambahkan alamat untuk mempermudah proses checkout</p>
                    <a href="{{ route('addresses.create') }}"
                        class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-lg transition-all">
                        <i class="fas fa-plus mr-2"></i>Tambah Alamat Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
