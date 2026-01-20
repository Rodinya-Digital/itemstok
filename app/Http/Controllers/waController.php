<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class waController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function verify_control()
    {

    }

    public function verify_phone_code(Request $request)
    {
        if ($request->code == $request->session()->get('verifyCode')) {
            if ($request->session()->get('verifyCode_dur') <= time()) {
                return response()->json(['status' => 'error', 'message' => 'Doğrulama kodunuz geçerliliğini yitirmiştir, lütfen yeniden kod alınız.']);
            } else {
                $user = Auth::user();
                $user->phone_verify = 1;
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Doğrulama işleminiz başarılı.']);
            }
        }
    }

    public function user_verify_code_send(Request $request)
    {
        if (auth()->user()->phone_verify != null) {
            return response()->json(['status' => 'error', 'message' => 'Doğrulama işlemi zaten yapıldı.', 'timer' => 0]);
        }
        //return response()->json([$request->session()->get('verifyCode_dur')]);
        $verifyCode = rand(000000, 999999);

        if ($request->session()->get('verifyCode_dur') <= time() || !$request->session()->has('verifyCode_dur')) {
            if ($this->wasender(Auth::User()->phone, 'Voldi.org Doğrulama Kodunuz: ' . $verifyCode)) {
                $request->session()->put('verifyCode', $verifyCode);
                $request->session()->put('verifyCode_dur', time() + 60);
                return response()->json(['status' => 'success', 'message' => 'Doğrulama kodu kayıtlı numaranıza Whatsapp üzerinden gönderilmiştir.', 'timer' => ($request->session()->get('verifyCode_dur') - time())]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'İşleminiz başarısız lütfen daha sonra tekrar deneyiniz.']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Tekrar doğrulama kodu istemeden önce '.($request->session()->get('verifyCode_dur') - time()).' saniye bekleyiniz.', 'timer' => ($request->session()->get('verifyCode_dur') - time())]);
        }
    }

    public static function wasender($phone, $message)
    {
        $message = "" . $message . "\\n\\n";
        $server = env('WA_IP');
        $port = env('WA_PORT');
        $byte = 1024;
        $komut = "/CMLOGINCM\\/CD//" . env('WA_USERNAME') . "\\\\//" . env('WA_PASSWORD') . "\\\\//VER_1_2\\\\CD\\\r\n";
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket !== false) {
            $result = socket_connect($socket, $server, $port);
            if ($result !== false) {
                socket_write($socket, $komut, strlen($komut));
                socket_write($socket, "/CMPHNCM\/CD//");
                socket_write($socket, $phone . '\\\//' . iconv("UTF-8", "ISO-8859-9//TRANSLIT//IGNORE", $message));
                socket_write($socket, "\\\CD\ \r\n");
                while ($out = @socket_read($socket, $byte)) {
                    socket_close($socket);
                    if (strstr($out, "send")) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
