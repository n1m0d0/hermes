<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCity extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $name;
    public $department_id;
    public $city_id;

    public $departments;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'department_id' => 'required',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
        $this->departments = Department::where('status', Department::Active)->get();
    }

    public function render()
    {
        $Query = City::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $cities = $Query->where('status', City::Active)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-city', compact('cities'));
    }

    public function store()
    {
        $this->validate();

        $city = new City();
        $city->name = $this->name;
        $city->department_id = $this->department_id;
        $city->save();

        $this->clear();
        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->city_id = $id;

        $city = City::find($id);

        $this->name = $city->name;
        $this->department_id = $city->department_id;

        $this->activity = "edit";
    }

    public function update()
    {
        $city = City::find($this->city_id);

        $this->validate();

        $city->name = $this->name;
        $city->department_id = $this->department_id;
        $city->save();

        $this->activity = "create";
        $this->clear();
        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->city_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $city = City::find($this->city_id);

        $city->state_id = City::Inactive;
        $city->save();

        $this->deleteModal = false;
        $this->clear();
        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'department_id', 'city_id']);
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
