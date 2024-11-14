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

if (! function_exists('page_title')) {
    function page_title(...$title): string
    {
        ray($title);

        return collect($title)->push(config('app.name'))->join(' | ');
    }
}
