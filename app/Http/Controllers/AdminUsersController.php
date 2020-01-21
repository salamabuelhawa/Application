<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $users = User::all();//for admin i have to display all users
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name','id')->all();//convert it to array to have specific data from there//pull out name and id// all is for brenging the array
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //create ccondition for password just incase its empty
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input['password'] = bcrypt($request->password);
            $input = $request->all();
        }

        $input = $request->all();
        //
        //if we have a photo?
        if($file = $request->file('photo_id')){
            $name = time(). $file->getClientOriginalName();
            //move the file to images folder
            $file->move('images',$name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        //if we don't have a photo?
        //User::create($request->all());//to create user
        $input['password'] = bcrypt($request->password);
        User::create($input);//to create user
        return redirect('admin/users');
        //return $request->all();//if i just want to see my request
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','id')->all();
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        //
        //return $request->all();
        $user = User::findOrFail($id);

        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input['password'] = bcrypt($request->password);
            $input = $request->all();
        }

        //$input = $request->all();
        //detict photos
        if($file = $request->file('photo_id')){//checking for the file
            $name = time(). $file->getClientOriginalName();
            $file->move('images',$name);
            //create photo
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
            //then update the user
            $user->update($input);

            return redirect('/admin/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //return "Destroy";
        $user = User::findOrFail($id);
        unlink(public_path().$user->photo->file );
        $user->delete();

        Session::flash('deleted_user','The user has been deleted');

        return redirect('/admin/users');
    }
}
