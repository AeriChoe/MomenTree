<?php

namespace App\Http\Controllers;

use Auth;
use Auth\Register;
use App\User;
use App\Profile;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class ProfileController extends Controller
{
  public function profile() {
      $user_id = Auth::user()->id;
      $msgct = Contact::where('to_user_id', $user_id)->count(); 

      return view('profiles.profile', ['msgct' => $msgct]);
  }
    
    public function addProfile(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'profile_pic' => 'required',            
        ]);
        $profile = new Profile;
        $profile->name = $request->input('name');
        $profile->user_id = Auth::user()->id;
        $profile->designation = $request->input('designation');
        if(Input::hasFile('profile_pic')) {
            $file = Input::file('profile_pic');
            $file->move(public_path(). '/uploads', $file->getClientOriginalName());
            $url = URL::to("/") . '/uploads/'. $file->getClientOriginalName();
            //return $url;
            //exit() <- for check
        }
         
        $profile->profile_pic = $url;
        $profile->save();
        
        return redirect('/home')->with('response', 'Profile Added Successfully!');
        
        
        //return Auth::user()->id;
        //exit() <-check하기
    }
    
    public function editPro($profile_id) {
        $user_id = Auth::user()->id;
        $profile = Profile::find($profile_id);
        $msgct = Contact::where('to_user_id', $user_id)->count(); 
        
        return view('profiles.editPro', ['profile' => $profile, 'msgct' => $msgct]);
        
    }
    
    public function editProfile(Request $request, $profile_id) {
        $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'profile_pic' => 'required',            
        ]);
        $profile = new Profile;
        $profile->name = $request->input('name');
        $profile->user_id = Auth::user()->id;
        $profile->designation = $request->input('designation');
        if(Input::hasFile('profile_pic')) {
            $file = Input::file('profile_pic');
            $file->move(public_path(). '/uploads', $file->getClientOriginalName());
            $url = URL::to("/") . '/uploads/'. $file->getClientOriginalName();
            //return $url;
            //exit() <- for check
        }
        
        $profile->profile_pic = $url;
        $data = array(
             'name' => $profile->name,
             'user_id' => $profile->user_id,
             'designation' => $profile->designation,
             'profile_pic' => $profile->profile_pic,
        );
        Profile::where('id', $profile_id)
            ->update($data);
        $profile->update();
        
        return redirect('/home')->with('response', 'Profile Update Successfully!');
        
    }
}
