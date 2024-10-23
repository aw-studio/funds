 @props(['video', 'campaign'])

 <div
     class="flex flex-col overflow-hidden pitch-video"
     x-data="{
         playing: false,
         paused: false,
         wasPlayed: false,
         get showPlayButton() {
             return true;
         }
     }"
     x-init="$watch('playing', (value) => {
         if (value) {
             $refs.video.play();
             wasPlayed = true;
         } else {
             $refs.video.pause()
         }
     })"
 >

     <div class="flex-shrink-0 relative video-container">
         <div
             id="overlay"
             class="absolute inset-0 w-full h-full z-10 pointer-events-none bg-black/30"
             x-show="!playing && wasPlayed"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100 "
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 "
             x-transition:leave-end="opacity-0 "
             x-cloak
         >
         </div>
         <video
             x-ref="video"
             loading="lazy"
             preload="none"
             poster="{{ $video->getUrl('thumb') }}"
             x-on:ended="playing = false"
         >
             <source src="{{ $video->getUrl() }}">
             Your browser does not support the video tag.
         </video>
         {{-- Play button --}}
         <div
             x-show="!playing"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="absolute inset-0 w-full h-full flex items-center justify-center play-pause-button"
             x-on:click="playing = true"
         >
             <svg
                 class="h-20 w-20 z-20 play-button"
                 viewBox="0 0 84 84"
             >
                 <circle
                     opacity="1"
                     cx="42"
                     cy="42"
                     r="42"
                     fill="currentColor"
                 ></circle>
                 <path
                     d="M55.5039 40.3359L37.1094 28.0729C35.7803 27.1869 34 28.1396 34 29.737V54.263C34 55.8604 35.7803 56.8131 37.1094 55.9271L55.5038 43.6641C56.6913 42.8725 56.6913 41.1275 55.5039 40.3359Z"
                     fill="white"
                 ></path>
             </svg>
         </div>
         {{-- Pause button --}}
         <div
             x-show="playing"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="absolute inset-0 w-full h-full flex items-center justify-center opacity-0 hover:opacity-100 play-pause-button"
             x-on:click="playing = false"
             x-cloak
         >
             <svg
                 class="h-20 w-20 z-20"
                 viewBox="0 0 84 84"
             >
                 <circle
                     opacity="1"
                     cx="42"
                     cy="42"
                     r="42"
                     fill="currentColor"
                 ></circle>
                 <rect
                     x="30"
                     y="25"
                     width="8"
                     height="34"
                     fill="white"
                 ></rect>
                 <rect
                     x="46"
                     y="25"
                     width="8"
                     height="34"
                     fill="white"
                 ></rect>
             </svg>
         </div>
     </div>
 </div>
