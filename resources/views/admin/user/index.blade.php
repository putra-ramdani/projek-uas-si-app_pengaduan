{{--
    Asumsi yang dipakai di file ini (sesuaikan kalau beda dengan project kamu):
    - Layout: layouts.admin  → ganti @extends kalau nama file layout kamu berbeda
    - Route: admin.users.index / admin.users.store / admin.users.update / admin.users.destroy
    - Kolom tabel users: name, email, no_telepon, role ('admin' | 'karyawan'), status ('aktif' | 'nonaktif'), gudang (relasi, opsional)
    - Variabel dari controller: $users (paginated), opsional $totalAdmin, $totalKaryawan, $totalAktif
--}}
@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola akun pengguna sistem pengaduan fasilitas')

@section('content')

    {{-- ============ STAT CARDS ============ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total User</p>
                <p class="text-xl font-bold leading-tight">{{ $users->total() ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Admin</p>
                <p class="text-xl font-bold leading-tight">{{ $totalAdmin ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">karyawan_gudang</p>
                <p class="text-xl font-bold leading-tight">{{ $totalkaryawan_gudang ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">User Aktif</p>
                <p class="text-xl font-bold leading-tight">{{ $totalAktif ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- ============ TOOLBAR ============ --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-1 gap-3">
            <div class="relative flex-1 max-w-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                       class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
            </div>

            <select name="role" onchange="this.form.submit()"
                    class="py-2.5 px-3 rounded-xl border border-gray-200 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-red-100">
                <option value="">Semua Role</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="karyawan_gudang" @selected(request('role') === 'karyawan_gudang')>karyawan_gudang</option>
            </select>
        </form>

        <button type="button" onclick="openModal('modalTambah')"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors duration-150 shadow-sm shadow-red-200">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah User
        </button>
    </div>

    {{-- ============ TABLE ============ --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                    <th class="text-left font-medium px-5 py-3 w-12">No</th>
                    <th class="text-left font-medium px-5 py-3">Nama</th>
                    <th class="text-left font-medium px-5 py-3">Email</th>
                    <th class="text-left font-medium px-5 py-3">No. HP</th>
                    <th class="text-left font-medium px-5 py-3">Role</th>
                    <th class="text-left font-medium px-5 py-3">Status</th>
                    <th class="text-right font-medium px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                        <td class="px-5 py-3.5 text-gray-400">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500">{{ $user->email }}</td>
                        <td class="px-5 py-3.5 text-gray-500">{{ $user->no_telepon ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            @if ($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">Admin</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600">karyawan_gudang</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @if (($user->status ?? 'aktif') === 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button"
                                        onclick='openEditModal(@json($user))'
                                        class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-blue-600 flex items-center justify-center transition-colors duration-150">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                <button type="button"
                                        onclick="openDeleteModal('{{ route('admin.users.destroy', $user->id) }}', '{{ $user->name }}')"
                                        class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition-colors duration-150">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-300">
                                <i class="fa-solid fa-user-slash text-3xl"></i>
                                <p class="text-sm text-gray-400">Belum ada data user</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif

    {{-- ============ MODAL: TAMBAH USER ============ --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold">Tambah User</h2>
                <button type="button" onclick="closeModal('modalTambah')" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">No. HP</label>
                    <input type="text" name="no_telepon"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Role</label>
                    <select name="role" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="karyawan_gudang">karyawan_gudang</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalTambah')"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow-sm shadow-red-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: EDIT USER ============ --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold">Edit User</h2>
                <button type="button" onclick="closeModal('modalEdit')" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" id="formEdit" action="" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_name" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                    <input type="email" name="email" id="edit_email" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">No. HP</label>
                    <input type="text" name="no_telepon" id="edit_no_telepon"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Role</label>
                    <select name="role" id="edit_role" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="karyawan_gudang">karyawan_gudang</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
                    <select name="status" id="edit_status" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEdit')"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow-sm shadow-red-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: HAPUS USER ============ --}}
    <div id="modalHapus" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h2 class="text-lg font-bold mb-1">Hapus User?</h2>
            <p class="text-sm text-gray-400 mb-6">
                Yakin ingin menghapus <span id="deleteUserName" class="font-medium text-gray-600"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>

            <form method="POST" id="formHapus" action="" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modalHapus')"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow-sm shadow-red-200">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditModal(user) {
            document.getElementById('edit_name').value = user.name ?? '';
            document.getElementById('edit_email').value = user.email ?? '';
            document.getElementById('edit_no_telepon').value = user.no_telepon ?? '';
            document.getElementById('edit_role').value = user.role ?? 'karyawan_gudang';
            document.getElementById('edit_status').value = user.status ?? 'aktif';

            const baseUrl = "{{ url('admin/users') }}";
            document.getElementById('formEdit').action = `${baseUrl}/${user.id}`;

            openModal('modalEdit');
        }

        function openDeleteModal(actionUrl, userName) {
            document.getElementById('formHapus').action = actionUrl;
            document.getElementById('deleteUserName').textContent = userName;
            openModal('modalHapus');
        }
    </script>

@endsection