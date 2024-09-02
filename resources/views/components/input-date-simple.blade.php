 <div>
     <style>
         ::-webkit-datetime-edit {}

         ::-webkit-datetime-edit-fields-wrapper {}

         ::-webkit-datetime-edit-text {
             padding: 0 0.05em;
         }

         ::-webkit-datetime-edit-month-field,
         ::-webkit-datetime-edit-day-field,
         ::-webkit-datetime-edit-year-field {
             color: gray
         }
     </style>
     <x-input {{ $attributes->merge(['type' => 'date']) }} />
 </div>
