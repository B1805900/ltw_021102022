@extends('layouts.main')
@section('content')

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Trang chủ
      </h3>
      <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <span></span>Thống kê <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
          </li>
        </ul>
      </nav>
    </div>
    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="{{asset('dashboard-template/assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Doanh thu <i class="mdi mdi-chart-line mdi-24px float-right"></i>
            </h4>
            @php
                $saved_courses = App\Models\SavedCourse::all();
                $courses = App\Models\Course::all();
                $users = App\Models\User::all();
                $sales = 0;
                foreach($saved_courses as $sc){
                    $sales += (int) filter_var($sc->ofCourse->price, FILTER_SANITIZE_NUMBER_INT);
                }
            @endphp
            <h2 class="mb-5">VNĐ {{number_format($sales);}}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="{{asset('dashboard-template/assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Số khóa học <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5">{{$courses->count()}}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="{{asset('dashboard-template/assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Số người dùng hệ thống <i class="mdi mdi-diamond mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5">{{$users->count()}}</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Khóa học mới được đăng</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th> ID </th>
                    <th> Người đăng </th>
                    <th> Tên Khóa học </th>
                    <th> Ngày đăng </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($recent_courses as $rc)


                  <tr>
                    <td>
                        {{$rc->id}}
                    </td>
                    <td>
                      <img src="{{asset('/images/avatar/')}}/{{$rc->hasOwner->avatar}}" class="me-2" alt="image"> {{$rc->hasOwner->name}}
                    </td>
                    <td> {{$rc->name}} </td>
                    <td>

                    </td>
                    <td> {{$rc->upload_date->format('d-m-Y')}} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>



@stop
