<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentDepartment extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $name;
    public $country_id;
    public $department_id;

    public $countries;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'country_id' => 'required',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
        $this->countries = Country::where('status', Country::Active)->get();
    }

    public function render()
    {
        $Query = Department::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $departments = $Query->where('status', Department::Active)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-department', compact('departments'));
    }

    public function store()
    {
        $this->validate();

        $department = new Department();
        $department->name = $this->name;
        $department->country_id = $this->country_id;
        $department->save();

        $this->clear();
        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->department_id = $id;

        $department = Department::find($id);

        $this->name = $department->name;
        $this->country_id = $department->country_id;

        $this->activity = "edit";
    }

    public function update()
    {
        $department = Department::find($this->department_id);

        $this->validate();

        $department->name = $this->name;
        $department->country_id = $this->country_id;
        $department->save();

        $this->activity = "create";
        $this->clear();
        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->department_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $department = Department::find($this->department_id);

        $department->state_id = Department::Inactive;
        $department->save();

        $this->deleteModal = false;
        $this->clear();
        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'country_id', 'department_id']);
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
