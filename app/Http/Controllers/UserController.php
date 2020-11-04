<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.default', $this->data);
    }

    /**
     * Display a profile user.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('admin.users.profile');
    }

    /**
     * List users
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function list($id=null)
    {
        $return = [];
        if (!is_null($id)) {
            $users = User::select('users.*')
                ->where('users.id', '<>', $id)
                ->groupBy('users.id')
                ->orderBy('users.name')
                ->get();
        } else {
            $users = User::orderBy('name')->get();
        }

        foreach ($users as $user) {
            $image     = "";
            $imageDB   = $user->image;

            if (!is_null($user->image) && file_exists(public_path($imageDB))) $image = asset($imageDB) . '?' . time();
            else $image = null;

            $item                      = [];
            $item['id']                = $user->id;
            $item['type']              = $user->type;
            $item['image']             = $image;
            $item['name']              = $user->name;
            $item['email']             = $user->email;
            $item['actived']           = $user->actived;

            $return[]                  = (object) $item;
        }

        return $return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUpdate(Request $request)
    {
        $return         = [];
        $error          = 1;
        $userID         = ((int) $request->input('id')>0 ? $request->input('id'): 0);
        $userType       = $request->input('type');
        $userImage      = $request->file('image');
        $userName       = $request->input('name');
        $userEmail      = $request->input('email');
        $userActived    = $request->input('actived');

        if (trim($userName) != '' && trim($userType) != '' && trim($userEmail) != '') {
            $userData = [
                'type'        => $userType,
                'name'        => $userName,
                'email'       => $userEmail,
                'actived'     => $userActived
            ];

            if($request->hasFile('image') && $userImage->isValid()) {
                $fileInfo  = pathinfo($userImage->getClientOriginalName());
                $extension = $fileInfo['extension'];

                $fileName  = md5($userName).'.'.$extension;
                $upload    = $userImage->storeAs($this->_public_path.'/users', $fileName);

                if($upload) {
                    $userData['image'] = str_replace($this->_public_path, $this->_uploads_path, $upload);
                    $error = 0;
                }
            }

            if ($userID>0) {
                $user = User::findOrFail($userID);

                foreach ($userData as $key => $value) {
                    $user->{$key} = $value;
                }

                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
            } else {
                $userData['password'] = Hash::make($this->passwordGenerate(6));
                $user = User::create($userData);

                // Sent password mail
                if (null===env("MAIL_STATUS") || (null!==env("MAIL_STATUS") && env('MAIL_STATUS')===true)) {
                    $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);
                    $this->email = $user->email;
                    $this->notify(new \App\Notifications\createPassword($token, $user->name, $user->email));
                }
            }

            $return = $user;
            $error  = 0;
        }

        return ['error'=>$error, 'user'=>$return];
    }

    /**
     * Show the form for editing a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request)
    {
        $return          = [];
        $error           = 1;
        $userID          = (int) $request->input('id');
        $userImage       = $request->file('image');
        $userName        = $request->input('name');
        $userEmail       = $request->input('email');
        $userPassword    = $request->input('password');
        $userPassConfirm = $request->input('passwordConfirm');

        if (trim($userName) !== '' && trim($userEmail) !== '') {
            $userData = [
                'name'     => $userName,
                'email'    => $userEmail
            ];

            if ($request->hasFile('image') && $userImage->isValid()) {
                $fileInfo  = pathinfo($userImage->getClientOriginalName());
                $extension = $fileInfo['extension'];

                $fileName  = md5($userName).'.'.$extension;
                $upload    = $userImage->storeAs($this->_public_path.'/users', $fileName);

                if($upload) {
                    $userData['image'] = str_replace($this->_public_path, $this->_uploads_path, $upload);
                    $error = 0;
                }
            }

            if (trim($userPassword)!=='' && trim($userPassConfirm)!=='' && $userPassword===$userPassConfirm) {
                $userData['password'] = Hash::make($userPassword);
            }

            $user = User::findOrFail($userID);

            foreach ($userData as $key => $value) {
                $user->{$key} = $value;
            }

            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();

            $return = $user;
            $error  = 0;
        }

        return ['error'=>$error, 'user'=>$return];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(!is_null($user->image) && file_exists($user->image)) {
            Storage::delete(str_replace($this->_uploads_path, $this->_public_path, $user->image));
        }

        $user->delete();
        return;
    }

    public function toogleActive(Request $request)
    {
        $return = [];
        $error  = 1;
        $user   = null;

        $id     = $request->input('id');
        $active = $request->input('status');
        $user   = User::where('id', $id)->update(['actived' => $active]);

        $error  = 0;

        return ['error' => $error, 'id' => $id, 'status' => $active];
    }

    private function passwordGenerate($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }
}
