<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customerController;
use App\Http\Controllers\indexStaffController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\managerController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\productController;
use App\Http\Controllers\shoppingBasketController;
use App\Http\Controllers\WeddingPackageController;
use App\Http\Controllers\WPBasketController;
use App\Http\Controllers\appointmentsController;
use App\Http\Controllers\reservationsController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\indexAdminController;
use App\Http\Controllers\indexManagerController;
use App\Http\Controllers\productManagerController;
use App\Http\Controllers\productAdminController;
use App\Http\Controllers\WeddingPackageManagerController;

// use App\Http\Controllers\GoogleAuthController;
// use App\Http\Controllers\GoogleAuthStaffController;


//customer

Route::get('/customer-signup', [indexController::class, 'customer_signup'])->name('customer-signup');
Route::post('/logmein', [indexController::class, 'logmein'])->name('logmein');
Route::post('/register', [indexController::class, 'register'])->name('register');


//staff
    Route::get('/staff-signup', [indexStaffController::class, 'manager_signup'])->name('staff-signup');
    Route::post('/logmeinStaff', [indexStaffController::class, 'logmeinStaff'])->name('logmeinStaff');
    Route::post('/registerStaff', [indexStaffController::class, 'registerStaff'])->name('registerStaff');

//Admin
    Route::get('/admin-signup', [indexAdminController::class, 'admin_signup'])->name('admin-signup');
    Route::post('/logmeinAdmin', [indexAdminController::class, 'logmeinAdmin'])->name('logmeinAdmin');
    Route::post('/registerAdmin', [indexAdminController::class, 'registerAdmin'])->name('registerAdmin');


//Manager
    Route::get('/manager-signup', [indexManagerController::class, 'manager_signup'])->name('manager-signup');
    Route::post('/logmeinManager', [indexManagerController::class, 'logmeinManager'])->name('logmeinManager');
    Route::post('/registerManager', [indexManagerController::class, 'registerManager'])->name('registerManager');

//customer Middleware

Route::get('/', [dashboardController::class, 'index'])->name('customer');
Route::get('/customer-login', [indexController::class, 'customer_login'])->name('customer-login');

//CUSTOMER
    Route::group(['middleware' =>['Authcheck']], function(){
        Route::get('/customer-home', [customerController::class, 'customer_home'])->name('customer-home');
        Route::get('/customer-add2cart/{id}', [customerController::class, 'customer_add2cart'])->name('customer-add2cart');
        Route::get('/customer-receipt', [customerController::class, 'customer_receipt'])->name('customer-receipt');
        Route::get('/customer-details', [customerController::class, 'customer_details'])->name('customer-details'); 

        //Customer Profile
        Route::get('/customer-profile', [customerController::class, 'customer_profile'])->name('customer-profile'); 
        Route::put('/customer-profile/update', [customerController::class, 'customer_profile_update'])->name('customer-profile.update'); 

        //Logout
        Route::get('/Logout',[customerController::class, 'Logout'])->name ('Logout');

            // Shopping Basket
                Route::get('/shopping-basket', [shoppingBasketController::class, 'shopping_basket'])->name('shopping-basket');
                Route::post('/shopping-basket/add', [shoppingBasketController::class, 'addToBasket'])->name('shopping-basket.add');
                Route::put('/shopping-basket/update', [shoppingBasketController::class, 'updateBasketItem'])->name('shopping-basket.update');
                Route::put('/shopping-basket-wp/update', [WPBasketController::class, 'updateWPBasket'])->name('shopping-basket-wp.update');
                Route::delete('/shopping-basket/delete/{id}', [shoppingBasketController::class, 'deleteFromBasket'])->name('shopping-basket.delete');

            // Wedding Package
                Route::get('/wedding-package/{id}', [WeddingPackageController::class, 'show'])->name('wedding-package');
                
                Route::post('/wedding-package/{id}', [WPBasketController::class, 'store'])->name('WPBasket.store');
                Route::get('/wedding-package-shopping-basket', [WPBasketController::class, 'show'])->name('wedding-package-shopping-basket');

            // Appointment routes
                Route::get('/customer-appointments', [appointmentsController::class, 'customer_appointments'])->name('customer-appointments');
                Route::get('/appointment-create', [appointmentsController::class, 'appointment_create'])->name('appointment-create');
                Route::post('/appointment-selection', [appointmentsController::class, 'appointment_selection'])->name('appointment-selection');
                Route::post('/appointment-create/store', [appointmentsController::class, 'appointment_store'])->name('appointment-store');

            // Reservation routes
                Route::get('/customer-reservations', [reservationsController::class, 'customer_reservations'])->name('customer-reservations');
                Route::get('/reservation-create', [reservationsController::class, 'reservation_create'])->name('reservation-create');
                Route::post('/reservation-selection', [reservationsController::class, 'reservation_selection'])->name('reservation-selection');
                Route::post('/reservation-create/store', [reservationsController::class, 'reservation_store'])->name('reservation-store');

                Route::get('/get-reservation-dates/{product_id}', [reservationsController::class, 'getReservationDates'])->name('get-reservation-dates');

    });     

//STAFF
    Route::group(['middleware'=>['AuthcheckStaff']], function(){
        Route::get('/staff-login', [indexStaffController::class, 'index'])->name('staff-login');
        Route::get('/staff-home', [staffController::class, 'staff_home'])->name('staff-home');
        Route::get('/staff-rented', [staffController::class, 'staff_rented'])->name('staff-rented');
        Route::get('/Logout-staff',[staffController::class, 'Logout_staff'])->name ('Logout-staff');

        //Staff Profile
            Route::get('/staff-profile', [staffController::class, 'staff_profile'])->name('staff-profile');
            Route::put('/staff-profile/update', [staffController::class, 'staff_profile_update'])->name('staff-profile.update'); 

        //PRODUCTS
            Route::get('/staff-products', [productController::class, 'staff_products'])->name('staff-products');
            Route::get('/staff-products-add', [productController::class, 'staff_products_add'])->name('staff-products-add');
            Route::post('/staff-products-add', [productController::class, 'store'])->name('products.store');
            Route::post('/staff-products-add/{product}/add-colors', [productController::class, 'addColors'])->name('product.addColors'); // Use route model binding
            Route::post('/staff-products-add/{product}/add-accessories', [productController::class, 'addAccessories'])->name('product.addAccessories'); // Use route model binding
            
            Route::get('/staff-products-update/{id}', [productController::class, 'staff_products_update'])->name('staff-products-update');
            Route::put('/staff-products-update/{id}', [productController::class, 'products_update'])->name('products.update');
            Route::delete('/staff-products-delete/{id}', [productController::class, 'products_delete'])->name('products.delete');

        // Wedding Package
            Route::get('/staff-products-add-wedding-package', [WeddingPackageController::class, 'staff_products_add_wedding_package'])->name('staff-products-add-wedding-package');
            Route::post('/staff-products-add-wedding-package', [WeddingPackageController::class, 'store'])->name('staff-products-add-wedding-package.store');
            
            Route::get('/staff-products-update-wedding-package/{id}', [WeddingPackageController::class, 'update_wedding_package_show'])->name('update-wedding-package');
            Route::put('/staff-products-update-wedding-package/{id}', [WeddingPackageController::class, 'wp_update'])->name('wp.update');

        // Appointment routes
            Route::get('/staff-appointments', [staffController::class, 'staff_appointments'])->name('staff-appointments');
            Route::get('/staff-appointments/{id}/complete', [staffController::class, 'appointments_completed'])->name('appointments.completed');
        
        // Reservation routes
            Route::get('/staff-home/{id}/confirm', [staffController::class, 'confirm_reservations'])->name('confirm.reservations');
            Route::get('/staff-home/{id}/decline', [staffController::class, 'decline_reservations'])->name('decline.reservations');

        //Confirm Rent
            Route::get('/staff-home/{id}/confirm-rent', [staffController::class, 'confirm_rent'])->name('confirm.rent');
            Route::get('/staff-rented/{id}/confirm-return', [staffController::class, 'confirm_return'])->name('confirm.return');

    });

//MANAGER
    Route::group(['middleware'=>['AuthcheckManager']], function(){

        Route::get('/manager-login', [indexManagerController::class, 'index'])->name('manager.manager-login');
        Route::get('/manager-home', [managerController::class, 'manager_home'])->name('manager.manager-home');
        Route::get('/manager-rented', [managerController::class, 'manager_rented'])->name('manager.manager-rented');
        Route::get('/Logout-manager',[managerController::class, 'Logout_manager'])->name ('Logout-manager');

            //PRODUCTS
            Route::get('/manager-products', [productManagerController::class, 'manager_products'])->name('manager.manager-products');
            Route::get('/manager-products-add', [productManagerController::class, 'manager_products_add'])->name('manager.manager-products-add');
            Route::post('/manager-products-add', [productManagerController::class, 'store'])->name('manager.products.store');
            Route::post('/manager-products-add/{product}/add-colors', [productManagerController::class, 'addColors'])->name('manager.product.addColors'); // Use route model binding
            Route::post('/manager-products-add/{product}/add-accessories', [productManagerController::class, 'addAccessories'])->name('manager.product.addAccessories'); // Use route model binding
            
            Route::get('/manager-products-update/{id}', [productManagerController::class, 'manager_products_update'])->name('manager.manager-products-update');
            Route::put('/manager-products-update/{id}', [productManagerController::class, 'products_update'])->name('manager.products.update');
            Route::delete('/manager-products-delete/{id}', [productManagerController::class, 'products_delete'])->name('manager.products.delete');

        //Manager Profile
            Route::get('/manager-profile', [managerController::class, 'manager_profile'])->name('manager.manager-profile');

        // Wedding Package
            Route::get('/manager-products-add-wedding-package', [WeddingPackageManagerController::class, 'manager_products_add_wedding_package'])->name('manager.manager-products-add-wedding-package');
            Route::post('/manager-products-add-wedding-package', [WeddingPackageManagerController::class, 'store'])->name('manager.manager-products-add-wedding-package.store');
            
            Route::get('/manager-products-update-wedding-package/{id}', [WeddingPackageManagerController::class, 'update_wedding_package_show'])->name('manager.update-wedding-package');
            Route::put('/manager-products-update-wedding-package/{id}', [WeddingPackageManagerController::class, 'wp_update'])->name('manager.wp.update');

        // Appointment routes
            Route::get('/manager-appointments', [managerController::class, 'manager_appointments'])->name('manager.manager-appointments');
            Route::get('/manager-appointments/{id}/complete', [managerController::class, 'manager_appointments_completed'])->name('manager.appointments.completed');
        
        // Reservation routes
            Route::get('/manager-home/{id}/confirm', [managerController::class, 'manager_confirm_reservations'])->name('manager.confirm.reservations');
            Route::get('/manager-home/{id}/decline', [managerController::class, 'manager_decline_reservations'])->name('manager.decline.reservations');

        //Confirm Rent
            Route::get('/manager-home/{id}/confirm-rent', [managerController::class, 'manager_confirm_rent'])->name('manager.confirm.rent');
            Route::get('/manager-home/{id}/confirm-return', [managerController::class, 'manager_confirm_return'])->name('manager.confirm.return');
        
        // Reports
            Route::get('/reports', [managerController::class, 'reports'])->name('reports');
            Route::get('/reports-reserved', [managerController::class, 'reports_reserved'])->name('reports.reserved');
            Route::get('/reports-pending', [managerController::class, 'reports_pending'])->name('reports.pending');
            Route::get('/reports-ongoing', [managerController::class, 'reports_ongoing'])->name('reports.ongoing');
            Route::get('/reports-declined', [managerController::class, 'reports_declined'])->name('reports.declined');
            Route::get('/reports-returned', [managerController::class, 'reports_returned'])->name('reports.returned');


    });

// ADMIN
    Route::group(['middleware'=>['AuthcheckAdmin']], function(){

        //ADMIN
        Route::get('/admin-login', [indexAdminController::class, 'index'])->name('admin-login');
        Route::get('/admin-home', [adminController::class, 'admin_home'])->name('admin.admin-home');
        Route::get('/admin-rented', [adminController::class, 'admin_rented'])->name('admin.admin-rented');
        Route::get('/admin-products', [adminController::class, 'admin_products'])->name('admin.admin-products');
        Route::get('/Logout-admin',[adminController::class, 'Logout_admin'])->name ('Logout-admin');

            //PRODUCTS
            Route::get('/admin-products', [productAdminController::class, 'admin_products'])->name('admin.admin-products');
            Route::get('/admin-products-add', [productAdminController::class, 'admin_products_add'])->name('admin.admin-products-add');
            Route::post('/admin-products-add', [productAdminController::class, 'store'])->name('admin.products.store');
            Route::post('/admin-products-add/{product}/add-colors', [productAdminController::class, 'addColors'])->name('admin.product.addColors'); // Use route model binding
            Route::post('/admin-products-add/{product}/add-accessories', [productAdminController::class, 'addAccessories'])->name('admin.product.addAccessories'); // Use route model binding
            
            Route::get('/admin-products-update/{id}', [productAdminController::class, 'admin_products_update'])->name('admin.admin-products-update');
            Route::put('/admin-products-update/{id}', [productAdminController::class, 'products_update'])->name('admin.products.update');
            Route::delete('/admin-products-delete/{id}', [productAdminController::class, 'products_delete'])->name('admin.products.delete');

        //Admin Profile
            Route::get('/admin-profile', [adminController::class, 'admin_profile'])->name('admin.admin-profile');

        //Activity Logs
            Route::get('/admin-activity-logs', [adminController::class, 'activity_logs'])->name('admin.admin-activity-logs');

        // Appointment routes
            Route::get('/admin-appointments', [adminController::class, 'admin_appointments'])->name('admin.admin-appointments');
            Route::get('/admin-appointments/{id}/complete', [adminController::class, 'admin_appointments_completed'])->name('admin.appointments.completed');
        //Reports
            Route::get('/admin-reports', [adminController::class, 'admin_reports'])->name('admin.reports');

            
    });




Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

Route::get('auth/google/staff', [GoogleAuthStaffController::class, 'redirect_staff'])->name('google-auth-staff');
Route::get('auth/google/staff/call-back', [GoogleAuthStaffController::class, 'callbackGoogleStaff']);


