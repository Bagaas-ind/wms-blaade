<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('suppliers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        + Tambah Supplier
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">No</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Supplier</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Telepon</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Alamat</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $index => $supplier)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $suppliers->firstItem() + $index }}</td>
                                <td class="py-3 px-4 border-b font-medium">{{ $supplier->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $supplier->phone ?? '-' }}</td>
                                <td class="py-3 px-4 border-b">{{ $supplier->address ?? '-' }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus supplier ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data supplier.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $suppliers->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>