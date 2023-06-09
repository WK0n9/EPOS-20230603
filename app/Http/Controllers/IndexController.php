<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //默认打开首页
    public function index()
    {
        return view("index");
    }
    //默认打开首页
    public function order()
    {
        return view("order");
    }
    //默认打开首页
    public function purchase()
    {
        return view("purchase");
    }
    //默认打开首页
    public function bill()
    {
        return view("bill");
    }
    //默认打开首页
    public function personal()
    {
        return view("personal");
    }
    //获取主页所需信息
    public function get_index()
    {
        $desk_info = DB::select("select * from order_desk WHERE Desk_DeleteValue = 0 ORDER BY `Desk_Order` ASC");
        $data = ["desk_info"=>$desk_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取点餐所需信息
    public function get_order()
    {
        $desk_info = DB::select("select * from order_desk WHERE Desk_DeleteValue = 0 ORDER BY `Desk_Order` ASC");
        $cate_info = DB::select("select * from order_cate WHERE Cate_DeleteValue = 0 ORDER BY `Cate_Order` ASC");
        $dish_info = DB::select("select * from order_dish WHERE Dish_DeleteValue = 0 ORDER BY `Dish_Cate` ASC");
        $data = ["desk_info"=>$desk_info,"cate_info"=>$cate_info,"dish_info"=>$dish_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取菜品所需信息
    public function get_cate()
    {
        $cate_info = DB::select("select * from order_cate WHERE Cate_DeleteValue = 0 ORDER BY `Cate_Order` ASC");
        $data = ["cate_info"=>$cate_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取菜品所需信息
    public function get_dish()
    {
        $dish_info = DB::select("SELECT Dish_ID,Dish_Name,Dish_Cate,Cate_Name AS `Dish_Cate_Name`,Dish_Cost,Dish_Sale
                                        FROM order_dish AS `od`,order_cate AS `oc`
                                        WHERE od.Dish_Cate = oc.Cate_ID
                                        AND od.Dish_DeleteValue = 0
                                        AND oc.Cate_DeleteValue = 0
                                        ORDER BY `Dish_Cate` ASC");
        $data = ["dish_info"=>$dish_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取库存所需信息
    public function get_item()
    {
        $item_info = DB::select("SELECT Item_ID, date_format( Item_Date,'%Y-%m-%d') AS Item_Date, Item_Tips, Item_Cost
                                        FROM order_item
                                        WHERE Item_DeleteValue = 0
                                        ORDER BY Item_Date DESC");
        $data = ["item_info"=>$item_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //提交点单
    public function add_order(Request $request)
    {
        $desk_id = $request->get("desk_id");
        $dish_count = $request->get("dish_count");
        date_default_timezone_set('Asia/Shanghai');
        $date = "'".date('Y-m-d H:i:s')."'";
        try {
            DB::beginTransaction();
            //
            for ($i = 0;$i < $dish_count;$i++){
                $dish_id = $request->get("dish_id_".$i);
                $dish_name = "'".$request->get("dish_name_".$i)."'";
                $dish_num = "'".$request->get("dish_num_".$i)."'";
                $dish_sale = "'".$request->get("dish_sale_".$i)."'";
                $dish_sale_equal = "'".$request->get("dish_sale_equal_".$i)."'";

                DB::insert("insert into order_bill (Bill_DeskID, Bill_Date, Bill_DishID, Bill_DishName, Bill_DishNum, Bill_DishSale, Bill_DishSaleEqual, Bill_DeleteValue)
                    values ($desk_id, $date, $dish_id, $dish_name, $dish_num, $dish_sale, $dish_sale_equal, 0)");
            }
            DB::commit();
            return ["status"=>"success","message"=>"下单成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"修改失败，原因如下：".$exception->getMessage()];
        }
    }
    //添加菜品
    public function add_dish(Request $request)
    {
        $Dish_Name = "'".$request->get("Dish_Name")."'";
        $Dish_Cate = $request->get("Dish_Cate");
        $Dish_Cost = "'".$request->get("Dish_Cost")."'";
        $Dish_Sale = "'".$request->get("Dish_Sale")."'";
        try {
            DB::beginTransaction();
            DB::insert("insert into order_dish (Dish_Name, Dish_Cate, Dish_Num, Dish_Cost, Dish_Sale, Dish_DeleteValue)
                values ($Dish_Name,$Dish_Cate,'0',$Dish_Cost,$Dish_Sale, 0)");
            DB::commit();
            return ["status"=>"success","message"=>"添加成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"添加失败，原因如下：".$exception->getMessage()];
        }
    }
    //添加货物
    public function add_item(Request $request)
    {
        $Item_Cost = "'".$request->get("Item_Cost")."'";
        $Item_Tips = "'".$request->get("Item_Tips")."'";
        date_default_timezone_set('Asia/Shanghai');
        $date = "'".date('Y-m-d H:i:s')."'";
        try {
            DB::beginTransaction();
            DB::insert("insert into order_item (Item_Date, Item_Tips, Item_Cost, Item_DeleteValue)
                values ($date,$Item_Tips,$Item_Cost, 0)");
            DB::commit();
            return ["status"=>"success","message"=>"添加成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"添加失败，原因如下：".$exception->getMessage()];
        }
    }
    //编辑菜品
    public function edit_dish(Request $request)
    {
        $Dish_ID = $request->get("Dish_ID");
        $Dish_Name = "'".$request->get("Dish_Name")."'";
        $Dish_Cate = $request->get("Dish_Cate");
        $Dish_Cost = "'".$request->get("Dish_Cost")."'";
        $Dish_Sale = "'".$request->get("Dish_Sale")."'";
        try {
            DB::beginTransaction();
            DB::update("UPDATE order_dish SET Dish_Name = $Dish_Name, Dish_Cate = $Dish_Cate, Dish_Cost = $Dish_Cost, Dish_Sale = $Dish_Sale WHERE Dish_ID = $Dish_ID");
            DB::commit();
            return ["status"=>"success","message"=>"编辑成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"编辑失败，原因如下：".$exception->getMessage()];
        }
    }
    //编辑货物
    public function edit_item(Request $request)
    {
        $Item_ID = $request->get("Item_ID");
        $Item_Cost = "'".$request->get("Item_Cost")."'";
        $Item_Tips = "'".$request->get("Item_Tips")."'";
        try {
            DB::beginTransaction();
            DB::update("UPDATE order_item SET Item_Cost = $Item_Cost, Item_Tips = $Item_Tips WHERE Item_ID = $Item_ID");
            DB::commit();
            return ["status"=>"success","message"=>"编辑成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"编辑失败，原因如下：".$exception->getMessage()];
        }
    }
    //删除菜品
    public function delete_dish(Request $request)
    {
        $Dish_ID = $request->get("Dish_ID");
        try {
            DB::beginTransaction();
            DB::update("UPDATE order_dish SET Dish_DeleteValue = 1 WHERE Dish_ID = $Dish_ID");
            DB::commit();
            return ["status"=>"success","message"=>"删除成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"删除失败，原因如下：".$exception->getMessage()];
        }
    }
    //删除货物
    public function delete_item(Request $request)
    {
        $Item_ID = $request->get("Item_ID");
        try {
            DB::beginTransaction();
            DB::update("UPDATE order_item SET Item_DeleteValue = 1 WHERE Item_ID = $Item_ID");
            DB::commit();
            return ["status"=>"success","message"=>"删除成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"删除失败，原因如下：".$exception->getMessage()];
        }
    }
}
