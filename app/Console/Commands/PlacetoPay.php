<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PlacetoPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'placetopay:pendiente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar transacciones pendientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
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

    public function handle()
    {
        $data = [
          'auth' => $this->authPlacetopay()
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type:application/json'));
        curl_setopt($ch, CURLOPT_URL,"https://test.placetopay.com/redirection/api/session/190275");
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
            Factura::where('request_id','190275')->update([
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
            return $respuesta;
            // return view('respuesta',$respuesta);

        }else {
            return [
                'resp' => false,
                // 'error' => $error
            ];
        }
    }
}
