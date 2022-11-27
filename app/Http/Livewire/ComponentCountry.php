<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCountry extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $name;
    public $flag;
    public $country_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'flag' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
    }
    
    public function render()
    {
        $Query = Country::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $countries = $Query->where('status', Country::Active)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-country', compact('countries'));
    }

    public function store()
    {
        $this->validate();

        $country = new Country();
        $country->name = $this->name;
        $country->flag = $this->flag->store('public');
        $country->save();

        $this->clear();
        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->country_id = $id;

        $country = Country::find($id);

        $this->name = $country->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $country = Country::find($this->country_id);

        if ($this->flag != null) {
            $this->validate();

            $country->name = $this->name;
            $country->flag = $this->flag->store('public');
            $country->save();
        } else {
            $this->validate([
                'name' => 'required|max:200',
            ]);

            $country->name = $this->name;
            $country->save();
        }

        $this->activity = "create";
        $this->clear();
        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->country_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $country = Country::find($this->country_id);

        $country->state_id = Country::Inactive;
        $country->save();

        $this->deleteModal = false;
        $this->clear();
        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'flag', 'country_id']);
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
