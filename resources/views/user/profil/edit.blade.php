@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex flex-col items-center mb-8">
            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-3xl font-bold mb-4">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
            <p class="text-gray-400">Karyawan Gudang</p>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                <i class="fa-solid fa-envelope text-red-500 w-6 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">Alamat Email</p>
                    <p class="font-medium text-sm">{{ auth()->user()->email }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                <i class="fa-solid fa-calendar text-red-500 w-6 text-center"></i>
                <div>
                    <p class="text-xs text-gray-400">Bergabung Sejak</p>
                    <p class="font-medium text-sm">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="#" class="block w-full text-center py-3 rounded-lg border border-red-600 text-red-600 font-bold hover:bg-red-50 transition-colors">
                Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection