<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromptRequest;
use App\Models\PromptHistory;
use Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log;

class OpenAIController extends Controller
{
    public function getOpenAIResponse(PromptRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }

        $openAIKey = config('app.openai_key');

        if ($openAIKey === null) {
            return response()->json(['error' => 'OpenAI key not set'], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openAIKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '
                    Parse all the given sentences into this JSON format. If you are unable to parse certain fields, set the value to null.
                    {
                        "Target": "(Azari/Beluga/Cinatu)",
                        "requestedItem": "Item Name",
                        "RequestedAmount": 0,
                        "OfferedItem": "Item Name",
                        "OfferedAmount": 0
                    }',
                ],
                [
                    'role' => 'user',
                    'content' => $validated['prompt'],
                ],
            ],
        ]);


        $this->logAPIInteraction($request->header('Authorization'), $validated['prompt'], $response->json());
        return response()->json(['status' => 'success', 'response' => $response->json()['choices'][0]['message']['content']]);
    }

    private function logAPIInteraction(string $sessionToken, string $inputText, array $apiResponseData): void
    {
        $outputText = $apiResponseData['choices'][0]['message']['content'];
        $inputTokens = $apiResponseData['usage']['prompt_tokens'];
        $outputTokens = $apiResponseData['usage']['completion_tokens'];
        $systemFingerprint = $apiResponseData['system_fingerprint'];
        $model = $apiResponseData['model'];
        Log::info('API LOG ID: ' . $apiResponseData['id']);
        PromptHistory::create([
            'input' => $inputText,
            'output' => $outputText,
            'input_tokens' => $inputTokens,
            'output_tokens' => $outputTokens,
            'system_fingerprint' => $systemFingerprint,
            'gpt_model' => $model,
            'session_token' => $sessionToken,
        ]);
    }
}
