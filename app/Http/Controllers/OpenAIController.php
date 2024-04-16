<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealRequest;
use App\Http\Requests\PromptRequest;

use App\Models\PromptHistory;
use App\Services\AIService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Log;

class OpenAIController extends Controller
{
    protected AIService $AIService;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $apiKey = config('app.openai_key');
        if ($apiKey === null) throw new \Exception('OpenAI API Key is missing or unreachable');

        $this->AIService = new AIService($apiKey, request()->header('Authorization'));
    }

    public function acceptDeal(DealRequest $request)
    {
        $validated = $request->validated();

        $response = $this->AIService->acceptDealPrompt($validated['prompt']);
        return response()->json(['message' => $response]);
    }

    public function rejectDeal(DealRequest $request)
    {
        $validated = $request->validated();

        $response = $this->AIService->rejectDealPrompt($validated['prompt']);
        return response()->json(['message' => $response]);
    }

    public function convertToTrade(PromptRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $response = $this->AIService->jsonPrompt($validated['prompt']);
        return response()->json($response);
    }


}
