<?php

namespace App\Http\Controllers;

class OperationsController extends Controller
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }
}
