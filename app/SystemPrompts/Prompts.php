<?php

namespace App\SystemPrompts;

class Prompts
{
    public static function jsonPrompt(): string
    {
        return
            'Parse all the given sentences into this JSON format. If you are unable to parse certain fields, set the value to null.
        {
            "Target": "(Azari/Beluga/Cinatu)",
            "requestedItem": "Item Name",
            "RequestedAmount": 0,
            "OfferedItem": "Item Name",
            "OfferedAmount": 0
        }';
    }

    public static function acceptDealPrompt(): string
    {
        return
            'Accept the deal with the following terms:
        {
            "Target": "(Azari/Beluga/Cinatu)",
            "requestedItem": "Item Name",
            "RequestedAmount": 0,
            "OfferedItem": "Item Name",
            "OfferedAmount": 0
        }';
    }

    public static function rejectDealPrompt(): string
    {
        return
            'Reject the deal with the following terms:
        {
            "Target": "(Azari/Beluga/Cinatu)",
            "requestedItem": "Item Name",
            "RequestedAmount": 0,
            "OfferedItem": "Item Name",
            "OfferedAmount": 0
        }';
    }

}
