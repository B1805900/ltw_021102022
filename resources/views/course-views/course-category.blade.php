@extends('layouts.main')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Quản lý khóa học </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Quản lý khóa học</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh mục khóa học </li>
      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                @if (Session::has('success'))
                    <h4 class="card-title msg text-success">{{Session::get('success')}}</h4>

                @elseif (Session::has('fail'))
                <h4 class="card-title msg text-danger">{{Session::get('fail')}}</h4>
                @endif
            <div class="row mb-3">
                <div class="col-lg-6">
                    <a id="" href="{{route('addCategory')}}" class="btn  me-3 btn-block btn-lg btn-gradient-primary ">+ Thêm danh mục</a>
                    <div class="btn-group">
                        <button id="sortUserByRole"
                            class="btn dropdown-toggle   me-3 btn-block btn-lg btn-gradient-primary "
                            data-bs-toggle="dropdown"> Vai trò </button>

                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" id="searchUserInput" placeholder="Nhập gì đó..."
                            aria-label="Nhập gì đó..." aria-describedby="basic-addon2">
                        <button class="btn btn-sm btn-gradient-primary" type="button"> Tìm Kiếm </button>
                    </div>

                </div>

            </div>
            <table id="data-table" class="table table-striped">
                <thead>
                  <tr>
                    <th> id </th>
                    <th> Tên danh mục </th>
                    <th> Ảnh minh họa </th>
                    <th> Số khóa học </th>
                    <th> Thao tác </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ( $categories as $category)


                  <tr>
                    <td>{{$category->id}}</td>
                    <td> {{$category->name}} </td>
                    <td>
                        <img style="border-radius: 0%;height:50px;width:50px " src="{{asset('images/categories')}}/{{$category->image}}">
                    </td>
                    <td>
                        {{$category->hasCourses() ? $category->hasCourses()->count() : false}}
                    </td>
                    <td>
                        <button type="button" title="Chỉnh sửa danh mục" id=""
                        data-toggle="tooltip" data-placement="top"
                        class="btn  tooltip-r btn-gradient-success btn-rounded btn-icon">
                        <a href="{{route('editCategory',['id'=> $category->id])}}"
                            ><i class="mdi mdi-eye"></i></a>
                    </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="row mt-3 ">
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>


              </div>
            </div>
        </div>
    </div>
  </div>
@stop
