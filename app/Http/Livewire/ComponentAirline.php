<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentAirline extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $name;
    public $logo;
    public $airline_id;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'logo' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Airline::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $airlines = $Query->where('status', Airline::Active)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-airline', compact('airlines'));
    }

    public function store()
    {
        $this->validate();

        $airline = new Airline();
        $airline->name = $this->name;
        $airline->logo = $this->logo->store('public');
        $airline->save();

        $this->clear();
        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->airline_id = $id;

        $airline = Airline::find($id);

        $this->name = $airline->name;

        $this->activity = "edit";
    }

    public function update()
    {
        $airline = Airline::find($this->airline_id);

        if ($this->logo != null) {
            $this->validate();

            $airline->name = $this->name;
            $airline->logo = $this->logo->store('public');
            $airline->save();
        } else {
            $this->validate([
                'name' => 'required|max:200',
            ]);

            $airline->name = $this->name;
            $airline->save();
        }

        $this->activity = "create";
        $this->clear();
        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->airline_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $airline = Airline::find($this->airline_id);

        $airline->state_id = Airline::Inactive;
        $airline->save();

        $this->deleteModal = false;
        $this->clear();
        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['name', 'logo', 'airline_id']);
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
