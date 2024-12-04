<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebhookConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required|string',
                'webhook_url' => 'required|url',
                'events' => 'required|array',
                'events.*' => 'required|in:message,status_change,agent_assigned'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $webhook = WebhookConfiguration::updateOrCreate(
                [
                    'client_id' => $request->client_id,
                    'webhook_url' => $request->webhook_url
                ],
                [
                    'events_config' => $request->events,
                    'is_active' => true
                ]
            );

            return response()->json([
                'webhook_id' => $webhook->id,
                'status' => 'registered'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to register webhook'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $webhookId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'events' => 'required|array',
                'events.*' => 'required|in:message,status_change,agent_assigned',
                'is_active' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $webhook = WebhookConfiguration::findOrFail($webhookId);

            $webhook->update([
                'events_config' => $request->events,
                'is_active' => $request->is_active
            ]);

            return response()->json([
                'webhook_id' => $webhook->id,
                'status' => 'updated'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to update webhook'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request, $webhookId)
    {
        try {
            $webhook = WebhookConfiguration::findOrFail($webhookId);
            $webhook->delete();

            return response()->json([
                'status' => 'deleted'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to delete webhook'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
