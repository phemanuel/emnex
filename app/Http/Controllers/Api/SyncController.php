<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Sync\SyncApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SyncController extends Controller
{
    public function __construct(
        protected SyncApiService $syncApiService
    ) {
    }

    /**
     * Receive synchronization mutations from an offline EMNEX device.
     */
    public function push(Request $request): JsonResponse
    {
        $device = $request->attributes->get('sync_device');

        abort_unless($device, 401);

        $validator = Validator::make(
            $request->all(),
            [
                'mutations' => [
                    'required',
                    'array',
                    'min:1',
                    'max:100',
                ],

                'mutations.*.mutation_uuid' => [
                    'required',
                    'uuid',
                ],

                'mutations.*.entity' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'mutations.*.entity_sync_uuid' => [
                    'required',
                    'uuid',
                ],

                'mutations.*.operation' => [
                    'required',
                    'string',
                    'in:create,update,delete',
                ],

                'mutations.*.payload' => [
                    'nullable',
                    'array',
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid synchronization payload.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $results = [];

        foreach ($validator->validated()['mutations'] as $mutation) {

            try {

                $results[] = $this->syncApiService->push(
                    $device,
                    $mutation
                );

            } catch (Throwable $e) {

                report($e);

                $results[] = [
                    'mutation_uuid' => $mutation['mutation_uuid'],
                    'accepted' => false,
                    'processed' => false,
                    'message' => 'The mutation could not be processed.',
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'device_uuid' => $device->device_uuid,
                'results' => $results,
            ],
        ]);
    }
}

