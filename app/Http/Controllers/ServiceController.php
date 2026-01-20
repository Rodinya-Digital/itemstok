<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Log;
use App\Managekey;
use App\Service;
use App\User;
use App\UserServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    public static function freepikDownloader($url)
    {
        $url = $url;
        $videoselected = false;
        $xurl = false;
        $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=freepik&url=' . $url . '&videoselected=' . $videoselected . '&xurl=' . $xurl));
        if($result->success === true){
            return $result;
        }
        $videoId = $result->types[0]->id;

        $xurl = $url;
        $url = 'https://www.freepik.com/premium-video/video_'.$videoId;
        $videoselected = 'secildi';
        $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=freepik&url=' . $url . '&videoselected=' . $videoselected . '&xurl=' . $xurl));

        return $result;
    }

    public static function OtherServices()
    {
        if (!request()->url)
            return response()->json(['success' => false, 'message' => 'Invalid url']);
        $targetLink = request()->url;
        if (request()->type == 'ask') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://easybargainloader.xyz/api/info/?url=' . $targetLink,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            if ($response->status) {

                $response->result->prices = array_map(function ($price) {
                    if ($price < 0.4) {
                        return round(($price * 5) * 35);
                    } elseif ($price >= 0.4) {
                        return round(($price * 3) * 35);
                    }
                }, $response->result->prices);

                return response()->json($response);

            } else {
                return response()->json(['success' => false, 'message' => 'İçerik türü sorgulanırken sunucuya bağlanılamadı ! <hr> Failed to connect to the server while querying content type !']);
            }
        } elseif (request()->type == 'download') {
            $stockAccessToken = 'QP6C6LG0WOG11V6RVC9GVHBTU3DQ7VAQVWSJSWY1IZY5O0O0I16G788U7WZ8SNDJ';

            $selectedSorce = request()->source;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://easybargainloader.xyz/api/info/?url=' . $targetLink,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            if ($response->status) {
                $servicePrice = $response->result->prices[array_search($selectedSorce, $response->result->sources)];
                $servicePriceX = round($response->result->prices[array_search($selectedSorce, $response->result->sources)] * 2.5);
                if ($servicePrice < 0.4) {
                    $servicePriceX = round(($servicePrice * 5) * 35);
                } elseif ($servicePrice >= 0.4) {
                    $servicePriceX = round(($servicePrice * 3) * 35);
                }

                if (Auth::user()->balance >= $servicePriceX) {
                    $prUser = User::find(Auth::id());
                    $old = $prUser->balance;
                    $new = $prUser->balance - $servicePriceX;
                    $prUser->balance -= $servicePriceX;
                    $prUser->save();

                    $logSave = Log::create([
                        'user_id' => Auth::id(),
                        'type' => 'info',
                        'name' => 'otherservices',
                        'value' => $targetLink,
                        'old' => $old.'('.$servicePriceX.')',
                        'new' => $new
                    ]);
                    if (in_array($selectedSorce, $response->result->sources)) {

                        if ($targetLink && str_contains($targetLink, 'motionarray.com')) {
                            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=motionarray&url=' . request()->url));
                            if ($result->success) {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'success';
                                $logSave->save();
                                return response()->json(['success' => true, 'download' => $result->url]);
                            } else {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'danger';
                                $logSave->save();

                                $prUser = User::find(Auth::id());
                                $prUser->balance += $servicePriceX;
                                $prUser->save();
                                return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                            }
                        }

                        if ($targetLink && str_contains($targetLink, 'elements.envato.com')) {
                            $result = json_decode(file_get_contents('http://188.132.168.79:3450/?key=sdasdas333&dw=envatoelements&url=' . request()->url));
                            if ($result->success) {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'success';
                                $logSave->save();
                                return response()->json(['success' => true, 'download' => $result->url]);
                            } else {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'danger';
                                $logSave->save();

                                $prUser = User::find(Auth::id());
                                $prUser->balance += $servicePriceX;
                                $prUser->save();
                                return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                            }
                        }

                        if ($targetLink && str_contains($targetLink, 'freepik.com')) {
                            $logSave = Log::find($logSave->id);
                            $logSave->name = 'freepik';
                            $logSave->save();
                            $result = self::freepikDownloader($targetLink);
                            if ($result->success) {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'success';
                                $logSave->save();
                                return response()->json(['success' => true, 'download' => $result->url]);
                            } else {
                                $logSave = Log::find($logSave->id);
                                $logSave->type = 'danger';
                                $logSave->save();

                                $prUser = User::find(Auth::id());
                                $prUser->balance += $servicePriceX;
                                $prUser->save();
                                return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                            }
                        }


                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://easybargainloader.xyz/api/order/?key=' . $stockAccessToken . '&url=' . $targetLink . '&source=' . $selectedSorce,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));
                        $response = json_decode(curl_exec($curl));
                        curl_close($curl);
                        if ($response->status) {
                            $ssGetLinkResult = $response->result;
                            $ssDownloadReady = true;
                            $tryedCount = 0;
                            while ($ssDownloadReady) {
                                $tryedCount++;
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://easybargainloader.xyz/api/download/?key=' . $stockAccessToken . '&task_id=' . $ssGetLinkResult->task_id,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'GET',
                                ));
                                $response = json_decode(curl_exec($curl));
                                curl_close($curl);
                                if ($response->status) {
                                    if ($response->result->ready) {
                                        $okDownloadLink = $response->result->download;
                                        $ssDownloadReady = false;
                                        $logSave = Log::find($logSave->id);
                                        $logSave->type = 'success';
                                        $logSave->save();
                                        return response()->json(['success' => true, 'download' => $okDownloadLink]);
                                    } else {
                                        sleep(5);
                                    }
                                } else {
                                    if ($tryedCount >= 10) {
                                        $ssDownloadReady = false;

                                        $logSave = Log::find($logSave->id);
                                        $logSave->type = 'danger';
                                        $logSave->save();

                                        $prUser = User::find(Auth::id());
                                        $prUser->balance += $servicePriceX;
                                        $prUser->save();

                                        return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                                    }
                                    sleep(5);
                                }
                            }
                        } else {
                            $logSave = Log::find($logSave->id);
                            $logSave->type = 'danger';
                            $logSave->save();

                            $prUser = User::find(Auth::id());
                            $prUser->balance += $servicePriceX;
                            $prUser->save();

                            return response()->json(['success' => false, 'message' => 'İndirme isteğiniz sisteme gönderilemedi, tekrar deneyin.<hr>Your download request could not be sent to the system, try again.<hr>ss-e-54334-20']);
                        }
                    } else {
                        $logSave = Log::find($logSave->id);
                        $logSave->type = 'danger';
                        $logSave->save();

                        $prUser = User::find(Auth::id());
                        $prUser->balance += $servicePriceX;
                        $prUser->save();

                        return response()->json(['success' => false, 'message' => 'Bu içerik türünü indirmek için bu hizmeti kullanamazsınız, bu hizmet bu içerik türünü desteklemiyor. <hr> You cannot use this service to download this content type, this service does not support this content type. <hr> ss-e-n4533-30']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Bakiyeniz bu işlem için yetersiz, lütfen bakiye ekleyin. <hr> Your balance is insufficient for this transaction, please add balance.']);
                }
                return response()->json($response);

            } else {
                return response()->json(['success' => false, 'message' => 'İçerik türü sorgulanırken sunucuya bağlanılamadı ! <hr> Failed to connect to the server while querying content type !']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Sunucuya bağlanılamadı ! <hr> Failed to connect to the server !']);

    }

    public static function shutterStockDW()
    {
        if (!request()->url)
            return response()->json(['success' => false, 'message' => 'Invalid url']);
        $ssTargetLink = request()->url;
        $stockAccessToken = 'QP6C6LG0WOG11V6RVC9GVHBTU3DQ7VAQVWSJSWY1IZY5O0O0I16G788U7WZ8SNDJ';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://easybargainloader.xyz/api/info/?url=' . $ssTargetLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($response->status) {
            if (in_array('shutterstock', $response->result->sources)) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://easybargainloader.xyz/api/order/?key=' . $stockAccessToken . '&url=' . $ssTargetLink . '&source=shutterstock',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
                if ($response->status) {
                    $ssGetLinkResult = $response->result;
                    $ssDownloadReady = true;
                    $tryedCount = 0;
                    while ($ssDownloadReady) {
                        $tryedCount++;
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://easybargainloader.xyz/api/download/?key=' . $stockAccessToken . '&task_id=' . $ssGetLinkResult->task_id,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));
                        $response = json_decode(curl_exec($curl));
                        curl_close($curl);
                        if ($response->status) {
                            if ($response->result->ready) {
                                $okDownloadLink = $response->result->download;
                                $ssDownloadReady = false;
                                return response()->json(['success' => true, 'download' => $okDownloadLink]);
                            } else {
                                sleep(2);
                            }
                        } else {
                            if ($tryedCount >= 10) {
                                $ssDownloadReady = false;
                                return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                            }
                            sleep(5);
                        }
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'İndirme isteğiniz sisteme gönderilemedi, tekrar deneyin.<hr>Your download request could not be sent to the system, try again.<hr>ss-e-54334-20']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Bu içerik türünü indirmek için bu hizmeti kullanamazsınız, bu hizmet bu içerik türünü desteklemiyor. <hr> You cannot use this service to download this content type, this service does not support this content type. <hr> ss-e-n4533-30']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'İçerik türü sorgulanırken sunucuya bağlanılamadı ! <hr> Failed to connect to the server while querying content type !<hr> ss-e-23422-30']);
        }
    }

    public static function adobeStockDW()
    {
        if (!request()->url)
            return response()->json(['success' => false, 'message' => 'Invalid url']);
        $ssTargetLink = request()->url;
        $stockAccessToken = 'QP6C6LG0WOG11V6RVC9GVHBTU3DQ7VAQVWSJSWY1IZY5O0O0I16G788U7WZ8SNDJ';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://easybargainloader.xyz/api/info/?url=' . $ssTargetLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($response->status) {
            if (in_array('adobestock', $response->result->sources)) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://easybargainloader.xyz/api/order/?key=' . $stockAccessToken . '&url=' . $ssTargetLink . '&source=adobestock',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
                if ($response->status) {
                    $ssGetLinkResult = $response->result;
                    $ssDownloadReady = true;
                    $tryedCount = 0;
                    while ($ssDownloadReady) {
                        $tryedCount++;
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://easybargainloader.xyz/api/download/?key=' . $stockAccessToken . '&task_id=' . $ssGetLinkResult->task_id,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));
                        $response = json_decode(curl_exec($curl));
                        curl_close($curl);
                        if ($response->status) {
                            if ($response->result->ready) {
                                $okDownloadLink = $response->result->download;
                                $ssDownloadReady = false;
                                return response()->json(['success' => true, 'download' => $okDownloadLink]);
                            } else {
                                sleep(2);
                            }
                        } else {
                            if ($tryedCount >= 10) {
                                $ssDownloadReady = false;
                                return response()->json(['success' => false, 'message' => 'Dosya indirme işlemi başarısız oldu, bir süre sonra tekrar deneyin.<hr>The file download failed, try again after a while.<hr>ss-e-34343-10']);
                            }
                            sleep(5);
                        }
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'İndirme isteğiniz sisteme gönderilemedi, tekrar deneyin.<hr>Your download request could not be sent to the system, try again.<hr>ss-e-54334-20']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Bu içerik türünü indirmek için bu hizmeti kullanamazsınız, bu hizmet bu içerik türünü desteklemiyor. <hr> You cannot use this service to download this content type, this service does not support this content type. <hr> ss-e-n4533-30']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'İçerik türü sorgulanırken sunucuya bağlanılamadı ! <hr> Failed to connect to the server while querying content type !<hr> ss-e-23422-30']);
        }
    }

    public function list()
    {
        $products = Service::where([
            'status' => 1
        ])->orderBy(\DB::raw('-`order`'), 'desc')->get();
        return view('user.shop.index', [
            'products' => $products,
            'countryCode' => \Location::get(request()->ip()) ? \Location::get(request()->ip())->countryCode : 'TR'
        ]);
    }

    public function usingkey()
    {
        $getedKey = Managekey::where('key', '=', request()->key)->where('usedby', null)->first();
        if ($getedKey) {
            UserServices::create([
                'user_id' => Auth::id(),
                'owner' => $getedKey->id,
                'name' => __("Using Key"),
                'downs' => $getedKey->downs,
                'max' => $getedKey->max,
                'services' => array_values($getedKey->services),
                'exp_date' => Carbon::now()->addDays($getedKey->days)
            ]);

            $dbKey = Managekey::find($getedKey->id);
            $dbKey->usedby = Auth::id();
            $dbKey->save();

            return redirect()->route('panel.user.dashboard')->with('result_post', json_encode([
                'status' => 'success',
                'message' => __("Transaction Successful!")
            ]));
        } else {
            return redirect()->route('panel.user.dashboard')->with('result_post', json_encode([
                'status' => 'danger',
                'message' => __("This key is invalid or used.")
            ]));
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $services = Service::create([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'services' => array_keys($request->services),
            'downs' => $request->downs,
            'max' => $request->max,
            'days' => $request->days,
            'order' => $request->order ? $request->order : '',
            'desc' => $request->desc,
            'desc_en' => $request->desc_en,
            'price' => $request->price,
            'status' => $request->status,
        ])->id;


        if ($services) {
            return redirect()->route('panel.services.edit', $services)->with('result_post', json_encode([
                'status' => 'success',
                'message' => 'Servis ekleme işlemi başarılı.'
            ]));
        } else {
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'danger',
                'message' => 'Servis ekleme işlemi başarısız.'
            ]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {

        return view('admin.services.edit', [
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateServiceRequest $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->name = $request->name;
        $service->name_en = $request->name_en;
        $service->services = array_keys($request->services);
        $service->downs = $request->downs;
        $service->max = $request->max;
        $service->days = $request->days;
        $service->order = $request->order ?: '';
        $service->desc = $request->desc;
        $service->desc_en = $request->desc_en;
        $service->price = $request->price;
        $service->status = $request->status;
        $result = $service->save();

        if ($result) {
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'success',
                'message' => 'Servis güncelleme işlemi başarılı.'
            ]));
        } else {
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'danger',
                'message' => 'Servis güncelleme işlemi başarısız.'
            ]));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            $service->deleteOrFail();
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
