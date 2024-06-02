<?php 
// require_once '/modules/google-calender/interfaces/IGoogleCalenderService.php';
// require_once '../modules/google-calender/services/interfaces/IGoogleCalenderService.php';
require_once __DIR__ . '/../interfaces/IGoogleCalenderService.php';


class GoogleCalenderService implements IGoogleCalenderService {
    private $googleClient;
    public function __construct(GoogleClient $googleClient)
    {
        $this->googleClient = $googleClient;
    }
    public function insertEvent($payload){
        $client = $this->googleClient->getClient();
        $service = new Google_Service_Calendar($client);
        $event = new Google_Service_Calendar_Event([
            'summary' => $payload['summary'],
            'start' => [
                'dateTime' => $payload['startDateTime'],
                'timeZone' => getTimezoneName($payload['startDateTime']),    
            ],
            'end' => [
                'dateTime' => $payload['endDateTime'],
                'timeZone' => getTimezoneName($payload['endDateTime']),
            ],
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        return $event;
    } 
    public function listEvents(){
        $client = $this->googleClient->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId);
        return $events;
    }
    public function getCalenderEvents(){
        $client = $this->googleClient->getClient();
        $service = new Google_Service_Calendar($client);

        $calendarId = 'primary'; 
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();
        return $events;
    }
    public function deleteEvents($eventId){
        $client = $this->googleClient->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $service->events->delete($calendarId, $eventId);
    }
}