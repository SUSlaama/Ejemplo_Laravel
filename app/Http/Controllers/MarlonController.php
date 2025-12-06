<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class MarlonController extends Controller
{
    /**
     * Calcula la edad a partir de una fecha de nacimiento.
     *
     * @param string $date Formato Y-m-d
     * @return int|null Edad calculada
     */
    public function calculateAge(string $date): ?int
    {
        try {
            $birthDate = Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception $e) {
            return null;
        }

        if ($birthDate->isFuture()) {
            return null;
        }

        return $birthDate->age;
    }
}
