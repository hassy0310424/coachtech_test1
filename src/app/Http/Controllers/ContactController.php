<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contact(){
        return view('contact');
    }

    public function confirm(Request $request){
        $contacts = $request->only(['name', 'gender', 'email', 'tel', 'address', 'building', 'inquiry_type', 'content']);
        return view('confirm', ['contacts' => $contacts]);
    }

    public function store(Request $request){
        $contacts = $request->only(['name', 'gender', 'email', 'tel', 'address', 'building', 'inquiry_type', 'content']);
        Contact::create($contacts);
        return view('thanks');

    }

    public function admin(){
        $contacts = Contact::all();
        return view('admin', ['contacts' => $contacts]);

    }

    public function search(Request $request){
        $params = $request->all();
        $contacts = Contact::query()
            ->querySearch($params)
            ->genderSearch($params)
            ->inquirytypeSearch($params)
            ->get();
        return view('admin',  ['contacts' => $contacts]);
       
    }

    public function detail($id){
        $contacts =Contact::find($id);
        if($contacts){
            return response()->json([
                'success' => true,
                'details' => $contacts
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

    public function delete($id){
        $contact = Contact::find($id);
        if($contact){
            $contact->delete();
            return redirect('/admin')->with('success', 'データが削除されました');
        }
        return redirect('/admin',)->with('error', 'データが見つかりません');

    }
      
}
