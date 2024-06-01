<?php

require_once '../core/Controller.php';
require_once '../modules/event/models/EventModel.php';
require_once '../vendor/autoload.php';
require_once '../core/GoogleClient.php';
require_once '../modules/event/validation/CreateEventValidation.php';

class EventController extends Controller
{
    
    public function index()
    {
        $client = GoogleClient::getClient();
        $service = new Google_Service_Calendar($client);

        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId);
        $this->view('event', 'index', ['events' => $events]);
    }
    public function create()
    {
        $this->view('event', 'create');
    }
    public function store(HttpRequest $request)
    {
        $errors = CreateEventValidation::validate($request->post);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /event/create');
            exit;
        }
        $client = GoogleClient::getClient();
        $service = new Google_Service_Calendar($client);
        $event = new Google_Service_Calendar_Event([
            'summary' => $request->post['summary'],
            'start' => [
                'dateTime' => $request->post['startDateTime'],
                'timeZone' => getTimezoneName($request->post['startDateTime']),    
            ],
            'end' => [
                'dateTime' => $request->post['endDateTime'],
                'timeZone' => getTimezoneName($request->post['endDateTime']),
            ],
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        printf("Event created: %s\n", $event->htmlLink);
        header('Location: /');

    }
    public function calenderEvents()
    {
        $client = GoogleClient::getClient();
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

        $calendarEvents = [];

        if (!empty($events)) {
            foreach ($events as $event) {
                $start = $this->convertDateTimeFormat($event->start->dateTime) ?: $event->start->date;
                $end = $this->convertDateTimeFormat($event->end->dateTime) ?: $event->end->date;
                
                $calendarEvents[] = [
                    'id' => $event->id,
                    'title' => $event->getSummary(),
                    'start' => $start,
                    'end' => $end,
                    'description' => $event->getDescription() ?: '',
                ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($calendarEvents);
    }
    public function delete(HttpRequest $request,$eventId)
    {
        $client = GoogleClient::getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $service->events->delete($calendarId, $eventId);
        echo "Event deleted.";
    }
    private function convertDateTimeFormat($datetime)
    {
        $dateTime = new DateTime($datetime);
        return $dateTime->format('Y-m-d\TH:i:s');
    }
}
?>