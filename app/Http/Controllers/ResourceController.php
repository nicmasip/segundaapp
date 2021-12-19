<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $request->session()->flush();
        $resources = [];
        if($request->session()->exists('resources')) {
            $resources = $request->session()->get('resources');
        }
        
        $enterprise = 'Products';
        $data = [];
        $data['resources'] = $resources;
        $data['enterprise'] = $enterprise;
        
        if($request->session()->exists('message')){
            $data['message'] = $request->session()->get('message');
            $type = 'success';
            if($request->session()->exists('type')){
                $data['type'] = $request->session()->get('type');
            }
        }
        
        return view('resource.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $enterprise = 'Products';
        $data = [];
        $data['enterprise'] = $enterprise;
        return view('resource.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = 0;
        $name = $request->input('name');
        $price = $request->input('price');
        $resources = [];
        
        if($request->session()->exists('resources')) {
            $resources = $request->session()->get('resources');
            foreach($resources as $key => $resource){
                if($key > $id){
                    $id = $key;
                }
            }
        }
        $id++;
        
        $resource = ['id' => $id, 'name' => $name, 'price' => $price];
        if(isset($resources[$id])){
            return back()->withInput();
        }
        else {
            $resources[$id] = $resource;
        }
        
        $request->session()->put('resources', $resources);
        return redirect('resource')->with('message', 'Se ha insertado el elemento correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->session()->exists('resources') && isset($request->session()->get('resources')[$id])){
            $resource = $request->session()->get('resources')[$id];
            $data = [];
            $data['resource'] = $resource;
            $data['enterprise'] = 'Products';
            return view('resource.show', $data);
        }
        else{
            return redirect('resource');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if($request->session()->exists('resources') && isset($request->session()->get('resources')[$id])){
            $resource = $request->session()->get('resources')[$id];
            // return view('resource.edit', ['resource' => $resource]);
            $data = [];
            $data['resource'] = $resource;
            $data['enterprise'] = 'Resources Ltd.';
            return view('resource.edit', $data);
        }
        else {
            return redirect('resource');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->session()->exists('resources')) {
            $resources = $request->session()->get('resources');
            if(isset($resources[$id])){
                $resource = $resources[$id];
                $idInput = $request->input('id');
                $nameInput = $request->input('name');
                $priceInput = $request->input('price');
                $resource['id'] = $idInput;
                $resource['name'] = $nameInput;
                $resource['price'] = $priceInput;
                
                if(isset($resources[$idInput]) && $id != $idInput){
                    return back()->withInput();
                }
                unset($resources[$id]);
                $resources[$idInput] = $resource;
                $request->session()->put('resources', $resources);
                
                return redirect('resource')->with('message', 'Se ha editado el elemento correctamente.');
            }
        }
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $message = 'No se ha borrado el elemento correctamente.';
        $type = 'danger';
        if($request->session()->exists('resources')){
            $resources = $request->session()->get('resources');
            if(isset($resources[$id])){
                unset($resources[$id]);
                $request->session()->put('resources', $resources);
                $message = 'Se ha borrado el elemento correctamente.';
                $type = 'success';
            }
        }
        $data = [];
        $data['message'] = $message;
        $data['type'] = $type;
        return redirect('resource')->with($data);
    }
}
