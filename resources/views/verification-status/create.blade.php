<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Verification Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-secondary-button :href="route('verification-status.verification-status')"
                class="mb-4">Kembali</x-secondary-button>
            <x-card>
                <form action="{{ route('verification-status.store') }}" method="POST"
                    class="w-full md:w-10/12 lg:w-1/2">
                    @csrf
                    <div>
                        <x-input-label for="curl_command" value="Curl Command" />
                        <x-textarea-input name="curl_command" id="curl_command" class="w-full  mt-1"
                            rows="8">{{old('curl_command')}}
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('curl_command')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-primary-button>
                            Save
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
