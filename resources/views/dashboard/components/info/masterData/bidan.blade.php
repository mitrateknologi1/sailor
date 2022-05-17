@if (Auth::user()->role != 'admin')
    <div class="col-12 mt-2">
        <div role="alert" class="alert alert-success">
            <ul class="mx-3 mb-0 p-0">
                <li>
                    Menampilkan keseluruhan data bidan
                </li>
                <li>
                    Kolom <span class="fw-bold">Aksi:</span>
                    <ul>
                        <li>
                            Dapat melihat <span class="fw-bold">detail</span> data
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endif
