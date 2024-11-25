<!-- resources/views/users/index.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Users Data</title>
    <!-- Bootstrap CSS -->
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .profile-img-table {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        .modal-preview-img {
            max-width: 150px;
            height: auto;
            cursor: pointer;
            /* Menambahkan cursor pointer untuk indikasi bisa diklik */
        }

        #fullscreenPreview {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        #fullscreenPreview img {
            max-width: 90%;
            max-height: 90vh;
        }

        #fullscreenPreview .close-preview {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="container mt-5">
        <h2>Users Data</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Dummy data
                    $users = [
                    [
                    'id' => 1,
                    'profile_picture' => 'https://via.placeholder.com/150',
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'gender' => 'Male'
                    ],
                    [
                    'id' => 2,
                    'profile_picture' => 'https://via.placeholder.com/150',
                    'name' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'gender' => 'Female'
                    ],
                    // Add more dummy data as needed
                    ];
                    @endphp

                    @foreach($users as $user)
                    <tr>
                        <td>
                            <img src="{{ $user['profile_picture'] }}" class="profile-img-table"
                                onclick="showFullscreen('{{ $user['profile_picture'] }}')" alt="Profile picture">
                        </td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['gender'] }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditModal({{ json_encode($user) }})">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <table id="example" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011-04-25</td>
                        <td>$320,800</td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011-07-25</td>
                        <td>$170,750</td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009-01-12</td>
                        <td>$86,000</td>
                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012-03-29</td>
                        <td>$433,060</td>
                    </tr>
                    <tr>
                        <td>Airi Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>2008-11-28</td>
                        <td>$162,700</td>
                    </tr>
                    <tr>
                        <td>Brielle Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2012-12-02</td>
                        <td>$372,000</td>
                    </tr>
                    <tr>
                        <td>Herrod Chandler</td>
                        <td>Sales Assistant</td>
                        <td>San Francisco</td>
                        <td>59</td>
                        <td>2012-08-06</td>
                        <td>$137,500</td>
                    </tr>
                    <tr>
                        <td>Rhona Davidson</td>
                        <td>Integration Specialist</td>
                        <td>Tokyo</td>
                        <td>55</td>
                        <td>2010-10-14</td>
                        <td>$327,900</td>
                    </tr>
                    <tr>
                        <td>Colleen Hurst</td>
                        <td>Javascript Developer</td>
                        <td>San Francisco</td>
                        <td>39</td>
                        <td>2009-09-15</td>
                        <td>$205,500</td>
                    </tr>
                    <tr>
                        <td>Sonya Frost</td>
                        <td>Software Engineer</td>
                        <td>Edinburgh</td>
                        <td>23</td>
                        <td>2008-12-13</td>
                        <td>$103,600</td>
                    </tr>
                    <tr>
                        <td>Jena Gaines</td>
                        <td>Office Manager</td>
                        <td>London</td>
                        <td>30</td>
                        <td>2008-12-19</td>
                        <td>$90,560</td>
                    </tr>
                    <tr>
                        <td>Quinn Flynn</td>
                        <td>Support Lead</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2013-03-03</td>
                        <td>$342,000</td>
                    </tr>
                    <tr>
                        <td>Charde Marshall</td>
                        <td>Regional Director</td>
                        <td>San Francisco</td>
                        <td>36</td>
                        <td>2008-10-16</td>
                        <td>$470,600</td>
                    </tr>
                    <tr>
                        <td>Haley Kennedy</td>
                        <td>Senior Marketing Designer</td>
                        <td>London</td>
                        <td>43</td>
                        <td>2012-12-18</td>
                        <td>$313,500</td>
                    </tr>
                    <tr>
                        <td>Tatyana Fitzpatrick</td>
                        <td>Regional Director</td>
                        <td>London</td>
                        <td>19</td>
                        <td>2010-03-17</td>
                        <td>$385,750</td>
                    </tr>
                    <tr>
                        <td>Michael Silva</td>
                        <td>Marketing Designer</td>
                        <td>London</td>
                        <td>66</td>
                        <td>2012-11-27</td>
                        <td>$198,500</td>
                    </tr>
                    <tr>
                        <td>Paul Byrd</td>
                        <td>Chief Financial Officer (CFO)</td>
                        <td>New York</td>
                        <td>64</td>
                        <td>2010-06-09</td>
                        <td>$725,000</td>
                    </tr>
                    <tr>
                        <td>Gloria Little</td>
                        <td>Systems Administrator</td>
                        <td>New York</td>
                        <td>59</td>
                        <td>2009-04-10</td>
                        <td>$237,500</td>
                    </tr>
                    <tr>
                        <td>Bradley Greer</td>
                        <td>Software Engineer</td>
                        <td>London</td>
                        <td>41</td>
                        <td>2012-10-13</td>
                        <td>$132,000</td>
                    </tr>
                    <tr>
                        <td>Dai Rios</td>
                        <td>Personnel Lead</td>
                        <td>Edinburgh</td>
                        <td>35</td>
                        <td>2012-09-26</td>
                        <td>$217,500</td>
                    </tr>
                    <tr>
                        <td>Jenette Caldwell</td>
                        <td>Development Lead</td>
                        <td>New York</td>
                        <td>30</td>
                        <td>2011-09-03</td>
                        <td>$345,000</td>
                    </tr>
                    <tr>
                        <td>Yuri Berry</td>
                        <td>Chief Marketing Officer (CMO)</td>
                        <td>New York</td>
                        <td>40</td>
                        <td>2009-06-25</td>
                        <td>$675,000</td>
                    </tr>
                    <tr>
                        <td>Caesar Vance</td>
                        <td>Pre-Sales Support</td>
                        <td>New York</td>
                        <td>21</td>
                        <td>2011-12-12</td>
                        <td>$106,450</td>
                    </tr>
                    <tr>
                        <td>Doris Wilder</td>
                        <td>Sales Assistant</td>
                        <td>Sydney</td>
                        <td>23</td>
                        <td>2010-09-20</td>
                        <td>$85,600</td>
                    </tr>
                    <tr>
                        <td>Angelica Ramos</td>
                        <td>Chief Executive Officer (CEO)</td>
                        <td>London</td>
                        <td>47</td>
                        <td>2009-10-09</td>
                        <td>$1,200,000</td>
                    </tr>
                    <tr>
                        <td>Gavin Joyce</td>
                        <td>Developer</td>
                        <td>Edinburgh</td>
                        <td>42</td>
                        <td>2010-12-22</td>
                        <td>$92,575</td>
                    </tr>
                    <tr>
                        <td>Jennifer Chang</td>
                        <td>Regional Director</td>
                        <td>Singapore</td>
                        <td>28</td>
                        <td>2010-11-14</td>
                        <td>$357,650</td>
                    </tr>
                    <tr>
                        <td>Brenden Wagner</td>
                        <td>Software Engineer</td>
                        <td>San Francisco</td>
                        <td>28</td>
                        <td>2011-06-07</td>
                        <td>$206,850</td>
                    </tr>
                    <tr>
                        <td>Fiona Green</td>
                        <td>Chief Operating Officer (COO)</td>
                        <td>San Francisco</td>
                        <td>48</td>
                        <td>2010-03-11</td>
                        <td>$850,000</td>
                    </tr>
                    <tr>
                        <td>Shou Itou</td>
                        <td>Regional Marketing</td>
                        <td>Tokyo</td>
                        <td>20</td>
                        <td>2011-08-14</td>
                        <td>$163,000</td>
                    </tr>
                    <tr>
                        <td>Michelle House</td>
                        <td>Integration Specialist</td>
                        <td>Sydney</td>
                        <td>37</td>
                        <td>2011-06-02</td>
                        <td>$95,400</td>
                    </tr>
                    <tr>
                        <td>Suki Burks</td>
                        <td>Developer</td>
                        <td>London</td>
                        <td>53</td>
                        <td>2009-10-22</td>
                        <td>$114,500</td>
                    </tr>
                    <tr>
                        <td>Prescott Bartlett</td>
                        <td>Technical Author</td>
                        <td>London</td>
                        <td>27</td>
                        <td>2011-05-07</td>
                        <td>$145,000</td>
                    </tr>
                    <tr>
                        <td>Gavin Cortez</td>
                        <td>Team Leader</td>
                        <td>San Francisco</td>
                        <td>22</td>
                        <td>2008-10-26</td>
                        <td>$235,500</td>
                    </tr>
                    <tr>
                        <td>Martena Mccray</td>
                        <td>Post-Sales support</td>
                        <td>Edinburgh</td>
                        <td>46</td>
                        <td>2011-03-09</td>
                        <td>$324,050</td>
                    </tr>
                    <tr>
                        <td>Unity Butler</td>
                        <td>Marketing Designer</td>
                        <td>San Francisco</td>
                        <td>47</td>
                        <td>2009-12-09</td>
                        <td>$85,675</td>
                    </tr>
                    <tr>
                        <td>Howard Hatfield</td>
                        <td>Office Manager</td>
                        <td>San Francisco</td>
                        <td>51</td>
                        <td>2008-12-16</td>
                        <td>$164,500</td>
                    </tr>
                    <tr>
                        <td>Hope Fuentes</td>
                        <td>Secretary</td>
                        <td>San Francisco</td>
                        <td>41</td>
                        <td>2010-02-12</td>
                        <td>$109,850</td>
                    </tr>
                    <tr>
                        <td>Vivian Harrell</td>
                        <td>Financial Controller</td>
                        <td>San Francisco</td>
                        <td>62</td>
                        <td>2009-02-14</td>
                        <td>$452,500</td>
                    </tr>
                    <tr>
                        <td>Timothy Mooney</td>
                        <td>Office Manager</td>
                        <td>London</td>
                        <td>37</td>
                        <td>2008-12-11</td>
                        <td>$136,200</td>
                    </tr>
                    <tr>
                        <td>Jackson Bradshaw</td>
                        <td>Director</td>
                        <td>New York</td>
                        <td>65</td>
                        <td>2008-09-26</td>
                        <td>$645,750</td>
                    </tr>
                    <tr>
                        <td>Olivia Liang</td>
                        <td>Support Engineer</td>
                        <td>Singapore</td>
                        <td>64</td>
                        <td>2011-02-03</td>
                        <td>$234,500</td>
                    </tr>
                    <tr>
                        <td>Bruno Nash</td>
                        <td>Software Engineer</td>
                        <td>London</td>
                        <td>38</td>
                        <td>2011-05-03</td>
                        <td>$163,500</td>
                    </tr>
                    <tr>
                        <td>Sakura Yamamoto</td>
                        <td>Support Engineer</td>
                        <td>Tokyo</td>
                        <td>37</td>
                        <td>2009-08-19</td>
                        <td>$139,575</td>
                    </tr>
                    <tr>
                        <td>Thor Walton</td>
                        <td>Developer</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2013-08-11</td>
                        <td>$98,540</td>
                    </tr>
                    <tr>
                        <td>Finn Camacho</td>
                        <td>Support Engineer</td>
                        <td>San Francisco</td>
                        <td>47</td>
                        <td>2009-07-07</td>
                        <td>$87,500</td>
                    </tr>
                    <tr>
                        <td>Serge Baldwin</td>
                        <td>Data Coordinator</td>
                        <td>Singapore</td>
                        <td>64</td>
                        <td>2012-04-09</td>
                        <td>$138,575</td>
                    </tr>
                    <tr>
                        <td>Zenaida Frank</td>
                        <td>Software Engineer</td>
                        <td>New York</td>
                        <td>63</td>
                        <td>2010-01-04</td>
                        <td>$125,250</td>
                    </tr>
                    <tr>
                        <td>Zorita Serrano</td>
                        <td>Software Engineer</td>
                        <td>San Francisco</td>
                        <td>56</td>
                        <td>2012-06-01</td>
                        <td>$115,000</td>
                    </tr>
                    <tr>
                        <td>Jennifer Acosta</td>
                        <td>Junior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>43</td>
                        <td>2013-02-01</td>
                        <td>$75,650</td>
                    </tr>
                    <tr>
                        <td>Cara Stevens</td>
                        <td>Sales Assistant</td>
                        <td>New York</td>
                        <td>46</td>
                        <td>2011-12-06</td>
                        <td>$145,600</td>
                    </tr>
                    <tr>
                        <td>Hermione Butler</td>
                        <td>Regional Director</td>
                        <td>London</td>
                        <td>47</td>
                        <td>2011-03-21</td>
                        <td>$356,250</td>
                    </tr>
                    <tr>
                        <td>Lael Greer</td>
                        <td>Systems Administrator</td>
                        <td>London</td>
                        <td>21</td>
                        <td>2009-02-27</td>
                        <td>$103,500</td>
                    </tr>
                    <tr>
                        <td>Jonas Alexander</td>
                        <td>Developer</td>
                        <td>San Francisco</td>
                        <td>30</td>
                        <td>2010-07-14</td>
                        <td>$86,500</td>
                    </tr>
                    <tr>
                        <td>Shad Decker</td>
                        <td>Regional Director</td>
                        <td>Edinburgh</td>
                        <td>51</td>
                        <td>2008-11-13</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Michael Bruce</td>
                        <td>Javascript Developer</td>
                        <td>Singapore</td>
                        <td>29</td>
                        <td>2011-06-27</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Donna Snider</td>
                        <td>Customer Support</td>
                        <td>New York</td>
                        <td>27</td>
                        <td>2011-01-25</td>
                        <td>$112,000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="profilePreview" class="form-label">Current Profile Picture</label>
                            <div class="text-center">
                                <img id="profilePreview" src="" class="modal-preview-img mb-2"
                                    onclick="showFullscreen(this.src)" title="Click to view fullscreen">
                            </div>
                            <input type="file" class="form-control" id="newProfilePicture" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Preview -->
    <div id="fullscreenPreview" onclick="closeFullscreen()">
        <span class="close-preview">&times;</span>
        <img src="" alt="Fullscreen preview">
    </div>

    <div class="container">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Nama Variabel CSS</th>
                    <th>Contoh Warna</th>
                    <th>Kode Warna Hex</th>
                </tr>
            </thead>
            <tbody>
                @php
                $colors = [
                    '--first-color',
                    '--first-color-alt',
                    '--first-color-alt-second',
                    '--first-color-lighter',
                    '--title-color',
                    '--text-color',
                    '--text-color-light',
                    '--input-color',
                    '--body-color',
                    '--container-color',
                    '--container-color-second',
                    '--color-bg-heroes',
                    '--scroll-bar-color',
                    '--scroll-thumb-color',
                    '--scroll-thumb-hover-color',
                    '--first-color-second',
                    '--first-color-second-alt',
                    '--first-color-second-alt-second',
                    '--color-home-description',
                    '--gradient-color',
                ];
                @endphp
                @foreach($colors as $color)
                <tr>
                    <td>{{ $color }}</td>
                    <td>
                        <div class="rounded-circle"
                            style="width: 30px; height: 30px; background: var({{ $color }});"></div>
                    </td>
                    <td id="hex-{{ Str::slug($color, '-') }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
        $variables = [
            [
                'name' => '--header-font',
                'description' => 'Header Font',
                'example' => '<span style="font-family: var(--header-font);">Sample Text</span>',
                'value' => 'var(--header-font)',
            ],
            [
                'name' => '--header-font-extraBold',
                'description' => 'Header Font Extra Bold',
                'example' => '<span style="font-family: var(--header-font-extraBold);">Sample Text</span>',
                'value' => 'var(--header-font-extraBold)',
            ],
            [
                'name' => '--body-font',
                'description' => 'Body Font',
                'example' => '<span style="font-family: var(--body-font);">Sample Text</span>',
                'value' => 'var(--body-font)',
            ],
            [
                'name' => '--font-medium',
                'description' => 'Font Weight Medium',
                'example' => '<span style="font-weight: var(--font-medium);">Medium Weight</span>',
                'value' => 'var(--font-medium)',
            ],
            [
                'name' => '--font-bold',
                'description' => 'Font Weight Bold',
                'example' => '<span style="font-weight: var(--font-bold);">Bold Weight</span>',
                'value' => 'var(--font-bold)',
            ],
            [
                'name' => '--font-extra-bold',
                'description' => 'Font Weight Extra Bold',
                'example' => '<span style="font-weight: var(--font-extra-bold);">Extra Bold Weight</span>',
                'value' => 'var(--font-extra-bold)',
            ],
            [
                'name' => '--m-0-5',
                'description' => 'Margin Bottom 0.5rem',
                'example' => '<div style="margin-bottom: var(--m-0-5); background-color: #f0f0f0;">Margin Example</div>',
                'value' => 'var(--m-0-5)',
            ],
            [
                'name' => '--z-modal',
                'description' => 'Z-Index for Modal',
                'example' => '<div style="position: relative; z-index: var(--z-modal);">Z-Index Example</div>',
                'value' => 'var(--z-modal)',
            ],
            // Add more variables as needed
        ];
        @endphp

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Variable Name</th>
                    <th>Description</th>
                    <th>Example</th>
                    <th>CSS Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($variables as $var)
                <tr>
                    <td>{{ $var['name'] }}</td>
                    <td>{{ $var['description'] }}</td>
                    <td>{!! $var['example'] !!}</td>
                    <td>{{ $var['value'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Font Variables -->
        <div>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Variable Type</th>
                        <th>Variable Name</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Font Variables -->
                    <tr>
                        <td>Font Variable</td>
                        <td>--header-font</td>
                        <td>
                            <p style="font-family: var(--header-font);">
                                This text uses --header-font.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Variable</td>
                        <td>--header-font-extraBold</td>
                        <td>
                            <p style="font-family: var(--header-font-extraBold);">
                                This text uses --header-font-extraBold.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Variable</td>
                        <td>--body-font</td>
                        <td>
                            <p style="font-family: var(--body-font);">
                                This text uses --body-font.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Variable</td>
                        <td>--body-font-extraBold</td>
                        <td>
                            <p style="font-family: var(--body-font-extraBold);">
                                This text uses --body-font-extraBold.
                            </p>
                        </td>
                    </tr>
                    <!-- Font Size Variables -->
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--big-font-size</td>
                        <td>
                            <p style="font-size: var(--big-font-size);">
                                This text uses --big-font-size.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--h1-font-size</td>
                        <td>
                            <h1 style="font-size: var(--h1-font-size);">
                                This heading uses --h1-font-size.
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--h2-font-size</td>
                        <td>
                            <h2 style="font-size: var(--h2-font-size);">
                                This heading uses --h2-font-size.
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--h3-font-size</td>
                        <td>
                            <h3 style="font-size: var(--h3-font-size);">
                                This heading uses --h3-font-size.
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--h4-font-size</td>
                        <td>
                            <h4 style="font-size: var(--h4-font-size);">
                                This heading uses --h4-font-size.
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--normal-font-size</td>
                        <td>
                            <p style="font-size: var(--normal-font-size);">
                                This text uses --normal-font-size.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--small-font-size</td>
                        <td>
                            <p style="font-size: var(--small-font-size);">
                                This text uses --small-font-size.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Size Variable</td>
                        <td>--smaller-font-size</td>
                        <td>
                            <p style="font-size: var(--smaller-font-size);">
                                This text uses --smaller-font-size.
                            </p>
                        </td>
                    </tr>
                    <!-- Font Weight Variables -->
                    <tr>
                        <td>Font Weight Variable</td>
                        <td>--font-medium</td>
                        <td>
                            <p style="font-weight: var(--font-medium);">
                                This text uses --font-medium.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Weight Variable</td>
                        <td>--font-bold</td>
                        <td>
                            <p style="font-weight: var(--font-bold);">
                                This text uses --font-bold.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Font Weight Variable</td>
                        <td>--font-extra-bold</td>
                        <td>
                            <p style="font-weight: var(--font-extra-bold);">
                                This text uses --font-extra-bold.
                            </p>
                        </td>
                    </tr>
                    <!-- Margin Variables -->
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-0-25</td>
                        <td>
                            <div style="background-color: #f0f0f0; margin-bottom: var(--m-0-25);">
                                This div uses --m-0-25.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-0-5</td>
                        <td>
                            <div style="background-color: #d0d0d0; margin-bottom: var(--m-0-5);">
                                This div uses --m-0-5.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-0-75</td>
                        <td>
                            <div style="background-color: #b0b0b0; margin-bottom: var(--m-0-75);">
                                This div uses --m-0-75.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-1</td>
                        <td>
                            <div style="background-color: #909090; margin-bottom: var(--m-1);">
                                This div uses --m-1.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-1-5</td>
                        <td>
                            <div style="background-color: #707070; margin-bottom: var(--m-1-5);">
                                This div uses --m-1-5.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-2</td>
                        <td>
                            <div style="background-color: #505050; margin-bottom: var(--m-2);">
                                This div uses --m-2.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-2-5</td>
                        <td>
                            <div style="background-color: #303030; margin-bottom: var(--m-2-5);">
                                This div uses --m-2-5.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-3</td>
                        <td>
                            <div style="background-color: #101010; color: #fff; margin-bottom: var(--m-3);">
                                This div uses --m-3.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Margin Variable</td>
                        <td>--m-4</td>
                        <td>
                            <div style="background-color: #000; color: #fff; margin-bottom: var(--m-4);">
                                This div uses --m-4.
                            </div>
                        </td>
                    </tr>
                    <!-- Z-Index Variables -->
                    <tr>
                        <td>Z-Index Variables</td>
                        <td>--z-tooltip, --z-fixed, --z-modal</td>
                        <td>
                            <div style="position: relative; width: 200px; height: 200px; background-color: rgba(255, 0, 0, 0.5); z-index: var(--z-tooltip);">
                                Z-Index: --z-tooltip
                                <div style="position: absolute; top: 30px; left: 30px; width: 150px; height: 150px; background-color: rgba(0, 255, 0, 0.5); z-index: var(--z-fixed);">
                                    Z-Index: --z-fixed
                                    <div style="position: absolute; top: 30px; left: 30px; width: 100px; height: 100px; background-color: rgba(0, 0, 255, 0.5); z-index: var(--z-modal);">
                                        Z-Index: --z-modal
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
        const colors = @json($colors);
        colors.forEach(function(colorName) {
            const computedStyle = getComputedStyle(document.documentElement);
            const colorValue = computedStyle.getPropertyValue(colorName).trim();

            // Create a temporary element to get the computed RGB value
            const tempElement = document.createElement('div');
            tempElement.style.backgroundColor = colorValue;
            document.body.appendChild(tempElement);

            const rgbColor = getComputedStyle(tempElement).backgroundColor;
            document.body.removeChild(tempElement);

            const hexColor = rgbToHex(rgbColor);
            const hexElementId = 'hex-' + colorName.replace(/--/g, '').replace(/[^a-zA-Z0-9]/g, '-');
            document.getElementById(hexElementId).textContent = hexColor;
        });

        function rgbToHex(rgb) {
            const rgbValues = rgb.match(/\d+/g);
            return '#' + rgbValues.map(function(value) {
                return ('0' + parseInt(value).toString(16)).slice(-2).toUpperCase();
            }).join('');
        }
    });
        </script>


    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    {{-- <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js"></script> --}}
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        new DataTable('#example',{
            fixedHeader: {
                header: true,
                footer: false
            }
        });
        // Initialize modal
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        
        // Open edit modal and populate with user data
        function openEditModal(user) {
            document.getElementById('userId').value = user.id;
            document.getElementById('profilePreview').src = user.profile_picture;
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('gender').value = user.gender;
            editModal.show();
        }

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
        document.getElementById('newProfilePicture').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('profilePreview');
                    previewImg.src = e.target.result;
                    // Memastikan event onclick masih berfungsi untuk gambar yang baru diupload
                    previewImg.onclick = () => showFullscreen(e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Save changes (implement your save logic here)
        function saveChanges() {
            // Get form data
            const formData = {
                id: document.getElementById('userId').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                gender: document.getElementById('gender').value,
                // Handle file upload separately if needed
            };

            // Add your save logic here
            console.log('Saving changes:', formData);
            
            // Close modal after save
            editModal.hide();
        }
    </script>
</body>

</html>