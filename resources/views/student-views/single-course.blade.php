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
    <!-- search section -->
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
<!-- single course section -->
                    @php
                        $saved_courses = App\Models\SavedCourse::all();

                    @endphp
<section class="single-course spad pb-0">
    <div class="container">
        <div class="course-meta-area">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="course-note">Featured Course</div>
                    <h3>{{$single_course->name}}</h3>
                    <div class="course-metas">
                        <div class="course-meta">
                            <div class="course-author">
                                <div class="ca-pic set-bg" data-setbg="img/authors/2.jpg"></div>
                                <h6>Người đăng</h6>
                                <p>{{$single_course->hasOwner->name}}, <span>{{$single_course->hasOwner->hasRole->role}}</span></p>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="cm-info">
                                <h6>Danh mục</h6>
                                <p>{{$single_course->hasCategory->name}}</p>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="cm-info">
                                <h6></h6>
                                <p>{{$single_course->hasSaves->count()}} Học sinh</p>
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
                    @php
                        $saved = false;
                        foreach ($saved_courses as $key => $value) {
                            if($value->course_id ==$single_course->id && $value->user_id == Auth()->id()){
                                $saved = true;
                                break;
                            }
                        }
                    @endphp
                    <form action="{{route('pay')}}" method="POST">

                    <a href="#" class="site-btn price-btn">Giá: {{$single_course->price}}</a>
                        @csrf
                        <input type="hidden" name="idCourse" value="{{$single_course->id}}">
                        <input type="hidden" name="amount" value="{{number_format((float)preg_replace('/[^0-9]/','',$single_course->price)/24855,2,'.','')}}">
                        <button type="submit" class="site-btn buy-btn @if($saved) d-none @endif" >Mua với PAYPAL <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                        @if($saved)
                        <button type="button" class="site-btn buy-btn" >Khóa học đã mua <i class="fa fa-check" aria-hidden="true"></i></button>
                        @endif
                    </form>
                    {{-- <a href="#" class="site-btn buy-btn">Đăng ký khóa học</a> --}}
                </div>
            </div>
        </div>
        <img src="img/courses/single.jpg" alt="" class="course-preview">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 course-list">
                <div class="cl-item">
                    <h4>Mô tả khóa học</h4>
                    <p>{{$single_course->desc}}</p>
                </div>
                <div class="cl-item">
                    <h4>Các chương của khóa học</h4>
                    			<!-- Element -->
			<div class="element">

				<div class="row">
					<div class="col-lg-12 mb-lg-0">
						<!-- Accordions -->
						<div id="accordion" class="accordion-area">
                            @foreach($single_course->hasLessons as $lesson)
                            <div class="panel">
								<div class="panel-header" id="headingOne">
									<button class="panel-link" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="false" aria-controls="collapse1">{{$lesson->name}}</button>
								</div>
								<div id="collapse{{$lesson->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="panel-body">
                                        <div class="col-lg-6 mb-lg-0">

                                            <p>{{$lesson->desc}}</p>
                                        </div>
                                        <div class="col-lg-6 mb-lg-0">

                                            <a href="{{route('showLesson',['idCourse' => $lesson->ofCourse->id,'idLesson' => $lesson->id])}}" class="site-btn">Xem chương</a>
                                        </div>
									</div>
								</div>
							</div>
                            @endforeach



						</div>
					</div>

				</div>
			</div>
			<!-- Element -->
                </div>

            </div>
        </div>
    </div>
</section>
<!-- single course section end -->
@stop
