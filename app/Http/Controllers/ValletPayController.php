<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use App\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Vallet_light_api
{
    private $userName,$password,$shopCode,$hash;
    public function __construct($userName,$password,$shopCode,$hash)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->shopCode = $shopCode;
        $this->hash = $hash;
    }
    private function hash_generate($string)
    {
        $hash = base64_encode(pack('H*',sha1($this->userName.$this->password.$this->shopCode.$string.$this->hash)));
        return $hash;
    }
    public function create_payment_link($order_data)
    {
        $post_data = array(
            'userName' => $this->userName,
            'password' => $this->password,
            'shopCode' => $this->shopCode,
            'productName' => $order_data['productName'],
            'productData' => $order_data['productData'],
            'productType' => $order_data['productType'],
            'productsTotalPrice' => $order_data['productsTotalPrice'],
            'orderPrice' => $order_data['orderPrice'],
            'currency' => $order_data['currency'],
            'orderId' => $order_data['orderId'],
            'locale' => $order_data['locale'],
            'conversationId' => $order_data['conversationId'],
            'buyerName' => $order_data['buyerName'],
            'buyerSurName' => $order_data['buyerSurName'],
            'buyerGsmNo' => $order_data['buyerGsmNo'],
            'buyerIp' => $order_data['buyerIp'],
            'buyerMail' => $order_data['buyerMail'],
            'buyerAdress' => $order_data['buyerAdress'],
            'buyerCountry' => $order_data['buyerCountry'],
            'buyerCity' => $order_data['buyerCity'],
            'buyerDistrict' => $order_data['buyerDistrict'],
            'callbackOkUrl' => 'https://www.stokla.net/panel/orders',
            'callbackFailUrl' => 'https://www.stokla.net/panel/orders',
            'module'=>'NATIVE_PHP'
        );
        $post_data['hash'] = $this->hash_generate($post_data['orderId'].$post_data['currency'].$post_data['orderPrice'].$post_data['productsTotalPrice'].$post_data['productType'].$post_data['callbackOkUrl'].$post_data['callbackFailUrl']);

        $response = $this->send_post('https://www.vallet.com.tr/api/v1/create-payment-link',$post_data);
        if ($response['status']=='success' && isset($response['payment_page_url']))
        {
            return $response;
        }
        else
        {
            print_r($response);
            /*Hatayı Sisteminiz için Yönetin ve Döndürün*/
        }
    }
    private function send_post($post_url,$post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['SERVER_NAME']);
        $result_origin = curl_exec($ch);
        $response = array();
        if (curl_errno($ch))
        {
            /*Curl sırasında bir sorun oluştu*/
            $response = array(
                'status'=>'error',
                'errorMessage'=>'Curl Geçersiz bir cevap aldı',
            );
        }
        else
        {
            /*Curl Cevabını Alın*/

            /*Curl Cevabını jsondan array'a dönüştür*/
            $result = json_decode($result_origin,true);
            if (is_array($result))
            {
                $response = (array) $result;
            }
            else
            {
                $response = array(
                    'status'=>'error',
                    'errorMessage'=>'Dönen cevap Array değildi',
                );
            }
        }
        curl_close($ch);
        return $response;
    }
}
class ValletPayController extends Controller
{

    public function odeme()
    {
        $service_id = request()->service_id;

        $thisUser = Auth::user();
        $service = Service::find($service_id);
        $country=\Location::get(request()->ip())?\Location::get(request()->ip())->countryCode:'TR';
        if($country!='TR'){
            $servicePrice = $service->price*2.4;
        }else{
            $servicePrice = $service->price;
        }
        $dbOrder = Order::create([
            'user_id' => $thisUser->id,
            'product' => serialize($service->toArray()),
            'gateway' => 'Vallet',
            'price' => $servicePrice,
            'status' => '0'//0 = pedding / 1 = success / 2 = error
        ]);
        $vallet = new Vallet_light_api("---------*","-------------","----","---------");

        /*Sipariş Bilgilerinizi Tanımlayın*/
        $order_data = array(
            'productName' => $service->name,
            'productData' => array(
                array(
                    'productName'=>$service->name,
                    'productPrice'=>$servicePrice,
                    'productType'=>'DIJITAL_URUN',
                ),
            ),
            'productType' => 'DIJITAL_URUN',
            'productsTotalPrice' => $servicePrice,
            'orderPrice' => $servicePrice,
            'currency' => 'TRY',
            'orderId' => $dbOrder->id,
            'locale' => $thisUser->locale,
            'conversationId' => '',
            'buyerName' => $thisUser->name,
            'buyerSurName' => $thisUser->surname,
            'buyerGsmNo' => '05553332211',
            'buyerIp' => $_SERVER['REMOTE_ADDR'],
            'buyerMail' => $thisUser->email,
            'buyerAdress' => '',
            'buyerCountry' => '',
            'buyerCity' => '',
            'buyerDistrict' => '',
        );
        /*Sipariş Bilgilerinizi link oluşturmak için sınıfa gönderin*/
        $request = $vallet->create_payment_link($order_data);

        if($request['status']=='success' && isset($request['payment_page_url']))
        {
            /*status==success ve payment_page_url varsa başarılı bir işlem yürüttünüz*/
            $odeme_link = $request['payment_page_url'];
            return redirect($odeme_link);
        }
        else
        {
            /*Hatalı bir cevap alındı*/
            echo 'Ödeme linki üretilirken bir sorun oluştu';
            print_r($request);
        }
    }

    public function bildirim()
    {
        $vallet_config = array(
            'userName'=>'---------',
            'password'=>'-----------------------',
            'shopCode'=>'---',
            'hash'=>'--------',
        );

        $post = array();
        $post['status'] = $_POST['status'];
        $post['paymentStatus'] = $_POST['paymentStatus'];
        $post['hash'] = $_POST['hash'];
        $post['paymentCurrency'] = $_POST['paymentCurrency'];
        $post['paymentAmount'] = $_POST['paymentAmount'];
        $post['paymentType'] = $_POST['paymentType'];
        $post['paymentTime'] = $_POST['paymentTime'];
        $post['conversationId'] = $_POST['conversationId'];
        $post['orderId'] = $_POST['orderId'];
        $post['shopCode'] = $_POST['shopCode'];
        $post['orderPrice'] = $_POST['orderPrice'];
        $post['productsTotalPrice'] = $_POST['productsTotalPrice'];
        $post['productType'] = $_POST['productType'];
        $post['callbackOkUrl'] = $_POST['callbackOkUrl'];
        $post['callbackFailUrl'] = $_POST['callbackFailUrl'];


        if (empty($post['status']) || empty($post['paymentStatus']) || empty($post['hash']) || empty($post['paymentCurrency']) || empty($post['paymentAmount']) || empty($post['paymentType']) || empty($post['orderId']) || empty($post['shopCode']) || empty($post['orderPrice']) || empty($post['productsTotalPrice']) || empty($post['productType']) || empty($post['callbackOkUrl']) || empty($post['callbackFailUrl']))
        {
            /*Eksik Form Datası Mevcut*/
            echo 'EKSIK_FORM_DATASI';
            exit();
        }
        else
        {
            $hash_string = $post['orderId'].$post['paymentCurrency'].$post['orderPrice'].$post['productsTotalPrice'].$post['productType'].$vallet_config["shopCode"].$vallet_config["hash"];
            $MY_HASH = base64_encode(pack('H*',sha1($hash_string)));
            if ($MY_HASH!==$post['hash'])
            {
                /*Hash Uyuşmuyor*/
                echo 'HATALI_HASH_IMZASI';
                exit();
            }
            else
            {
                /*
                paymentStatus'un alabileceği değerler =
                paymentWait(Ödeme Bekleniyor),
                paymentVerification(Ödendi ancak ödeme doğrulama bekliyor. Reddedilebilir. Mal yada hizmetinizi müşterinize paymentOk alana kadar vermeyin),
                paymentOk(Ödeme alındı. Artık mal yada hizmetinizi müşterinize verebilirsiniz),
                paymentNotPaid('Ödenmedi'),
                */
                if ($post['paymentStatus']=='paymentOk')
                {
                    $upOrder = Order::findOrFail($post['orderId']);
                    $upOrder->gateway = 'Vallet';
                    $upOrder->detail = serialize(json_encode($post));
                    $upOrder->payment_date = Carbon::now();
                    /*Bu alanda sipariş bilgilerinizi veritabanınızdan çektiğinizi varsayalım ve doğrulama işlemlerine devam edelim*/

                    if (!$upOrder)
                    {
                        /*Böyle bir sipariş sistemimde yok*/
                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                        exit();
                    }
                    else if($upOrder->status=='1')
                    {
                        /*Zaten ödenmiş ve işlenmiş*/
                        echo 'OK';
                        exit();
                    }
                    else
                    {
                        $productData = unserialize($upOrder->product);
                        UserServices::create([
                            'order_id'=>$upOrder->id,
                            'user_id'=>$upOrder->user_id,
                            'owner'=>'System',
                            'name'=>$productData['name'],
                            'downs'=>$productData['downs'],
                            'max' => $productData['max'],
                            'services'=>array_values($productData['services']),
                            'exp_date'=>Carbon::now()->addDays($productData['days'])
                        ]);


                        $apiToken = "6646176483:AAEQF-0RL-ulD1BhOdeMxmpBld19TLollVA";
                        $data = [
                            'chat_id' => '-4098216664',
                            'text' => "STOKLA ORDER\nNEW ORDER : ".$productData['name']."\nPrice : ".($upOrder->price)." TRY"."\n"."ORDER ID : ".$upOrder->id."\n"."USERID :".$upOrder->user_id
                        ];
                        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));

                        $upOrder->status = 1;
                        $upOrder->save();

                        echo 'OK';
                        exit();
                    }
                }
            }
        }
    }

    public function payid19pay()
    {
        $service_id = request()->service_id;

        $thisUser = Auth::user();
        $service = Service::find($service_id);
        $servicePrice = $service->price / 38;
        $servicePriceForDb = $service->price;
        if (\Location::get(request()->ip())->countryCode != 'TR') {
            $servicePrice = $service->price * 1.5;
            $servicePriceForDb = $service->price * 1.5;
            $servicePrice = $servicePrice / 38;
        }
        $servicePrice = number_format($servicePrice, 2);
        $dbOrder = Order::create([
            'user_id' => $thisUser->id,
            'product' => serialize($service->toArray()),
            'gateway' => 'Crypto',
            'type' => 'service',
            'price' => $servicePriceForDb,
            'status' => '0'//0 = pedding / 1 = success / 2 = error
        ]);

        $url = 'https://payid19.com/api/v1/create_invoice';

        $post = [
            'public_key' => '---------------',
            'private_key' => '---------------------------------',
            'email' => $thisUser->email,
            'price_amount' => round($servicePrice,1),
            'price_currency' => 'USD',
            'merchant_id' => 1,
            'order_id' => $dbOrder->id,
            'customer_id' => $thisUser->id,
            //'test' => 1,
            'title' => $service->name,
            'description' => $service->name . ' Price : ' . $servicePrice . ' USD',
            'add_fee_to_price' => 1,
            'cancel_url' => 'https://www.stokla.net/panel/dashboard',
            'success_url' => 'https://www.stokla.net/panel/dashboard',
            'callback_url' => 'https://www.stokla.net/payid19call',
            'expiration_date' => 6,
//'margin_ratio' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $result = curl_exec($ch);
        curl_close($ch);


        $returnedData = json_decode($result);
        if ($returnedData->status == 'success') {
            return redirect($returnedData->message);
            //return view('iframe',['url'=>$returnedData->message]);
        }
    }

    public function payid19call()
    {
        $data = json_decode(file_get_contents('php://input')); //catch request data

        if ($data->privatekey == "sJPLQZyvKjMeckk8e91UeDVeQWnKYZVpCsstw2jY") { //compare private keys
            $upOrder = Order::findOrFail($data->order_id);
            $upOrder->gateway = 'Crypto';
            $upOrder->detail = serialize(json_encode($data));
            $upOrder->payment_date = Carbon::now();

            $apiToken = "6646176483:AAEQF-0RL-ulD1BhOdeMxmpBld19TLollVA";
            $data = [
                'chat_id' => '-4098216664',
                'text' => "STOKLA PAYID19 NEW ORDER : ".$data->description."\n"."ORDER ID : ".$data->order_id."\n"."EMAIL :".$data->email
            ];
            file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));

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

            $upOrder->status = 1;
            $upOrder->save();
            abort(200);
        } else {
            abort(500);
        }
    }
}
