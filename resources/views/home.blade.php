@extends('layout')

@section('content')

<body class="">
    <div class="panel-header panel-header-sm">
    </div>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-xl navbar-transparent  bg-primary  navbar-absolute">
        <div class="container justify-content-around">
            <form action="{{ action('ServicesController@keywordReserch') }}" method="POST">
                @csrf
              <div class="input-group no-border ">
                <input type="text" value="" class="form-control" placeholder="Search..." name="url">

                <div class="input-group-append">
                  <div class="input-group-text">
                   <button type="submit" class="form-control now-ui-icons ui-1_zoom-bold"> </button>
                  </div>
                </div>
              </div>
            </form>
        </div>

      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-xl">
            <div class="header text-center">
                <h1 class="title justify-content-lg-center">Keyword search</h1>
                <p class="category"></p>
            </div>
      </div>

      <div class="content ">
        <div class="justify-content-xl-center">
          <div class="col-md-12  ">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title"> Keyword list</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Keyword
                      </th>
                      <th>
                        Frequency
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                            @foreach ($posts as $key => $value)
                             <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                            @endforeach
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          @endsection

