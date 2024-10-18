<?php

namespace App\Http\Controllers;

use App\Services\KmsService;
use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    protected $kmsService;

    public function __construct(KmsService $kmsService)
    {
        $this->kmsService = $kmsService;
    }

    public function encryptData(Request $request)
    {
        $data = $request->input('data'); // Get data from request
        $encryptedData = $this->kmsService->encrypt($data);

        return response()->json(['encrypted_data' => $encryptedData]);
    }

    public function decryptData(Request $request)
    {
        $encryptedData = $request->input('encrypted_data'); // Get encrypted data from request
        $decryptedData = $this->kmsService->decrypt($encryptedData);

        return response()->json(['decrypted_data' => $decryptedData]);
    }
}
