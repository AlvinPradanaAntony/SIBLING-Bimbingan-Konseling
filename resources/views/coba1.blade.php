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
  <title>Dashboard | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Data Siswa</h4>
          </div>
          <div class="card-body">
            <table id="example" class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th>Alamat</th>
                  <th>No. Telp</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($siswa as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nisn }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->class->class_level }}</td>
                  <td>{{ $item->class->major_id }}</td>
                  <td>{{ $item->address }}</td>
                  <td>{{ $item->phone_number }}</td>
                  <td>{{ $item->email }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <p class="d-inline-flex gap-1">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample1"
          aria-expanded="false" aria-controls="multiCollapseExample1">
          Toggle first element
        </button>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2"
          aria-expanded="false" aria-controls="multiCollapseExample2">
          Toggle second element
        </button>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse"
          aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">
          Toggle both elements
        </button>
      </p>
      <div class="row">
        <div class="col">
          <div class="collapse multi-collapse" id="multiCollapseExample1">
            <div class="card card-body">
              Some placeholder content for the first collapse component of this multi-collapse example. This panel is
              hidden by default but revealed when the user activates the relevant trigger.
            </div>
          </div>
        </div>
        <div class="col">
          <div class="collapse multi-collapse" id="multiCollapseExample2">
            <div class="card card-body">
              Some placeholder content for the second collapse component of this multi-collapse example. This panel is
              hidden by default but revealed when the user activates the relevant trigger.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="collapseEach">
    <p>
      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
        aria-expanded="false" aria-controls="collapseOne">
        Collapse Item #1
      </button>
    </p>
    <div class="collapse" data-bs-parent="#collapseEach" id="collapseOne">
      <div class="card card-body">
        <strong>This is the first item's collapse body.</strong> It is hidden by default, until the collapse plugin adds
        the appropriate classes that we use to style each element. These classes control the overall appearance, as well
        as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our
        default variables. It's also worth noting that just about any HTML can go within the <code>.card-body</code>,
        though the transition does limit overflow.
      </div>
    </div>

    <p>
      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
        aria-expanded="false" aria-controls="collapseTwo">
        Collapse Item #2
      </button>
    </p>
    <div class="collapse" data-bs-parent="#collapseEach" id="collapseTwo">
      <div class="card card-body">
        <strong>This is the second item's collapse body.</strong> It is hidden by default, until the collapse plugin
        adds the appropriate classes that we use to style each element. These classes control the overall appearance, as
        well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our
        default variables. It's also worth noting that just about any HTML can go within the <code>.card-body</code>,
        though the transition does limit overflow.
      </div>
    </div>

    <p>
      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
        aria-expanded="false" aria-controls="collapseThree">
        Collapse Item #3
      </button>
    </p>
    <div class="collapse" data-bs-parent="#collapseEach" id="collapseThree">
      <div class="card card-body">
        <strong>This is the third item's collapse body.</strong> It is hidden by default, until the collapse plugin adds
        the appropriate classes that we use to style each element. These classes control the overall appearance, as well
        as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our
        default variables. It's also worth noting that just about any HTML can go within the <code>.card-body</code>,
        though the transition does limit overflow.
      </div>
    </div>
  </div>

  <div class="p-5">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="simple-tab-0" data-bs-toggle="tab" href="#simple-tabpanel-0" role="tab"
          aria-controls="simple-tabpanel-0" aria-selected="true">Tab 1</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="simple-tab-1" data-bs-toggle="tab" href="#simple-tabpanel-1" role="tab"
          aria-controls="simple-tabpanel-1" aria-selected="false">Tab 2</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="simple-tab-2" data-bs-toggle="tab" href="#simple-tabpanel-2" role="tab"
          aria-controls="simple-tabpanel-2" aria-selected="false">Tab 3</a>
      </li>
    </ul>
    <div class="tab-content pt-5" id="tab-content">
      <div class="tab-pane active" id="simple-tabpanel-0" role="tabpanel" aria-labelledby="simple-tab-0">Tab 1 selected
      </div>
      <div class="tab-pane" id="simple-tabpanel-1" role="tabpanel" aria-labelledby="simple-tab-1">Tab 2 selected</div>
      <div class="tab-pane" id="simple-tabpanel-2" role="tabpanel" aria-labelledby="simple-tab-2">Tab 3 selected</div>
    </div>
  </div>

  {{-- <div class="p-5">
    <img src="img/example.jpg" alt="foto-user" id="foto-user" class="img-fluid mx-auto d-block" />
  </div> --}}

  <div class="p-5">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img src="" alt="Fullscreen Image" id="fullscreenImage" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 1000;">
            <img src="img/example.jpg" id="foto-user" alt="foto-user" class="rounded-circle object-fit-cover img-fluid mx-auto d-block" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/calendar.js"></script>
  <script src="js/script.js"></script>
  <script>
    new DataTable('#example');
  </script>
  <script>
var profileImage = document.getElementById('foto-user');
var fullscreenImage = document.getElementById('fullscreenImage');

profileImage.addEventListener('click', function() {
  fullscreenImage.src = this.src;
  fullscreenImage.style.display = 'block';
});

fullscreenImage.addEventListener('click', function() {
  this.style.display = 'none';
});
  </script>
</body>

</html>