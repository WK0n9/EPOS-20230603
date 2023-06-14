<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## 关于EPOS

这是一个简单的基于Laravel和bootstrap框架的web端餐饮管理系统:

- 带有账号控制系统，避免误入
- 基于数据库表的灵活桌号系统.
- 可以灵活调整的菜品分类和菜品列表.
- 订单结账前可以多次加单，并能够按次记录加单情况.
- 后厨基于专用账号，可以查看订单状况，便于出餐.
- 结账时可以灵活抹零或进行打折、优惠券抵扣.
- 结账后订单将会锁定，仅可查看.
- 两种不同的收支计算方式，分别基于成品菜的预计成本价格和进货时的实际支出进行计算.

## 关于开发

- 前端：Bootstrap框架为主，加入了少量layerUI和JQueryUI
- 后端：Laravel （基于PHP 8.0）
- 数据库：Mysql 8.0
- 服务端集成环境：WampServer 3.2.6

## 前端文件结构

- epos_bill：账单查看页面
- epos_bill_back：后厨页面
- epos_index：系统主页面，桌号选择
- epos_login：登录页面
- epos_order：点单页面
- epos_order_again：加单页面
- epos_personal：收支情况汇总页面
- epos_purchase：采购进货页面

## 数据库结构

- order_bill：账单明细记录
- order_bill_equal：账单记录
- order_cate：菜品分类
- order_desk：桌号记录
- order_dish：菜品记录
- order_item：进货记录
- order_token：账号记录
