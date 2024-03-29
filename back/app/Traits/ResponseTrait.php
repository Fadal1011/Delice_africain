<?php
namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait{


    public function responseData(String $message, bool $status, int  $code , array| null | object $data=[] ){
        return response()->json(["message" => $message, "status" => $status, "data" => $data ],  $code);
    }
}

?>
