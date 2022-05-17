@if (Auth::user()->role != 'admin')
    <div class="col-12 mt-2">
        <div role="alert" class="alert alert-success">
            <ul class="mx-3 mb-0 p-0">
                <li>
                    Hanya menampilkan keseluruhan akun keluarga (Kepala Keluarga dan Remaja)
                </li>
                <li>
                    Kolom <span class="fw-bold">Aksi:</span>
                    <ul>
                        <li>
                            Dapat melihat <span class="fw-bold">detail</span> data
                        </li>
                        <li>
                            Hanya dapat <span class="fw-bold">menghapus</span> dan <span
                                class="fw-bold">mengubah</span> data yang profilnya
                            telah anda validasi.
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endif
