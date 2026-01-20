<?php

namespace App\Http\Controllers;

use App\Log;
use App\Order;
use App\User;
use App\UserServices;
use App\Http\Requests\StoreUserServicesRequest;
use App\Http\Requests\UpdateUserServicesRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserServicesController extends Controller
{

    public static function getServiceInfos($service, $user = false, $type = false)
    {
        if (!$user && !$type) {
            $user_id = Auth::id();
        }
        if ($user && !$type) {
            $user_id = $user;
        }

        $thisData = UserServices::orderBy('exp_date', 'ASC')
            ->where([
                ['user_id', $user_id],
                ['exp_date', '>=', Carbon::now()],
            ])
            ->whereJsonContains('services', $service)
            ->get();
        $todayTotalDowns = 0;
        $betweenMaxDownloadTotal = 0;
        $downs = 0;
        $expDAte = Carbon::now();
        if ($thisData->toArray()) {
            $todayTotalDowns = Log::where('user_id', $user_id)
                ->whereIn('name', array_values(max(array_column($thisData->toArray(), 'services'))))
                ->where('type', 'success')
                ->whereOr('type', 'info')
                ->whereDate('created_at', Carbon::today())
                ->get()->count();
            $betweenMaxDownloadTotal = Log::where('user_id', $user_id)
                ->whereIn('name', array_values(max(array_column($thisData->toArray(), 'services'))))
                ->where('type', 'success')
                ->whereOr('type', 'info')
                ->whereBetween('created_at', [min(array_column($thisData->toArray(), 'created_at')), max(array_column($thisData->toArray(), 'exp_date'))])
                ->get()->count();
            if ($betweenMaxDownloadTotal < $thisData->sum('max')) {
                $downs = $thisData->sum('downs') - $todayTotalDowns;
            }
            $expDAte = max(array_column($thisData->toArray(), 'exp_date'));
        }
        $allTotalDowns = Log::where('user_id', $user_id)
            ->whereIn('name', [$service])
            ->where('type', 'success')
            ->get()->count();

        return ['expDAte' => $expDAte, 'maxp' => (object)['max' => $thisData->sum('max'), 'total' => $betweenMaxDownloadTotal], 'data' => $thisData->first(), 'downs' => $downs, 'allDowns' => $allTotalDowns];
    }

    public function shutterstock()
    {
        return view('user.services.shutterstock', $this->getServiceInfos('shutterstock'));
    }

    public function otherServices()
    {
        return view('user.services.otherServices');
    }

    public function adobestock()
    {
        return view('user.services.adobestock', $this->getServiceInfos('adobestock'));
    }

    public function envatoelements()
    {
        return view('user.services.envatoelements', $this->getServiceInfos('envatoelements'));
    }

    public function freepik()
    {
        return view('user.services.freepik', $this->getServiceInfos('freepik'));
    }

    public function flaticon()
    {
        return view('user.services.flaticon', $this->getServiceInfos('flaticon'));
    }

    public function epidemicsound()
    {
        return view('user.services.epidemicsound', $this->getServiceInfos('epidemicsound'));
    }

    public function motionarray()
    {
        return view('user.services.motionarray', $this->getServiceInfos('motionarray'));
    }

    public function motionelements()
    {
        return view('user.services.motionelements', $this->getServiceInfos('motionelements'));
    }

    public function licenseCenter()
    {
        //dd('This page is currently under maintenance.');
        return view('user.license');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserServicesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserServicesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param \App\UserServices $userServices
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user, UserServices $userServices)
    {
        //$getUserServiceInfo = self::getServiceInfos('envatoelements',$user->id);
        //dd($getUserServiceInfo);
        $thisData = UserServices::orderBy('exp_date', 'DESC')
            ->where([
                ['user_id', $user->id],
                /*['exp_date', '>=', Carbon::now()],*/
            ])
            /*->whereJsonContains('services', $service)*/
            ->get();
        $orders = Order::orderBy('id', 'DESC')
            ->where([
                ['user_id', $user->id],
            ])
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
            ->get();
        return view('admin.user_services.show', [
            'user' => $user,
            'data' => $thisData,
            'downs' => $downs + $todayTotalDowns,
            'tdowns' => $todayTotalDowns,
            'orders' => $orders,
            'allDowns' => $allTotalDowns,
            'allDownsCount' => $allTotalDowns->count(),
            'services' => [
                'Envato Elements' => (object)self::getServiceInfos('envatoelements', $user->id),
                'Freepik Premium' => (object)self::getServiceInfos('freepik', $user->id),
                'Motion Array' => (object)self::getServiceInfos('motionarray', $user->id),
                'Motion Elements' => (object)self::getServiceInfos('motionelements', $user->id),
                'Shutter Stock' => (object)self::getServiceInfos('shutterstock', $user->id),
                'Epidemic Sound' => (object)self::getServiceInfos('epidemicsound', $user->id),
                'Adobe Stock' => (object)self::getServiceInfos('adobestock', $user->id)
            ],

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UserServices $userServices
     * @return \Illuminate\Http\Response
     */
    public function edit(UserServices $userServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserServicesRequest $request
     * @param \App\UserServices $userServices
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserServicesRequest $request, UserServices $userServices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserServices $userServices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            UserServices::find($id)->delete();
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'success',
                'message' => 'Servis silme işlemi başarılı.'
            ]));
        } catch (\Throwable $e) {
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'danger',
                'message' => 'Servis silme işlemi Başarısız. <br> Hata Kodu: ' . $e->getCode()
            ]));
        }
    }
}
