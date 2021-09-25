<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {

        $limit = $request->limit ?? 10;

        //建立查詢建構器
        $query = Animal::query();

        //programing logic for select
        if(isset($request->filters)){
            dump($request->filters);
            $filters = explode(',',$request->filters);
            dump($filters);
            foreach($filters as $key => $filter){
               list($key,$value) = explode(':',$filter);
               dump($key,$value);
               $query->where($key,'like',"%$value");
            }
        }
        $animals = $query->orderBy('id','desc')
        ->paginate($limit)
        ->appends($request->query());

        return response($animals,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $this->validate($request,[
        //     'type_id' => 'nullable|integer' ,
        //     'name' => 'required|string|max:255' ,
        //     'birthday' => 'nullable|date',
        //     'fix' => 'required|boolean',
        //     'description' => 'nullalbe',
        //     'personality' =>'nullable',
        //     'user_id' => 'required'
        // ]);

        $animal = Animal::create($request->all());
        $animal = $animal->refresh();
        return response($animal, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        return response($animal,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        $animal->update($request->all());
        return response($animal,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return response(null,204);
    }
}

