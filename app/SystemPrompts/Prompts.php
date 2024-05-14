<?php

namespace App\SystemPrompts;

class Prompts
{
    public static function jsonPrompt(): string
    {
        return
            'Parse all the given sentences into this JSON format. If you are unable to parse certain fields, set the value to null.
        {
            "TargetName": "(Azari/Beluga/Cinatu)",
            "RequestedItem": "Item Name",
            "RequestedAmount": 0,
            "OfferedItem": "Item Name",
            "OfferedAmount": 0
        }';
    }

    public static function dealSystemPrompt(): string
    {
        return 'You are a human player in a negotiation game responding to another player. Do not use any special characters in your response.';
    }

    public static function acceptDealPrompt(array $dealData): string
    {
        //TODO: Implement the tribe name and reason for accepting the deal
        $tribe = "Azari";
        $reason = "come up with a reason for accepting the deal here.";
        return
            $tribe . ' requested ' . $dealData['RequestedAmount'] . ' ' . $dealData['RequestedItem'] . ' in exchange for your ' . $dealData['OfferedAmount'] . ' ' . $dealData['OfferedItem'] .
            'Write a response to accept the following deal from the ' . $tribe . ' tribe leader. Use a ' . $dealData['speakerStyle'] . ' tone in your response.
            You are accepting the deal for the following reason: ' . $reason . '. Include this reason in your response.';
    }

    public static function rejectDealPrompt(array $dealData): string
    {
        //TODO: Implement the tribe name
        $tribe = "Azari";
        return
            $tribe . ' requested ' . $dealData['RequestedAmount'] . ' ' . $dealData['RequestedItem'] . ' in exchange for your ' . $dealData['OfferedAmount'] . ' ' . $dealData['OfferedItem'] .
            'Write a response to reject the following deal from the ' . $tribe . ' tribe leader. Use a ' . $dealData['speakerStyle'] . ' tone in your response.
            You are refusing the deal for the following reason: ' . $dealData['reason'] . '. Include this reason in your response.';
    }

    /**
     * Generate a counter offer prompt to propose a new deal to the human player
     *
     * @param array $dealData
     * @return string
     */
    public static function counterOfferPrompt(array $dealData): string
    {
        //TODO: Implement the tribe name
        $tribe = "Azari";
        //the $dealData contains a new offer, coming from the AI.
        // It has already been generated by the algorithm and needs a response from the AI.
        return
            "You are proposing a counter offer to the " . $tribe . " tribe leader. You declined for the following reason: "
            . $dealData['reason'] . ". Your new proposal is " . $dealData['OfferedAmount'] . " " . $dealData['OfferedItem'] . " in exchange for "
            . $dealData['RequestedAmount'] . " " . $dealData['RequestedItem'] . ". Write a response to the tribe leader in a " . $dealData['speakerStyle']
            . " tone. Mention that you are declining their offer and presenting the above as an alternative in the speaker's style.
            Be creative in your response, but keep it limited to three sentences.";
    }

}
