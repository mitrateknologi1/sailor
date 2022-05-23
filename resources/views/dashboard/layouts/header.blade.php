<!-- start: page header -->
<header class="page-header sticky-top px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
    <div class="container-fluid">

        <nav class="navbar">
            <!-- start: toggle btn -->
            <div class="d-flex">
                <button type="button" class="btn btn-link d-none d-xl-block sidebar-mini-btn p-0 text-primary">
                    <span class="hamburger-icon">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </span>
                </button>
                <button type="button" class="btn btn-link d-block d-xl-none menu-toggle p-0 text-primary">
                    <span class="hamburger-icon">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </span>
                </button>
            </div>
            <!-- start: link -->
            <ul class="header-right justify-content-end d-flex align-items-center mb-0">
                <!-- start: notifications dropdown-menu -->
                @if (Auth::user()->role == 'keluarga')
                    <li class="@if (Auth::user()->pemberitahuan->count() == 0) d-none @endif">
                        <div class="dropdown morphing scale-left notifications">
                            <a class="nav-link dropdown-toggle pulse justify-content-center text-center"
                                id="pemberitahuan" href="#">
                                <i class="fa fa-bell text-secondary text-center"></i>
                                <span class="
                                    pulse-ring mx-auto"></span>
                            </a>
                        </div>
                    </li>
                @endif
                <!-- start: My notes toggle modal -->
                <li class="d-none d-sm-inline-block d-xl-none">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#MynotesModal">
                        <svg viewBox="0 0 16 16" width="18px" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-secondary"
                                d="M1.5 0A1.5 1.5 0 0 0 0 1.5V13a1 1 0 0 0 1 1V1.5a.5.5 0 0 1 .5-.5H14a1 1 0 0 0-1-1H1.5z" />
                            <path
                                d="M3.5 2A1.5 1.5 0 0 0 2 3.5v11A1.5 1.5 0 0 0 3.5 16h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 16 9.586V3.5A1.5 1.5 0 0 0 14.5 2h-11zM3 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V9h-4.5A1.5 1.5 0 0 0 9 10.5V15H3.5a.5.5 0 0 1-.5-.5v-11zm7 11.293V10.5a.5.5 0 0 1 .5-.5h4.293L10 14.793z" />
                        </svg>
                    </a>
                </li>
                <!-- start: Recent Chat toggle modal -->
                <li class="d-none d-sm-inline-block d-xl-none">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#RecentChat">
                        <svg viewBox="0 0 16 16" width="18px" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path class="fill-secondary"
                                d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                </li>
                <!-- start: quick light dark -->
                <li>
                    <a class="nav-link quick-light-dark" href="#">
                        <svg viewBox="0 0 16 16" width="18px" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
                            <path class="fill-secondary"
                                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                        </svg>
                    </a>
                </li>
                <!-- start: User dropdown-menu -->
                <li>
                    <div class="dropdown morphing scale-left user-profile mx-lg-3 mx-2">
                        <a class="nav-link dropdown-toggle rounded-circle after-none p-0" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <img class="avatar img-thumbnail rounded-circle shadow"
                                src="{{ Auth::user()->profil->foto_profil != null && Storage::exists('upload/foto_profil/' . Auth::user()->role . '/' . Auth::user()->profil->foto_profil) ? Storage::url('upload/foto_profil/' . Auth::user()->role . '/' . Auth::user()->profil->foto_profil) : asset('assets/dashboard/images/avatar.png') }}"
                                alt="Avatar" class="rounded-circle avatar xl shadow img-thumbnail">
                        </a>
                        <div class="dropdown-menu border-0 rounded-4 shadow p-0">
                            <div class="card border-0 w240">
                                <div class="card-body border-bottom d-flex">
                                    <img class="avatar rounded-circle"
                                        src="{{ Auth::user()->profil->foto_profil != null && Storage::exists('upload/foto_profil/' . Auth::user()->role . '/' . Auth::user()->profil->foto_profil) ? asset('upload/foto_profil/' . Auth::user()->role . '/' . Auth::user()->profil->foto_profil) : asset('assets/dashboard/images/avatar.png') }}"
                                        alt="Avatar" class="rounded-circle avatar xl shadow img-thumbnail">
                                    <div class="flex-fill ms-3">
                                        <h6 class="card-title mb-0">{{ Auth::user()->profil->nama_lengkap }}</h6>

                                        @if (Auth::user()->role != 'keluarga')
                                            <span class="text-muted">{{ ucfirst(Auth::user()->role) }}</span>
                                            @if (Auth::user()->role == 'bidan' || Auth::user()->role == 'penyuluh')
                                                @if (Auth::user()->profil->lokasiTugas->count() != 0)
                                                    <span
                                                        class="text-muted d-block">({{ ucwords(strtolower(Auth::user()->profil->lokasiTugas->pluck('desaKelurahan.nama')->implode(', '))) }})</span>
                                                @else
                                                    <span class="text-danger d-block">(Belum Ada Lokasi Tugas)</span>
                                                @endif
                                            @endif
                                        @elseif(Auth::user()->role == 'keluarga')
                                            @if (Auth::user()->is_remaja == 0)
                                                <span class="text-muted">Kepala Keluarga</span>
                                            @else
                                                <span class="text-muted">Remaja</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="list-group m-2 mb-3">
                                    <a class="list-group-item list-group-item-action border-0 test"
                                        href="{{ route('profilDanAkun') }}" id=""><i class="w30 fa fa-user"></i>Ubah
                                        Profil
                                        &
                                        Akun</a>
                                </div>
                                <a href="{{ url('logout') }}"
                                    class="btn bg-secondary text-light text-uppercase rounded-0">Sign out</a>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- start: Settings toggle modal -->
                <li class="{{ Auth::user()->role == 'keluarga' ? 'd-none' : '' }}">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#SettingsModal"
                        title="Settings">
                        <svg viewBox="0 0 16 16" width="18px" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-secondary"
                                d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z">
                            </path>
                            <path
                                d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z">
                            </path>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</header>

<div id="pemberitahuanModalDiv">
    <!-- Modal: my notes -->
    <div class="modal fade" id="pemberitahuanModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-vertical modal-dialog-scrollable">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
</div>



@push('script')
    <script>
        $(document).on('click', '#pemberitahuan', function() {
            listPemberitahuan()
        });

        function listPemberitahuan() {
            $.ajax({
                method: "GET",
                url: '{{ route('pemberitahuan.index') }}',
                success: function(response) {
                    if (response.pemberitahuan == 0) {
                        $('#pemberitahuanModal').modal('hide')
                        Swal.fire(
                            'Berhasil dibersihkan!',
                            'Semua pemberitahuan berhasil dibersihkan.',
                            'success'
                        ).then(function() {
                            location.reload()
                        })
                    } else {
                        $('#modal-content').html(response)
                        $('#pemberitahuanModal').modal('show')
                    }
                },
            });
        }

        $(document).on('click', '.delete-pemberitahuan', function() {
            $.ajax({
                url: "{{ url('pemberitahuan') }}" + '/' + $(this).data('id'),
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    listPemberitahuan()
                }
            })
        })

        $(document).on('click', '#delete-all-pemberitahuan', function() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda ingin membersihkan semua pemberitahuan yang ada?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('pemberitahuan/destroy-all') }}",
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#pemberitahuanModal').modal('hide')
                                Swal.fire(
                                    'Berhasil dibersihkan!',
                                    'Semua pemberitahuan berhasil dibersihkan.',
                                    'success'
                                ).then(function() {
                                    location.reload()
                                })
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Pemberitahuan gagal dibersihkan.',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })

        })
    </script>
@endpush
