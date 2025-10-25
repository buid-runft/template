<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function category()
    {
        return view('admin.category');
    }

    public function addNewCategory()
    {
        return view('admin.add-new-category');
    }

    public function storeCategory(StoreCategoryRequest $request)
    {
        try {
            $this->categoryService->store($request);
            return redirect()->route('admin.category')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    public function attributes()
    {
        return view('admin.attributes');
    }

    public function addNewAttributes()
    {
        return view('admin.add-new-attributes');
    }

    public function products()
    {
        return view('dashbord-admin.products');
    }

    public function addNewProduct()
    {
        return view('dashbord-admin.add-new-product');
    }

    public function productReview()
    {
        return view('dashbord-admin.product-review');
    }

    public function orderList()
    {
        return view('dashbord-admin.order-list');
    }

    public function orderDetail()
    {
        return view('dashbord-admin.order-detail');
    }

    public function createOrder()
    {
        return view('dashbord-admin.create-order');
    }

    public function orderTracking()
    {
        return view('dashbord-admin.order-tracking');
    }

    public function vendorList()
    {
        return view('dashbord-admin.vendor-list');
    }

    public function createVendor()
    {
        return view('dashbord-admin.create-vendor');
    }

    public function couponList()
    {
        return view('dashbord-admin.coupon-list');
    }

    public function createCoupon()
    {
        return view('dashbord-admin.create-coupon');
    }

    public function allUsers()
    {
        return view('dashbord-admin.all-users');
    }

    public function addNewUser()
    {
        return view('dashbord-admin.add-new-user');
    }

    public function role()
    {
        return view('dashbord-admin.role');
    }

    public function createRole()
    {
        return view('dashbord-admin.create-role');
    }

    public function reports()
    {
        return view('dashbord-admin.reports');
    }

    public function media()
    {
        return view('dashbord-admin.media');
    }

    public function contentSettings()
    {
        return view('dashbord-admin.content-settings');
    }

    public function contentSettingsFull()
    {
        return view('dashbord-admin.content-settings-full');
    }

    public function contentSettingsDynamic()
    {
        return view('dashbord-admin.content-settings-dynamic');
    }

    public function createMenu()
    {
        return view('dashbord-admin.create-menu');
    }

    public function menuLists()
    {
        return view('dashbord-admin.menu-lists');
    }

    public function translation()
    {
        return view('dashbord-admin.translation');
    }

    public function currencyRates()
    {
        return view('dashbord-admin.currency-rates');
    }

    public function taxes()
    {
        return view('dashbord-admin.taxes');
    }

    public function supportTicket()
    {
        return view('dashbord-admin.support-ticket');
    }

    public function backupIndex()
    {
        return view('dashbord-admin.backup-index');
    }

    public function invoice()
    {
        return view('dashbord-admin.invoice');
    }

    public function listPage()
    {
        return view('dashbord-admin.list-page');
    }

    public function profileSetting()
    {
        return view('dashbord-admin.profile-setting');
    }

    public function login()
    {
        return view('dashbord-admin.login');
    }

    public function signUp()
    {
        return view('dashbord-admin.sign-up');
    }

    public function forgotPassword()
    {
        return view('dashbord-admin.forgot-password');
    }

    public function forgot()
    {
        return view('dashbord-admin.forgot');
    }

    public function otp()
    {
        return view('dashbord-admin.otp');
    }
}
