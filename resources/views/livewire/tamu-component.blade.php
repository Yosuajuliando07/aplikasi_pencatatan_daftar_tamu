<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3><strong>Sistem Pencatatan Daftar Tamu</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: left;"><strong>Daftar Tamu</strong></h5>
                        <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal"
                            data-target="#addModal">Tambah Tamu</button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="search" class="form-control w-25" placeholder="search"
                                    wire:model="searchTerm" style="float: right;">
                            </div>
                        </div>

                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No Telpon</th>
                                    <th>Alamat</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data_tamu->count() > 0)
                                    @foreach($data_tamu as $index => $tamu)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $tamu->nama }}</td>
                                            <td>{{ $tamu->no_telp }}</td>
                                            <td>{{ $tamu->alamat }}</td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-secondary"
                                                    wire:click="show({{ $tamu->id }})">View</button>
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="edit({{ $tamu->id }})">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="deleteConfirmation({{ $tamu->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><small>Data Tidak Ditemukan</small>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        @unless($this->searchTerm)
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li>
                                        <p class="text-blue">{{ $data_tamu->links() }}</p>
                                    </li>
                                </ul>
                            </nav>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tamu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group row">
                            <label for="nama" class="col-3">Nama</label>
                            <div class="col-9">
                                <input type="text" id="nama" class="form-control" wire:model="nama">
                                @error('nama')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_telp" class="col-3">No Telpon</label>
                            <div class="col-9">
                                <input type="text" id="no_telp" class="form-control" wire:model="no_telp">
                                @error('no_telp')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-3">Alamat</label>
                            <div class="col-9">
                                <div wire:ignore>
                                    <textarea wire:model="alamat" id="alamat" class="form-control"></textarea>
                                </div>
                                @error('alamat')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <div wire:loading wire:target="store" wire:key="store"><i
                                            class="fa fa-spinner fa-spin"></i></div>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tamu</h5>

                    <button wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="update">
                        <div class="form-group row">
                            <label for="nama" class="col-3">Nama</label>
                            <div class="col-9">
                                <input type="text" id="nama" class="form-control" wire:model="nama">
                                @error('nama')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_telp" class="col-3">No Telpon</label>
                            <div class="col-9">
                                <input type="text" id="no_telp" class="form-control" wire:model="no_telp">
                                @error('no_telp')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-3">Alamat</label>
                            <div class="col-9">
                                <div wire:ignore>
                                    <textarea wire:model="alamat" id="alamat" class="form-control"></textarea>
                                </div>
                                @error('alamat')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <div wire:loading wire:target="update" wire:key="update"><i
                                            class="fa fa-spinner fa-spin"></i></div>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Penghapusan Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Apa Anda yakin ingin menghapus data tamu?</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button class="btn btn-sm btn-danger" wire:click="destroy()">Ya! Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeViewModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>

                            <tr>
                                <th>Nama: </th>
                                <td>{{ $view_tamu_nama }}</td>
                            </tr>

                            <tr>
                                <th>No Telpon: </th>
                                <td>{{ $view_tamu_no_telp }}</td>
                            </tr>

                            <tr>
                                <th>Alamat: </th>
                                <td>{{ $view_tamu_alamat }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addModal').modal('hide');
            $('#editModal').modal('hide');
            $('#deleteModal').modal('hide');
        });
        window.addEventListener('show-edit-modal', event => {
            $('#editModal').modal('show');
        });
        window.addEventListener('show-delete-confirmation-modal', event => {
            $('#deleteModal').modal('show');
        });
        window.addEventListener('show-view-modal', event => {
            $('#viewModal').modal('show');
        });

    </script>
@endpush
