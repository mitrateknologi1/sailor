<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />

   <title>Offline Mode</title>

   <!-- Inline the page's stylesheet. -->
   <link rel="stylesheet" href="{{ asset('assets/offline/luno.style.min.css') }}">

</head>

<body id="layout-1" data-luno="theme-blue">

   <!-- start: body area -->
   <div class="wrapper">

      <!-- start: page body -->
      <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
         <div class="container-fluid">

            <div class="row">
               <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                  <div style="max-width: 25rem;">
                     <div class="mb-5">
                        <h2 class="color-900">SI GERCEP STUNTING</h2>
                     </div>
                     <!-- List Checked -->
                     <ul class="list-unstyled mb-5">
                        <li class="mb-4">
                           <span class="d-block mb-1 fs-4 fw-light">Sistem Informasi Gerakan Cepat Penurunan
                              Stunting</span>
                           <span class="color-600">Deteksi Stunting ● Moms Care ● Tumbuh Kembang ● Randa Kabilasa</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-6 d-flex justify-content-center align-items-center">
                  <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
                     <!-- Form -->
                     <form class="row g-3">
                        <div class="col-12 text-center mb-4">
                           <img src="{{ asset('assets/offline/auth-500.svg') }}" class="w240 mb-4" alt="" />
                           <h1 class="display-1">offline</h1>
                           <h5>Internet Kamu Terputus</h5>
                           <span class="text-muted">Kamu dan server SI GERCEP STUNTING lagi tidak terhubung nih. Coba
                              periksa data atau wifi kamu!!</span>
                        </div>
                        <div class="col-12 text-center">
                           <button class="btn btn-lg btn-block btn-dark lift text-uppercase">Reload</button>
                        </div>
                     </form>
                     <!-- End Form -->
                  </div>
               </div>
            </div> <!-- End Row -->

         </div>
      </div>

   </div>
   <!-- Inline the page's JavaScript file. -->
   <script>
      // Manual reload feature.
      document.querySelector("button").addEventListener("click", () => {
         window.location.reload();
      });

      // Listen to changes in the network state, reload when online.
      // This handles the case when the device is completely offline.
      window.addEventListener('online', () => {
         window.location.reload();
      });

      // Check if the server is responding and reload the page if it is.
      // This handles the case when the device is online, but the server
      // is offline or misbehaving.
      async function checkNetworkAndReload() {
         try {
            const response = await fetch('.');
            // Verify we get a valid response from the server
            if (response.status >= 200 && response.status < 500) {
               window.location.reload();
               return;
            }
         } catch {
            // Unable to connect to the server, ignore.
         }
         window.setTimeout(checkNetworkAndReload, 2500);
      }

      checkNetworkAndReload();
   </script>
</body>

</html>
