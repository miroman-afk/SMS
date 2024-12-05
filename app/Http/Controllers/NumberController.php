<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NumberController extends Controller
{
    public function getNumber(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'country' => 'required|string',
            'service' => 'required|string',
            'token' => 'required|string',
            'rent_time' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'error',
                //'message' => $validator->errors()->first()
                'message' => 'Not parameters passed'
            ], 400);
        }
        try {
            $response = Http::withOptions(['verify' => false])->get('https://postback-sms.com/api/', [
                'action' => $request->action,
                'country' => $request->country,
                'service' => $request->service,
                'token' => $request->token,
                'rent_time' => $request->rent_time ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'message' => 'Connection Error: ' . $e->getMessage()
            ]);
        }
        if (!array_key_exists('code', $response->json())) {
            return response()->json($response);
        }
        if ($response['code'] == 'ok') {
            return response()->json([
                'code' => $response['code'],
                'number' => $response['number'],
                'activation' => $response['activation'],
                'end_date' => $response['end_date'] ?? null,
                'cost' => $response['cost'],
            ]);
        } else {
            return response()->json([
                'code' => $response['code'],
                'message' => $response['message'],
            ]);
        }
    }

    public function getSms(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'activation' => 'required|string',
            'token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'error',
                //'message' => $validator->errors()->first()
                'message' => 'Not parameters passed'
            ], 400);
        }
        try {
            $response = Http::withOptions(['verify' => false])->get('https://postback-sms.com/api/', [
                'action' => $request->action,
                'activation' => $request->activation,
                'token' => $request->token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'message' => 'Connection Error: ' . $e->getMessage()
            ]);
        }
        if (!array_key_exists('code', $response->json())) {
            return response()->json($response);
        }
        if ($response['code'] == 'ok') {
            return response()->json([
                'code' => $response['code'],
                'sms' => $response['sms'],
            ]);
        } else {
            return response()->json([
                'code' => $response['code'],
                'message' => $response['message'],
            ]);
        }
    }

    public function cancelNumber(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'activation' => 'required|string',
            'token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'error',
                //'message' => $validator->errors()->first()
                'message' => 'Not parameters passed'
            ], 400);
        }
        try {
            $response = Http::withOptions(['verify' => false])->get('https://postback-sms.com/api/', [
                'action' => $request->action,
                'activation' => $request->activation,
                'token' => $request->token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'message' => 'Connection Error: ' . $e->getMessage()
            ]);
        }
        if (!array_key_exists('code', $response->json())) {
            return response()->json($response->json());
        }
        if ($response->json()['code'] == 'ok') {
            return response()->json([
                'code' => $response['code'],
                'activation' => $response['activation'],
                'status' => $response['status'],
            ]);
        } else {
            return response()->json([
                'code' => $response['code'],
                'message' => $response['message'],
            ]);
        }
    }

    public function getStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string',
            'activation' => 'required|string',
            'token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'error',
                //'message' => $validator->errors()->first()
                'message' => 'Not parameters passed'
            ], 400);
        }
        try {
            $response = Http::withOptions(['verify' => false])->get('https://postback-sms.com/api/', [
                'action' => $request->action,
                'activation' => $request->activation,
                'token' => $request->token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'message' => 'Connection Error: ' . $e->getMessage()
            ]);
        }
        if (!array_key_exists('code', $response->json())) {
            return response()->json($response->json());
        }
        if ($response->json()['code'] == 'ok') {
            return response()->json([
                'code' => $response['code'],
                'activation' => $response['activation'],
                'status' => $response['status'],
            ]);
        } else {
            return response()->json([
                'code' => $response['code'],
                'message' => $response['message'],
            ]);
        }
    }
}
