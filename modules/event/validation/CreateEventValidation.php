<?php

class   CreateEventValidation
{
    public static function validate(array $data)
    {
        $errors = [];

        // Check if summary is provided
        if (empty($data['summary'])) {
            $errors[] = "Please enter the event summary";
        }

        // Check if startDateTime is provided and in the correct format
        if (empty($data['startDateTime']) || !strtotime($data['startDateTime'])) {
            $errors[] = "Please enter a valid start date and time";
        }

        // Check if endDateTime is provided and in the correct format
        if (empty($data['endDateTime']) || !strtotime($data['endDateTime'])) {
            $errors[] = "Please enter a valid end date and time";
        }

        // Check if endDateTime is after startDateTime
        if (!empty($data['startDateTime']) && !empty($data['endDateTime'])) {
            if (strtotime($data['startDateTime']) >= strtotime($data['endDateTime'])) {
                $errors[] = "End date and time must be greater than start date and time";
            }
        }

        return $errors;
    }
}