<?php

namespace App\Http\Controllers;

use App\Models\GameCode;
use App\Models\Pricing;
use App\Models\PromptHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CostsController extends Controller
{

    private const GPT_3_5_TURBO_0125 = 'gpt-3.5-turbo-0125';
    private const GPT_4_TURBO = 'gpt-4-turbo';
    /**
     * Calculate the total cost of the prompt history
     *
     * Returns an array with:
     * - GPT 3.5 input tokens
     * - GPT 3.5 output tokens
     * - GPT 4 input tokens
     * - GPT 4 output tokens
     * - Total cost
     *
     * @return array
     */
    public function calculateTotal(): array
    {
        $gpt3Input = $this->getCosts(true, true);
        $gpt3Output = $this->getCosts(true, false);
        $gpt4Input = $this->getCosts(false, true);
        $gpt4Output = $this->getCosts(false, false);

        $total = $this->total($gpt3Input, $gpt3Output, $gpt4Input, $gpt4Output);
        $budget = 100;

        return ([
            'gpt3InputTokens' => $gpt3Input,
            'gpt3OutputTokens' => $gpt3Output,
            'gpt4InputTokens' => $gpt4Input,
            'gpt4OutputTokens' => $gpt4Output,
            'total' => $total,
            'budget' => $budget,
        ]);
    }

    public function getGameCosts(GameCode $gameCode): float
    {
        //get all sessions that have used this game key
        $sessions = $gameCode->sessionList;

        $gpt3Input = 0;
        $gpt3Output = 0;
        $gpt4Input = 0;
        $gpt4Output = 0;

        foreach ($sessions as $session) {
            foreach ($session->promptsList as $prompt) {
                if ($prompt->gpt_model === self::GPT_3_5_TURBO_0125) {
                    $gpt3Input += $prompt->input_tokens;
                    $gpt3Output += $prompt->output_tokens;
                } else {
                    $gpt4Input += $prompt->input_tokens;
                    $gpt4Output += $prompt->output_tokens;
                }
            }
        }

        return $this->total(
            $this->calculate($this->getPricing(self::GPT_3_5_TURBO_0125, 'input'), $gpt3Input),
            $this->calculate($this->getPricing(self::GPT_3_5_TURBO_0125, 'output'), $gpt3Output),
            $this->calculate($this->getPricing(self::GPT_4_TURBO, 'input'), $gpt4Input),
            $this->calculate($this->getPricing(self::GPT_4_TURBO, 'output'), $gpt4Output)
        );
    }

    private
    function getCosts(bool $isGpt3, bool $isInput): float
    {
        $gptModel = $isGpt3 ? self::GPT_3_5_TURBO_0125 : self::GPT_4_TURBO; // gpt-3.5-turbo-0125 or gpt4-turbo
        $column = ($isInput ? 'input' : 'output'); // input or output

        return $this->getCostsFromTokens($gptModel, $column);
    }

    /**
     * Calculate the cost of the tokens
     *
     * @param string $model
     * @param string $column
     * @return float
     */
    private
    function getCostsFromTokens(string $model, string $column): float
    {
        $tokens = $this->getTokenTotal($model, $column);

        return $this->calculate($this->getPricing($model, $column), $tokens);
    }

    private
    function getTokenTotal(string $gptModel, string $column)
    {
        return PromptHistory::where('gpt_model', $gptModel)
            ->sum($column . '_tokens');
    }

    private
    function getPricing(string $model, string $column): float
    {
        $column .= '_price';
        return Pricing::select($column)->where('model', $model)->first()->$column;
    }

    /**
     * Calculate the price of the tokens in USD
     * Token price is per 1000 tokens
     *
     * @param float $tokenPrice
     * @param int $tokens
     * @return float
     */
    private
    function calculate(float $tokenPrice, int $tokens): float
    {
        return round(($tokenPrice / 1000) * $tokens, 4);
    }

    private
    function total(float ...$args): float
    {
        return round(array_sum($args), 2);
    }
}
