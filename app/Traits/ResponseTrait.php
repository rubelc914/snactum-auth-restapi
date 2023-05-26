<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait responseTraits{

    /**
     * sendError
     *
     * @param  mixed $error
     * @param  mixed $errorMessage
     * @param  mixed $code
     * @return JsonResponse
     */
    public function sendError($error,$errorMessage=[],$code=404):JsonResponse
    {
        $response =[
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
            }
        return response()->json($response,$code);
    }


    /**
     * sendResponse
     *
     * @param  mixed $result
     * @param  mixed $message
     * @return JsonResponse
     */
    public function sendResponse($result,$message):JsonResponse
    {
        $response =[
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response,200);
    }
}
