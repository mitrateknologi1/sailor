<form method="POST" id="{{ $idForm ?? '' }}">
    @csrf
    {{ $method ?? '' }}
    <div class="modal fade {{ $class ?? '' }}" id="{{ $idModal ?? '' }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">{{ $label ?? '' }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <label for="TextInput" class="form-label">Nama</label>
                        <input type="text" class="form-control nama" name="nama">
                        <span class="badge bg-danger mt-2 d-none nama-error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    @component('dashboard.components.buttons.submit', [
                        'label' => 'Simpan',
                        ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</form>
