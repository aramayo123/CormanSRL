<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <form action="{{ url('tareas/' . $tarea->id . '/cerrar') }}" method="post" class="max-w-xl mx-auto">
                        @csrf
                        <div class="mb-5">
                            <p class="block mb-2 text-md font-medium text-gray-900 ">Tipo de tarea :
                                <strong>{{ $tarea->tipo_de_tarea }}</strong>
                            </p>
                        </div>
                        @if ($tarea->tipo_de_tarea == 'CORRECTIVO')
                            <div class="mb-5 flex gap-2">
                                <div class="w-8/12">
                                    <p class="block mb-2 text-md font-medium text-gray-900 ">Remedy nro :
                                        <strong>{{ $tarea->ticket }}</strong>
                                    </p>
                                </div>
                                <div class="ml-5">
                                    <p class="block mb-2 text-md font-medium text-gray-900 ">ATM :
                                        <strong>{{ $tarea->Atm() }}</strong>
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="mb-5 flex">
                            <div class="w-1/2">
                                <p class="block mb-2 text-md font-medium text-gray-900 ">Cliente :
                                    <strong>{{ $tarea->Cliente->cliente }}</strong>
                                </p>
                            </div>
                            <div class="w-1/2">
                                <p class="block mb-2 text-md font-medium text-gray-900 ">Sucursal : <strong>
                                        {{ $tarea->Sucursal->sucursal }}</strong></p>
                            </div>
                        </div>
                        @if ($tarea->tipo_de_tarea == 'CORRECTIVO')
                            <div class="mb-5 ocultar">
                                <label for="fecha_cerrado"
                                    class="block mb-2 text-md font-medium text-gray-900 ">Seleccione
                                    la fecha de cierre <p class="inline-block text-red-500">*</p></label>
                                <input type="date" id="fecha_cerrado" name="fecha_cerrado"
                                    value="{{ $tarea->fecha_cerrado }}"
                                    class="hover:cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-md">
                                <x-mi-input-error :messages="$errors->get('fecha_cerrado')" />
                            </div>
                            <div class="mb-5 ocultar">
                                <p class="block mb-2 text-md font-medium text-gray-900 ">Prioridad : <strong>
                                        {{ $tarea->Prioridad->prioridad }}</strong></p>
                            </div>
                            <div class="mb-5">
                                <p class="block mb-2 text-md font-medium text-gray-900 ">Estado :
                                    <strong>{{ $tarea->Estado->estado }}</strong>
                                </p>
                            </div>
                        @endif
                        <p class="block mb-2 text-md font-medium text-gray-900 ">Subir fotos :</p>
                        @if ($tarea->tipo_de_tarea == 'CORRECTIVO')
                            <div class="mb-5 flex gap-4 flex-col md:flex-row">
                                <button data-modal-target="fotos-antes" data-modal-toggle="fotos-antes"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    ANTES</button>
                                <button data-modal-target="fotos-despues" data-modal-toggle="fotos-despues"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    DESPUES</button>
                                <button data-modal-target="fotos-ot" data-modal-toggle="fotos-ot"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    OT</button>
                                <button data-modal-target="fotos-boleta" data-modal-toggle="fotos-boleta"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    BOLETAS</button>
                            </div>
                        @else
                            <div class="mb-5 flex gap-4 flex-col md:flex-row">
                                <button data-modal-target="fotos-preventivo" data-modal-toggle="fotos-preventivo"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    PREVENTIVO</button>
                                <button data-modal-target="fotos-observaciones" data-modal-toggle="fotos-observaciones"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    OBSERVACIONES</button>
                                <button data-modal-target="fotos-boletas" data-modal-toggle="fotos-boletas"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    BOLETAS</button>
                                <button data-modal-target="fotos-ot-combustible"
                                    data-modal-toggle="fotos-ot-combustible"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    OT Y COMBUSTIBLE</button>
                                <button data-modal-target="fotos-planilla" data-modal-toggle="fotos-planilla"
                                    class="md:mx-auto text-center block text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
                                    type="button">
                                    PLANILLA</button>
                            </div>
                        @endif
                        <div class="mb-5">
                            <section class="bg-gray-50 mb-5 hidden" id="material_eliminado">
                                <div class="mx-auto max-w-screen-xl ">
                                    <div class="bg-white relative sm:rounded-lg overflow-hidden">
                                        <div class="">
                                            <div id="alert-3"
                                                class="flex items-center p-4 text-green-800 rounded-lg bg-green-200"
                                                role="alert">
                                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <div class="ml-3 text-sm font-medium">
                                                    <p>Material eliminado con exito!</p>
                                                </div>
                                                <button type="button"
                                                    class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 inline-flex items-center justify-center h-8 w-8 bg-green-200 text-green-800 hover:bg-green-300"
                                                    data-dismiss-target="#alert-3" aria-label="Close">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div id="table_material" class="mb-5">
                            </div>
                            <div
                                class="mb-5 p-5 bg-white relative border-solid border border-gray-300 rounded-lg sm:rounded-lg overflow-hidden">
                                <div class="mb-5">
                                    <label for="material_id"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Material: <p
                                            class="inline-block text-red-500">*</p> </label>
                                    <select id="material_id" name="material_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                        <option selected value="">Ninguna seleccion</option>
                                        @foreach ($materiales as $material)
                                            <option value="{{ $material->id }}" <?php echo old('material_id') == $material->id ? 'selected' : ''; ?>>
                                                {{ $material->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="error-material_id"
                                        class="hidden flex items-center my-2 text-red-800 rounded-lg " role="alert">
                                        <svg class="w-5 h-5 text-red-900 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3 text-sm font-medium" id="text-material_id"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="cantidad"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Cantidad: <p
                                            class="inline-block text-red-500">*</p> </label>
                                    <input type="number" id="cantidad" name="cantidad" value=""
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="" />
                                    <div id="error-cantidad"
                                        class="hidden flex items-center my-2 text-red-800 rounded-lg " role="alert">
                                        <svg class="w-5 h-5 text-red-900 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3 text-sm font-medium" id="text-cantidad"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="precio"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Precio: <p
                                            class="inline-block text-red-500">*</p> </label>
                                    <input type="number" id="precio" name="precio"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="" />
                                    <div id="error-precio"
                                        class="hidden flex items-center my-2 text-red-800 rounded-lg " role="alert">
                                        <svg class="w-5 h-5 text-red-900 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3 text-sm font-medium" id="text-precio"></div>
                                    </div>
                                    <div id="mensaje-exito"
                                        class="hidden flex items-center my-2 text-green-800 rounded-lg mt-5"
                                        role="alert">
                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="ml-3 text-sm font-medium">El material ha sido agregado con exito!
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="tarea_id" name="tarea_id" value="{{ $tarea->id }}" />
                                <div class="text-center mx-auto" onclick="CrearMaterial()">
                                    <button type="button"
                                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-blue-700 bg-blue-800 text-white border-blue-600 hover:text-white hover:bg-blue-700">
                                        AGREGAR PRESUPUESTO
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mx-auto text-center">
                            <button type="submit"
                                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-blue-700 bg-blue-800 text-white border-blue-600 hover:text-white hover:bg-blue-700">
                                CERRAR TRABAJO
                            </button>
                            <a href="{{ url('/') }}">
                                <button type="button"
                                    class="py-2.5 px-5 me-2 mb-2 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-red-700 bg-red-800 text-white border-red-600 hover:text-white hover:bg-red-700">
                                    CANCELAR
                                </button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ObtenerMateriales()
        });

        const ConfirmarEliminarMaterial = (form) => {
            const id = form.previousElementSibling.value;
            const material = form.nextElementSibling.value;
            Swal.fire({
                title: "Estas seguro?",
                text: `Estas a punto de eliminar el material "${material}"`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const EliminarMaterial = async () => {
                        const url = "{{ url('/tareas/materiales/') }}/" + id;
                        try {
                            const opciones = {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]')
                                        .getAttribute(
                                            'content'),
                                    'Accept': 'application/json',
                                },
                                method: 'DELETE',
                            }
                            const res = await fetch(url, opciones);
                            const data = await res.json();
                            const material_eliminado = document.querySelector("#material_eliminado");
                            material_eliminado.classList.remove("hidden");
                            ObtenerMateriales();
                        } catch (error) {
                            console.log(error)
                        }
                    }
                    EliminarMaterial();
                }
            });
        }

        var material = document.querySelector("#material_id");
        var tarea = document.querySelector("#tarea_id");
        var cantidad = document.querySelector("#cantidad");
        var precio = document.querySelector("#precio");
        const CrearMaterial = async () => {
            const formData = new FormData();
            const url = "{{ url('/tareas/materiales') }}";
            try {
                formData.append("material_id", material.value);
                formData.append("tarea_id", tarea.value);
                formData.append("cantidad", cantidad.value);
                formData.append("precio", precio.value);
                const opciones = {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    body: formData,
                };
                const res = await fetch(url, opciones);
                const data = await res.json();
                var error_material = document.querySelector("#error-material_id");
                var error_precio = document.querySelector("#error-precio");
                var error_cantidad = document.querySelector("#error-cantidad");
                error_material.classList.add("hidden");
                error_precio.classList.add("hidden");
                error_cantidad.classList.add("hidden");
                var text_material = document.querySelector("#text-material_id");
                var text_precio = document.querySelector("#text-precio");
                var text_cantidad = document.querySelector("#text-cantidad");
                console.log(data)
                if (data.message === "error") {
                    if (data.errors.material_id || data.errors.precio || data.errors.cantidad) {
                        if (data.errors.material_id) {
                            text_material.innerHTML = data.errors.material_id;
                            error_material.classList.remove("hidden");
                        }
                        if (data.errors.precio) {
                            text_precio.innerHTML = data.errors.precio;
                            error_precio.classList.remove("hidden");
                        }
                        if (data.errors.cantidad) {
                            text_cantidad.innerHTML = data.errors.cantidad;
                            error_cantidad.classList.remove("hidden");
                        }
                        return
                    }
                }
                if (data.message === "exito") {
                    error_material.classList.add("hidden");
                    error_precio.classList.add("hidden");
                    error_cantidad.classList.add("hidden");
                    mensaje_exito = document.querySelector("#mensaje-exito");
                    mensaje_exito.classList.remove("hidden");
                    material.value = "";
                    cantidad.value = "";
                    precio.value = "";
                    setTimeout(function() {
                        mensaje_exito.classList.add("hidden");
                    }, 3000);
                    ObtenerMateriales();
                    return
                }
            } catch (error) {
                console.log(error)
            }
        }

        function ObtenerMateriales() {
            var tabla = document.querySelector('#table_material');
            tabla.innerHTML = "";
            const getAll = async () => {
                try {
                    const formData = new FormData();
                    formData.append("tarea_id", tarea.value);
                    const url = "{{ url('materiales_gastados') }}";
                    const opciones = {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                        },
                        method: 'POST',
                        body: formData,
                    };
                    const res = await fetch(url, opciones);
                    const data = await res.json();
                    //console.log(data.message)

                    var registro = data.message;
                    var filas = "";
                    registro.forEach(material => {
                        filas += `
                        <tr class="border-b text-gray-900">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">${ material.nombre_material}</th>
                            <td class="px-1 py-1">$${ material.precio}</td>
                            <td class="px-1 py-1">${ material.cantidad}</td>
                            <td>
                                <input type="hidden" id="" name="" value="${material.id}">
                                <button type="button"onclick="ConfirmarEliminarMaterial(this)"
                                    class="hover:cursor-pointer hover:bg-gray-100 mt-1">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" 
                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                                <input type="hidden" id="" name="" value="${material.nombre_material}">
                            </td>
                        </tr>
                        `;
                    });

                    var principal = `
                        <div class="overflow-x-auto bg-white relative border-solid border border-gray-300 rounded-lg sm:rounded-lg overflow-hidden">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Material</th>
                                        <th scope="col" class="px-1 py-1">Precio</th>
                                        <th scope="col" class="px-1 py-1">Cantidad</th>
                                        <th scope="col">
                                            <span class="sr-only">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${filas}
                                </tbody>
                            </table>
                        </div>
                    `;
                    if (registro.length)
                        tabla.innerHTML = principal;

                } catch (error) {
                    console.log(error)
                }
            }
            getAll()
        }
    </script>
@if ($tarea->tipo_de_tarea == 'CORRECTIVO')
    <!-- antes modal -->
    <div id="fotos-antes" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos del antes
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-antes">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/foto_antes') }}" method="post" enctype="multipart/form-data"
                        id="imagen-antes" class="dropzone">
                        @csrf
                        <input type="hidden" name="ticket" id="ticket" value="{{ $tarea->ticket }}" />
                        <input type="hidden" name="atm" id="atm" value="{{ $tarea->atm }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- despues modal -->
    <div id="fotos-despues" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos del despues
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-despues">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/foto_despues') }}" method="post" enctype="multipart/form-data"
                        id="imagen-despues" class="dropzone">
                        @csrf
                        <input type="hidden" name="ticket" id="ticket" value="{{ $tarea->ticket }}" />
                        <input type="hidden" name="atm" id="atm" value="{{ $tarea->atm }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ot modal -->
    <div id="fotos-ot" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos del ot
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-ot">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/foto_ot') }}" method="post" enctype="multipart/form-data"
                        id="imagen-ot" class="dropzone">
                        @csrf
                        <input type="hidden" name="ticket" id="ticket" value="{{ $tarea->ticket }}" />
                        <input type="hidden" name="atm" id="atm" value="{{ $tarea->atm }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- boleta modal -->
    <div id="fotos-boleta" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos de boleta
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-boleta">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/foto_boleta') }}" method="post" enctype="multipart/form-data"
                        id="imagen-boleta" class="dropzone">
                        @csrf
                        <input type="hidden" name="ticket" id="ticket" value="{{ $tarea->ticket }}" />
                        <input type="hidden" name="atm" id="atm" value="{{ $tarea->atm }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Dropzone("#imagen-antes", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })

        new Dropzone("#imagen-despues", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })

        new Dropzone("#imagen-ot", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })

        new Dropzone("#imagen-boleta", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
    </script>

@else

    <!-- preventivo modal -->
    <div id="fotos-preventivo" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos del preventivo
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-preventivo">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/fotos_preventivo') }}" method="post"
                        enctype="multipart/form-data" id="imagen-preventivo" class="dropzone">
                        @csrf
                        <input type="hidden" name="sucursal" id="sucursal" value="{{ $tarea->Sucursal->numero }} {{ $tarea->Sucursal->sucursal }}" />
                        <input type="hidden" name="mes" id="mes" value="{{ $tarea->fecha_mail }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- observaciones modal -->
    <div id="fotos-observaciones" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos de las observaciones
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-observaciones">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/fotos_observaciones') }}" method="post"
                        enctype="multipart/form-data" id="imagen-observaciones" class="dropzone">
                        @csrf
                        <input type="hidden" name="sucursal" id="sucursal" value="{{ $tarea->Sucursal->numero }} {{ $tarea->Sucursal->sucursal }}" />
                        <input type="hidden" name="mes" id="mes" value="{{ $tarea->fecha_mail }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- boletas modal -->
    <div id="fotos-boletas" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos de las boletas
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-boletas">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/fotos_boleta') }}" method="post"
                        enctype="multipart/form-data" id="imagen-boletas" class="dropzone">
                        @csrf
                        <input type="hidden" name="sucursal" id="sucursal" value="{{ $tarea->Sucursal->numero }} {{ $tarea->Sucursal->sucursal }}" />
                        <input type="hidden" name="mes" id="mes" value="{{ $tarea->fecha_mail }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ot-combustible modal -->
    <div id="fotos-ot-combustible" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos de las ot y combustible
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-ot-combustible">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/fotos_ot_combustible') }}" method="post"
                        enctype="multipart/form-data" id="imagen-ot-combustible" class="dropzone">
                        @csrf
                        <input type="hidden" name="sucursal" id="sucursal" value="{{ $tarea->Sucursal->numero }} {{ $tarea->Sucursal->sucursal }}" />
                        <input type="hidden" name="mes" id="mes" value="{{ $tarea->fecha_mail }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- planilla modal -->
    <div id="fotos-planilla" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Subir fotos de las planillas
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
                        data-modal-toggle="fotos-planilla">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ url('/tareas/fotos_planilla') }}" method="post"
                        enctype="multipart/form-data" id="imagen-planilla" class="dropzone">
                        @csrf
                        <input type="hidden" name="sucursal" id="sucursal" value="{{ $tarea->Sucursal->numero }} {{ $tarea->Sucursal->sucursal }}" />
                        <input type="hidden" name="mes" id="mes" value="{{ $tarea->fecha_mail }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Dropzone("#imagen-preventivo", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
        new Dropzone("#imagen-observaciones", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
        new Dropzone("#imagen-boletas", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
        new Dropzone("#imagen-ot-combustible", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
        new Dropzone("#imagen-planilla", {
            maxFilesize: 100,
            acceptedFiles: "image/*,video/*",
            dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
            maxThumbnailFilesize: 200,
        })
    </script>

@endif
    

</x-app-layout>
