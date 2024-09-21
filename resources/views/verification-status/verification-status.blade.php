<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Verification Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            @if(!$verificationStatus)
            <x-primary-button :href="route('verification-status.create')" class="mb-4">Buat</x-primary-button>
            @endif
            <x-card>
                <div class="relative overflow-x-auto shadow-md rounded-md">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Hasil Terakhir
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Terakhir Diperbarui
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($verificationStatus)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $verificationStatus->status }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$verificationStatus->updated_at->diffForHumans()}}
                                </th>
                                <td class="px-6 py-4">
                                    <a href="{{ route('verification-status.edit', $verificationStatus->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Edit
                                    </a>

                                    <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                        action="{{ route('verification-status.destroy', $verificationStatus->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit">Hapus</x-danger-button>
                                    </form>
                                </td>
                            </tr>
                            @else
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" colspan="3"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Belum ada data
                                </th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
