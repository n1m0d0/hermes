<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentUser extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $name;
    public $email;
    public $password;
    public $role;
    public $user_id;
    
    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'email' => 'required|unique:users|max:100',
        'role' => 'required'
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = User::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $users = $Query->where('id', "!=", 1)->orderBy('id', 'DESC')->paginate(7);
        $roles = DB::table('roles')->where('guard_name', 'web')->get();
        return view('livewire.component-user', compact('users', 'roles'));
    }

    public function store()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt("sistemas123");
        $user->save();

        $user->assignRole($this->role);

        $this->clear();
        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->user_id = $id;

        $user = User::find($id);

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()[0];

        $this->activity = "edit";
    }

    public function update()
    {
        $user = User::find($this->user_id);

        $this->validate([
            'name' => 'required|max:200',
            'email' => ['required', 'max:100', Rule::unique('users')->ignore($this->user_id)],
            'role' => 'required'
        ]);

        $user->removeRole($user->getRoleNames()[0]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        $user->assignRole($this->role);

        $this->activity = "create";
        $this->clear();
        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->user_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $user = User::find($this->user_id);
        $user->delete();

        $this->deleteModal = false;
        $this->clear();
        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'email', 'role', 'user_id']);
        $this->iteration++;
        $this->activity = "create";
    }

    public function resetSearch()
    {
        $this->reset(['search']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
