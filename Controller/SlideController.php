<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
    //
    public function kiemtra(){
        if(Auth::check()){
            $us=Auth::user();
            view()->share('us',$us);
        }
    }


    public function getDanhSach(){
    	$slide=Slide::all();
        $this->kiemtra();
    	return view('admin.slide.danhsach',['slide'=>$slide]);

    }

     public function suaDanhSach($id){
        $slide=Slide::find($id);
        $this->kiemtra();
     	return view('admin.slide.sua',['slide'=>$slide]);
    	
    }

    public function postsuaDanhSach(Request $re,$id){
        $this->validate($re,
            [
               'ten'=>'required',
               'NoiDung' => 'required',
               'link'=>'required',
            ],
            [
                'ten.required'=>'Bạn chưa nhập tên ',
                'NoiDung.required'=>' Bạn chưa nhập nội dung',
                'link.required' =>'Bạn chưa nhập link',
            ]);
        $slide=Slide::find($id);
        $slide->Ten=$re->ten;
        $slide->NoiDung=$re->NoiDung;
        $slide->link=$re->link;
        if($re->hasFile('Hinh')){
            $file = $re->file('Hinh');
            $name=$file->getClientOriginalName();
            $Hinh= str_random(4)."_".$name;         
            $file->move("upload/slide",$Hinh);
            //unlink("upload/slide/".$slide->Hinh);
            $slide->Hinh = $Hinh;
        }
        else{
            $slide->Hinh="";
        }
        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
    

    }

    public function getXoaDanhSach($id){
        $slide =Slide::find($id);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao','Bạn đã xóa thành công');
    	
    }

    public function themDanhSach(){
        $this->kiemtra();
        return view('admin/slide/them');
    }


    public function postthemDanhSach(Request $re){
    	$this->validate($re,
    		[
               'ten'=>'required',
    		   'NoiDung' => 'required',
               'link'=>'required',
            ],
    		[
                'ten.required'=>'Bạn chưa nhập tên ',
                'NoiDung.required'=>' Bạn chưa nhập nội dung',
                'link.required' =>'Bạn chưa nhập link',
    		]);
        $slide=new Slide;
        $slide->Ten=$re->ten;
        $slide->NoiDung=$re->NoiDung;
        $slide->link=$re->link;
        if($re->hasFile('Hinh')){
            $file = $re->file('Hinh');
            $name=$file->getClientOriginalName();
            $Hinh= str_random(4)."_".$name;         
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;
        }
        else{
            $slide->Hinh="";
        }
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao',' Bạn đã thêm thành công');
    

    }
}
