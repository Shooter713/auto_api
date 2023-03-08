<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AutoController extends Controller
{

    public function index(Request $request)
    {
        if(isset($request->key) && $request->key){
            $auto = Auto::orderBy($request->key, $request->sort)->paginate(5);
        }elseif(isset($request->search) && $request->search){
            $auto = Auto::where(function ($query) use ($request){
                return $query
                    ->orWhere('id', $request->search)
                    ->orWhere('user_name', $request->search)
                    ->orWhere('state_number', $request->search)
                    ->orWhere('color', $request->search)
                    ->orWhere('vin_code', $request->search);
            })->paginate(5);
        }else{
            $auto = Auto::paginate(5);
        }

        return view('auto.view',[
            'auto'=>$auto,
            'sort_key'=> $request->key ?? false,
            'sort_sort'=> $request->sort ?? false,
        ]);
    }

    public function addAuto(Request $request)
    {

        Auto::updateOrCreate([
            'vin_code'      =>$request->vin_code,
        ],[

            'user_name'     =>$request->user_name,
            'state_number'  =>$request->state_number,
            'color'         =>$request->color,

        ]);

        return response()->json(['result'=>true], 200);
    }

    public function deleteAuto(Request $request)
    {
        Auto::where('id', $request->id)->delete();

        return response()->json(array('delete' => true), 200);
    }

}
























