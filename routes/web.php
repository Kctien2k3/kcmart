<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
| 
*/

#################################################################################################################
#########////////////////////////////////PHÂN VÙNG ADMIN//////////////////////////////////////////######
#################################################################################################################

// Route::get('/', function () {
//     return view('client/home');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Auth::routes();

/////////////////////////////////////////////////////////////////////////////////////////////////////////// Auth 
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show']);
    // Route::get('admin/order/edit/{order_id}', [App\Http\Controllers\DashboardController::class, 'edit'])->name('order.edit');
    ;
    // Route::get('admin/dashboard/delete/{order_id}', [App\Http\Controllers\DashboardController::class, 'delete'])->name('delete_newOrder');
    Route::get('admin', [App\Http\Controllers\DashboardController::class, 'show']);

    //////////////////////////////////////////////////////////////////////////////////////////////////////////// Pages
    Route::get('admin/user/list', [App\Http\Controllers\AdminUserController::class, 'list'])->can('user.view');
    Route::get('admin/user/add', [App\Http\Controllers\AdminUserController::class, 'add'])->can('user.add');
    Route::post('admin/user/store', [App\Http\Controllers\AdminUserController::class, 'store'])->can('user.add');
    Route::get('admin/user/delete/{id}', [App\Http\Controllers\AdminUserController::class, 'delete'])->name('delete_user')->can('user.delete');
    Route::get('admin/user/action', [App\Http\Controllers\AdminUserController::class, 'action'])->can('user.delete');
    Route::get('admin/user/edit/{user}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('user.edit')->can('user.edit');
    Route::post('admin/user/update/{user}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('user.update')->can('user.edit');

});

//////////////////////////////////////////////////////////////////////////////////////////////////////////// Pages
Route::get('admin/page/list', [App\Http\Controllers\AdminPageController::class, 'list'])->can('page.view');
Route::get('admin/page/add', [App\Http\Controllers\AdminPageController::class, 'add'])->can('page.add');
Route::post('admin/page/store', [App\Http\Controllers\AdminPageController::class, 'store'])->can('page.add');
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('admin/page/delete/{page_id}', [App\Http\Controllers\AdminPageController::class, 'delete'])->name('delete_page')->can('page.delete');
Route::get('admin/page/action', [App\Http\Controllers\AdminPageController::class, 'action'])->can('page.delete');
Route::get('admin/page/edit/{page_id}', [App\Http\Controllers\AdminPageController::class, 'edit'])->name('page.edit')->can('page.edit');
Route::post('admin/page/update/{page_id}', [App\Http\Controllers\AdminPageController::class, 'update'])->name('page.update')->can('page.edit');

//////////////////////////////////////////////////////////////////////////////////////////////////////////// posts
Route::get('admin/post/list', [App\Http\Controllers\AdminPostController::class, 'list'])->can('post.view');
Route::get('admin/post/add', [App\Http\Controllers\AdminPostController::class, 'add'])->can('post.add');
Route::post('admin/post/store', [App\Http\Controllers\AdminPostController::class, 'store'])->can('post.add');
Route::get('admin/post/delete/{post_id}', [App\Http\Controllers\AdminPostController::class, 'delete'])->name('delete_post')->can('post.delete');
Route::get('admin/post/action', [App\Http\Controllers\AdminPostController::class, 'action'])->can('post.delete');
Route::get('admin/post/edit/{post_id}', [App\Http\Controllers\AdminPostController::class, 'edit'])->name('post.edit')->can('post.edit');
Route::post('admin/post/update/{post_id}', [App\Http\Controllers\AdminPostController::class, 'update'])->name('post.update')->can('post.edit');
///////////////////// post cat 
Route::get('admin/post/cat/list_cat', [App\Http\Controllers\AdminPostController::class, 'list_cat'])->can('post.view');
Route::post('admin/post/cat/add_cat', [App\Http\Controllers\AdminPostController::class, 'add_cat'])->can('post.add_cat');
Route::get('admin/post/cat/delete_cat/{category_id}', [App\Http\Controllers\AdminPostController::class, 'delete_cat'])->name('delete_post_cat')->can('post.delete_cat');
Route::get('admin/post/cat/edit_cat/{category_id}', [App\Http\Controllers\AdminPostController::class, 'edit_cat'])->name('post_cat.edit')->can('post.edit_cat');
Route::post('admin/post/cat/update_cat/{category_id}', [App\Http\Controllers\AdminPostController::class, 'update_cat'])->name('post_cat.update')->can('post.edit_cat');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// products
Route::get('admin/product/list', [App\Http\Controllers\AdminProductController::class, 'list'])->can('product.view');
Route::get('admin/product/add', [App\Http\Controllers\AdminProductController::class, 'add'])->can('product.add');
Route::post('admin/product/store', [App\Http\Controllers\AdminProductController::class, 'store'])->can('product.add');
Route::get('admin/product/delete/{product_id}', [App\Http\Controllers\AdminProductController::class, 'delete'])->name('product.delete')->can('product.delete');
Route::get('admin/product/action', [App\Http\Controllers\AdminProductController::class, 'action'])->can('product.delete');
Route::get('admin/product/edit/{product_id}', [App\Http\Controllers\AdminProductController::class, 'edit'])->name('product.edit')->can('product.edit');
Route::post('admin/product/update/{product_id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('product.update')->can('product.edit');
/////////////////// product cat
Route::get('admin/product/cat/list_cat', [App\Http\Controllers\AdminProductController::class, 'list_cat'])->can('product.view');
Route::post('admin/product/cat/add_cat', [App\Http\Controllers\AdminProductController::class, 'add_cat'])->can('product.add_cat');
Route::get('admin/product/cat/delete_cat/{category_id}', [App\Http\Controllers\AdminProductController::class, 'delete_cat'])->name('delete_cat')->can('product.delete_cat');
Route::get('admin/product/cat/edit_cat/{category_id}', [App\Http\Controllers\AdminProductController::class, 'edit_cat'])->name('category.edit')->can('product.edit_cat');
Route::post('admin/product/cat/update_cat/{category_id}', [App\Http\Controllers\AdminProductController::class, 'update_cat'])->name('category.update')->can('product.edit_cat');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// Sliders
Route::get('admin/slider/list', [App\Http\Controllers\AdminSliderController::class, 'list'])->can('slider.view');
Route::get('admin/slider/add', [App\Http\Controllers\AdminSliderController::class, 'add'])->can('slider.add');
Route::post('admin/slider/store', [App\Http\Controllers\AdminSliderController::class, 'store'])->can('slider.add');
Route::get('admin/slider/edit/{slider_id}', [App\Http\Controllers\AdminSliderController::class, 'edit'])->name('slider.edit')->can('slider.edit');
Route::post('admin/slider/update/{slider_id}', [App\Http\Controllers\AdminSliderController::class, 'update'])->name('slider.update')->can('slider.edit');
Route::get('admin/slider/delete/{slider_id}/{image_id}', [App\Http\Controllers\AdminSliderController::class, 'delete'])->name('delete_slider')->can('slider.delete');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// Orders
Route::get('admin/order/list', [App\Http\Controllers\AdminOrderController::class, 'list'])->can('order.view');
Route::get('admin/order/delete/{order_id}', [App\Http\Controllers\AdminOrderController::class, 'delete'])->name('delete_order')->can('order.delete');
Route::get('admin/order/action', [App\Http\Controllers\AdminOrderController::class, 'action'])->can('order.delete');
Route::post('admin/order/store', [App\Http\Controllers\AdminOrderController::class, 'store']);
Route::get('admin/order/edit/{order_id}', [App\Http\Controllers\AdminOrderController::class, 'edit'])->name('order.edit')->can('order.edit');
Route::post('admin/order/update/{order_id}', [App\Http\Controllers\AdminOrderController::class, 'update'])->name('order.update')->can('order.edit');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// Menu
// Route::get('admin/menu/list', [App\Http\Controllers\AdminMenuController::class, 'list']);
// Route::get('admin/menu/add', [App\Http\Controllers\AdminMenuController::class, 'add']);
// Route::post('admin/menu/store', [App\Http\Controllers\AdminMenuController::class, 'store']);
// Route::get('admin/menu/edit/{menu_id}', [App\Http\Controllers\AdminMenuController::class, 'edit'])->name('menu.edit');
// Route::post('admin/menu/update/{menu_id}', [App\Http\Controllers\AdminMenuController::class, 'update'])->name('menu.update');
// Route::get('admin/menu/delete/{menu_id}', [App\Http\Controllers\AdminMenuController::class, 'delete'])->name('delete_menu');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// Permission
Route::get('admin/permission/add', [App\Http\Controllers\PermissionController::class, 'add'])->name('permission.add')->can('permission.add');
Route::post('admin/permission/store', [App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store')->can('permission.add');
Route::get('admin/permission/edit/{id}', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permission.edit')->can('permission.edit');
Route::post('admin/permission/update/{id}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update')->can('permission.edit');
Route::get('admin/permission/delete/{id}', [App\Http\Controllers\PermissionController::class, 'delete'])->name('permission.delete')->can('permission.delete');

///////////////////////////////////////////////////////////////////////////////////////////////////////////// Role
Route::get('admin/role/index', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index')->can('role.view');
Route::get('admin/role/add', [App\Http\Controllers\RoleController::class, 'add'])->name('role.add')->can('role.add');
Route::post('admin/role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store')->can('role.add');
Route::get('admin/role/edit/{role}', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit')->can('role.edit');
Route::post('admin/role/update/{role}', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update')->can('role.edit');
Route::get('admin/role/delete/{role}', [App\Http\Controllers\RoleController::class, 'delete'])->name('role.delete')->can('role.delete');


#################################################################################################################
#########////////////////////////////////PHÂN VÙNG CLIENTS//////////////////////////////////////////######
#################################################################################################################

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/tim-kiem.html', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/gioi-thieu.html', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/lien-he.html', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

//////////
Route::get('/tin-tuc-su-kien.html', [App\Http\Controllers\PostController::class, 'post'])->name('post');
Route::get('/tin-tuc-su-kien/{post_slug}.html', [App\Http\Controllers\PostController::class, 'post_detail'])->name('post_detail');

//////////
Route::get('san-pham/{category_slug}.html', [App\Http\Controllers\ProductController::class, 'show'])->name('product.category');
Route::get('san-pham/chi-tiet/{product_slug}.html', [App\Http\Controllers\ProductController::class, 'detail_product'])->name('detail.product');
 
//////////
// Route::middleware('cart')->group(function () {
    Route::get('/gio-hang.html', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::get('/add/{product_id}', [App\Http\Controllers\CartController::class, 'add_cart'])->name('cart.add');
    Route::get('/delete/{product_id}', [App\Http\Controllers\CartController::class, 'delete_cart'])->name('cart.delete');
    Route::post('/update', [App\Http\Controllers\CartController::class, 'update_cart'])->name('cart.update');
    Route::get('/clear', [App\Http\Controllers\CartController::class, 'clear_cart'])->name('cart.clear');
// });

//////////
Route::get('/thanh-toan.html', [App\Http\Controllers\CheckOutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/get_district_data', [App\Http\Controllers\CheckOutController::class, 'district']);
Route::get('/checkout/get_ward_data', [App\Http\Controllers\CheckOutController::class, 'ward']);
Route::get('/order_success/{order_id}', [App\Http\Controllers\CheckOutController::class, 'orderSuccess'])->name('order_success');
//////////

Route::get('/order/sendmail', [App\Http\Controllers\MailOrderController::class, 'sendmail']);