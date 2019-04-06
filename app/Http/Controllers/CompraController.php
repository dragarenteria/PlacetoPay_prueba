<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Direccion;
use App\Factura;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function authPlacetopay() {
        $login = env('PLACETOPAY_IDENTIFICACDOR');
        $secretKey = env('PLACETOPAY_SECRETKEY');
        $seed = date('c');
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        $nonceBase64 = base64_encode($nonce);
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        return 
             [ 
                "login"=> $login,
                "seed"=> $seed,
                "nonce"=> $nonceBase64,
                "tranKey"=>$tranKey
            ];
    }
  
  public function conexion(Request $request){
        $referencia = 'david-'.mt_rand(100,1000000000); //esta es una referencia provicional
        $data = [
           'auth'=> $this->authPlacetopay(),
            "buyer"=> [
                "document"=> $request->documento,
                "documentType"=> $request->tipo_doc,
                "name"=> $request->nombres,
                "surname"=> $request->apellidos,
                "email"=> $request->email,
                "mobile" => $request->telefono,
                "address"=> [
                    "street"=> $request->direccion['direccion'],
                    "city"=> $request->direccion['ciudad'],
                    "country"=> $request->direccion['pais']
                    ]
            ],
            "payment" => [
                "reference"=> $referencia,
                "description"=> $request->compra['descripcion'],
                "amount"=> [
                    "currency"=> "COP",
                    "total"=>$request->compra['total'],
                ]
            ],
            "expiration"=> "2020-08-01T00:00:00-05:00",
            "returnUrl"=> "http://placetopay.test/compra/respuesta/".$referencia,
            "ipAddress"=> "127.0.0.1",
            "userAgent"=> "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like
            Gecko) Chrome/52.0.2743.82 Safari/537.36"
        ];

        // Peticion
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type:application/json'));
        curl_setopt($ch, CURLOPT_URL,"https://test.placetopay.com/redirection/api/session");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        curl_close ($ch);
        $respuesta =json_decode($remote_server_output,true);


        if (isset($respuesta['requestId'])) {
            DB::beginTransaction();
        try {
            $direccion =  Direccion::create([
                'street' => $request->direccion['direccion'],
                'city' => $request->direccion['ciudad'],
                'country' => $request->direccion['pais']
            ]);
           $persona = Persona::create([
                'documento' => $request->documento,
                'tipo_documento' => $request->tipo_doc,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'direccion_id' => $direccion->id,
            ]);
            Factura::create([
                'referencia' => $referencia,
                'request_id' => $respuesta['requestId'],
                'estado' => 'Esperando respuesta',
                'descripcion' => $request->compra['descripcion'],
                'precio' => $request->compra['total'],
                'date' => $respuesta['status']['date'],
                'persona_id' => $persona->id
            ]);
            DB::commit();
            $succes = true;
        } catch (\Throwable $th) {
            $succes = false;
            $error = $th->getMessage();
            DB::rollback();
        }
        if ($succes) {
            return [
                'resp' => true,
                'placetopay' => $respuesta
            ];
        }else {
            return [
                'resp' => false,
                'error' => $error
            ];
        }
          
        }else{
            return $respuesta;
        }

    }

    public function respuesta($referencia){
       
        $factura = Factura::where('referencia',$referencia)->get();
        // return $factura[0]->id;

        $data = [
          'auth' => $this->authPlacetopay()
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type:application/json'));
        curl_setopt($ch, CURLOPT_URL,"https://test.placetopay.com/redirection/api/session/".$factura[0]->request_id);
        curl_setopt($ch, CURLOPT_POST, TRUE);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        curl_close ($ch);
        $respuesta =json_decode($remote_server_output,true);
        // return $respuesta;
        //actualizar informacion de la compra
        DB::beginTransaction();
        try {
            Factura::where('referencia',$referencia)->update([
                'estado' => $respuesta['status']['status'],
                'msg_respuesta' =>$respuesta['status']['message']
            ]);
            DB::commit();
            $succes = true;
        } catch (\Throwable $th) {
            $succes = false;
            $error = $th->getMessage();
            DB::rollback();
        }
        if ($succes) {
            return view('respuesta',$respuesta);

        }else {
            return [
                'resp' => false,
                // 'error' => $error
            ];
        }
    }

}
