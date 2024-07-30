<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Imports\CategoryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ImageController;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    //
    public function __construct(){

    }
    public function index(){
        return view('admin.catalog.categories');
    }
    public function addCategoryIndex(){
        return view('admin.catalog.add_category');
    }
    public function importCategoryIndex(){
        return view('admin.catalog.categories_import');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:255|regex:/^[A-Za-z\d ]+$/',//,
            'description' => 'regex:/^[A-Za-z\d @$.()-]+$/',
            'category_status' => 'required',
        ]);

        //validate input fields
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        //check the thumbnail has been provided or not
        $hasThumbnail = false;
        if($request->hasFile('thumbnail')){
            $hasThumbnail = true;
            $thumbnailPath = ImageController::uploadImage($request->file('thumbnail'), 'category', $request->category_name);
        }
        // dd($request);
        //update or create the record
        $category = CategoryModel::updateOrCreate(
            [
                'name' => $request->category_name
            ],
            [
                'name' => $request->category_name,
                'description'=> $request->description,
                'thumbnailPath'=> $hasThumbnail == true ? $thumbnailPath : "",
                'statusId' => $request->category_status,
                'deleted_at' => null
            ]
        );
        return redirect()->route('categories_index');
    }



    public function editCategory($category_id){
        //find the category in DB
        $category = CategoryModel::where('id', $category_id)->first();
        if($category){//if found
            //fetch category data to the request and return
            return view('admin.catalog.editCategory');
        }
        else{
            return redirect()->back()->with('msg', 'Category not found.');
        }
    }

    public function deleteCategory($key, $value){
        //perform soft delete
        CategoryModel::where($key, $value)->delete();
    }

    public function deleteCategoryAndRedirect($key, $value){
        //perform soft delete
        $this->deleteCategory($key, $value);
        return redirect()->back();
    }

    public function restoreCategory($key, $value){
        //restore from soft delete
        CategoryModel::where($key, $value)->restore();
    }
    public function restoreCategoryAndRedirect($key, $value){
        //restore from soft delete
        $this->restoreCategory($key, $value);
        return redirect()->back();
    }

    //return json object contains category records match with the value from request, return all if empty search string
    public function searchCategory(Request $request){
        if($request->searchValue){
            $value = $request->searchValue;
            $returnData = CategoryModel::where('name', 'like', "%".$value."%")->get();
            return json_encode($returnData);
        }


        $returnData = $this->getAll();
        return json_encode($returnData);
    }

    public function getAll(){
        return CategoryModel::all();
    }

    public function importExcelWithReview(Request $request){
        if($request->hasFile('file_excel')){
            //this variable contains array of sheets, each sheet contains array of rows
            $categorySheets = Excel::toArray([], $request->file('file_excel'));
            //convert sheets with arrays to array of json
            $categorySheetArray = [];
            foreach($categorySheets as $categorySheet){
                $categoryHeader = $categorySheet[0];
                $categoryArray = [];
                $columnIndex = 0;
                //loop through rows
                for($row = 1; $row < count($categorySheet); $row++){
                    $categoryDataArray = [];
                    for($col = 0; $col < count($categoryHeader); $col++){
                        $categoryDataArray[$categoryHeader[$col]] = $categorySheet[$row][$col];
                    }
                    //add new json entry with the header is key, and the data array is value
                    $categoryArray[] = $categoryDataArray;
                }
                //loop through columns

                $categorySheetArray[] = $categoryArray;
            }
            // dd($categorySheetArray);
            return view('admin.catalog.categories_review')->with('categorySheetArray', $categorySheetArray);
        }
        return "no file to import";

    }
}
