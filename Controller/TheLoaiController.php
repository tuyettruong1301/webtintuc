<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use Illuminate\Support\Facades\Auth;

class TheLoaiController extends Controller
{
    //
     public function kiemtra(){
        if(Auth::check()){
            $us=Auth::user();
            view()->share('us',$us);
        }
    }


    public function getDanhSach(){
        $theloai=TheLoai::all();
        $this->kiemtra();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);

    }

     public function suaDanhSach($id){
        $theloai = TheLoai::find($id);
        $this->kiemtra();
        return view('admin.theloai.sua',['theloai'=>$theloai]);
        
    }

    public function postsuaDanhSach(Request $re,$id){
        $theloai =TheLoai::find($id);
        $this->validate($re,
            [
               'Ten' => 'required|min:3|max:100|unique:TheLoai,Ten'
            ],
            [

                'Ten.required' => ' Điền vào tên thể loại',
                'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
                'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
                'Ten.unique' => ' Tên thể loại đã tồn tại',
            ]);

        $theloai->Ten = $re ->Ten;
        $theloai->TenKhongDau = changeTitle($re->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sua thành công');
    }


     public function themDanhSach(){
        $this->kiemtra();
        return view('admin.theloai.them');
        
    }

    public function postthemDanhSach(Request $re){
        $this->validate($re,
            [
               'Ten' => 'required|min:3|max:100|unique:TheLoai,Ten'
            ],
            [

                'Ten.required' => ' Điền vào tên thể loại',
                'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
                'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
                'Ten.unique' => ' Tên thể loại đã tồn tại',
            ]);

        $theloai = new TheLoai;
        $theloai->Ten = $re ->Ten;
        $theloai->TenKhongDau = changeTitle($re->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');

    }

    public function getXoaDanhSach($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
