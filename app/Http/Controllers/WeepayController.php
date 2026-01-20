<?php

namespace App\Http\Controllers;

use App\Notifications\ServiceActive;
use App\Order;
use App\Service;
use App\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class WeepayController extends Controller
{
    public $options;

    public function __construct()
    {
        $this->options = new \weepay\Auth();
        $this->options->setBayiID("26246");// weepay tarafıdan verilen bayiId
        $this->options->setApiKey("c07c9e10-d086-4a27-ba38-f4b030545fda");// weepay tarafıdan verilen apiKey
        $this->options->setSecretKey("edf7028c-eb0e-44bd-8872-97d12ce8ff74"); // weepay tarafıdan verilen secretKey
        $this->options->setBaseUrl("https://api.weepay.co");
    }

    public function weepay_payment($id)
    {
        $thisUser = Auth::user();
        $service = Service::find($id);
        $dbOrder = Order::create([
            'user_id' => $thisUser->id,
            'product' => serialize($service->toArray()),
            'gateway' => 'WeePay',
            'price' => ceil($service->price+($service->price/100*3.65)),
            'status' => '0'//0 = pedding / 1 = success / 2 = error
        ]);
//Request
        $request = new \weepay\Request\FormInitializeRequest();
        $request->setOrderId($dbOrder->id);
        $request->setIpAddress(\request()->ip());
        $request->setPrice(ceil($service->price+($service->price/100*3.65)));
        $request->setCurrency(\weepay\Model\Currency::TL);
        if (Auth::user()->locale == 'tr')
            $request->setLocale(\weepay\Model\Locale::TR);
        if (Auth::user()->locale == 'en')
            $request->setLocale(\weepay\Model\Locale::EN);
        $request->setDescription('jetStock.net');
        $request->setCallBackUrl(route('weepay_cb'));
        $request->setPaymentGroup(\weepay\Model\PaymentGroup::PRODUCT);
        $request->setPaymentChannel(\weepay\Model\PaymentChannel::WEB);

//Customer
        $customer = new \weepay\Model\Customer();
        $customer->setCustomerId(Auth::id()); // Üye işyeri müşteri Id
        $customer->setCustomerName(Auth::user()->name); //Üye işyeri müşteri ismi
        $customer->setCustomerSurname(Auth::user()->surname); //Üye işyeri müşteri Soyisim
        $customer->setGsmNumber("5523863450"); //Üye işyeri müşteri Cep Tel
        $customer->setEmail(Auth::user()->email); //Üye işyeri müşteri ismi
        $customer->setIdentityNumber("53399922244"); //Üye işyeri müşteri TC numarası
        $customer->setCity("istanbul"); //Üye işyeri müşteri il
        $customer->setCountry("turkey"); //Üye işyeri müşteri ülke
        $request->setCustomer($customer);

//Adresler
// Fatura Adresi
        $BillingAddress = new \weepay\Model\Address();
        $BillingAddress->setContactName(Auth::user()->name . ' ' . Auth::user()->surname);
        $BillingAddress->setAddress("Bilinmiyor");
        $BillingAddress->setCity("istanbul");
        $BillingAddress->setCountry("turkey");
        $BillingAddress->setZipCode("34000");
        $request->setBillingAddress($BillingAddress);

//Kargo / Teslimat Adresi
        $request->setShippingAddress($BillingAddress);

// Sipariş Ürünleri
        $Products = array();

// Birinci Ürün
        $firstProducts = new \weepay\Model\Product();
        $firstProducts->setName($service->name);
        $firstProducts->setProductId($service->id);
        $firstProducts->setProductPrice(ceil($service->price+($service->price/100*3.65)));
        $firstProducts->setItemType(\weepay\Model\ProductType::VIRTUAL);
        $Products[0] = $firstProducts;
        $request->setProducts($Products);

        $checkoutFormInitialize = \weepay\Model\CheckoutFormInitialize::create($request, $this->options);


        if ($checkoutFormInitialize->getStatus() == 'success') {

            return redirect($checkoutFormInitialize->getPaymentPageUrl());

        } else {
            dd($checkoutFormInitialize->getMessage());
        }
    }

    public function weepay_cb()
    {
//Request
        $request = new \weepay\Request\GetPaymentRequest();
        $request->setPaymentId(\request()->paymentId);
        $request->setLocale(\weepay\Model\Locale::TR);

        $getPaymentRequest = \weepay\Model\GetPaymentRequestInitialize::create($request, $this->options);

        $upOrder = Order::find($getPaymentRequest->getOrderId());
        $upOrder->gateway = 'WeePay #' . $getPaymentRequest->getPaymentId();
        $upOrder->detail = $getPaymentRequest->getRawResult();
        $upOrder->payment_date = $getPaymentRequest->getPaymentDate();
        if ($getPaymentRequest->getStatus() == 'success') {

            if ($getPaymentRequest->getPaymentStatus() == 'SUCCESS') {
                $productData = unserialize($upOrder->product);
                UserServices::create([
                    'order_id' => $upOrder->id,
                    'user_id' => $upOrder->user_id,
                    'owner'=>'System',
                    'name' => $productData['name'],
                    'downs' => $productData['downs'],
                    'max' => $productData['max'],
                    'services' => array_values($productData['services']),
                    'exp_date' => Carbon::now()->addDays($productData['days'])
                ]);

                $upOrder->status = 1;
                $upOrder->save();

                return redirect()->route('panel.orders')->with('result_post', json_encode([
                    'status' => 'success',
                    'message' => __('Transaction Successful!')
                ]));

            } else if ($getPaymentRequest->getPaymentStatus() == 'FAILURE') {
                $upOrder->status = 2;
                $upOrder->save();

                // işlemler başarısız.

                return redirect()->route('panel.orders')->with('result_post', json_encode([
                    'status' => 'danger',
                    'message' => __('Transaction Failed!') . '  ' . $getPaymentRequest->getMessage()
                ]));
            }


        } else {
            $upOrder->status = 2;
            $upOrder->save();
            return redirect()->route('panel.orders')->with('result_post', json_encode([
                'status' => 'danger',
                'message' => __('Transaction Failed!') . '  ' . $getPaymentRequest->getMessage()
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
        return redirect(route('panel.admin.dashboard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    public function serviceToUser($id, Request $request)
    {
        UserServices::create([
            'order_id' => NULL,
            'user_id' => $id,
            'name' => $request->name,
            'downs' => $request->downs,
            'max' => $request->max,
            'services' => array_keys($request->services),
            'owner' => Auth::user()->email,
            'exp_date' => Carbon::now()->addDays($request->days)
        ]);
        return redirect()->back()->with('result_post', json_encode([
            'status' => 'success',
            'message' => 'Servis tanımlama başarılı.'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

