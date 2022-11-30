@extends('student-layouts.details')
@section('page-content')
	<!-- Page info -->
	<div class="page-info-section set-bg" data-setbg="{{asset('mainpage-template/img/page-bg/1.jpg')}}">
		<div class="container">
			<div class="site-breadcrumb">
				<a href="#">Home</a>
				<span>Courses</span>
			</div>
		</div>
	</div>
	<!-- Page info end -->
<section class="search-section">
    <div class="container">
        <div class="search-warp">
            <div class="section-title text-white">
                <h2>Tìm kiếm khóa học</h2>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <!-- search form -->
                    <form method="POST" action="{{route('searchCourseByNameAndCat')}}" class="course-search-form">
                        @csrf
                        <input name="course_name" type="text" required placeholder="Nhập tên khóa học" >
                        {{-- <input name="category_name" type="text" required class="last-m" placeholder="Category"> --}}
                        <select name="category_id" class="custom-select custom-select-lg mb-3 "
                        style="    height: 56px;
                        width: 36.6%;
                        padding: 0 30px;
                        margin-right: 18px;
                        float: left;
                        border: none;
                        font-size: 14px;
                        background: #edf4f6;"
                        required
                        >
                            <option selected disabled value="">Chọn danh mục</option>
                            @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name}}</option>

                            @endforeach
                          </select>
                        <button type="submit" class="site-btn">Search Couse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- search section end -->
<section class="single-course spad pb-0">
    <div class="container">
        <div class="course-meta-area">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="course-note">Featured Course</div>
                    <h3><a href="{{route('showSingleCourse',['idCourse' => $saved_courses->course_id])}}">{{$saved_courses->ofCourse->name}}</a></h3>
                    <div class="course-metas">
                        <div class="course-meta">
                            <div class="course-author">
                                <div class="ca-pic set-bg" data-setbg="img/authors/2.jpg"></div>
                                <h6>Người đăng</h6>
                                <p>{{$saved_courses->ofCourse->hasOwner->name}}, <span>{{$saved_courses->ofCourse->hasOwner->hasRole->role}}</span></p>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="cm-info">
                                <h6>Danh mục</h6>
                                <p>{{$saved_courses->ofCourse->hasCategory->name}}</p>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="cm-info">
                                <h6></h6>
                                <p>{{$saved_courses->hasSaves->count()}} Học sinh</p>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="cm-info">
                                <h6>Reviews</h6>
                                <p>2 Reviews <span class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star is-fade"></i>
                                </span></p>
                            </div>
                        </div>
                    </div>


                    <a href="#" class="site-btn price-btn">Giá: {{$saved_courses->ofCourse->price}}</a>

                    {{-- <a href="#" class="site-btn buy-btn">Đăng ký khóa học</a> --}}
                </div>
            </div>
        </div>
        <img src="img/courses/single.jpg" alt="" class="course-preview">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 course-list">
                <div class="cl-item">
                    <h4>{{$lesson->name}}</h4>
                    <p>{{$lesson->desc}}</p>
                </div>
                <div class="cl-item">
                    <h4>Nội dung</h4>
                    			<!-- Element -->
			<div class="element">

				<div class="row">
					<div class="col-lg-12 mb-lg-0" style="border-bottom: 3px solid black ">
						<!-- Accordions -->
						<div id="accordion" class="accordion-area">
                            {!!($lesson->content)!!}




						</div>
					</div>
                    <div class="m-3" >
                    <a href="{{route('showSingleCourse',['idCourse' => $saved_courses->course_id])}}" class="site-btn">Trở lại</a>

                    </div>

				</div>
			</div>
			<!-- Element -->
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
