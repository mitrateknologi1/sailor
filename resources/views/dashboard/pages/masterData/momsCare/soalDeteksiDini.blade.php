@extends('dashboard.layouts.main')

@section('title')
    Soal Deteksi Dini
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Moms Care</a></li>
            <li class="breadcrumb-item active" aria-current="page">Soal Deteksi Dini</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card ">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Soal Deteksi Dini</h5>
                        @component('dashboard.components.buttons.add', [
                            'id' => 'btn-tambah',
                            'class' => '',
                            'url' => '#',
                            ])
                        @endcomponent
                    </div>
                    <div class="card-body pt-2">
                        <div class="row">
                            <div class="col">
                                <div class="card fieldset border border-secondary">
                                    @component('dashboard.components.dataTables.index', [
                                        'id' => 'table-data',
                                        'th' => ['Urutan', 'Soal', 'Skor Ya', 'Skor Tidak', 'Aksi'],
                                        ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @component('dashboard.components.modals.masterData.soalDeteksiDini', [
        'idModal' => 'modal-tambah',
        'idForm' => 'form-tambah',
        'label' => 'Tambah Soal Deteksi dini',
        ])
    @endcomponent

    @component('dashboard.components.modals.masterData.soalDeteksiDini', [
        'idModal' => 'modal-edit',
        'idForm' => 'form-edit',
        'label' => 'Edit Soal Deteksi dini',
        ])
    @endcomponent
@endsection

@push('script')
    <script>
        var idEdit = 0;

        $('#btn-tambah').click(function() {
            resetError();
            resetModal();
            $('#modal-tambah').modal('show');
        })

        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('masterData/soal-deteksi-dini/') }}" + '/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Data gagal dihapus',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })

        $(document).on('click', '#btn-edit', function() {
            let id = $(this).val();
            idEdit = id;
            $.ajax({
                url: "{{ url('masterData/soal-deteksi-dini/') }}" + '/' + id + '/edit',
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#modal-edit').modal('show');
                    $('#modal-edit .urutan').val(response.urutan);
                    $('#modal-edit .soal').html(response.soal);
                    $('#modal-edit .skor_ya').val(response.skor_ya);
                    $('#modal-edit .skor_tidak').val(response.skor_tidak);
                },
            })
        })

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            resetError();
            $.ajax({
                url: "{{ url('masterData/soal-deteksi-dini/') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        $('#modal-tambah').modal('hide');
                        table.draw();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Data Gagal Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })

        $('#form-edit').submit(function(e) {
            e.preventDefault();
            resetError();
            $.ajax({
                url: "{{ url('masterData/soal-deteksi-dini') }}" + '/' + idEdit,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        $('#modal-edit').modal('hide');
                        table.draw();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Data Gagal Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })
    </script>

    <script>
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/masterData/soal-deteksi-dini') }}",
            columns: [{
                    data: 'urutan',
                    name: 'urutan',
                    class: 'text-center'
                },
                {
                    data: 'soal',
                    name: 'soal'
                },
                {
                    data: 'skor_ya',
                    name: 'skor_ya',
                    class: 'text-center'
                },
                {
                    data: 'skor_tidak',
                    name: 'skor_tidak',
                    class: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true,
                    class: 'text-center'
                },
            ]
        });
    </script>

    <script>
        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').removeClass('d-none');
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            resetErrorElement('urutan');
            resetErrorElement('soal');
        }

        function resetModal() {
            resetError();
            $('#form-tambah')[0].reset();
            $('#form-edit')[0].reset();
        }

        function resetErrorElement(key) {
            $('.' + key + '-error').addClass('d-none');
        }
    </script>

    <script>
        $('#m-link-master-data-moms-care').addClass('active');
        $('#menu-master-data-moms-care').addClass('collapse show')
        $('#ms-link-master-data-deteksi-dini').addClass('active')
    </script>
@endpush
