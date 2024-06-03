<?php

require_once '../core/Controller.php';
require_once '../modules/event/models/EventModel.php';
require_once '../vendor/autoload.php';
require_once '../core/GoogleClient.php';
require_once '../modules/event/validation/CreateEventValidation.php';
require_once '../modules/google-calender/services/interfaces/IGoogleCalenderService.php';

class EventController extends Controller
{
    private $googleCalenderService;
    public function __construct(IGoogleCalenderService $googleCalenderService){
        $this->googleCalenderService = $googleCalenderService;
    }
    
    public function index()
    {
        $events = $this->googleCalenderService->listEvents();
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
        
        $event = $this->googleCalenderService->insertEvent($request->post);
        printf("Event created: %s\n", $event->htmlLink);
        header('Location: /');

    }
    public function calenderEvents()
    {
        $events = $this->googleCalenderService->getCalenderEvents();
        $calendarEvents = [];

        if (!empty($events)) {
            foreach ($events as $event) {
                $start = convertDateTimeFormat($event->start->dateTime) ?: $event->start->date;
                $end = convertDateTimeFormat($event->end->dateTime) ?: $event->end->date;
                
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
        $this->googleCalenderService->deleteEvents($eventId);
        echo "Event deleted.";
    }
    
    public function disconnect(){
        GoogleClient::disconnect();    
        header('Location: /');
    }
  
}
