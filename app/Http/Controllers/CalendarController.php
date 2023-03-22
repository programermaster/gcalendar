<?php

namespace App\Http\Controllers;

use Google\Service\Calendar\EventReminder;
use Google\Service\Calendar\EventReminders;
use App\Http\Requests\Calendar\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Session;
class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $client = new \Google\Client();
        $client->setAccessToken(file_get_contents(storage_path('app/google-calendar/oauth-token.json')));
        $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
        if ($client->isAccessTokenExpired()) {
            return redirect()->route("connect_to_google");
        }
        else {
            return view("index");
        }
    }

    public function connectToGoogle(){
        $client = new \Google\Client();
        $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
        $client->addScope("https://www.googleapis.com/auth/calendar");
        $client->setRedirectUri(route("revoke-oauth-token"));
        return view("connect", with(["authUrl" => $client->createAuthUrl()]));
    }

    public function revokeOauthToken(){

        $client = new \Google\Client();
        $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
        $client->addScope("https://www.googleapis.com/auth/calendar");
        $client->setRedirectUri(route("revoke-oauth-token"));

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            file_put_contents(storage_path('app/google-calendar/oauth-token.json'), json_encode($token));
        }

        return redirect()->route("index");
    }
    /**
     * Store event
     */
    public function store(Request $request)
    {
        $event = new Event;

        $event->name = $request->get("name");

        $event->startDateTime = Carbon::createFromFormat('d-m-Y H:i A', $request->get("date"). " " . $request->get("time"), "Europe/Belgrade");
        $event->endDateTime = $event->startDateTime->addHour();

        $event->addAttendee([
            'email' => $request->get("email"),
            'comment' => 'Phone: '.$request->get("phone"),
        ]);

        $reminder = new EventReminder();
        $reminder->setMethod('email');
        $reminder->setMinutes('15');
        $reminder_items[] = $reminder;

        $reminder = new EventReminder();
        $reminder->setMethod('email');
        $reminder->setMinutes('30');
        $reminder_items[] = $reminder;

        $reminders = new EventReminders();
        $reminders->setUseDefault('false');
        $reminders->setOverrides($reminder_items);

        $event->googleEvent->setReminders($reminders);

        $event->save();

        \Session::flash('alert-success', 'Event is successfully added');
        return \Redirect::back();
    }
}
