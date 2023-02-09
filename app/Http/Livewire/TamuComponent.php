<?php

namespace App\Http\Livewire;

use App\Models\Tamu;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Component;

class TamuComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama, $no_telp, $alamat, $tamu_edit_id, $tamu_delete_id;

    public $view_tamu_nama, $view_tamu_no_telp, $view_tamu_alamat;

    public $searchTerm;

    public function updated($fields)
    {
        $messages = [
            'required' => ':attribute wajib diisi !!!',
            'unique' => ':attribute sudah ada !!!',
            'min' => ':attribute harus diisi minimal :min karakter!!!',
            'max' => ':attribute harus diisi maksimal :max karakter!!!',
        ];

        $this->validateOnly($fields, [
            'nama.*' => 'required|unique:tamu|max:50|min:2',
            'no_telp.*' => 'required|unique:tamu|max:15|min:8',
            'alamat' => 'required|min:3',
        ], $messages);
    }

    public function store()
    {
        $messages = [
            'required' => ':attribute wajib diisi !!!',
            'unique' => ':attribute sudah ada !!!',
            'min' => ':attribute harus diisi minimal :min karakter!!!',
            'max' => ':attribute harus diisi maksimal :max karakter!!!',
        ];
        $this->validate([
            'nama' => 'required|unique:tamu|max:50|min:2',
            'no_telp' => 'required|unique:tamu|max:15|min:8',
            'alamat' => 'required|min:3',
        ], $messages);

        $tamu = new Tamu();
        $tamu->slug = Str::slug($this->nama); //Untuk url
        $tamu->nama = $this->nama;
        $tamu->no_telp = $this->no_telp;
        $tamu->alamat = $this->alamat;
        $tamu->save();

        session()->flash('message', 'Data Tamu Baru telah berhasil ditambahkan');

        $this->nama = '';
        $this->no_telp = '';
        $this->alamat = '';
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->nama = '';
        $this->no_telp = '';
        $this->alamat = '';
        $this->tamu_edit_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function edit($id)
    {
        $tamu = Tamu::find($id);
        $this->tamu_edit_id = $tamu->id;
        $this->nama = $tamu->nama;
        $this->no_telp = $tamu->no_telp;
        $this->alamat = $tamu->alamat;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function update()
    {
        $messages = [
            'required' => ':attribute wajib diisi !!!',
            'unique' => ':attribute sudah ada !!!',
            'min' => ':attribute harus diisi minimal :min karakter!!!',
            'max' => ':attribute harus diisi maksimal :max karakter!!!',
        ];
        $this->validate([
            'nama.*' => 'required|unique:tamu|max:50|min:2',
            'no_telp.*' => 'required|unique:tamu|max:15|min:8',
            'alamat' => 'required|min:3',
        ], $messages);

        $tamu = Tamu::find($this->tamu_edit_id);
        $tamu->nama = $this->nama;
        $tamu->slug = Str::slug($this->nama);
        $tamu->no_telp = $this->no_telp;
        $tamu->alamat = $this->alamat;
        $tamu->save();
        session()->flash('message', "Data Tamu *$this->nama telah berhasil diperbarui");
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        $this->tamu_delete_id = $id;
        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function destroy()
    {
        $tamu = Tamu::find($this->tamu_delete_id);
        $tamu->delete();
        session()->flash('message', "Data Tamu *$tamu->nama berhasil dihapus");
        $this->dispatchBrowserEvent('close-modal');
        $this->tamu_delete_id = '';
    }

    public function cancel()
    {
        $this->tamu_delete_id = '';
    }

    public function show($id)
    {
        $tamu = Tamu::find($id);
        $this->view_tamu_nama = $tamu->nama;
        $this->view_tamu_no_telp = $tamu->no_telp;
        $this->view_tamu_alamat = $tamu->alamat;
        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function closeViewModal()
    {
        $this->view_tamu_nama = '';
        $this->view_tamu_no_telp = '';
        $this->view_tamu_alamat = '';
    }
    public function render()
    {
        if ($this->searchTerm) {
            $data_tamu = Tamu::where('nama', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('no_telp', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('alamat', 'like', '%' . $this->searchTerm . '%')->latest()->get();
        } else {
            $data_tamu = Tamu::where('nama', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('no_telp', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('alamat', 'like', '%' . $this->searchTerm . '%')->latest()->paginate(10);
        }
        return view('livewire.tamu-component', ['data_tamu' => $data_tamu])->layout('livewire.layouts.base');
    }
}
