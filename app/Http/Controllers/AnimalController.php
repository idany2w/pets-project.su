<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AnimalController extends Controller
{
    public function index()
    {
        $json = \App\Models\Animal::with('AnimalKind')->get()->transform(function($item){
            return [
                'kind' => $item->AnimalKind->kind,
                'name' => $item->name,
                'age' => $item->age,
                'size' => $item->size,
            ];
        });
        return response()->json($json);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kind' => 'required|exists:animal_kinds,kind'
        ]);

        if ($validator->fails()) {
            $json = [
                "error" => $validator->errors()->all(),
                "data" => "error"
            ];

            return response()->json($json, 422);
        }

        $animal = Animal::create([
            'name' => $request->name,
            'kind' => $request->kind,
            'age' => 1,
            'size' => 1,
        ]);

        if($animal){
            $json = [
                "error" => null,
                "data" => "ok",
            ];
            return response()->json($json);
        } else{
            $json = [
                "error" => true,
                "data" => "error",
            ];
            return response()->json($json, 500);
        }

    }

    public function show($name)
    {
        $animal = Animal::with('AnimalKind')->find($name);

        $json = [
            'name' => $animal->name,
            'kind' => $animal->AnimalKind->kind,
            'age' => $animal->age,
            'size' => $animal->size,
        ];

        return response()->json($json);
    }
    
    public function age(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:animals,name',
        ]);

        if ($validator->fails()) {
            $json = [
                "error" => $validator->errors()->all(),
                "data" => "error"
            ];

            return response()->json($json, 422);
        }

        $animal = Animal::with('AnimalKind')->find($request->name);

        $animal->age();

        $json = [
            "error" => null,
            "data" => "ok"
        ];

        return response()->json($json);
    }
}
