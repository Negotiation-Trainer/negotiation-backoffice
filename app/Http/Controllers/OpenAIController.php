<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealRequest;
use App\Http\Requests\PromptRequest;

use App\Http\Requests\TradeRequest;
use App\Services\AIService;

use Exception;

use Illuminate\Http\JsonResponse;


class OpenAIController extends Controller
{
    protected AIService $AIService;

    /**
     * Constructor, but can't use __construct because of middleware execution order
     * @return void
     * @throws Exception
     */
    public function construct(): void
    {
        $apiKey = config('openai.api_key');
        if ($apiKey === null) throw new Exception('OpenAI API Key is missing or unreachable');

        $this->AIService = new AIService($apiKey, request()->header('Authorization'));
    }


    public function acceptDeal(DealRequest $request): JsonResponse
    {
        $this->construct();
        $validated = $request->validated();

        $response = $this->AIService->acceptDealPrompt($validated);
        return response()->json(['message' => $response]);
    }

    public function rejectDeal(DealRequest $request): JsonResponse
    {
        $this->construct();
        $validated = $request->validated();

        $response = $this->AIService->rejectDealPrompt($validated);
        return response()->json(['message' => $response]);
    }

    public function convertToTrade(PromptRequest $request): JsonResponse
    {
        $this->construct();
        $validated = $request->validated();

        $response = $this->AIService->jsonPrompt($validated['prompt']);
        return response()->json($response);
    }

    /**
     * Generate a counter offer dialogue based on the user's input
     *
     * @return JsonResponse
     */
    public function counterOffer(DealRequest $request): JsonResponse
    {
        $this->construct();
        $validated = $request->validated();

        $response = $this->AIService->counterOfferPrompt($validated);
        return response()->json(['message' => $response]);
    }

    public function convertToChat(TradeRequest $request): JsonResponse
    {
        $this->construct();
        $validated = $request->validated();

        $response = $this->AIService->tradeChatPrompt($validated);
        return response()->json(['message' => $response]);

    }

}
