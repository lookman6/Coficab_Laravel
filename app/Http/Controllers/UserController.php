<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageGoogle;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required'
        ]);

        $tab = array();

        $tab["email"] = $request->email;
        $tab["password"] = str::random(8);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($tab["password"]),
            'email' => $request->email
        ]);

        $roles = Role::whereIn('intitule',$request["roles"])->get();

        foreach($roles as $role)
        {
            $user->role()->attach($role);
        }
		Mail::to($user->email)->bcc("cofma.gf@gmail.com")
        ->queue(new MessageGoogle($tab));

        return redirect(route('users.index'))->with('success', 'utilisateur ajouté avec succès !!!');
    }


    private function find($element,$tab)
    {
        foreach ($tab as $value) {
            if($element == $value)
            return true;
        }
    }
    public function updateRole(Request $request,User $user)
    {
        
        User::where('id',$user->id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        $elements = $user->role;
        $mesRoles = array();
        $i = 0;
        foreach($elements as $element)
        $mesRoles[$i++] = $element->intitule;
        
        $rolesCoches = $request->roles;
        $rolesCoches = Role::whereIn('intitule',$rolesCoches)->get();
      
        foreach($rolesCoches as $role)
        {
            // si l'utilisateur ne possède pas le rôle coché
            if(!$this->find($role->intitule, $mesRoles))
                $user->role()->attach($role);
        }

       $rolesCoches = $request->roles;
       $mesRoles = $elements;

       foreach ($mesRoles as $role) {
        //if not found
        if(!$this->find($role->intitule, $rolesCoches))
            $user->role()->detach($role);
        }

        return redirect(route('users.index'))->with('success', 'modification effectuée avec succès !!!');
      
    }

    private function supprimerRole($mesRoles,$user,$rolesCoches)
    {
        foreach ($mesRoles as $role) {
            //if not found
            if(!$this->find($role->intitule, $rolesCoches))
            {
                $user->role()->detach($role);
            }
        }
    }
    public function modifierMesInfos(User $user)
    {
        return view("users.modifierMesInfos",compact(['user']));
    }

    public function updateMesInfos(Request $request,User $user)
    {
        // if($request->password != "")
        $insere = User::where('id',$user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ]);
        return redirect(route("home"))->with('success','modification effectuée avec succès!');
    }
    public function modifierRole(User $user)
    {
        $tab = array();

        $roles = $user->role();
        $roles = $roles->select('intitule')->get()->toArray();
        // $user = User::where('id',$user->id)->update(k,);
        // dd($roles[0]["intitule"]);
        return view("users.editRole",compact(['user','roles']));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //public function show(User $user)
    public function show($id)
    {
       // return view('users.show');
        $user = User::findOrFail($id);
        return view('users.show')->with('users', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // return view('users.edit');
        $user = User::findOrFail($id);
        return view('users.edit')->with('users', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $user->update($input);
        return redirect('users')->with('success', 'Modification effectuée !!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('users')->with('warning', 'Utilisateur supprimé!!!'); 
    }
}
