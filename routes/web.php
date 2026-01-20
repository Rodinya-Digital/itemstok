<?php

use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\UserServicesController;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\View;

Route::post('/token', 'Auth\TokenController@token')->middleware(['auth'])->name('getToken');

Route::get('/', function () {
    //if (Auth::check())
    return redirect(route('panel.admin.dashboard'));
    // return view('loading');
});

Route::get('home', function () {
    return redirect(route('panel.admin.dashboard'));
});

Route::get('panel', function () {
    return redirect(route('panel.admin.dashboard'));
});

Route::get('admin', function () {
    return redirect(route('admin.admin.dashboard'));
});




Route::get('r/{ref}', function ($ref) {
    \Illuminate\Support\Facades\Session::put('ref', $ref);
    return \redirect()->route('register');
});


Route::get('setThemeMode', function () {
    if (!Auth::check())
        return \redirect()->route('login');
    $user = User::find(Auth::id());
    if ($user->theme_mode == 'dark') {
        $user->theme_mode = 'light';
        $user->save();
        return back();
    } else {
        $user->theme_mode = 'dark';
        $user->save();
        return back();
    }

})->name('setThemeMode');


Route::get('Feedback-yes/{id}', function ($id) {
    \Mydnic\Kustomer\Feedback::whereId($id)->update(['reviewed' => 1]);
    return back();
})->middleware('Admin')->name('Feedback-yes');
Route::get('Feedback-no/{id}', function ($id) {
    \Mydnic\Kustomer\Feedback::whereId($id)->update(['reviewed' => 0]);
    return back();
})->middleware('Admin')->name('Feedback-no');
Route::post('Feedback-del/{id}', function ($id) {
    \Mydnic\Kustomer\Feedback::find($id)->delete();
    return back();
})->middleware('Admin')->name('Feedback-del');

Route::get('luzumsuzKullaniciListesixp24x', function () {

    $fiveHoursAgo = Carbon::now()->subHours(6);

    $usersWithMultipleIPs = DB::table('loginezer')
        ->select('user_id', DB::raw('count(*) as ip_count'))
        ->where('date', '>=', $fiveHoursAgo)
        ->groupBy('user_id')
        ->having('ip_count', '>=', 2)
        ->get();

    foreach ($usersWithMultipleIPs as $user) {
        $userStatus = User::find($user->user_id)->status;

        // Kullanıcıya ait IP adreslerini al
        $ipAddresses = DB::table('loginezer')
            ->select('ip')
            ->where('user_id', $user->user_id)
            ->where('date', '>=', $fiveHoursAgo)
            ->groupBy('ip')
            ->get()
            ->pluck('ip')
            ->toArray();

        // IP adreslerini string haline getir
        $ipAddressesString = "<span style='color:white;background: #0b0b0b;padding: 2px 5px;margin:15px;font-weight: bold'>" . implode("</span><span style='color:white;background: #0b0b0b;padding: 2px 5px;margin:15px;font-weight: bold'>", $ipAddresses) . "</span>";

        if ($user->ip_count > 3) {
            $ipCount = "<span style='color:red;background: #0b0b0b;padding: 5px;font-weight: bold'>" . $user->ip_count . "</span>";
        } elseif ($user->ip_count > 2) {
            $ipCount = "<span style='color:orangered;background: #0b0b0b;padding: 5px;font-weight: bold'>" . $user->ip_count . "</span>";
        } else {
            $ipCount = "<span style='color:green;background: #0b0b0b;padding: 5px;font-weight: bold'>" . $user->ip_count . "</span>";
        }

        if ($userStatus == 2) {
            $userStatusH = "<span style='color:red;background: #0b0b0b;padding: 5px;font-weight: bold'>Kullanıcı Banlandı !</span>";
        } else {
            $userStatusH = "";
        }

        echo "<button><a href='https://www.itemstok.org/panel/users/" . $user->user_id . "/edit'>Düzenle</a></button> | <button><a href='https://www.itemstok.org/panel/uservice/user/" . $user->user_id . "'>Servislere Bak</a></button> | User ID: " . $user->user_id . " Bu Kullanıcı " . $ipCount . " Farklı IP adresi ile erişim sağladı son 6 saatte." . $userStatusH . "<br>IP Adresleri: " . $ipAddressesString . "<hr>";
    }

});


Route::name('panel.')->prefix('panel')->middleware(['auth'])->group(function () {


    Route::post('service-add-user/{id}', 'WeepayController@serviceToUser')->name('serviceAddToUser')->middleware(['Admin']);
    Route::post('addAnswerFB/{id}', 'DashboardController@AddAnswerFB')->name('addAnswerFB')->middleware(['Admin']);

    /*YÖNETİCİ ROUTES*/
    Route::resource('services', 'ServiceController')->middleware('Admin');
    Route::name('uservice.')->prefix('uservice')->middleware(['Admin'])->group(function () {
        Route::get('list', 'UserServicesController@index')->name('list');
        Route::get('user/{user}', 'UserServicesController@show')->name('user');
        Route::delete('destroy/{id}', 'UserServicesController@destroy')->name('destroy');
    });
    Route::get('admin-dashboard', 'DashboardController@admin')->middleware('Admin')->name('admin.dashboard');

    Route::get('getFeedBacks', 'DashboardController@getFeedBacks')->middleware('Admin')->name('getFeedBacks');

    Route::get('cookie-mnt', function () {
        return view('admin.cookie');
    })->middleware('Admin')->name('cookie.mnt');
    Route::get('users/roles', 'UserController@roles')->middleware('Admin')->name('users.roles');
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'users'
        ]
    ])->withoutMiddleware(['Admin']);
    Route::resource('managekeys', 'ManageKeysController')->middleware('Admin');
    Route::get('getDownloadStats', 'DashboardController@getDownloadStats')->middleware('Admin');

    /*KULLANICI ROUTES*/
    Route::get('setThemeOptions', 'DashboardController@setThemeOptions')->name('setThemeOptions');
    Route::get('getFeedBacksUser', 'DashboardController@getFeedBackUser')->name('getFeedBacksUser');
    Route::get('dashboard', 'DashboardController@user')->name('user.dashboard');
    Route::get('shop', 'ServiceController@list')->name('shop');
    Route::post('usingkey', 'ServiceController@usingkey')->name('usingkey');
    Route::get('service/shutterstock', 'UserServicesController@shutterstock')->name('service.shutterstock');
    Route::get('service/otherServices', 'UserServicesController@otherServices')->name('service.otherServices');
    Route::get('service/adobestock', 'UserServicesController@adobestock')->name('service.adobestock');
    Route::get('service/envatoelements', 'UserServicesController@envatoelements')->name('service.envatoelements');
    Route::get('service/freepik', 'UserServicesController@freepik')->name('service.freepik');
    Route::get('service/flaticon', 'UserServicesController@flaticon')->name('service.flaticon');
    Route::get('service/epidemicsound', 'UserServicesController@epidemicsound')->name('service.epidemicsound');
    Route::get('service/motionarray', 'UserServicesController@motionarray')->name('service.motionarray');
    Route::get('service/motionelements', 'UserServicesController@motionelements')->name('service.motionelements');
    Route::get('service/licenseCenter', 'UserServicesController@licenseCenter')->name('service.licenseCenter');
    Route::get('orders', function () {
        return view('user.order.list', ['orders' => Order::where('user_id', Auth::user()->id)->where('status', '1')->orderBy('updated_at', 'DESC')->get()]);
    })->name('orders');


    Route::get('dealer/keys', [\App\Http\Controllers\DealerController::class, 'index'])->name('dealerKeys');

});

Route::get('getDownloadStats', 'DashboardController@getDownloadStats')->name('getDownloadStats')->middleware('Admin');
Route::get('getPaymentStats', 'DashboardController@getPaymentStats')->name('getPaymentStats')->middleware('Admin');
Route::get('getActiveServiceStats', 'DashboardController@getActiveServiceStats')->name('getActiveServiceStats')->middleware('Admin');

Route::get('api/shutterstock_custom', function () {
    if (request()->accesskey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9') {
        return \App\Http\Controllers\ServiceController::shutterStockDW();
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid Access Key.']);
    }
});

Route::get('api/adoobestock_custom', function () {
    if (request()->accesskey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9') {
        return \App\Http\Controllers\ServiceController::adobeStockDW();
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid Access Key.']);
    }
});


Route::name('api.')->prefix('api')->middleware(['auth'])->group(function () {
    Route::post('licenseCenter', function () {
        $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=licenseCenter&url=' . request()->url));
        return $result;
    })->name('licenseCenter');

    Route::post('OtherServices', [\App\Http\Controllers\ServiceController::class, 'OtherServices'])->name('OtherServices');

    Route::post('shutterstock', function () {
        /* if (Auth::id()!==1)
             return response()->json(['success' => false, 'message' => '<hr> SİSTEM BAKIMDADIR !!!']);*/
        if (UserServicesController::getServiceInfos('shutterstock')['downs'] <= 0)
            return response()->json(['success' => false, 'message' => 'nolimit']);
        if (!str_contains(request()->url, 'shutterstock.com'))
            return response()->json(['success' => false, 'message' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'shutterstock',
                "value" => request()->url
            ]);
            try {
                $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=shutterstock&url=' . request()->url));
                if ($result->success) {
                    $logInto->type = 'success';
                } else {
                    $logInto->type = 'danger';
                }
                $logInto->save();
                return $result;
            } catch (\Exception $exception) {
                $logInto->type = 'danger';
                $logInto->save();
                return response()->json(['success' => false, 'message' => 'error']);
            }

        }
    })->name('shutterstock');
    Route::post('adobestock', function () {
        if (UserServicesController::getServiceInfos('adobestock')['downs'] <= 0)
            return response()->json(['success' => false, 'message' => 'nolimit']);
        if (!str_contains(request()->url, 'stock.adobe.com'))
            return response()->json(['success' => false, 'message' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'adobestock',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=adobestock&url=' . request()->url));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('adobestock');
    Route::post('envatoelements', function () {
        if (UserServicesController::getServiceInfos('envatoelements')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'elements.envato.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'envatoelements',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=envatoelements&url=' . request()->url));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('envatoelements');
    Route::post('tenvatoelements', function () {
        if (UserServicesController::getServiceInfos('envatoelements')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, '.envato.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $result = json_decode(file_get_contents('https://rose.voltyazilim.com.tr/envatoe/getThemeToken?apikey=e23c3b6f02de8a14e808b8&url=' . urlencode(request()->url)));
            return $result;
        }
    })->name('tenvatoelements');
    Route::post('flaticon', function () {
        /*if(\auth()->user()->id!='1')
            return response()->json(['success' => false, 'error' => 'BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ']);*/
        if (UserServicesController::getServiceInfos('flaticon')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'flaticon.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'flaticon',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('https://188.132.168.79:3450/?key=sdasdas333&dw==flaticon&url=' . request()->url . '&dwType=' . request()->dwType));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('flaticon');
    Route::post('epidemicsound', function () {
        if (UserServicesController::getServiceInfos('epidemicsound')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'epidemicsound.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'epidemicsound',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=epidemicsound&url=' . request()->url . '&dwType=' . urlencode(request()->dwType)));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('epidemicsound');
    Route::post('freepik', function () {
        /*if(\auth()->user()->id!='1')
            return response()->json(['success' => false, 'error' => 'BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ<HR>BAKIMDAYIZ']);*/
        if (UserServicesController::getServiceInfos('freepik')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'freepik.'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'freepik',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=freepik&url=' . request()->url . '&videoselected=' . request()->videoselected . '&xurl=' . request()->xurl));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('freepik');
    Route::post('motionarray', function () {
        //return response()->json(['success' => false, 'error' => 'BU HİZMET ŞUANDA BAKIMDADIR ! <hr>BU HİZMET ŞUANDA BAKIMDADIR ! <hr>BU HİZMET ŞUANDA BAKIMDADIR ! <hr>']);
        if (UserServicesController::getServiceInfos('motionarray')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'motionarray.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'motionarray',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=motionarray&url=' . request()->url));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('motionarray');
    Route::post('motionelements', function () {
        if (UserServicesController::getServiceInfos('motionelements')['downs'] <= 0)
            return response()->json(['success' => false, 'error' => 'nolimit']);
        if (!str_contains(request()->url, 'motionelements.com'))
            return response()->json(['success' => false, 'error' => 'nosupport']);
        if (request()->type == 'file') {
            $logInto = Log::create([
                "user_id" => Auth::id(),
                "type" => 'info',
                "name" => 'motionelements',
                "value" => request()->url
            ]);
            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=motionelements&url=' . request()->url));
            if ($result->success) {
                $logInto->type = 'success';
            } else {
                $logInto->type = 'danger';
            }
            $logInto->save();
            return $result;
        }
    })->name('motionelements');
});


Route::middleware('auth')->get('logout', function () {
    Auth::logout();
    return redirect(route('login'))->withInfo(__("You have successfully logged out!"));
});

Auth::routes(['verify' => true]);

Route::name('js.')->group(function () {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function () {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});

Route::get('paytrpay', 'PayTRController@odeme')->name('paytrpay');
Route::post('paytr_callback', 'PayTRController@bildirim')->name('paytr_callback');

Route::get('valletpay', 'ValletPayController@odeme')->name('valletpay');
Route::post('valletpay_callback', 'ValletPayController@bildirim')->name('valletpay_callback');


Route::get('payid19pay', 'ValletPayController@payid19pay')->name('payid19pay');
Route::post('payid19call', 'ValletPayController@payid19call')->name('payid19call');


Route::post('cookie_envatoelements1_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'envatoelements1')
        ->update(['cookie' => $request->envatoelements1, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_envatoelements1_update')->middleware(['Admin']);

Route::post('cookie_envatoelements2_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'envatoelements2')
        ->update(['cookie' => $request->envatoelements2, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_envatoelements2_update')->middleware(['Admin']);

Route::post('cookie_freepik1_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'freepik1')
        ->update(['cookie' => $request->freepik1, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_freepik1_update')->middleware(['Admin']);

Route::post('cookie_freepik2_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'freepik2')
        ->update(['cookie' => $request->freepik2, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_freepik2_update')->middleware(['Admin']);

Route::post('cookie_freepik3_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'freepik3')
        ->update(['cookie' => $request->freepik3, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_freepik3_update')->middleware(['Admin']);

Route::post('cookie_freepik4_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'freepik4')
        ->update(['cookie' => $request->freepik4, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_freepik4_update')->middleware(['Admin']);

Route::post('cookie_freepik5_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'freepik5')
        ->update(['cookie' => $request->freepik5, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_freepik5_update')->middleware(['Admin']);


Route::post('cookie_flaticon1_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'flaticon1')
        ->update(['cookie' => $request->flaticon1, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_flaticon1_update')->middleware(['Admin']);

Route::post('cookie_flaticon2_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'flaticon2')
        ->update(['cookie' => $request->flaticon2, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_flaticon2_update')->middleware(['Admin']);

Route::post('cookie_flaticon3_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'flaticon3')
        ->update(['cookie' => $request->flaticon3, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_flaticon3_update')->middleware(['Admin']);

Route::post('cookie_flaticon4_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'flaticon4')
        ->update(['cookie' => $request->flaticon4, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_flaticon4_update')->middleware(['Admin']);

Route::post('cookie_epidemicsound_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'epidemicsound')
        ->update(['cookie' => $request->epidemicsound, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_epidemicsound_update')->middleware(['Admin']);


Route::post('cookie_motionarray_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'motionarray')
        ->update(['cookie' => $request->motionarray, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_motionarray_update')->middleware(['Admin']);

Route::post('cookie_motionelements_update', function (Request $request) {
    DB::table('service_auths')->where('name', 'motionelements')
        ->update(['cookie' => $request->motionelements, 'updated_at' => now()]);
    return redirect()->back();
})->name('cookie_motionelements_update')->middleware(['Admin']);

Route::get('dtx', function () {
    $topDownloaderUsers = Log::where([
        ['created_at', '>=', \Carbon\Carbon::today()],
        ['type', '=', 'success'],
        ['name', '=', 'envatoelements']
    ])
        ->groupBy('user_id', 'name')
        ->orderBy('totalDownload', 'DESC')
        ->limit(20)
        ->get(array(
            DB::raw('COUNT(*) as "totalDownload" , user_id, name,created_at'),
        ));
    return response()->json($topDownloaderUsers);
});