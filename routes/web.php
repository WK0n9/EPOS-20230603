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
Route::prefix("/epos/")->group(function (){
    Route::get('/home', function () {
        return view('welcome');
    });
    Route::get('/', [\App\Http\Controllers\IndexController::class,"index"])->name("home");//主页，选择桌号
    Route::get('/order', [\App\Http\Controllers\IndexController::class,"order"])->name("order");//点餐
    Route::get('/order_again', [\App\Http\Controllers\IndexController::class,"order_again"])->name("order_again");//加单
    Route::get('/purchase', [\App\Http\Controllers\IndexController::class,"purchase"])->name("purchase");//点餐
    Route::get('/bill', [\App\Http\Controllers\IndexController::class,"bill"])->name("bill");//点餐
    Route::get('/personal', [\App\Http\Controllers\IndexController::class,"personal"])->name("personal");//点餐

    Route::post('/get_index', [\App\Http\Controllers\IndexController::class,"get_index"]);//获取主页所需信息
    Route::post('/get_order', [\App\Http\Controllers\IndexController::class,"get_order"]);//获取点餐所需信息
    Route::post('/get_cate', [\App\Http\Controllers\IndexController::class,"get_cate"]);//获取菜品分类信息
    Route::post('/get_dish', [\App\Http\Controllers\IndexController::class,"get_dish"]);//获取菜品所需信息
    Route::post('/get_item', [\App\Http\Controllers\IndexController::class,"get_item"]);//获取库存所需信息
    Route::post('/get_bill_equal', [\App\Http\Controllers\IndexController::class,"get_bill_equal"]);//获取账单所需信息
    Route::post('/get_ori_order', [\App\Http\Controllers\IndexController::class,"get_ori_order"]);//加单时获取已点信息
    Route::post('/get_finish', [\App\Http\Controllers\IndexController::class,"get_finish"]);//获取结单信息

    Route::post('/add_order', [\App\Http\Controllers\IndexController::class,"add_order"]);//提交点单
    Route::post('/add_new_order', [\App\Http\Controllers\IndexController::class,"add_new_order"]);//提交加单
    Route::post('/add_dish', [\App\Http\Controllers\IndexController::class,"add_dish"]);//添加菜品
    Route::post('/add_item', [\App\Http\Controllers\IndexController::class,"add_item"]);//添加菜品
    Route::post('/add_finish', [\App\Http\Controllers\IndexController::class,"add_finish"]);//提交结单

    Route::post('/edit_dish', [\App\Http\Controllers\IndexController::class,"edit_dish"]);//修改菜品
    Route::post('/edit_item', [\App\Http\Controllers\IndexController::class,"edit_item"]);//修改货物

    Route::post('/delete_dish', [\App\Http\Controllers\IndexController::class,"delete_dish"]);//删除菜品
    Route::post('/delete_item', [\App\Http\Controllers\IndexController::class,"delete_item"]);//删除货物
    Route::post('/delete_bill', [\App\Http\Controllers\IndexController::class,"delete_bill"]);//删除账单

    Route::post('/calc_income', [\App\Http\Controllers\IndexController::class,"calc_income"]);//查询应收实收
    Route::post('/calc_cost', [\App\Http\Controllers\IndexController::class,"calc_cost"]);//查询菜品成本
    Route::post('/calc_item', [\App\Http\Controllers\IndexController::class,"calc_item"]);//查询菜品成本
});

