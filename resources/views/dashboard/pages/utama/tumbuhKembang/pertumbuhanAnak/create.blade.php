@extends('dashboard.layouts.main')

@section('title')
    Tambah Pertumbuhan Anak
@endsection

@push('style')
@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
        <li class="breadcrumb-item active" aria-current="page">Pertumbuhan Anak</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Pertumbuhan Anak</li>
    </ol>
</div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card fieldset border border-secondary bg-white p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        <form>
                            <div class="row g-4">
                                <div class="col-sm-12 col-lg-6">
                                    @component('dashboard.components.formElements.select', [
                                        'label' => 'Nama Kepala Keluarga / Nomor KK',
                                        'id' => 'nama-kepala-keluarga',
                                        'name' => 'nama_kepala_keluarga',
                                        'class' => 'select2',
                                        ])         
                                        @slot('options')
                                            @foreach ($kartuKeluarga as $item)
                                                <option value="{{ $item->id }}">{{$item->nama_kepala_keluarga}} / {{$item->nomor_kk}}</option>
                                            @endforeach
                                        @endslot
                                    @endcomponent
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    @component('dashboard.components.formElements.select', [
                                        'label' => 'Nama Anak',
                                        'id' => 'nama-anak',
                                        'name' => 'nama_anak',
                                        'class' => 'select2',
                                        'attribute' => 'disabled',
                                    ])
                                    @endcomponent
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-pertumbuhan-anak').addClass('active')    
        
        $(function() {
            $('#nama-kepala-keluarga').change(function() {
                var id = $(this).val();
                var fungsi = 'pertumbuhan_anak';
                // alert(id);
                $.get("{{ route('getAnak') }}", {id: id, fungsi: fungsi}, function(result) {
                    // console.log(result);
                    $.each(result, function(key, val) {
                        // console.log(val.anggota_keluarga)
                        $.each(val.anggota_keluarga, function(key, val) {
                            console.log(val.nama_lengkap + ' | ' + val.status_hubungan_dalam_keluarga)                          
                        });

                        
                    })
                    $('#nama-anak').removeAttr('disabled');
                });
            });
        });
    </script>
@endpush
