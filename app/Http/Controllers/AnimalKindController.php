<?php

namespace App\Http\Controllers;

use App\Models\AnimalKind;
use Illuminate\Http\Request;

class AnimalKindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $json = AnimalKind::all()->transform(function($item){
            return [
                'kind' => $item->kind,
                'max_size' => $item->max_size,
                'max_age' => $item->max_age,
                'growth_factor' => $item->growth_factor,
            ];
        });
        return response()->json($json);
    }
}
