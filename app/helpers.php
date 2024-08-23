<?php

if (! function_exists('flash')) {
    function flash($value, $type = 'info')
    {
        return session()->flash('flashMessage', [
            'message' => $value,
            'type' => $type,
        ]);
    }

}
