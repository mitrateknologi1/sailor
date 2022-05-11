<div class="modal-content">
    <div class="modal-header px-4 align-items-center">
        <h5 class="modal-title">Pemberitahuan <span class="badge bg-danger ms-2">{{ $pemberitahuan->count() }}</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body px-4 custom_scroll">
        <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="pemberitahuanList" role="tabpanel">
                @foreach ($pemberitahuan as $item)
                    <div class="card ribbon mb-3 p-3">
                        <span class="d-flex mb-1">
                            <img class="avatar rounded-circle"
                                src="{{ isset($item->anggotaKeluarga) &&$item->anggotaKeluarga->foto_profil != null &&Storage::exists('upload/foto_profil/keluarga/' . $item->anggotaKeluarga->foto_profil)? asset('upload/foto_profil/keluarga/' . $item->anggotaKeluarga->foto_profil): asset('assets/dashboard/images/avatar.png') }}"
                                alt="">
                            <div class="flex-fill ms-3">
                                <p class="d-flex justify-content-between mb-0 align-items-center">
                                    <span>{{ $item->anggotaKeluarga->nama_lengkap }}</span>
                                    <small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small>
                                </p>
                                <span>{{ $item->judul }}</span><br>
                            </div>
                        </span>
                        <span class="text-muted">{{ $item->isi }}</span>
                        <div class="card-footer p-0 pt-1 border-0 float-right text-end text-muted">
                            <a class="btn btn-sm btn-outline-secondary delete-pemberitahuan float-right" href="#"
                                data-id="{{ $item->id }}">
                                <small>
                                    <i class="fa fa-trash favourite-note"></i> Sudah Dibaca</a>
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-end">
            <a class="btn btn-sm btn-outline-secondary test w-100 mb-3" id="delete-all-pemberitahuan" href="#"><i
                    class="fa fa-trash favourite-note"></i> Bersihkan Semua Pemberitahuan</a>
        </div>
    </div>
</div>
