<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('admin/dangnhap','UserController@dangnhapAdmin');
Route::post('admin/dangnhap','UserController@postdangnhapAdmin');
Route::get('admin/logout','UserController@getDangXuatAdmin');
Route::get('admin/report/{id}/{idTin}/{noidung}','TinTucController@report');

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	Route::group(['prefix'=>'theloai'],function(){
		Route::get('danhsach','TheLoaiController@getDanhSach');
		Route::get('them','TheLoaiController@themDanhSach');
		Route::post('them','TheLoaiController@postthemDanhSach');
		Route::get('sua/{id}','TheLoaiController@suaDanhSach');
		Route::post('sua/{id}','TheLoaiController@postsuaDanhSach');
		Route::get('xoa/{id}','TheLoaiController@getXoaDanhSach');
	});
	Route::group(['prefix'=>'loaitin'],function(){
		Route::get('danhsach','LoaiTinController@getDanhSach');
		Route::get('them','LoaiTinController@themDanhSach');
		Route::post('them','LoaiTinController@postthemDanhSach');
		Route::get('sua/{id}','LoaiTinController@suaDanhSach');
		Route::post('sua/{id}','LoaiTinController@postsuaDanhSach');
		Route::get('xoa/{id}','LoaiTinController@getXoaDanhSach');
	});
	Route::group(['prefix'=>'tintuc'],function(){
		Route::get('danhsach','TinTucController@getDanhSach');
		Route::get('them','TinTucController@themDanhSach');
		Route::post('them/{id}','TinTucController@postthemDanhSach');
		Route::get('sua/{id}','TinTucController@suaDanhSach');
		Route::post('sua/{id}','TinTucController@postsuaDanhSach');
		Route::get('xoa/{id}','TinTucController@getXoaDanhSach');
	});

    Route::group(['prefix'=>'slide'],function(){
		Route::get('danhsach','SlideController@getDanhSach');
		Route::get('them','SlideController@themDanhSach');
		Route::post('them','SlideController@postthemDanhSach');
		Route::get('sua/{id}','SlideController@suaDanhSach');
		Route::post('sua/{id}','SlideController@postsuaDanhSach');
		Route::get('xoa/{id}','SlideController@getXoaDanhSach');
	});

	Route::group(['prefix'=>'user'],function(){
		Route::get('danhsach','UserController@getDanhSach');
		Route::get('them','UserController@themDanhSach');
		Route::post('them','UserController@postthemDanhSach');
		Route::get('sua/{id}','UserController@suaDanhSach');
		Route::post('sua/{id}','UserController@postsuaDanhSach');
		Route::get('xoa/{id}','UserController@getXoaDanhSach');
	});


	Route::group(['prefix'=>'comment'],function(){
		Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');
	});

});

Route::group(['prefix'=>'ajax'],function(){
	Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
});

Route::get('trangchu','PageController@trangchu');
Route::get('lienhe','PageController@lienhe');
Route::get('loaitin/{id}','PageController@loaitin');
Route::get('tintuc/{id}','PageController@tintuc');
Route::get('dangnhap','PageController@dangnhap');
Route::post('dangnhap','PageController@postdangnhap');
Route::get('dangxuat','PageController@dangxuat');
Route::post('comment/{id}','CommentController@postcomment');
Route::get('nguoidung','PageController@nguoidung');
Route::post('nguoidung','PageController@postnguoidung');
Route::get('dangky','PageController@dangky');
Route::post('dangky','PageController@postdangky');
Route::post('timkiem','PageController@timkiem');
Route::get('gioithieu','PageController@gioithieu');
Route::get('chat/{id}','PageController@chat');
Route::get('report/{idTinTuc}/{idUser}','PageController@report');
Route::get('lienket','PageController@lienket');
Route::get('luotthich/{id}','PageController@luotthich');
Route::get('binhluan/traloi/{id}/{idadmin}','PageController@traloi');
Route::post('binhluan/traloi/{id}/{idadmin}','PageController@posttraloi');
Route::get('binhluan/xoa/{id}/{iduser}','PageController@getxoachat');