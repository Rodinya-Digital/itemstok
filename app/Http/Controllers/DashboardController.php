<?php

namespace App\Http\Controllers;

use App\Log;
use App\Order;
use App\User;
use App\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mydnic\Kustomer\Feedback;
use function GuzzleHttp\json_encode;
use function PHPUnit\Framework\countOf;


class DashboardController extends Controller
{
    public function setThemeOptions()
    {
        $data = \request()->all();
        if (Auth::user()->theme !== null) {
            $userSettings = collect(json_decode(Auth::user()->theme))->toArray();
        } else {
            $userSettings = [
                "Theme" => "dark", // light | dark
                "ColorTheme" => "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
                "Layout" => "vertical", // vertical | horizontal
                "BoxedLayout" => false, // true | false
                "SidebarType" => "full", // full | mini-sidebar
                "cardBorder" => false, // true | false
            ];
        }


        if ($data['name'] == 'theme-layout') {
            if ($data['id'] == 'light-layout') {
                $userSettings['Theme'] = "light";
            } else {
                $userSettings['Theme'] = "dark";
            }
        }

        if ($data['name'] == 'color-theme-layout') {
            if ($data['id'] == 'Blue_Theme' || $data['id'] == 'Aqua_Theme' || $data['id'] == 'Purple_Theme' || $data['id'] == 'Green_Theme' || $data['id'] == 'Cyan_Theme' || $data['id'] == 'Orange_Theme') {
                $userSettings['ColorTheme'] = $data['id'];
            } elseif ($data['id'] == 'green-theme-layout') {
                $userSettings['ColorTheme'] = "Green_Theme";
            } elseif ($data['id'] == 'cyan-theme-layout') {
                $userSettings['ColorTheme'] = "Cyan_Theme";
            } elseif ($data['id'] == 'orange-theme-layout') {
                $userSettings['ColorTheme'] = "Orange_Theme";
            } else {
                $userSettings['ColorTheme'] = "Blue_Theme";
            }
        }
        $userSettings['Layout'] = "vertical";
        /*if ($data['name'] == 'page-layout') {
            if ($data['id'] == 'vertical-layout') {
                $userSettings['Layout'] = "vertical";
            } else {
                $userSettings['Layout'] = "horizontal";
            }
        }*/

        if ($data['name'] == 'avatar-selection' && is_numeric($data['id']) && $data['id'] >= 1 && $data['id'] <= 26) {
            $userUp = User::find(Auth::id());
            $userUp->avatar = $data['id'];
            $userUp->save();
        }

        if ($data['name'] == 'layout') {
            if ($data['id'] == 'boxed-layout') {
                $userSettings['BoxedLayout'] = true;
            } else {
                $userSettings['BoxedLayout'] = false;
            }
        }

        if ($data['name'] == 'sidebar-type') {
            if ($data['id'] == 'mini-sidebar') {
                $userSettings['SidebarType'] = "mini-sidebar";
            } else {
                $userSettings['SidebarType'] = "full";
            }
        }

        if ($data['name'] == 'card-layout') {
            if ($data['id'] == 'card-with-border') {
                $userSettings['cardBorder'] = true;
            } else {
                $userSettings['cardBorder'] = false;
            }
        }


        $userUp = User::find(Auth::id());
        $userUp->theme = json_encode($userSettings);
        $userUp->save();
    }

    public function user(Request $request)
    {
        $user = Auth::user();
        $thisData = UserServices::orderBy('exp_date', 'DESC')
            ->where([
                ['user_id', $user->id],
                /*['exp_date', '>=', Carbon::now()],*/
            ])
            /*->whereJsonContains('services', $service)*/
            ->get();
        $todayTotalDowns = 0;
        $downs = 0;
        if ($thisData->toArray()) {
            $todayTotalDowns = Log::where('user_id', $user->id)
                ->where('type', 'success')
                ->whereDate('created_at', Carbon::today())
                ->get()->count();
            $downs = $thisData->sum('downs') - $todayTotalDowns;
        }


        $allTotalDowns = Log::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->limit(200)->get();

        return view('user.dashboard.index', [
            'downloads' => $allTotalDowns,
            'data' => $thisData
        ]);
    }

    public function admin(Request $request)
    {

        $userCount = User::count();

        $todayRegUserCount = User::whereDate('created_at', Carbon::today())->where('deleted_at', null)->count();
        $todayRegServiceCount = UserServices::whereDate('created_at', Carbon::today())->count();


        $adminUsers = User::whereHas(
            'roles', function ($q) {
            $q->where('name', 'Admin');
        })->get();


        return view('admin.dashboard.index', [
            'userCount' => $userCount,
            'adminUsers' => $adminUsers,
            'todayRegUserCount' => $todayRegUserCount,
            'todayRegServiceCount' => $todayRegServiceCount,
        ]);
    }

    public static function getActiveServiceStats()
    {
        $services = UserServices::select('services')
            ->distinct()
            ->get()
            ->flatMap(function ($item) {
                return $item->services; // JSON'u diziye çeviriyoruz
            })
            ->unique()
            ->toArray();

        $activeServicesData = [];

        foreach ($services as $service) {
            $activeCount = UserServices::whereJsonContains('services', $service) // JSON veriyi kontrol ediyoruz
            ->where('exp_date', '>', \Carbon\Carbon::now())
                ->groupBy('user_id')
                ->orderBy('exp_date', 'ASC')
                ->get()
                ->count();
            $activeServicesData[] = [
                'name' => ucfirst($service),
                'count' => $activeCount
            ];
        }

        return response()->json($activeServicesData);
    }

    public static function getDownloadStats()
    {
        $startDate = Carbon::today()->subDays(\request()->days ?: 7);
        $endDate = Carbon::now();

        // Generate an array of dates for the past 7 days
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Fetch distinct service names from the database
        $services = Log::where('type', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct()
            ->pluck('name')
            ->toArray();

        // Fetch the data from the database
        $forChartServicesUsingData = Log::where('type', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, name, COUNT(*) as count')
            ->groupBy('date', 'name')
            ->get();

        // Organize data into a nested array [date][service] => count
        $counts = [];
        foreach ($forChartServicesUsingData as $record) {
            $counts[$record->date][$record->name] = $record->count;
        }

        // Prepare chart data
        $chartData = [];
        foreach ($services as $service) {
            $serviceData = [];
            foreach ($dates as $date) {
                $y = isset($counts[$date][$service]) ? (int)$counts[$date][$service] : 0;
                $serviceData[] = ['x' => $date, 'y' => $y];
            }
            $chartData[] = [
                'name' => mb_strtoupper($service),
                'data' => $serviceData,
            ];
        }

        return response()->json($chartData);
    }

    public static function getPaymentStats()
    {
        $startDate = Carbon::today()->subDays(\request()->days ?: 7);
        $endDate = Carbon::now();

        // Günlük ödeme verileri için tarih aralığı oluşturuluyor
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Günlük başarılı ödemeler (grafik verileri için)
        $forChartOrdersData = Order::where('status', 1)
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('DATE(payment_date) as date, SUM(price) as total')
            ->groupBy('date')
            ->get();

        // Verileri organize et
        $totals = [];
        foreach ($forChartOrdersData as $record) {
            $totals[$record->date] = $record->total;
        }

        // Günlük veri formatı oluşturuluyor
        $chartData = [];
        foreach ($dates as $date) {
            $total = isset($totals[$date]) ? (int)$totals[$date] : 0;
            $chartData[] = ['x' => $date, 'y' => $total];
        }

        // Bugün
        $todayTotal = Order::where('status', 1)
            ->whereDate('payment_date', Carbon::today())
            ->sum('price');

        // Dün
        $yesterdayTotal = Order::where('status', 1)
            ->whereDate('payment_date', Carbon::yesterday())
            ->sum('price');

        // Bu Hafta
        $thisWeekTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('price');

        // Geçen Hafta
        $lastWeekTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->sum('price');

        // Bu Ay
        $thisMonthTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('price');

        // Geçen Ay
        $lastMonthTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum('price');

        // Bu Yıl
        $thisYearTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('price');

        $befYearTotal = Order::where('status', 1)
            ->whereBetween('payment_date', [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])
            ->sum('price');

        // JSON yanıtı oluşturuluyor
        return response()->json([
            'name' => 'TOTAL_PAYMENTS',
            'data' => $chartData, // Grafik verileri
            'today_total' => $todayTotal,
            'yesterday_total' => $yesterdayTotal,
            'this_week_total' => $thisWeekTotal,
            'last_week_total' => $lastWeekTotal,
            'this_month_total' => $thisMonthTotal,
            'last_month_total' => $lastMonthTotal,
            'this_year_total' => $thisYearTotal,
            'befYearTotal' => $befYearTotal,
        ]);
    }

    public function phone_verify()
    {
        return view('phone_verify');
    }

    public function getFeedBacks()
    {
        $feedbacks = Feedback::orderByDesc('id')->get();
        return view('admin.feedbacks', ['feedbacks' => $feedbacks]);
    }

    public function getFeedBackUser()
    {
        $feedbacks = Feedback::where('user_id', \auth()->id())->orderByDesc('id')->get();
        return view('user.feedbacks', ['feedbacks' => $feedbacks]);
    }

    public function AddAnswerFB($id)
    {
        $fb = Feedback::find($id);
        $fb->answer = \request()->answer;
        $fb->reviewed = 1;
        $fb->save();
        return back();
    }

}
