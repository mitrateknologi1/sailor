@if (Auth::user()->role != 'admin')
    <div class="col-12 mt-2">
        <div role="alert" class="alert alert-success">
            <ul class="mx-3 mb-0 p-0">
                @if (Auth::user()->role == 'bidan')
                    <li>
                        Data yang ditampilkan hanyalah data yang berasal dari lokasi tugas anda sekarang
                        dan data yang
                        telah anda validasi baik dilokasi tugas anda yang sekarang maupun dilokasi tugas
                        sebelumnya.
                    </li>
                @elseif (Auth::user()->role == 'penyuluh')
                    <li>
                        Data yang ditampilkan hanyalah data yang berasal dari lokasi tugas anda sekarang yang sudah
                        divalidasi (Tervalidasi)
                    </li>
                @endif
                <li>
                    Kolom <span class="fw-bold">Aksi:</span>
                    <ul>
                        @if (Auth::user()->role == 'bidan')
                            <li>
                                Dapat melihat <span class="fw-bold">detail</span> data
                            </li>
                            <li>
                                Hanya dapat <span class="fw-bold">menghapus</span> dan <span
                                    class="fw-bold">mengubah</span> data yang
                                telah anda validasi.
                            </li>
                            <li>Tombol <span class="fw-bold">konfirmasi</span> hanya akan muncul
                                ketika ada data baru dilokasi tugas anda.</li>
                        @elseif (Auth::user()->role == 'penyuluh')
                            <li>
                                Dapat melihat <span class="fw-bold">detail</span> data
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endif
