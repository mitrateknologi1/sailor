@extends('dashboard.layouts.main')

@section('title')
    Provinsi
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Wilayah</a></li>
            <li class="breadcrumb-item active" aria-current="page">Provinsi</li>
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
                        <h5 class="card-title mb-0">Data Wilayah Provinsi</h5>
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
                                        'th' => ['No', 'Nama', 'Aksi'],
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

    @component('dashboard.components.modals.masterData.wilayah', [
        'idModal' => 'modal-tambah',
        'idForm' => 'form-tambah',
        'label' => 'Tambah Provinsi',
        ])
    @endcomponent

    @component('dashboard.components.modals.masterData.wilayah', [
        'idModal' => 'modal-edit',
        'idForm' => 'form-edit',
        'label' => 'Edit Provinsi',
        ])
    @endcomponent
@endsection

@push('script')
    <script>
        var idEdit = 0;

        $('#btn-tambah').click(function() {
            resetError();
            $('#modal-tambah').modal('show');
        })

        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data provinsi ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('provinsi/') }}" + '/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data provinsi telah dihapus.',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Data provinsi gagal dihapus.',
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
                url: "{{ url('provinsi/') }}" + '/' + id + '/edit',
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#modal-edit').modal('show');
                    $('#modal-edit .nama').val(response.nama);
                },
            })
        })

        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            resetError();
            $.ajax({
                url: "{{ url('/provinsi') }}",
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
                url: "{{ url('/provinsi') }}" + '/' + idEdit,
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
            ajax: "{{ url('/provinsi') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
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
        $('#m-link-wilayah').addClass('active');

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').removeClass('d-none');
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            resetErrorElement('nama');
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
@endpush
