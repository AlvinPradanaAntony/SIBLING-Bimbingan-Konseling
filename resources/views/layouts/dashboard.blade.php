<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/img/app_logo.png">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css" />
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="css/Dashboard.css">
  <link rel="stylesheet" href="css/calendar.css">
  @stack('styles')
  <title>Dashboard | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div class="wrapper">
    @include('partials.sidebar')
    <section class="home-section">
      @include('partials.navbar')

      @yield('content')
    </section>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/script.js"></script>
  <script src="js/calendar.js"></script>
  @stack('scripts')
  <script>
    new DataTable('#example', {
      columnDefs: [{
          className: 'dt-head-left dt-body-left',
          targets: '_all'
        },
        {
          className: 'dt-body-center',
          targets: 0
        }
      ],
      dom: '<"dt-length"l><"dt-search"f>rt<"dt-info"i><"dt-pagination"p>',
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        search: "Pencarian:",
      },
      // Move controls outside card after initialization
      initComplete: function() {
        $('.dt-custom-info').append($('.dt-info'));
        $('.dt-custom-paging').append($('.dt-paging'));
        $('.dt-layout-start').append($('.dt-search'));
        $('.dt-layout-end').append($('.dt-length'));
      }
    });
  </script>

  <script>
    // Show fullscreen image preview
    function showFullscreen(imgSrc) {
      const preview = document.getElementById('fullscreenPreview');
      preview.querySelector('img').src = imgSrc;
      preview.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    // Close fullscreen preview
    function closeFullscreen() {
      document.getElementById('fullscreenPreview').style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Handle image upload preview
    function previewImage(event, id) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('profilePreview' + id);
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

</body>

</html>
