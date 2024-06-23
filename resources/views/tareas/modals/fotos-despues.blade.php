 <!-- despues modal -->
 <div id="fotos-despues" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative p-4 w-full sm:w-2/3">
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
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                     <input type="hidden" name="tarea_id" id="tarea_id" value="{{ $tarea->id }}" />
                     <div class="dz-default dz-message text-white">
                         <button class="dz-button" type="button">Arrastra y
                             suelta los archivos aqui o haz click aqui
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <script>
     new Dropzone("#imagen-despues", {
         maxFilesize: 10000,
         acceptedFiles: "image/*,video/*",
         dictDefaultMessage: "Arrastra y suelta los archivos aqui o haz click aqui",
         maxThumbnailFilesize: 200,
         success(file) {
             if (file.previewElement) {
                 ObtenerImagenes()
                 return file.previewElement.classList.add("dz-success");
             }
         },
     })
 </script>
