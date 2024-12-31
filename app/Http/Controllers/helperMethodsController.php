<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class helperMethodsController extends Controller
{
    function formatTextWithLinks($text)
    {
        return preg_replace(
            '~(http[s]?:\/\/[^\s]+)~i',
            '<a href="$1" target="_blank" style="color: #ed6b2f; text-decoration: underline;">$1</a>',
            e($text) // لضمان سلامة النص
        );
    }
}
