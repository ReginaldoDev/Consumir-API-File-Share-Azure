<?php

namespace App\Http\Controllers;

use App\Parametros;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function index($arquivo)
    {
        if (substr($arquivo, -3) != "pdf") {
            return redirect('/api/v1/');
        }

        $dataPar = Parametros::all()->first();

        #PARAMETROS
        define("ACCESS_KEY", $dataPar->CHAVE_ACCESSKEY);
        define("USER_ACCOUNT", $dataPar->USER_ACCOUNT);
        define("CONTAINER_NAME", $dataPar->CONTAINER_NAME);
        define("VERSION", $dataPar->VERSION);
        define("FILE", $arquivo);
        define("CURRENT_DATE", gmdate("D, d M Y H:i:s T", time()));
        define("DESTINA_URL", "https://" . USER_ACCOUNT . ".file.core.windows.net/" . CONTAINER_NAME . "/" . FILE);
        define("URL_RESOURCE", "/" . USER_ACCOUNT . "/" . CONTAINER_NAME . "/" . FILE);

        $arraySign = array();
        $arraySign[] = 'GET';               /*HTTP Verb*/
        $arraySign[] = '';                  /*Content-Encoding*/
        $arraySign[] = '';                  /*Content-Language*/
        $arraySign[] = '';                  /*Content-Length (include value when zero)*/
        $arraySign[] = '';                  /*Content-MD5*/
        $arraySign[] = '';                  /*Content-Type*/
        $arraySign[] = '';                  /*Date*/
        $arraySign[] = '';                  /*If-Modified-Since */
        $arraySign[] = '';                  /*If-Match*/
        $arraySign[] = '';                  /*If-None-Match*/
        $arraySign[] = '';                  /*If-Unmodified-Since*/
        $arraySign[] = '';                  /*Range*/
        $arraySign[] = "x-ms-date:" . CURRENT_DATE . "\nx-ms-version:" . VERSION;     /*CanonicalizedHeaders*/
        $arraySign[] = URL_RESOURCE;        /*CanonicalizedResource*/

        $str2Sign = implode("\n", $arraySign);

        $sig = base64_encode(
            hash_hmac(
                'sha256',
                urldecode(
                    utf8_encode($str2Sign)
                ),
                base64_decode(ACCESS_KEY),
                true
            )
        );

        define("AUTH_HEADER", "SharedKey " . USER_ACCOUNT . ":$sig");
        define("HEADERS", [
            'Authorization: ' . AUTH_HEADER,
            'x-ms-date: ' . CURRENT_DATE,
            'x-ms-version: ' . VERSION
        ]);

        $curl = curl_init(DESTINA_URL);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, HEADERS);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if (substr($response, 54, 16) == "ResourceNotFound") {
            return redirect('/api/v1/');
        }
        
        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . FILE . '"');
        header('Content-Length: ' . strlen($response));
        echo $response;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $par = Parametros::find(1);

        if (isset($par)) {
            $par->CHAVE_ACCESSKEY = $request->input('CHAVE_ACCESSKEY');
            $par->USER_ACCOUNT = $request->input('USER_ACCOUNT');
            $par->CONTAINER_NAME = $request->input('CONTAINER_NAME');
            $par->VERSION = $request->input('VERSION');
            $par->save();
        }

        return redirect("/parametros");
    }
}
