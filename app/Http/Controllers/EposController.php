<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EposController extends Controller
{
    //打开登录页面
    public function login()
    {
        return view("epos_login");
    }
    //默认打开首页
    public function index()
    {
        return view("epos_index");
    }
    //打开点餐页面
    public function order()
    {
        return view("epos_order");
    }
    //打开加单页面
    public function order_again()
    {
        return view("epos_order_again");
    }
    //打开采购页面
    public function purchase()
    {
        return view("epos_purchase");
    }
    //打开账单页面
    public function bill()
    {
        return view("epos_bill");
    }
    //打开账单页面
    public function bill_back()
    {
        return view("epos_bill_back");
    }
    //打开我的页面
    public function personal()
    {
        return view("epos_personal");
    }
    //获取主页所需信息
    public function get_index()
    {
        $desk_info = DB::select("select * from order_desk WHERE Desk_DeleteValue = 0 ORDER BY `Desk_Order` ASC");
        $bill_info = DB::select("select * from order_bill_equal WHERE Bill_Equal_Value = 1 AND Bill_Equal_DeleteValue <> 1");
        $data = ["desk_info"=>$desk_info,"bill_info"=>$bill_info];
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
    //获取账单所需信息
    public function get_bill_equal(Request $request)
    {
        $bill_date = $request->get("bill_date");
        date_default_timezone_set('Asia/Shanghai');
        if ($bill_date == 'today') {
            $date = "'".date('Y-m-d')."'";
        }else {
            $date= "'".date('Y-m-d', strtotime($bill_date.' day'))."'";
        }

        $bill_equal_info = DB::select("SELECT Bill_Equal_ID, Bill_Equal_DeskID, od.Desk_Name AS Bill_Equal_DeskName, Bill_Equal_Date, Bill_Equal_Sale,Bill_Equal_Value,
                                                CASE
                                                  WHEN Bill_Equal_Value <> 0 THEN '未结单'
                                                  WHEN Bill_Equal_Value = 0 THEN '已结单'
                                                END AS Bill_Value
                                                FROM order_bill_equal AS ob,order_desk AS od
                                                WHERE ob.Bill_Equal_DeskID = od.Desk_ID
                                                AND Bill_Equal_DeleteValue = 0
                                                AND DATE(Bill_Equal_Date) = $date
                                                ORDER BY CASE WHEN Bill_Equal_Value = 0 THEN 1 ELSE 0 END, Bill_Equal_Date DESC;");
        $data = ["bill_equal_info"=>$bill_equal_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //加单时获取已点信息
    public function get_ori_order(Request $request)
    {
        $bill_equal_id = $request->get("bill_equal_id");

//        $ori_order_info = DB::select("SELECT ob.Bill_DishID, ob.Bill_DishName, ob.Bill_DishNum
//                                FROM order_bill AS ob,order_bill_equal AS obe,order_cate AS oc,order_dish AS od
//                                WHERE obe.Bill_Equal_DeskID = ob.Bill_DeskID
//                                AND obe.Bill_Equal_Date = ob.Bill_Date
//                                AND ob.Bill_DishID = od.Dish_ID
//                                AND od.Dish_Cate = oc.Cate_ID
//                                AND obe.Bill_Equal_ID = $bill_equal_id
//                                AND ob.Bill_DeleteValue = 0
//                                AND obe.Bill_Equal_DeleteValue = 0
//                                AND oc.Cate_DeleteValue = 0
//                                AND od.Dish_DeleteValue = 0
//                                ORDER BY oc.Cate_ID ASC");
        $ori_order_info = DB::select("SELECT ob.Bill_DishID, ob.Bill_DishName, SUM(ob.Bill_DishNum) AS Bill_DishNum
                                                FROM order_bill AS ob,order_bill_equal AS obe,order_cate AS oc,order_dish AS od
                                                WHERE obe.Bill_Equal_DeskID = ob.Bill_DeskID
                                                AND obe.Bill_Equal_Date = ob.Bill_Date
                                                AND ob.Bill_DishID = od.Dish_ID
                                                AND od.Dish_Cate = oc.Cate_ID
                                                AND obe.Bill_Equal_ID = $bill_equal_id
                                                AND ob.Bill_DeleteValue = 0
                                                AND obe.Bill_Equal_DeleteValue = 0
                                                AND oc.Cate_DeleteValue = 0
                                                AND od.Dish_DeleteValue = 0
                                                GROUP BY ob.Bill_DishID, ob.Bill_DishName, oc.Cate_ID
                                                ORDER BY oc.Cate_ID ASC");
        $data = ["ori_order_info"=>$ori_order_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取结单信息
    public function get_finish(Request $request)
    {
        $bill_equal_id = $request->get("Bill_Equal_ID");

        $finish_info = DB::select("SELECT ob.Bill_ID, ob.Bill_DishName, ob.Bill_DishNum, ob.Bill_DishSale, ob.Bill_DishSaleEqual,
                                                   obe.Bill_Equal_ID, obe.Bill_Equal_Date, obe.Bill_Equal_Sale,
                                                   ode.Desk_ID, ode.Desk_Name, ob.Bill_Value
                                                FROM order_bill AS ob,order_bill_equal AS obe,order_desk AS ode,order_cate AS oc,order_dish AS od
                                                WHERE obe.Bill_Equal_DeskID = ob.Bill_DeskID
                                                AND obe.Bill_Equal_Date = ob.Bill_Date
                                                AND ob.Bill_DeskID = ode.Desk_ID
                                                AND ob.Bill_DishID = od.Dish_ID
                                                AND od.Dish_Cate = oc.Cate_ID
                                                AND obe.Bill_Equal_ID = $bill_equal_id
                                                AND ob.Bill_DeleteValue = 0
                                                AND obe.Bill_Equal_DeleteValue = 0
                                                AND oc.Cate_DeleteValue = 0
                                                AND od.Dish_DeleteValue = 0
                                                AND ode.Desk_DeleteValue = 0
                                                ORDER BY oc.Cate_ID ASC");
        //获取当前最大加单次数
        $max_value = 1;
        foreach ($finish_info as $info) {
            if ($info->Bill_Value > $max_value) {
                $max_value = $info->Bill_Value;
            }
        }
        $data = ["finish_info"=>$finish_info,"max_value"=>$max_value];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取结单信息
    public function get_finish_view(Request $request)
    {
        $bill_equal_id = $request->get("Bill_Equal_ID");

        $finish_info = DB::select("SELECT ob.Bill_ID, ob.Bill_DishName, SUM(ob.Bill_DishNum) AS Bill_DishNum, ob.Bill_DishSale, SUM(ob.Bill_DishSaleEqual) AS Bill_DishSaleEqual,
                                                   obe.Bill_Equal_ID, obe.Bill_Equal_Date, obe.Bill_Equal_Sale, obe.Bill_Equal_Sale_Real,
                                                   ode.Desk_ID, ode.Desk_Name
                                                FROM order_bill AS ob,order_bill_equal AS obe,order_desk AS ode,order_cate AS oc,order_dish AS od
                                                WHERE obe.Bill_Equal_DeskID = ob.Bill_DeskID
                                                AND obe.Bill_Equal_Date = ob.Bill_Date
                                                AND ob.Bill_DeskID = ode.Desk_ID
                                                AND ob.Bill_DishID = od.Dish_ID
                                                AND od.Dish_Cate = oc.Cate_ID
                                                AND obe.Bill_Equal_ID = $bill_equal_id
                                                AND ob.Bill_DeleteValue = 0
                                                AND obe.Bill_Equal_DeleteValue = 0
                                                GROUP BY ob.Bill_DishID, ob.Bill_DishName, oc.Cate_ID, ob.Bill_ID
                                                ORDER BY oc.Cate_ID ASC");
        $data = ["finish_info"=>$finish_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //获取当前桌账单信息
    public function get_desk_bill(Request $request)
    {
        $desk_id = $request->get("desk_id");

        $desk_bill_info = DB::select("SELECT Bill_Equal_Value
                                                FROM order_bill_equal
                                                WHERE Bill_Equal_DeskID = $desk_id
                                                AND Bill_Equal_Value = 1
                                                AND Bill_Equal_DeleteValue <> 1");
        if ($desk_bill_info == []) {
            $data = ["desk_value"=>"true"];
        } else {
            $data = ["desk_value"=>"false"];
        }
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }

    //提交点单
    public function add_order(Request $request)
    {
        $desk_id = $request->get("desk_id");
        $dish_count = $request->get("dish_count");
        $dish_equal = $request->get("dish_equal");
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

                DB::insert("insert into order_bill (Bill_DeskID, Bill_Date, Bill_DishID, Bill_DishName, Bill_DishNum, Bill_DishSale, Bill_DishSaleEqual, Bill_Value, Bill_DeleteValue)
                    values ($desk_id, $date, $dish_id, $dish_name, $dish_num, $dish_sale, $dish_sale_equal, 1, 0)");
            }
            DB::insert("insert into order_bill_equal (Bill_Equal_DeskID, Bill_Equal_Date, Bill_Equal_Sale, Bill_Equal_Value, Bill_Equal_DeleteValue)
                    values ($desk_id, $date, $dish_equal, 1, 0)");
            DB::commit();
            return ["status"=>"success","message"=>"下单成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"下单失败，原因如下：".$exception->getMessage()];
        }
    }
    //提交加单
    public function add_new_order(Request $request)
    {
        $desk_id = $request->get("desk_id");
        $bill_equal_id = $request->get("bill_equal_id");
        $dish_count = $request->get("dish_count");
        $dish_equal = $request->get("dish_equal");
        $order_info = DB::select("SELECT ob.Bill_DishID,ob.Bill_ID,ob.Bill_Date,ob.Bill_Value
                                            FROM order_bill AS ob,order_bill_equal AS obe
                                            WHERE obe.Bill_Equal_DeskID = ob.Bill_DeskID
                                            AND obe.Bill_Equal_Date = ob.Bill_Date
                                            AND obe.Bill_Equal_ID = $bill_equal_id
                                            AND ob.Bill_DeleteValue = 0
                                            AND obe.Bill_Equal_DeleteValue = 0");
        //获取当前最大加单次数
        $max_value = 1;
        foreach ($order_info as $info) {
            if ($info->Bill_Value > $max_value) {
                $max_value = $info->Bill_Value;
            }
        }

        try {
            DB::beginTransaction();
            //
            for ($i = 0;$i < $dish_count;$i++){
                $dish_id = $request->get("dish_id_".$i);
                $dish_name = "'".$request->get("dish_name_".$i)."'";
                $dish_num = "'".$request->get("dish_num_".$i)."'";
                $dish_sale = "'".$request->get("dish_sale_".$i)."'";
                $dish_sale_equal = "'".$request->get("dish_sale_equal_".$i)."'";
//                $tip = 0;
//                for ($j = 0;$j < count($order_info);$j++) {
//                    $bill_dish_id = $order_info[$j]->Bill_DishID;
//                    $bill_id = $order_info[$j]->Bill_ID;
//                    if ($dish_id == $bill_dish_id) {
//                        $tip = 1;
//                        DB::update("UPDATE order_bill SET Bill_DishNum = Bill_DishNum + $dish_num, Bill_DishSaleEqual = Bill_DishSaleEqual + $dish_sale_equal, Bill_Value = 2 WHERE Bill_ID = $bill_id");
//                        break;
//                    }
//                }
//                if ($tip != 0) {
//                    continue;
//                }
                $date_ori = $order_info[0]->Bill_Date;
                $date = "'".$date_ori."'";
                $now_value = $max_value + 1;
                DB::insert("insert into order_bill (Bill_DeskID, Bill_Date, Bill_DishID, Bill_DishName, Bill_DishNum, Bill_DishSale, Bill_DishSaleEqual, Bill_Value, Bill_DeleteValue)
                    values ($desk_id, $date, $dish_id, $dish_name, $dish_num, $dish_sale, $dish_sale_equal, $now_value, 0)");
            }
            DB::update("update order_bill_equal set Bill_Equal_Sale = Bill_Equal_Sale + $dish_equal where Bill_Equal_ID = $bill_equal_id");
            DB::commit();
            return ["status"=>"success","message"=>"加单成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"加单失败，原因如下：".$exception->getMessage()];
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
    //提交结单
    public function add_finish(Request $request)
    {
        $bill_equal_id = $request->get("Bill_Equal_ID");
        $bill_sale_real = "'".$request->get("Bill_Real_Sale")."'";
        $Bill_ID_List = DB::select("SELECT ob.Bill_ID
                                        FROM order_bill AS ob,order_bill_equal AS obe
                                        WHERE ob.Bill_Date = obe.Bill_Equal_Date
                                        AND ob.Bill_DeskID = obe.Bill_Equal_DeskID
                                        AND obe.Bill_Equal_ID = $bill_equal_id
                                        AND ob.Bill_DeleteValue = 0
                                        AND obe.Bill_Equal_DeleteValue = 0");
        try {
            DB::beginTransaction();
            DB::update("update order_bill_equal set Bill_Equal_Sale_Real = $bill_sale_real, Bill_Equal_Value = 0 where Bill_Equal_ID = $bill_equal_id");
            for ($i = 0;$i < count($Bill_ID_List);$i++) {
                $Bill_ID = $Bill_ID_List[$i]->Bill_ID;
                DB::update("UPDATE order_bill SET Bill_Value = 0 WHERE Bill_ID = $Bill_ID");
            }
            DB::commit();
            return ["status"=>"success","message"=>"结单成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"结单失败，原因如下：".$exception->getMessage()];
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
    //删除账单
    public function delete_bill(Request $request)
    {
        $Bill_Equal_ID = $request->get("Bill_Equal_ID");
        $Bill_ID_List = DB::select("SELECT ob.Bill_ID
                                        FROM order_bill AS ob,order_bill_equal AS obe
                                        WHERE ob.Bill_Date = obe.Bill_Equal_Date
                                        AND ob.Bill_DeskID = obe.Bill_Equal_DeskID
                                        AND obe.Bill_Equal_ID = $Bill_Equal_ID
                                        AND ob.Bill_DeleteValue = 0
                                        AND obe.Bill_Equal_DeleteValue = 0");
        try {
            DB::beginTransaction();
            DB::update("UPDATE order_bill_equal SET Bill_Equal_DeleteValue = 1 WHERE Bill_Equal_ID = $Bill_Equal_ID");
            for ($i = 0;$i < count($Bill_ID_List);$i++) {
                $Bill_ID = $Bill_ID_List[$i]->Bill_ID;
                DB::update("UPDATE order_bill SET Bill_DeleteValue = 1 WHERE Bill_ID = $Bill_ID");
            }
            DB::commit();
            return ["status"=>"success","message"=>"删除成功"];
        }catch (Exception $exception){
            DB::rollBack();
            return ["status"=>"fail","message"=>"删除失败，原因如下：".$exception->getMessage()];
        }
    }

    //查询应收实收
    public function calc_income()
    {
        date_default_timezone_set('Asia/Shanghai');
        $date_today = "'".date('Y-m-d')."'";
        $date_last_day= "'".date('Y-m-d', strtotime('-1 day'))."'";
        $today_income_info = DB::select("SELECT IFNULL(SUM(Bill_Equal_Sale),0) AS Bill_Equal_Sale,IFNULL(SUM(Bill_Equal_Sale_Real),0) AS Bill_Equal_Sale_Real
                                        FROM order_bill_equal
                                        WHERE Bill_Equal_Value = 0
                                        AND Bill_Equal_DeleteValue <> 1
                                        AND DATE(Bill_Equal_Date) = $date_today");
        $last_day_income_info = DB::select("SELECT IFNULL(SUM(Bill_Equal_Sale),0) AS Bill_Equal_Sale,IFNULL(SUM(Bill_Equal_Sale_Real),0) AS Bill_Equal_Sale_Real
                                        FROM order_bill_equal
                                        WHERE Bill_Equal_Value = 0
                                        AND Bill_Equal_DeleteValue <> 1
                                        AND DATE(Bill_Equal_Date) = $date_last_day");
        $all_income_info = DB::select("SELECT IFNULL(SUM(Bill_Equal_Sale),0) AS Bill_Equal_Sale,IFNULL(SUM(Bill_Equal_Sale_Real),0) AS Bill_Equal_Sale_Real
                                        FROM order_bill_equal
                                        WHERE Bill_Equal_Value = 0
                                        AND Bill_Equal_DeleteValue <> 1");
        $data = ["today_income_info"=>$today_income_info,"last_day_income_info"=>$last_day_income_info,"all_income_info"=>$all_income_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //查询菜品成本
    public function calc_cost()
    {
        date_default_timezone_set('Asia/Shanghai');
        $date_today = "'".date('Y-m-d')."'";
        $date_last_day= "'".date('Y-m-d', strtotime('-1 day'))."'";
        $today_cost_info = DB::select("SELECT IFNULL(SUM(All_Dish_Cost),0) AS 'Total_Dish_Cost'
                                                FROM (
                                                    SELECT ob.Bill_DishID, ob.Bill_DishNum, od.Dish_Cost, ob.Bill_DishNum * od.Dish_Cost AS 'All_Dish_Cost'
                                                    FROM order_bill AS ob, order_dish AS od
                                                    WHERE ob.Bill_DishID = od.Dish_ID
                                                    AND ob.Bill_Value = 0
                                                    AND ob.Bill_DeleteValue <> 1
                                                    AND DATE(ob.Bill_Date) = $date_today
                                                ) AS subquery");
        $last_day_cost_info = DB::select("SELECT IFNULL(SUM(All_Dish_Cost),0) AS 'Total_Dish_Cost'
                                                FROM (
                                                    SELECT ob.Bill_DishID, ob.Bill_DishNum, od.Dish_Cost, ob.Bill_DishNum * od.Dish_Cost AS 'All_Dish_Cost'
                                                    FROM order_bill AS ob, order_dish AS od
                                                    WHERE ob.Bill_DishID = od.Dish_ID
                                                    AND ob.Bill_Value = 0
                                                    AND ob.Bill_DeleteValue <> 1
                                                    AND DATE(ob.Bill_Date) = $date_last_day
                                                ) AS subquery");
        $all_cost_info = DB::select("SELECT IFNULL(SUM(All_Dish_Cost),0) AS 'Total_Dish_Cost'
                                                FROM (
                                                    SELECT ob.Bill_DishID, ob.Bill_DishNum, od.Dish_Cost, ob.Bill_DishNum * od.Dish_Cost AS 'All_Dish_Cost'
                                                    FROM order_bill AS ob, order_dish AS od
                                                    WHERE ob.Bill_DishID = od.Dish_ID
                                                    AND ob.Bill_Value = 0
                                                    AND ob.Bill_DeleteValue <> 1
                                                ) AS subquery");
        $data = ["today_cost_info"=>$today_cost_info,"last_day_cost_info"=>$last_day_cost_info,"all_cost_info"=>$all_cost_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }
    //查询进货支出
    public function calc_item()
    {
        $item_info = DB::select("SELECT IFNULL(SUM(Item_Cost),0) AS Item_Cost
                                            FROM order_item
                                            WHERE Item_DeleteValue <> 1");
        $data = ["item_info"=>$item_info];
        return ["status"=>"success","message"=>"获取成功！","data"=>$data];
    }

    //登录
    public function login_token(Request $request)
    {

        $pwd = "'". $request->get("pwd") ."'";
        $pwd_md5 = "'". $request->get("pwd_md5") ."'";
        $res = DB::select("select Token_ID, Token, Token_MD5, Token_Cate
                from order_token WHERE Token = $pwd");
        if(count($res) > 0)
        {
            if ($res[0]->Token_MD5 == ""){
                try {
                    DB::update("
                        update order_token set Token_MD5  = $pwd_md5 where Token = $pwd");
                    $request->session()->put("pwd",$pwd_md5);
                    $request->session()->put("pwd_cate",$res[0]->Token_Cate);
                    if ($res[0]->Token_Cate == 'qiantai') {
                        return ["status"=>"success","message"=>"登陆成功","pid"=>$res[0]->Token_ID,"cate"=>$res[0]->Token_Cate,"href"=>route("epos_home")];
                    }elseif ($res[0]->Token_Cate == 'houchu') {
                        return ["status"=>"success","message"=>"登陆成功","pid"=>$res[0]->Token_ID,"cate"=>$res[0]->Token_Cate,"href"=>route("epos_bill_back")];
                    }
                }catch (\Exception $exception) {
                    return ["status"=>"fail","message"=>"登录失败，可能是数据库写入错误","href"=>route("epos_login")];
//                    return ["status"=>"fail","message"=>$pwd_md5,"href"=>route("login")];
                }
            }else{
                $request->session()->put("pwd",$pwd_md5);
                $request->session()->put("pwd_cate",$res[0]->Token_Cate);
                if ($res[0]->Token_Cate == 'qiantai') {
                    return ["status"=>"success","message"=>"登陆成功","pid"=>$res[0]->Token_ID,"cate"=>$res[0]->Token_Cate,"href"=>route("epos_home")];
                }elseif ($res[0]->Token_Cate == 'houchu') {
                    return ["status"=>"success","message"=>"登陆成功","pid"=>$res[0]->Token_ID,"cate"=>$res[0]->Token_Cate,"href"=>route("epos_bill_back")];
                }
            }
        }else{
            return ["status"=>"fail","message"=>"登录失败，用户不存在","href"=>route("epos_login")];
            //这里是没查询到用户
        }
    }
}
