<div class="row g-4">
    <div class="col-md-12">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nomor HP',
                'type' => 'text',
                'id' => 'nomor-hp-akun',
                'name' => 'nomor_hp',
                'class' => 'angka',
                'value' => isset($user) ? $user->nomor_hp : null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-md-12">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Kata Sandi',
                'type' => 'password',
                'id' => 'kata-sandi',
                'name' => 'kata_sandi',
                'class' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
        <div class="form-text text-muted">
            <small><i>Kosongkan kata sandi jika tidak ingin
                    mengubahnya</i></small>
        </div>
    </div>
    <div class="col-md-12">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Ulangi Kata Sandi',
                'type' => 'password',
                'id' => 'ulangi-kata-sandi',
                'name' => 'ulangi_kata_sandi',
                'class' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
        <div class="form-text text-muted">
            <small><i>Kosongkan kata sandi jika tidak ingin
                    mengubahnya</i></small>
        </div>
    </div>
    <div class="col-12 text-end">
        @component('dashboard.components.buttons.submit',
            [
                'id' => 'proses-pertumbuhan-anak',
                'type' => 'submit',
                'class' => 'text-white text-uppercase',
                'label' => $titleSubmit ?? 'Simpan',
            ])
        @endcomponent
    </div>
</div>
