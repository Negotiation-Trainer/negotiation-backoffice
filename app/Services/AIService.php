<?php

namespace App\Services;

use App\Models\PromptHistory;
use App\SystemPrompts\Prompts;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $apiKey;

    protected string $requestToken;

    protected string $model = 'gpt-3.5-turbo'; //Default for now.
    protected string $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct(string $apiKey, string $requestToken)
    {
        $this->apiKey = $apiKey;
        $this->requestToken = $requestToken;
    }

    public function jsonPrompt(string $userPrompt): string
    {
        $response = $this->performApiRequest($this->model, Prompts::jsonPrompt(), $userPrompt);

        $this->logAPIInteraction($this->requestToken, $userPrompt, $response);

        return $this->getAIResponse($response);
    }

    public function acceptDealPrompt(string $userPrompt): string
    {
        $response = $this->performApiRequest($this->model, Prompts::acceptDealPrompt(), $userPrompt);

        $this->logAPIInteraction($this->requestToken, $userPrompt, $response);

        return $this->getAIResponse($response);
    }

    public function rejectDealPrompt(string $userPrompt): string
    {
        $response = $this->performApiRequest($this->model, Prompts::rejectDealPrompt(), $userPrompt);

        $this->logAPIInteraction($this->requestToken, $userPrompt, $response);

        return $this->getAIResponse($response);
    }

    private function getAIResponse(array $request): string
    {
        return $request['choices'][0]['message']['content'];
    }


    private function performApiRequest(string $model, string $systemPrompt, string $userPrompt): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ],
                [
                    'role' => 'user',
                    'content' => $userPrompt,
                ],
            ],
        ]);


        return $response->json();
    }

    private function logAPIInteraction(string $sessionToken, string $inputText, array $apiResponseData): void
    {
        Log::info('API LOG ID: ' . $apiResponseData['id']);

        PromptHistory::create([
            'input' => $inputText,
            'output' => $apiResponseData['choices'][0]['message']['content'],
            'input_tokens' => $apiResponseData['usage']['prompt_tokens'],
            'output_tokens' => $apiResponseData['usage']['completion_tokens'],
            'system_fingerprint' => $apiResponseData['system_fingerprint'],
            'gpt_model' => $apiResponseData['model'],
            'session_token' => $sessionToken,
        ]);
    }
}