<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de tareas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    @if ($message = Session::get('exito'))
                        <x-exito>
                            <x-slot:message>
                                {{ $message }}
                            </x-slot:message>
                        </x-exito>
                    @endif
                    @if ($message = Session::get('error'))
                        <x-error>
                            <x-slot:message>
                                {{ $message }}
                            </x-slot:message>
                        </x-error>
                    @endif
                    @include('tareas.table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
