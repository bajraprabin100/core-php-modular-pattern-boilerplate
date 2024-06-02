<?php
interface IGoogleCalenderService
{
    public function insertEvent(array $payload);
    public function listEvents();
    public function getCalenderEvents();
    public function deleteEvents($eventId);
}