<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Chat;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	//
	public function kiemtra(){
        if(Auth::check()){
            $us=Auth::user();
            view()->share('us',$us);
        }
    }


	public function getDanhSach(){
		$user=User::all();
		 $this->kiemtra();
		return view('admin.user.danhsach',['user'=>$user]);

	}

	 public function suaDanhSach($id){
		$user=User::find($id);
		 $this->kiemtra();
		 $chat = Chat::where('idUser','=',$id."")->get();
		return view('admin.user.sua',['user'=>$user,'chat'=>$chat]);
		
	}

	public function postsuaDanhSach(Request $re,$id){

		$user= User::find($id);
		$this->validate($re,
			[
			   'Ten'=>'required|min:3',
		  
			],
			[
				'Ten.required'=>'Bạn chưa nhập tên ',
				'Ten.min'=>'  Tên ít nhất phải có 3 ký tự ',
			
			]);
		if($re->changepassword == "on"){
			 $this->validate($re,
			[
			   'Password'=>'required|min:3|max:32',
			   'Password1'=>'required|same:Password',
		  
			],
			[
				'Password.required'=>' Bạn chưa nhập lại mật khẩu',
				'Password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password1.required'=>'Bạn chưa nhập lại mật khẩu',
				'Password1.same'=>'Mật khẩu nhập lại chưa khớp',
			]);
			 $user->password= bcrypt($re->Password);

		} 
   
		$user->name=$re->Ten;
		$user->quyen=$re->Quyen;
		$user->save();
		return redirect('admin/user/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
	

	}

	public function getXoaDanhSach($id){
		$user=User::find($id);
		$user->delete();
		return redirect('admin/user/danhsach')->with('thongbao','Bạn đã xóa thành công');
		
	}

	public function themDanhSach(){
		$this->kiemtra();
		return view('admin/user/them');
	}


	public function postthemDanhSach(Request $re){
		$this->validate($re,
			[
			   'Ten'=>'required|min:3',
			   'Email' => 'required|email|unique:users,email',
			   'Password'=>'required|min:3|max:32',
			   'Password1'=>'required|same:Password',
			],
			[
				'Ten.required'=>'Bạn chưa nhập tên ',
				'Ten.min'=>'  Tên ít nhất phải có 3 ký tự ',
				'Email.required' =>'Bạn chưa nhập email',
				'Email.email'=>' Email không đúng định dạng',
				'Email.unique'=>'Email đã được đăng ký',
				'Password.required'=>' Bạn chưa nhập lại mật khẩu',
				'Password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password1.required'=>'Bạn chưa nhập lại mật khẩu',
				'Password1.same'=>'Mật khẩu nhập lại chưa khớp',
			]);
		$user= new User;
		$user->name=$re->Ten;
		$user->email=$re->Email;
		$user->password= bcrypt($re->Password);
		$user->quyen=$re->Quyen;
		$user->save();
		return redirect('admin/user/them')->with('thongbao','Bạn đã thêm thành công');
	}

	public function dangnhapAdmin(){
		return view('admin.login');
	}

	public function postdangnhapAdmin(Request $re){
		$this->validate($re,
			[
			   'email' => 'required',
			   'password'=>'required|min:3|max:32',
			],
			[
			 
				'Email.required' =>'Bạn chưa nhập email',
				'Password.required'=>' Bạn chưa nhập lại mật khẩu',
				'Password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
			]);
		if(Auth::attempt(['email'=>$re->email,'password'=>$re->password])){
			 
            return redirect('admin/theloai/danhsach');
		}else {
			return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
		}
	}

	public function getDangXuatAdmin(){
		Auth::logout();
		return redirect('trangchu');
	}
}
