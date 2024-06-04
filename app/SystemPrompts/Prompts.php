<?php

namespace App\SystemPrompts;

class Prompts
{
    public static function jsonPrompt(): string
    {
        return
            'Parse all the given sentences into this JSON format. If you are unable to parse certain fields, set the value to null.
            The amounts should be clamped between 0 and 10. If the amount is beyond this range, set it to the nearest valid value.
            Do not use special characters, escape characters, newlines (\n), and do not format the JSON using backticks (`). Just give the JSON object.
            The following items are valid for RequestedItem and OfferedItem. Try to match the item as closely as possible to one of these:
            Wood, Lenses, Clay, Gold, Steel, Insulation, Fertilizer, Stone
        {
            "TargetName": "(Azari/Beluga/Cinatu)", //Cinatu may not always be recognised. If you hear something similar, fill in Cinatu (e.g: tribe see, or sona tu, see etc)
            "OriginName": "Azari", //default is Azari
            "RequestedItem": "Item Name",
            "RequestedAmount": 0,
            "OfferedItem": "Item Name",
            "OfferedAmount": 0
        }';
    }

    public static function dealSystemPrompt(): string
    {
        return 'You are a human player in a negotiation game responding to another player. Do not use special characters,' .
            ' escape characters, newlines (\n) or emoji in your response. Always respond in English. The below are the tribe-specific instructions. Use these for your responses to enchance your storytelling depending on which tribe you are.'
            . 'The following is the game instruction.' .
            "Welcome to Connor's Paradise, an island in the Atlantic Ocean where three tribes—the Azari, Beluga, and Cinatu—live peacefully but independently. After a powerful storm ravaged the island, destroying homes and crops, the tribes demand infrastructure improvements to prepare for future storms.
            There are eight construction projects to build, each with their own material.

            An observation point to identify storms and tsunamis in time, constructed with wood.
            A wave breaker to protect the coast, built with stone.
            An astronomy center to improve weather forecasts, made with lenses.
            A temple to appease and calm the god Connor, built with gold.
            A storm shelter for refuge during storms, made with steel.
            Home repairs to fix storm damage, made with clay.
            A warehouse to store food, built with insulation.
            Improvements to crop yield for increased agricultural productivity, made with fertilizer.

            Resources are limited, so tribes must collaborate to complete projects. Each project requires ten units of different resources and can only be built once. If a tribe builds a project itself, it benefits the most with 10 points. Other tribes might gain 5 points, lose 5 points or have no effect. If no project is built, all tribes suffer (-3 points).

            Your goal is to maximize your tribe's benefits by negotiating and trading resources with other tribes. Act decisively, as a severe storm is approaching, and ensure your tribe's needs are met.";
    }

    public static function acceptDealPrompt(array $dealData): string
    {
        //TODO: Implement the tribe name and reason for accepting the deal
        $tribe = $dealData['targetName'];
        return
            $tribe . ' requested ' . $dealData['RequestedAmount'] . ' ' . $dealData['RequestedItem'] . ' in exchange for your ' . $dealData['OfferedAmount'] . ' ' . $dealData['OfferedItem'] .
            'Write a response from You, the ' . $dealData['originName'] . ' tribe, to accept the following deal from the ' . $tribe . ' tribe leader . use a ' . $dealData['speakerStyle'] . ' tone in your response .
    You are accepting the deal for the following reason: ' . $dealData['reason'] . ' . include this reason in your response . ';
    }

    public static function rejectDealPrompt(array $dealData): string
    {
        //TODO: Implement the tribe name
        $tribe = $dealData['targetName'];
        return
            $tribe . ' requested ' . $dealData['RequestedAmount'] . ' ' . $dealData['RequestedItem'] . ' in exchange for their ' . $dealData['OfferedAmount'] . ' ' . $dealData['OfferedItem'] .
            'Write a response from You, the ' . $dealData['originName'] . ' tribe, to reject the following deal from the ' . $tribe . ' tribe leader . use a ' . $dealData['speakerStyle'] . ' tone in your response .
    You are refusing the deal for the following reason: ' . $dealData['reason'] . ' . include this reason in your response . ';
    }

    /**
     * Generate a counter offer prompt to propose a new deal to the human player
     *
     * @param array $dealData
     * @return string
     */
    public static function counterOfferPrompt(array $dealData): string
    {
        $tribe = $dealData['targetName'];
        //the $dealData contains a new offer, coming from the AI.
        // It has already been generated by the algorithm and needs a response from the AI.
        return
            "You are proposing a counter offer to the " . $tribe . " tribe leader. You, the " . $dealData['originName'] . " tribe, declined for the following reason: "
            . $dealData['reason'] . ". Your new proposal is " . $dealData['OfferedAmount'] . " " . $dealData['OfferedItem'] . " in exchange for "
            . $dealData['RequestedAmount'] . " " . $dealData['RequestedItem'] . ". Write a response to the tribe leader in a " . $dealData['speakerStyle']
            . " tone. Mention that you are declining their offer and presenting the above as an alternative in the speaker's style .
    Be creative in your response, but keep it limited to three sentences . ";
    }

    public static function tradeChatPrompt(array $dealData): string
    {
        //the trade chat prompt is used to generate a chat dialogue between the AI and the human player.
        //It generates a chat dialogue based on the trade offer to simulate a negotiation.
        return "Generate a message that you, leader of the " . $dealData['originName'] . " will use to tell another human player(from the "
            . $dealData['targetName'] . " tribe) about what you are offering them . You are offering: "
            . $dealData['OfferedAmount'] . " " . $dealData['OfferedItem'] . " in exchange for " . $dealData['RequestedAmount'] . " " . $dealData['RequestedItem']
            . ". use a " . $dealData['speakerStyle'] . " tone in your dialogue . ";
    }

}
