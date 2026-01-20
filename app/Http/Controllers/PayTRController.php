<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use App\User;
use App\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayTRController extends Controller
{

    public function odeme()
    {
        if (\request()->service_id && !\request()->add_balance) {
            $service_id = request()->service_id;
            $thisUser = Auth::user();
            $service = Service::find($service_id);
            $serviceName = $service->name;
            $servicePrice = $service->price;
            if (\Location::get(request()->ip())->countryCode != 'TR') {
                $servicePrice = $service->price * 1.5;
            }

            $dbOrder = Order::create([
                'user_id' => $thisUser->id,
                'product' => serialize($service->toArray()),
                'gateway' => 'PayTR',
                'type' => 'service',
                'price' => $servicePrice,
                'status' => '0'//0 = pedding / 1 = success / 2 = error
            ]);
        } else {
            if(\request()->add_balance<1)
                return back();
            if(\request()->add_balance>50000)
                return back();
            $thisUser = Auth::user();
            $servicePrice = \request()->add_balance;
            $serviceName = 'AddBalance';
            $dbOrder = Order::create([
                'user_id' => $thisUser->id,
                'name' => 'AddBalance',
                'type' => 'balance',
                'gateway' => 'PayTR',
                'price' => $servicePrice,
                'status' => '0'//0 = pedding / 1 = success / 2 = error
            ]);
        }
        $currency = 'TL';

        ## 1. ADIM için örnek kodlar ##

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_id = '--------';
        $merchant_key = '-------------';
        $merchant_salt = '--------------';

        #
        ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
        $email = $thisUser->email;
        #
        ## Tahsil edilecek tutar.
        $payment_amount = $servicePrice * 100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
        #
        ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
        $merchant_oid = $dbOrder->id;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
        $user_name = $thisUser->name . ' ' . $thisUser->surname;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
        $user_address = "TR";
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
        $user_phone = '0000000000';
        #
        ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_ok_url = "https://www.stokla.net/panel/orders";
        #
        ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_fail_url = "https://www.stokla.net/panel/orders";
        #
        ## Müşterinin sepet/sipariş içeriği
        /*  $user_basket = base64_encode(json_encode(array(
              array($data["urun"], $payment_amount, 1)
          )));*/


        #
        // ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
        $user_basket = base64_encode(json_encode(array(
            array($serviceName, $servicePrice, 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
        )));

        ############################################################################################

        ## Kullanıcının IP adresi
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
        ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
        $user_ip = $ip;
        ## İşlem zaman aşımı süresi - dakika cinsinden
        $timeout_limit = "30";
        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 0;
        ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
        $test_mode = 0;
        $no_installment = 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın
        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;
        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
        $data_vals = array(
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket,
            'debug_on' => $debug_on,
            'no_installment' => $no_installment,
            'max_installment' => $max_installment,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit' => $timeout_limit,
            'currency' => $currency,
            'test_mode' => $test_mode
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
        // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = @curl_exec($ch);

        if (curl_errno($ch))
            die("PAYTR IFRAME connection error. err:" . curl_error($ch));

        curl_close($ch);

        $result = json_decode($result, 1);
        if ($result['status'] == 'success')
            $token = $result['token'];
        else
            die("PAYTR IFRAME failed. reason:" . $result['reason']);

        return redirect('https://www.paytr.com/odeme/guvenli/' . $token);

        //return view('iframe', ['url' => 'https://www.paytr.com/odeme/guvenli/' . $token]);


    }

    public function bildirim()
    {
        $data = request()->all();
        //file_put_contents("/var/www/stokla_net_usr/data/www/stokla.net/voltSfaVeTest.txt",json_encode($data));
        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.

        $merchant_key = 'oKo6FZgHoYEH63Yx';
        $merchant_salt = 'nGXSENo3QAy8mZb1';

        ###########################################################################

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        #
        ## POST değerleri ile hash oluştur.
        $hash = base64_encode(hash_hmac('sha256', $data['merchant_oid'] . $merchant_salt . $data['status'] . $data['total_amount'], $merchant_key, true));
        #
        ## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
        ## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.
        if ($hash != $data['hash'])
            die('PAYTR notification failed: bad hash');
        ###########################################################################

        $upOrder = Order::findOrFail($data['merchant_oid']);
        $upOrder->gateway = 'PayTR';
        $upOrder->detail = serialize(json_encode($data));
        $upOrder->payment_date = Carbon::now();

        if ($data['status'] == 'success') {
            if ($upOrder->status != '1') {
                if ($upOrder->type == 'service') {
                    $productData = unserialize($upOrder->product);
                    UserServices::create([
                        'order_id' => $upOrder->id,
                        'user_id' => $upOrder->user_id,
                        'owner' => 'System',
                        'name' => $productData['name'],
                        'downs' => $productData['downs'],
                        'max' => $productData['max'],
                        'services' => array_values($productData['services']),
                        'exp_date' => Carbon::now()->addDays($productData['days'])
                    ]);

                    $apiToken = "6646176483:AAEQF-0RL-ulD1BhOdeMxmpBld19TLollVA";
                    $data = [
                        'chat_id' => '-4098216664',
                        'text' => "STOKLA ORDER\nNEW ORDER : " . $productData['name'] . "\nPrice : " . ($upOrder->price) . " TRY" . "\n" . "ORDER ID : " . $upOrder->id . "\n" . "USERID :" . $upOrder->user_id
                    ];
                    file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));

                    $upOrder->status = 1;
                    $upOrder->save();
                    echo "OK";
                    exit;
                } elseif ($upOrder->type == 'balance') {
                    $user = User::find($upOrder->user_id);
                    $user->balance = $user->balance + $upOrder->price;
                    $user->save();

                    $apiToken = "6646176483:AAEQF-0RL-ulD1BhOdeMxmpBld19TLollVA";
                    $data = [
                        'chat_id' => '-4098216664',
                        'text' => "STOKLA ORDER\nNEW ORDER : AddBalance\nPrice : " . ($upOrder->price) . " TRY" . "\n" . "ORDER ID : " . $upOrder->id . "\n" . "USERID :" . $upOrder->user_id
                    ];
                    file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));

                    $upOrder->status = 1;
                    $upOrder->save();
                    echo "OK";
                    exit;
                }
            } else {
                echo "OK";
                exit;
            }

        } else { ## Ödemeye Onay Verilmedi

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi iptal edin.
            ## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
            ## $data['failed_reason_code'] - başarısız hata kodu
            ## $data['failed_reason_msg'] - başarısız hata mesajı
            $upOrder->status = 2;
            $upOrder->save();

            // işlemler başarısız.

            /*return redirect()->route('panel.orders')->with('result_post', json_encode([
                'status' => 'danger',
                'message' => 'Ödeme işlemi başarısız. ' . $data['failed_reason_msg']
            ]));*/

        }

        ## Bildirimin alındığını PayTR sistemine bildir.
        echo "OK";
        exit;

    }
}