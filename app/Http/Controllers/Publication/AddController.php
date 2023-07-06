<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use DB;

use App\Models\Categories;
use App\Models\Authortypes;
use App\Models\Rankings;
use App\Models\Broadareas;
use App\Models\Articletypes;
use App\Models\Pubhdrs;
use App\Models\Pubdtls;

class AddController extends Controller
{
    public function index()
    {
        //Date Format
        date_default_timezone_set("Asia/kolkata");

        // Fetch AuthorTypes
        $authortypeData['data'] = Authortypes::orderby("authortype","asc")
        ->select('id','authortype')
        ->get();

        // Fetch Categories
        $categoryData['data'] = Categories::orderby("category","asc")
        ->select('id','category')
        ->get();

        // Fetch only Rankings -> Others
        $rankingsOnlyAstarData = Rankings::select('id','ranking')
        ->where('ranking','=','Core A*')
        ->get();                        
        
        // Fetch w/o Rankings -> Others
        $rankingsNoOthersData = Rankings::orderby("ranking","asc")
        ->select('id','ranking')
        ->whereNotIn('ranking', ['Core A*','Others'])
        ->get();                         

        // Fetch only Rankings -> Others
        $rankingsOnlyOthersData = Rankings::select('id','ranking')
        ->where('ranking','=','Others')
        ->get();

        //Fetch all rankings in
        $rankingsData['data'] = $rankingsOnlyAstarData->merge($rankingsNoOthersData)->merge($rankingsOnlyOthersData);

        //Fetch Broadareas
        $broadareasData['data'] = Broadareas::orderby("broadarea","asc")
        ->select('id','broadarea')
        ->get();

        return view('publication.pubadd')->with('departmentId',request()->id)->with('department',request()->dept)
        ->with('authortypeData', $authortypeData)->with("categoryData",$categoryData)
        ->with('rankingsData', $rankingsData)->with('broadareasData', $broadareasData);
    }

    public function showarticle()
    {
        $data = Articletypes::orderby("articleid","asc")
                        ->select('articleid','article')
                        ->get();                

        return response()->json($data);                
    }

    //CHECK FOR DUPLICATE TITLE ENTRY
    public function get_title_data(Request $request)
    {
        Session::forget('title_data');

        session()->put('title_data', trim($request->duptitle));
    }

    public function check_dup_title()
    {
        $title = session()->get('title_data');

        $titledata =  Pubhdrs::where('title',$title)->where('deleted','0')->get(['title']);

        if (count($titledata) > 0){
            $titledata =  Pubhdrs::where('title',$title)->where('deleted','0')->first()->title;
        }
        else
        {
            $titledata = "";
        }

        echo json_encode($titledata);
    }

      //CHECK FOR DUPLICATE CONFERENCE ENTRY
    function get_conference_data(Request $request)
    {
        Session::forget('conference_data');

        session()->put('conference_data', trim($request->duptitle));
    }

    function check_dup_conference()
    {
        $conference = session()->get('conference_data');

        $conferencedata =  Pubhdrs::where('confname',$conference)->where('deleted','0')->get(['confname']);

        if (count($conferencedata) > 0){
            $conferencedata =  Pubhdrs::where('confname',$conference)->where('deleted','0')->first()->confname;
        }
        else
        {
            $conferencedata = "";
        }

        echo json_encode($conferencedata);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            // $userid = User::where('email',Auth::user()->email)->first()->id;

            if($request->ajax()){
                $pubhdrs = new Pubhdrs();

                $pubhdrs->departmentID = (int)$request->departmentid;
                $pubhdrs->categoryid = (int)$request->categoryid;
                $pubhdrs->authortypeid = (int)$request->authortypeid;
                $pubhdrs->articletypeid = (int)$request->article;
                $pubhdrs->nationality = (int)$request->nationality;
                $pubhdrs->pubdate = $request->pubdate;
                $pubhdrs->submitted = $request->submitted === 'true' ? 1 : 0;
                $pubhdrs->accepted = $request->accepted === 'true' ? 1 : 0;
                $pubhdrs->published = $request->published === 'true' ? 1 : 0;
                $pubhdrs->title = $request->title;
                $pubhdrs->confname = $request->confname;
                $pubhdrs->place = $request->place;
                $pubhdrs->rankingid = (int)$request->rankingid;
                $pubhdrs->broadareaid = (int)$request->broadareaid;
                $pubhdrs->impactfactor = (int)$request->impactfactor;
                $pubhdrs->volume = $request->volume;
                $pubhdrs->issue = $request->issue;
                $pubhdrs->pp = $request->pp;
                $pubhdrs->digitallibrary = $request->digitallibrary;
                $pubhdrs->publisher = $request->publisher;
                $pubhdrs->userid = 7;
                $pubhdrs->deleted  = 0;
                $pubhdrs->created_at = Carbon::now()->timezone('Asia/kolkata');
                $pubhdrs->updated_at = Carbon::now()->timezone('Asia/kolkata');
                    
                $pubhdrs->save();
    
                $headermaxid = pubhdrs::max('id');

                for($count = 0; $count < count($request->tabledata); $count++ ){
                    $data = array(
                        'pubhdrid' => $headermaxid,
                        'slno' =>  $request->tabledata[$count]['slno'],
                        'fullname' => $request->tabledata[$count]['name'],
                        "created_at" => Carbon::now()->timezone('Asia/kolkata')
                    );

                    $inser_data[] = $data;
                }

                Pubdtls::insert($inser_data);
            }
            
            DB::commit();
            return "{\"msg\":\"success\"}";
        }
        catch (Exception $ex)
        {
            DB::rollback();
            dd('Exception block', $ex);
        }
    }
}
