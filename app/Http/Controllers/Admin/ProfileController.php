<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
    $this->validate($request, Profile::$rules);
    $profile = new Profile;
    // \Debugbar::info($profile);
    $form = $request->all();
    
    // if (isset($form['image'])) {
    //     $path = $request->file('image')->store('public/image');
    //     $profile->image_path = basename($path);
    // } else {
    //     $profile->image_path = null;
    // }
    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    // フォームから送信されてきたimageを削除する
    // unset($form['image']);
    // データベースに保存する
    $profile->fill($form);
    $profile->save();    
        return redirect('admin/profile/create');
        
    }
    
    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404); 
      }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $profile_form = $request->all();
        
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        
        $history = new ProfileHistory();
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile/edit?id='.$profile->id);
        
        // return redirect('admin/profile/edit');
    }
}
