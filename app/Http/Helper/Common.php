<?php

namespace App\Http\Helper;

trait Common {

    protected function jsonData($data) {

        return response()->json([
            'status' => $data['success'],
            'status_code' => $data['status_code'],
            'message' => $data['message'],
            'data' => $data['data']
        ]);
    }

}
