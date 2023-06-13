<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/epos/login', [\App\Http\Controllers\EposController::class,"login"])->name("epos_login");//登录页面
Route::post('/epos/login_token', [\App\Http\Controllers\EposController::class,"login_token"]);//登录

Route::middleware(["CheckLogin"])->prefix("/epos/")->group(function (){
    Route::get('/home', function () {
        return view('epos_welcome');
    });
    Route::get('/', [\App\Http\Controllers\EposController::class,"index"])->name("epos_home");//主页，选择桌号
    Route::get('/order', [\App\Http\Controllers\EposController::class,"order"])->name("epos_order");//点餐
    Route::get('/order_again', [\App\Http\Controllers\EposController::class,"order_again"])->name("epos_order_again");//加单
    Route::get('/purchase', [\App\Http\Controllers\EposController::class,"purchase"])->name("epos_purchase");//采购
    Route::get('/bill', [\App\Http\Controllers\EposController::class,"bill"])->name("epos_bill");//账单
    Route::get('/bill_back', [\App\Http\Controllers\EposController::class,"bill_back"])->name("epos_bill_back");//账单_后厨
    Route::get('/personal', [\App\Http\Controllers\EposController::class,"personal"])->name("epos_personal");//我的

    Route::post('/get_index', [\App\Http\Controllers\EposController::class,"get_index"]);//获取主页所需信息
    Route::post('/get_order', [\App\Http\Controllers\EposController::class,"get_order"]);//获取点餐所需信息
    Route::post('/get_cate', [\App\Http\Controllers\EposController::class,"get_cate"]);//获取菜品分类信息
    Route::post('/get_dish', [\App\Http\Controllers\EposController::class,"get_dish"]);//获取菜品所需信息
    Route::post('/get_item', [\App\Http\Controllers\EposController::class,"get_item"]);//获取库存所需信息
    Route::post('/get_bill_equal', [\App\Http\Controllers\EposController::class,"get_bill_equal"]);//获取账单所需信息
    Route::post('/get_ori_order', [\App\Http\Controllers\EposController::class,"get_ori_order"]);//加单时获取已点信息
    Route::post('/get_finish', [\App\Http\Controllers\EposController::class,"get_finish"]);//获取结单信息
    Route::post('/get_desk_bill', [\App\Http\Controllers\EposController::class,"get_desk_bill"]);//获取当前桌账单信息

    Route::post('/add_order', [\App\Http\Controllers\EposController::class,"add_order"]);//提交点单
    Route::post('/add_new_order', [\App\Http\Controllers\EposController::class,"add_new_order"]);//提交加单
    Route::post('/add_dish', [\App\Http\Controllers\EposController::class,"add_dish"]);//添加菜品
    Route::post('/add_item', [\App\Http\Controllers\EposController::class,"add_item"]);//添加菜品
    Route::post('/add_finish', [\App\Http\Controllers\EposController::class,"add_finish"]);//提交结单

    Route::post('/edit_dish', [\App\Http\Controllers\EposController::class,"edit_dish"]);//修改菜品
    Route::post('/edit_item', [\App\Http\Controllers\EposController::class,"edit_item"]);//修改货物

    Route::post('/delete_dish', [\App\Http\Controllers\EposController::class,"delete_dish"]);//删除菜品
    Route::post('/delete_item', [\App\Http\Controllers\EposController::class,"delete_item"]);//删除货物
    Route::post('/delete_bill', [\App\Http\Controllers\EposController::class,"delete_bill"]);//删除账单

    Route::post('/calc_income', [\App\Http\Controllers\EposController::class,"calc_income"]);//查询应收实收
    Route::post('/calc_cost', [\App\Http\Controllers\EposController::class,"calc_cost"]);//查询菜品成本
    Route::post('/calc_item', [\App\Http\Controllers\EposController::class,"calc_item"]);//查询菜品成本
});

