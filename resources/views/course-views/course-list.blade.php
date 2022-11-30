@extends('layouts.main')
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Quản lý khóa học </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Quản lý khóa học</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách khóa học</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if (Session::has('success'))
                        <h4 class="card-title msg text-success">{{ Session::get('success') }}</h4>
                    @elseif (Session::has('fail'))
                        <h4 class="card-title msg text-danger">{{ Session::get('fail') }}</h4>
                    @endif
                    @php
                        $categories = App\Models\Category::all();
                    @endphp
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <a id="" href="{{ route('addCourse') }}"
                                class="btn  me-3 btn-block btn-lg btn-gradient-primary ">+ Thêm khóa học</a>
                            <div class="btn-group">
                                <button id="sortUserByRole"
                                    class="btn dropdown-toggle   me-3 btn-block btn-lg btn-gradient-primary "
                                    data-bs-toggle="dropdown"> Danh mục </button>
                                <div class="dropdown-menu " id="filter">
                                    <a class="dropdown-item">Tất cả</a>
                                    @foreach ($categories as $cat)
                                    <a class="dropdown-item">{{$cat->name}}</a>
                                    @endforeach
                                </div>
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
                    <div class="col-lg-12 grid-margin stretch-card">

                        <table id="data-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Tên khóa học </th>
                                    <th> Danh mục </th>
                                    <th> Số chương </th>
                                    <th> Giá </th>
                                    <th> Trạng thái </th>
                                    <th> Ngày thêm </th>
                                    <th> Người thêm </th>
                                    <th> Thao tác </th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td> {{ $course->name }} </td>
                                        <td>{{ $course->hasCategory->name ? $course->hasCategory->name : '' }}</td>
                                        <td> {{ $course->hasLessons->count() }} </td>
                                        <td> {{ $course->price }} </td>
                                        <td> {{ $course->status }} </td>
                                        <td> {{ $course->upload_date->format('d-M-Y') }} </td>
                                        <td> {{ $course->hasOwner->name ? $course->hasOwner->name : '' }} </td>
                                        <td>
                                            <a href="{{ route('editCourse', ['id' => $course->id]) }}"
                                                >
                                            <button type="button" title="Chỉnh sửa thông tin" id=""
                                                data-toggle="tooltip" data-placement="top"
                                                class="btn act-user-btn tooltip-r btn-gradient-success btn-rounded btn-icon">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('showAllLesson', ['id' => $course->id]) }}"
                                            >
                                            <button type="button" title="Quản lý nội dung" id=""
                                                data-toggle="tooltip" data-placement="top"
                                                class="btn act-user-btn tooltip-r btn-gradient-success btn-rounded btn-icon">
                                                <i class="mdi mdi-library-plus"></i>
                                            </button>
                                        </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-js')
