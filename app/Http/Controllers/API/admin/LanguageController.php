<?php

namespace App\Http\Controllers\API\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index(Request $request){
        $language = Language::latest('id');
        if(!empty($request->get('keyword'))){
            $language = $language->where('name','like','%'.$request->get('keyword').'%');
        }
        $language = $language->paginate(10);
        return response()->json([
            'language' => $language,
        ]);
    }

    public function create(){
        return view('admin.languages.create');
    }

    public function store(Request $request){
        $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:languages',
            'isocode'=>'required',
            'status'=>'required',
        ]);

        if($validater->passes()){
            $language = new Language();
            $language->name = $request->name;
            $language->slug = $request->slug;
            $language->Isocode = $request->isocode;
            $language->status = $request->status;

            $language->save();

            return response()->json([
                'status'=>true,
                'message'=> 'Language is added sucessfully'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=> $validater->errors()
            ]);
        }
    }

    public function edit($id, Request $request){

        $language = Language::find($id);
        if(empty($language)){
            $request->session()->flash('error','Record not found');
            return redirect()->route('languages.index');
        }
        $data['language'] = $language; 
        return response()->json([
            'data' => $data,
        ]);
    }
    public function update($id, Request $request){
        $language_edit = Language::find($id);
        if(empty($language_edit)){
            $request->session()->flash('error','Record not found');
             return response()->json([
                'status'=>false,
                'notfound'=> true
            ]);
        }

        $validater = Validator::make($request->all(),
            ['name'=>'required', 
            'slug'=>'required|unique:brands',
            'slug'=>'required|unique:languages,slug,'.$language_edit->id.',id',
            'Isocode'=>'required',
            'status'=>'required',

        ]);

        if($validater->passes()){

            $language_edit->name = $request->name;
            $language_edit->slug = $request->slug;
            $language_edit->Isocode = $request->Isocode;
            $language_edit->status = $request->status;
            $language_edit->save();
            $request->session()->flash('success','Language updated sucessfully');
            return response()->json([
                'status'=>true,
                'message'=> 'Language updated sucessfully'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'error'=>$validater->errors()
            ]);
        }
    }

    public function destroy($lang_id, Request $request){
        $lang_del = Language::find($lang_id);
        if(empty($lang_del)){
            $request->session()->flash("Error","Language not found");
                   return response()->json([
            'status'=>true,
            'message'=> 'Language not found'
        ]);
        }
        $lang_del->delete();
        $request->session()->flash("success","Language deleted successfully");
        return response()->json([
            'status'=>true,
            'message'=> 'Language deleted successfully'
        ]);
    }
}