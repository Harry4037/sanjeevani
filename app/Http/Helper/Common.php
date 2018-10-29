<?php

namespace App\Http\Helper;

trait Common {

    protected function jsonData($data) {

        return response()->json([
            'status' => $data['success'],
            'message' => $data['message'],
            'data' => $data['data']
        ]);
    }

}
