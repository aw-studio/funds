 <div
     x-data="fileUpload"
     class="flex justify-center items-center border border-dashed bg-gray-50 rounded-md h-32 overflow-y-hidden"
     :class="imageUrl && 'border-primary-200'"
 >
     <template x-if="!imageUrl">
         <div class="space-y-1 text-center px-6 pt-5 pb-6 w-full">
             <svg
                 aria-hidden="true"
                 class="mx-auto h-12 w-12 text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 48 48"
             >
                 <path
                     d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     stroke-width="2"
                 />
             </svg>
             <div class="text-sm text-gray-600 dark:text-gray-400">
                 <label
                     class="relative cursor-pointer bg-transparent rounded-md font-medium text-orange-500 dark:text-pink-500"
                     for="post_image"
                 >
                     <p class="text-gray-500 dark:text-white space-y-1">
                         <span class="text-orange-500 dark:text-pink-500">Upload a file</span> or drag and drop
                         <span class="block text-xs text-gray-500">PNG, JPG up to *MB</span>
                     </p>
                 </label>
             </div>
         </div>
     </template>

     <template x-if="imageUrl">
         <div class="object-contain group relative">
             <div
                 class="hidden group-hover:flex absolute justify-center text-sm items-center m-auto text-white tracking-wider uppercase bg-transparent h-full w-full hover:bg-black/50 hover:cursor-pointer transition-background duration-100"
                 x-on:click="imageUrl = ''"
             >
                 Remove
             </div>
             <img
                 :src="imageUrl"
                 x-bind:class="{ 'hidden': !imageUrl, 'object-cover h-32': imageUrl }"
             >
         </div>
     </template>

     <input
         id="post_image"
         class="sr-only"
         name="image"
         type="file"
         x-on:change="selectFile"
     >
     <input
         id="post_header_delete"
         value="{{ $reward->getFirstMedia('image')?->id }}"
         name="post_header_delete"
         type="hidden"
     />
 </div>

 <script>
     document.addEventListener('alpine:init', () => {
         Alpine.data('fileUpload', () => ({
             imageUrl: @json($reward->getFirstMediaUrl('image', 'thumb')),

             selectFile(event) {
                 const file = event.target.files[0]
                 const reader = new FileReader()

                 if (event.target.files.length < 1) {
                     return
                 }

                 reader.readAsDataURL(file)

                 reader.onload = () => (this.imageUrl = reader.result)
             },
         }))
     })
 </script>
