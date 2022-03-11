<!-- start: sidebar -->
<div class="sidebar p-2 py-md-3">
    <div class="container-fluid">
        <!-- sidebar: title-->
        <div class="title-text d-flex align-items-center mb-4 mt-1">
            <h4 class="sidebar-title mb-0 flex-grow-1"><span class="sm-txt">L</span><span>UNO</span></h4>
           
        </div>
        <!-- sidebar: menu list -->
        <div class="main-menu flex-grow-1">
            <ul class="menu-list">
                <li class="divider py-2 lh-sm"><span class="small">MENU UTAMA</span><br> 
                    {{-- <small class="text-muted">Unique dashboard designs </small> --}}
                </li>
                <li>
                    <a class="m-link" id="m-link-dashboard" href="{{ url('/') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                        <span class="ms-2">Dashboard</span>
                    </a>
                </li>
                <li class="collapsed">
                    <a class="m-link collapsed" id="m-link-deteksi-stunting" data-bs-toggle="collapse" data-bs-target="#menu-deteksi-stunting" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16">
                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                          </svg>
                        <span class="ms-2">Deteksi Stunting</span>
                        <span class="arrow fa fa-angle-right ms-auto text-end"></span>
                    </a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse" id="menu-deteksi-stunting">
                        <li><a class="ms-link" id="ms-link-stunting-anak" href="{{ url('stunting-anak') }}">Stunting Anak</a></li>
                        <li><a class="ms-link" id="ms-link-ibu-melahirkan-stunting" href="{{ url('ibu-melahirkan-stunting') }}">Ibu Melahirkan Stunting</a>
                        </li>
                    </ul>
                </li>
                <li class="collapsed">
                    <a class="m-link" id="m-link-moms-care" data-bs-toggle="collapse" data-bs-target="#menu-moms-care"
                        href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
                        </svg>
                        <span class="ms-2">Moms Care</span>
                        <span class="arrow fa fa-angle-right ms-auto text-end"></span>
                    </a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse" id="menu-moms-care">
                        <li><a class="ms-link" id="ms-link-perkiraan-melahirkan" href="{{ url('perkiraan-melahirkan') }}">Perkiraan Melahirkan</a></li>
                        <li><a class="ms-link" id="ms-link-deteksi-dini" href="{{ url('deteksi-dini') }}">Deteksi Dini</a></li>
                        <li><a class="ms-link" id="ms-link-anc" href="{{ url('anc') }}">ANC</a></li>
                    </ul>
                </li>
                <li class="collapsed">
                    <a class="m-link" id="m-link-tumbuh-kembang" data-bs-toggle="collapse" data-bs-target="#menu-tumbuh-kembang" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z"/>
                        </svg>
                        <span class="ms-2">Tumbuh Kembang</span>
                        <span class="arrow fa fa-angle-right ms-auto text-end"></span>
                    </a>

                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse" id="menu-tumbuh-kembang">
                        <li><a class="ms-link" id="ms-link-pertumbuhan-anak" href="{{ url('pertumbuhan-anak') }}">Pertumbuhan Anak</a></li>
                        <li><a class="ms-link" id="ms-link-perkembangan-anak" href="{{ url('perkembangan-anak') }}">Perkembangan Anak</a></li>
                    </ul>
                </li>
                <li class="collapsed">
                    <a class="m-link" id="m-link-randa-kabilasa" data-bs-toggle="collapse" data-bs-target="#menu-randa-kabilasa" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                        <span class="ms-2">Randa Kabilasa</span>
                        <span class="arrow fa fa-angle-right ms-auto text-end"></span>
                        
                    </a>

                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse" id="menu-randa-kabilasa">
                        <li><a class="ms-link" id="ms-link-mencegah-malnutrisi" href="{{ url('mencegah-malnutrisi') }}">Mencegah Malnutrisi</a></li>
                        <li><a class="ms-link" id="ms-link-mencegah-pernikahan-dini" href="{{ url('mencegah-pernikahan-dini') }}">Mencegah Pernikahan Dini</a></li>
                        <li><a class="ms-link" id="ms-link-meningkatkan-life-skill" href="{{ url('meningkatkan-life-skill') }}  ">Meningkatkan Life Skill & Potensi Diri</a></li>
                    </ul>
                </li>

            </ul>
            <ul class="menu-list">
                <li class="divider py-2 lh-sm"><span class="small">MASTER DATA</span><br> </li>
                <li class="collapsed">
                    <a class="m-link" id="m-link-profil" data-bs-toggle="collapse" data-bs-target="#menu-profil" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                        </svg>
                        <span class="ms-2">Profil</span>
                        <span class="arrow fa fa-angle-right ms-auto text-end"></span>
                    </a>

                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse" id="menu-profil">
                        <li><a class="ms-link" href="account-settings.html">Keluarga</a></li>
                        <li><a class="ms-link" href="account-invoices.html">Nakes</a></li>
                        <li><a class="ms-link" href="account-create-invoices.html">Penyuluh BKKBN</a></li>
                    </ul>
                </li>

                <li>
                    <a class="m-link" id="m-link-akun" href="modals.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        <span class="ms-2">Akun</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- sidebar: footer link -->
        <ul class="menu-list nav navbar-nav flex-row text-center">
            <li class="nav-item flex-fill p-2">
                <a class="d-inline-block w-100 color-400" href="auth-signin.html" title="sign-out">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7.5 1v7h1V1h-1z" />
                        <path class="fill-secondary"
                            d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                    </svg>
                </a>
            </li>
            <li class="nav-item flex-fill p-2">
                <a class="d-inline-block w-100 color-400" href="#" data-bs-toggle="modal"
                    data-bs-target="#MynotesModal" title="My notes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
                    </svg>
                    
                </a>
            </li>
        </ul>
    </div>
</div>
