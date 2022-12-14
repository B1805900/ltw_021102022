<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\SavedCourse;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
class CoursesController extends Controller
{
    public function showAllCourse(){
        $courses = Course::paginate(10);
        return view('course-views.course-list',compact('courses'));
    }

    public function showAllCategory(){
        $categories = Category::paginate(10);

        return view('course-views.course-category',compact('categories'));
    }
    public function addCategory(){
        return view('course-views.add-category',);
    }
    public function editCategory($idCategory){
        $category = Category::find($idCategory);
        return view('course-views.add-category',compact('category'));
    }
    public function addCourse(){
        $categories = Category::all();
        return view('course-views.add-course',compact('categories'));
    }
    public function editCourse($idCourse){
        $categories = Category::all();
        $course = Course::find($idCourse);
        return view('course-views.add-course',compact('categories','course'));
    }
    public function addLesson($id){
        $course = Course::find($id);
        return view('course-views.add-lesson',compact('course'));
    }
    public function editLesson($idCourse,$idLesson){
        $course = Course::find($idCourse);
        $lesson = Lesson::find($idLesson);
        return view('course-views.add-lesson',compact('course','lesson'));
    }
    public function showAllLesson($id){
        $course = Course::find($id);
        $lessons = Lesson::where('course_id','=',$course->id)->paginate(10);
        return view('course-views.lesson-list',compact('course','lessons'));
    }


    public function storeCategory(Request $request){
        if($request->idCategory){
            $request->validate([
                'name' => 'required|max:255',
                'img' => '|max:10000',
                'desc' => 'required|min:30'
            ],[
                'name.required' => 'T??n danh m???c kh??ng ???????c b??? tr???ng',
                'name.unique' => 'T??n danh m???c ???? ???????c t???o',
                'img.max' => 'File ???nh qu?? l???n',
                'desc.required' => 'M?? t??? danh m???c kh??ng ???????c ????? tr???ng',
                'desc.min' => 'M?? t??? ??t nh???t 30 k?? t???'
            ]
        );
            if($request->hasFile('img')){
                $file = $request->file('img') ;
                $fileName = $file->hashName() ;
                $destinationPath = public_path().'/images/categories';
                $file->move($destinationPath,$fileName);
                $img = Category::where('id',$request->idCategory)->update([
                    'image' => $fileName,
                ]);
            }
        $category = Category::where('id',$request->idCategory)->update([
            'name' => $request->name,
            'description' => $request->desc,
        ]);
            return redirect()->route('showAllCategory')->with('success','C???p nh???t danh m???c th??nh c??ng');



        }
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'img' => 'required|max:10000',
            'desc' => 'required|min:30'
        ],[
            'name.required' => 'T??n danh m???c kh??ng ???????c b??? tr???ng',
            'name.unique' => 'T??n danh m???c ???? ???????c t???o',
            'img.required' => '???nh minh h???a kh??ng ???????c ????? tr???ng',
            'img.max' => 'File ???nh qu?? l???n',
            'desc.required' => 'M?? t??? danh m???c kh??ng ???????c ????? tr???ng',
            'desc.min' => 'M?? t??? ??t nh???t 30 k?? t???'
        ]
    );
    $file = $request->file('img') ;
    $fileName = $file->hashName() ;
    $destinationPath = public_path().'/images/categories';
    $file->move($destinationPath,$fileName);

    $category = Category::create([
        'name' => $request->name,
        'image' => $fileName,
        'description' => $request->desc,
    ]);
    if ($category){
        return redirect()->route('showAllCategory')->with('success','T???o danh m???c th??nh c??ng');
    }else{
        return redirect()->route('showAllCategory')->with('fail','T???o danh m???c kh??ng th??nh c??ng');

    }
    }
    public function storeCourse(Request $request){
        if($request->idCourse){
            $request->validate([
                'name' => 'required|max:255',
                'img' => 'max:10000',
                'category' => 'required',
                'price' => 'required',
                'desc' => 'required|min:30'
            ],[
                'name.required' => 'T??n danh m???c kh??ng ???????c b??? tr???ng',
                'name.unique' => 'T??n danh m???c ???? ???????c t???o',
                'img.max' => 'File ???nh qu?? l???n',
                'desc.required' => 'M?? t??? danh m???c kh??ng ???????c ????? tr???ng',
                'desc.min' => 'M?? t??? ??t nh???t 30 k?? t???'
            ]
        );
        if($request->hasFile('img')){
            $file = $request->file('img') ;
            $fileName = $file->hashName() ;
            $destinationPath = public_path().'/images/courses';
            $file->move($destinationPath,$fileName);
            $img = Course::where('id',$request->idCourse)->update([
                'image' => $fileName,
            ]);
        }
        $course = Course::where('id',$request->idCourse)->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'desc' => $request->desc,
            'update_date' => Carbon::now(),
        ]);

        return redirect()->route('showAllCourse')->with('success','S???a th??ng tin kh??a h???c th??nh c??ng');

    }
        $request->validate([
            'name' => 'required|unique:courses,name|max:255',
            'category' => 'required',
            'price' => 'required',
            'desc' => 'required|min:50|max:255',
            'img' => 'required|max:10000',

        ],
        [
            'name.required' => 'T??n kh??a h???c kh??ng ???????c tr???ng',
            'name.unique' => 'T??n kh??a h???c ???? ???????c d??ng',
            'name.max' => 'T??n kh??a h???c qu?? d??i',
            'category.required' => ' Ch??a ch???n danh m???c cho kh??a h???c',
            'price.required' => 'Gi?? kh??a h???c kh??ng ???????c ????? tr???ng',
            'price.numeric' => 'Gi?? ti???n ph???i l?? s???',
            'desc.required' => 'M?? t??? kh??a h???c kh??ng ???????c ????? tr???ng',
            'desc.min' => 'M?? t??? kh??a h???c ??t nh???t 50 k?? t???',
            'desc.max' => 'M?? t???  kh??a h???c qu?? d??i',
            'img.required' => '???nh minh h???a kh??ng ???????c ????? tr???ng',
            'img.max' => 'File ???nh qu?? l???n',
        ]);
		//dd('validate thanh cong');
		//dd($request->file('img'));
		//exit;
        $file = $request->file('img') ;
        $fileName = $file->hashName() ;

        $destinationPath = public_path().'/images/courses';
        $file->move($destinationPath,$fileName);

        $course = Course::create([
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'desc' => $request->desc,
            'owner' => Auth::id(),
            'upload_date' => Carbon::now(),
            'image' => $fileName,
        ]);

        if($course){
            return redirect()->route('showAllCourse')->with('success','Th??m kh??a h???c th??nh c??ng');
        }
        else{
            return redirect()->route('showAllCourse')->with('fail','Th??m kh??a h???c kh??ng th??nh c??ng');
        }
    }

    public function storeLesson($idCourse, Request $request){
        if($request->idLesson){
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'content' => 'required',
            ],[
                'name.required' => 'T??n ch????ng h???c kh??ng ???????c tr???ng',
                'desc.required' => 'M?? t??? ch????ng h???c kh??ng ???????c ????? tr???ng',
                'content.required' => 'N???i dung ch????ng h???c kh??ng ???????c ????? tr???ng',
            ]);
            Lesson::where('id',$request->idLesson)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'content' => $request->content,
                'update_date' => Carbon::now(),
            ]);
            return redirect()->route('showAllLesson',['id' => $idCourse])->with('success','S???a th??ng tin ch????ng h???c th??nh c??ng');
        }
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'content' => 'required',
        ],[
            'name.required' => 'T??n ch????ng h???c kh??ng ???????c tr???ng',
            'desc.required' => 'M?? t??? ch????ng h???c kh??ng ???????c ????? tr???ng',
            'content.required' => 'N???i dung ch????ng h???c kh??ng ???????c ????? tr???ng',
        ]);
        $lesson = Lesson::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'content' => $request->content,
            'upload_date' => Carbon::now(),
            'course_id' => $idCourse,
        ]);
        if($lesson){
            return redirect()->route('showAllLesson',['id' => $idCourse])->with('success','Th??m ch????ng h???c th??nh c??ng');
        }else{
            return redirect()->route('showAllLesson',['id' => $idCourse])->with('fail','Th??m ch????ng h???c kh??ng th??nh c??ng');
        }
    }

    public function deleteLesson($idLesson){
        Lesson::find($idLesson)->delete();
        return redirect()->back()->with('success','X??a ch????ng th??nh c??ng');
    }
//----------------------------------------------------------------
// Trang ch??? h???c vi??n
    public function showMainPage(){
        $categories = Category::all();
        $courses = Course::all();
        return view('student-views.main-page',compact('categories','courses'));

    }

    public function searchCourseByNameAndCat(Request $request){
        $courses_searched = Course::join('categories','categories.id','=','courses.category_id')
        ->where('courses.name','like',"%$request->course_name%")
        ->where('categories.id','=',$request->category_id)
        ->get(['courses.*','categories.name as categoryName' ]);
        $categories = Category::all();
        $courses = Course::all();
        return view('student-views.courses-searched',compact('categories','courses','courses_searched'));
    }

    public function showSingleCourse($idCourse){
        $single_course = Course::find($idCourse);
        $categories = Category::all();

        return view('student-views.single-course',compact('categories','single_course'));
    }

    public function addToWishList($idCourse){
        if(!Auth::check()) return redirect()->back()->with('error','H??y ????ng nh???p ????? ti???p t???c');
        $create = Wishlist::create([
            'course_id' => $idCourse,
            'user_id' => Auth::id()
        ]);
        if($create){
            return redirect()->back()->with("success","Th??m v??o y??u th??ch th??nh c??ng");

        }
        else return ;
    }

    public function deleteWishItem($id){
        Wishlist::find($id)->delete();
        return redirect()->back()->with("success","X??a th??nh c??ng");
    }

    public function showLesson($idCourse,$idLesson){
        $categories = Category::all();
        $saved_courses = SavedCourse::where([
            'course_id'=>$idCourse,
            'user_id'=>Auth::id()
        ])->first();
        $lesson = Lesson::find($idLesson);
        if(!$saved_courses){
            return redirect()->back()->with('error','B???n ch??a mua kh??a h???c n??y');
        }
        return view('student-views\lesson-page',compact('categories','saved_courses','lesson'));
    }



}
