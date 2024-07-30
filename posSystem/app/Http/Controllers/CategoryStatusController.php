<?php

namespace App\Http\Controllers;

use App\Imports\CategoryStatusImport;
use Illuminate\Http\Request;
use App\Models\CategoryStatusModel;
use Maatwebsite\Excel\Facades\Excel;

class CategoryStatusController extends Controller
{
    public function index(){
        return view('admin.catalog.category_status');
    }
    public function store(){

    }

    public function getAll(){
        return CategoryStatusModel::all();
    }
    public function getName(){

        return response()->json(CategoryStatusModel::all());
    }

    //return a array of json with fields: id, name
    public static function getNameJson(){
        $json = CategoryStatusModel::select('id', 'name')->get();
        return json_encode($json);
    }

    public function importExcel(Request $request){
        if($request->hasFile('file_excel')){
            Excel::import(new CategoryStatusImport, $request->file('file_excel'));
            return view('admin.catalog.categories')->with('msg', 'Import successfully');
        }
        return redirect()->back()->with('msg','Excel file not found to be imported');
    }

}
