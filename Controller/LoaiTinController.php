<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use Illuminate\Support\Facades\Auth;

class LoaiTinController extends Controller
{
	//

	public function kiemtra(){
        if(Auth::check()){
            $us=Auth::user();
            view()->share('us',$us);
        }
    }


	public function getDanhSach(){
		$loaitin=LoaiTin::all();
		$this->kiemtra();
		return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);

	}

	 public function suaDanhSach($id){
		$theloai=TheLoai::all();
		$loaitin = LoaiTin::find($id);
		$this->kiemtra();
		return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
		
	}

	public function postsuaDanhSach(Request $re,$id){
		$loaitin =LoaiTin::find($id);
		$this->validate($re,
			[
			   'Ten' => 'required|min:3|max:100|unique:TheLoai,Ten',
			   'TheLoai'=> 'required'
			],
			[

				'Ten.required' => ' Điền vào tên thể loại',
				'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
				'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
				'Ten.unique' => ' Tên thể loại đã tồn tại',
				'TheLoai.required'=>'Bạn chưa chọn tên thể loại',
			]);

		$loaitin->Ten = $re ->Ten;
		$loaitin->TenKhongDau = changeTitle($re->Ten);
		$loaitin->idTheLoai=$re->TheLoai;
		$loaitin->save();
		return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sua thành công');
	}


	 public function themDanhSach(){
		$theloai= TheLoai::all();
		$this->kiemtra();
		return view('admin.loaitin.them',['theloai'=>$theloai]);
		
	}

	public function postthemDanhSach(Request $re){
		$this->validate($re,
			[
			   'Ten' => 'required|min:3|max:100|unique:LoaiTin,Ten',
			   'TheLoai'=> 'required'
			],
			[

				'Ten.required' => ' Điền vào tên loại tin',
				'Ten.min' => 'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
				'Ten.max' => 'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
				'Ten.unique' => ' Tên loại tin đã tồn tại',
				'TheLoai.required'=>'Bạn chưa chọn tên thể loại',
			]);

		$loaitin = new LoaiTin;
		$loaitin->Ten = $re ->Ten;
		$loaitin->TenKhongDau = changeTitle($re->Ten);
		$loaitin->idTheLoai= $re->TheLoai;
		$loaitin->save();
		return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công');

	}

	public function getXoaDanhSach($id){
		$loaitin = LoaiTin::find($id);
		$loaitin->delete();
		return redirect('admin/loaitin/danhsach')->with('thongbao','Bạn đã xóa thành công');
	}
}
