<form id="{{$form_id}}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        <div class="col-sm-12 col-md-6 col-lg">
            @component('dashboard.components.formElements.select', [
                'label' => 'Nama Anak (Tanggal Lahir)',
                'id' => 'nama-anak',
                'name' => 'nama_anak',
                'class' => 'select2',
                'attribute' => 'disabled',
                'wajib' => '<sup class="text-danger">*</sup>'
            ])
            @endcomponent
        </div>
        <div class="col-12 text-end">
            @component('dashboard.components.buttons.process', [
                'id' => 'proses-pertumbuhan-anak',
                'type' => 'submit',
            ])      
            @endcomponent
        </div>
    </div>
    <div class="modal fade" id="modal-hasil" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body custom_scroll p-lg-4 pb-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div>
                            <h5>Hasil Perkembangan Anak</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card fieldset border border-primary mb-4">
                        <span class="fieldset-tile text-primary bg-white">Motorik Kasar:</span>
                        <p class="text-primary mb-0" id="modal-motorik-kasar" style="text-align: justify">-</p>
                    </div>
                    <div class="card fieldset border border-secondary">
                        <span class="fieldset-tile text-secondary bg-white">Motorik Halus:</span>
                        <p class="text-secondary mb-0 " id="modal-motorik-halus" style="text-align: justify">-</p>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Anak:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Anak:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-anak"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-cake-candles"></i> Usia</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-usia"> - </span>
                                </li>
                                <li class="justify-content-between">
                                    <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> - </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6 col-lg-4">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i>  Batal</button>
                        </div>
                        <div class="col-sm-6 col-lg-8">
                            @component('dashboard.components.buttons.submit', [
                                'id' => 'proses-pertumbuhan-anak',
                                'type' => 'submit',
                                'class' => 'text-white text-uppercase w-100',
                                'label' => 'Simpan',
                            ])      
                            @endcomponent
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>


@push('script')
    <script>       

    </script>

@endpush