<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Tour;
use App\Models\User;
use App\Models\Banner;
use App\Models\Champion;
use App\Models\CmsContent;
use App\Models\Tournament;
use App\Models\Testimonial;
use App\Models\TeamSchedule;
use App\Models\SponsorImage;
use App\Models\SupportContact;
use App\Models\Subscriber;
use App\Models\WantTourDetails;
use App\Models\TournamentPlayer;
use App\Models\TournamentGameScore;
use App\Models\TourTournament;
use App\Models\RuleBook;
use App\Models\TourChampion;
use App\Models\Representative;

use Yajra\DataTables\Facades\DataTables;

use App\Mail\ContactUsMail;
use App\Mail\SendSubscribeWelcomeMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request){
        $sponsor_images = SponsorImage::get();
        $tours = Tour::with('images')->where('status','active')->get();
        $testimonials = Testimonial::where('status','1')->get();
        
        return view('front-user.home',compact('sponsor_images', 'tours', 'testimonials'));
    }

    public function tourDetails(Request $request,$id){
        $today_date = Carbon::now();
        $tour = Tour::with('latestImages','tournaments')->where(['id' => $id, 'status' => 'active'])->first();

        if(!$tour){
            abort(404);
        }

        $latest_tour_log = fetch_latest_tour_log($id);


        $players_ranking = '';
        if(isset($latest_tour_log))
        {
            $players_ranking = TournamentGameScore::with('user')->whereRaw("find_in_set('".$id."',tour_id)")->whereRaw("find_in_set('".$latest_tour_log->id."',tour_log_id)")->selectRaw('*, sum(lasn_cup_points) as points')->orderBY('points','DESC')->groupBy('user_id')->get();

            if($players_ranking->count() == 0)
            {
                $previous_tour_log = fetch_previous_tour_log($id);
                if(isset($previous_tour_log))
                {
                    // $players_ranking = TournamentGameScore::with('user')->where(['tour_id' => $id,'tour_log_id' => $previous_tour_log->id])->selectRaw('*, sum(lasn_cup_points) as points')->orderBY('points','DESC')->groupBy('user_id')->get();
                    $players_ranking = TournamentGameScore::with('user')->whereRaw("find_in_set('".$id."',tour_id)")->whereRaw("find_in_set('".$previous_tour_log->id."',tour_log_id)")->selectRaw('*, sum(lasn_cup_points) as points')->orderBY('points','DESC')->groupBy('user_id')->get();
                }
            }

        }

        // find gross winners
        $tournament_gross_winners = Tournament::with(['Tournament_scores'=>function($q)  use($latest_tour_log){
                $q->whereRaw("find_in_set('".$latest_tour_log->id."',tour_log_id)")->orderBy('gross_score','ASC');
            }])->has('Tournament_scores')->whereRaw("find_in_set('".$latest_tour_log->id."',tour_log_id)")->where(['is_session_over' => 'yes'])->get();

        // find net winners
        $tournament_net_winners = Tournament::with(['Tournament_scores'=>function($q)  use($latest_tour_log){
                $q->whereRaw("find_in_set('".$latest_tour_log->id."',tour_log_id)")->orderBy('net_score','ASC');
            }])->has('Tournament_scores')->whereRaw("find_in_set('".$latest_tour_log->id."',tour_log_id)")->where(['is_session_over' => 'yes'])->get();

        // find upcoming tournaments
        $Upcoming_tournaments = Tournament::with('latestTournament_images','location_data')
            ->where(['tour_id' => $id, 'is_session_over' => 'no','tour_log_id' => $latest_tour_log->id])
            ->orderBy('tournament_date', 'ASC')
            ->paginate(3);

        // find past tournaments
        $past_tournaments = TourTournament::with('tournament','tour','tour_log')->whereHas('tournament',function($query) use($id){
            return $query->with('latestTournament_images','location_data')->where(['is_session_over' => 'yes']);
        })->where(['tour_log_id'=> $latest_tour_log->id ,'tour_id' => $id])->paginate(3);


        return view('front-user.tour',compact('tour','Upcoming_tournaments','players_ranking','tournament_gross_winners','tournament_net_winners','season_champion','past_tournaments'));
    }

    public function tourBook(Request $request){

        return view('front-user.tour_book');
    }

    public function checkUsername(Request $request){
        if(Auth::check()){
            if(Auth::user()->username == $request->username){
                return response(['status' => true]);
            }
        }
        $verify = User::where('username', $request->username)->first();
        if($verify){
            return "false";
        }
        else{
            return "true";
        }
    }

    public function contactUs(Request $request)
    {
        try{
            $attributes = $request->all();
            if($request->ajax())
            {
                $validateArray = [
                    'contact_name' => ['required', 'string', 'max:255'],
                    'contact_message' => 'required',
                    'contact_email' => 'required',
                ];
                $validator = Validator::make($attributes, $validateArray);
                if ($validator->fails())
                {
                    return response()->json(["status" => false, 'type' => 'validation-error', 'message' => $validator->errors()]);
                }
                $details = [
                    'name' => $attributes['contact_name'],
                    'email' => $attributes['contact_email'],
                    'message' => $attributes['contact_message']
                ];

                $contact_data = SupportContact::find(1);
                if($contact_data)
                {
                    Mail::to($contact_data->email)->send(new ContactUsMail($details));
                }
                return response()->json(['status'=>true,'message'=>'Thanks for contacting us']);
            }
            return response()->json(['status'=>false,'message'=>'Un authorised request']);
        }
        catch (\Exception $e)
        {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    public function subscribeNewsletter(Request $request){
        $attributes = $request->all();
        $validateArray = [
            'subscribe_email' => ['required', 'string', 'max:255'],
            'state' => ['required']
        ];

        $validator = Validator::make($attributes, $validateArray);
        if ($validator->fails()){
            return response()->json(["status" => false, 'type' => 'validation-error', 'message' => $validator->errors()]);
        }

        try{
            $fyndOld = Subscriber::where(['email'=>$attributes['subscribe_email'], 'state'=>$attributes['state'] ])->count();
            if($fyndOld > 0)
            {
                return response()->json(['status' => false, "message" => "User has already subscribed for the newsletter."]);
            }
            $subscribers = new Subscriber();
            $subscribers->email = $attributes['subscribe_email'];
            $subscribers->state = $attributes['state'];
            $subscribers->save();

            $details['link'] = route('unsubscribe.newsletter',$attributes['subscribe_email']);
            $email = new SendSubscribeWelcomeMail($details);
            Mail::to($attributes['subscribe_email'])->send($email);

            return response()->json(['status' => true, "message" => "User has subscribed to the newsletter successfully."]);
        } catch (\Exception $e){
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }

    public function unsubscribeNewsletter($email)
    {
        $subCount = Subscriber::where(['email'=>$email,'subscribed'=>'yes'])->count();
        $userCount = User::where(['email'=>$email,'subscribed'=>'yes'])->count();
        if($subCount == 0 && $userCount == 0){
            return redirect('/')->with('success','You have already unsubscribed successfully.');
        }

        Subscriber::where('email',$email)->update(['subscribed'=>'no']);
        User::where('email',$email)->update(['subscribed'=>'no']);
        return redirect('/')->with('success','You have unsubscribed successfully.');
    }

}
