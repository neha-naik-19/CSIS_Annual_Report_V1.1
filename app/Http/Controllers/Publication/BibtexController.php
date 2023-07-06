<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use App\Models\Categories;
use App\Models\Authortypes;
use App\Models\Rankings;
use App\Models\Broadareas;
use App\Models\Articletypes;
use App\Models\Pubhdrs;
use App\Models\Pubdtls;

use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;
use RenanBr\BibTexParser\Processor;

class BibtexController extends Controller
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


        return view('publication.pubbibtex')->with('departmentId',request()->id)->with('department',request()->dept)
        ->with('authortypeData', $authortypeData)->with("categoryData",$categoryData)
        ->with('rankingsData', $rankingsData)->with('broadareasData', $broadareasData);
    }

    //Get bibtex file data
    function get_file_data(Request $request)
    {
        $get_content = base64_decode($request->filedata);

        Session::forget('filedata');

        session()->put('filedata', $get_content);
    }

    //parse bibtex file data
    function parse_bib_data()
    {
        // Create and configure a Listener
        $listener = new Listener();
        $listener->addProcessor(new Processor\TagNameCaseProcessor(CASE_LOWER));

        // Create a Parser and attach the listener
        $parser = new Parser();
        $parser->addListener($listener);

        $parser->parseString(session()->get('filedata')); // or parseFile('/path/to/file.bib')
        $entries = $listener->export();

        $finaldata = '';
       

        foreach ($entries as $key => $value) {
            $arraykeys = array_keys($value);

            $categoryid = '';
            $category = '';
            $month = 0;
            $year = 0;
            $date = '';
            $conference = null;
            $place = null;
            $title = '-';
            $volume = null;
            $issue = null;
            $pages = null;
            $doi = null;
            $publisher = null;
            $authors = [];

            if(strtolower($value['type']) == "article" || strtolower($value['type']) == "misc")
            {
                // Fetch Category id for journal
                $categoryid = categories::where('category', 'journal')->first()->id;
                $category =  'journal';
            }else if(strtolower($value['type']) == "conference" || strtolower($value['type']) == "inproceedings"){
            
                // Fetch Category id for conference
                $categoryid = categories::where('category', 'Conference/Workshop')->first()->id;
                $category =  'Conference/Workshop';
            }

            /***********Date*************/
            if(in_array('month',$arraykeys)){
                $month = $value['month'];
            }

            if(in_array('year',$arraykeys)){
                $year = $value['year'];
            }

            if($month != 0)
            {
                if(strlen($month) > 2)
                {
                    if (!preg_match("/^[0-9]+$/", $month))
                    {
                        $month = 0;
                    }
                }
            }

            //publication date
            if($month != 0 && $year != 0)
            {
                $date =  "01" . "." . $month . $value['year'];
            }
            if($month == 0 && $year != 0)
            {
                $date =  "01.01." . $value['year'];
            }
            if($month != 0 && $year == 0)
            {
                $date = "01" . $month .  Carbon::now()->year->timezone('Asia/kolkata');
            }
            if($month == 0 && $year == 0)
            {
                $date = Carbon::now()->timezone('Asia/kolkata');
            }
            /***********Date*************/

            /***********Title*************/
            if(in_array('booktitle',$arraykeys)){
                $title = $value['booktitle'];
            }

            if(in_array('title',$arraykeys)){
                $title = $value['title'];
            }
            /***********Title*************/

            /***********Conference*************/
            if(in_array('journal',$arraykeys)){
                $conference = $value['journal'];
            }

            // if(in_array('booktitle',$arraykeys)){
            //     $conference = $value['booktitle'];
            // }

            if(in_array('conference',$arraykeys)){
                $conference = $value['conference'];
            }
            /***********Conference*************/

            /***********Place*************/
            if(in_array('address',$arraykeys)){ 
                $place = $value['address'];
            }

            if(in_array('place',$arraykeys)){
                $place = $value['place'];
            }
            /***********Place*************/

             /***********Volume*************/
             if(in_array('volume',$arraykeys)){
                $volume = $value['volume'];
            }
            /***********Volume*************/

            /***********Issue*************/
            if(in_array('issue',$arraykeys)){
                $issue = $value['issue'];
            }
            /***********Issue*************/

            /***********Pages*************/
            if(in_array('pages',$arraykeys)){
                $pages = $value['pages'];
            }
            /***********Pages*************/

            /***********DOI*************/
            if(in_array('doi',$arraykeys)){
                $doi = $value['doi'];
            }
            /***********DOI*************/

            /***********publisher*************/
            if(in_array('publisher',$arraykeys)){
                $publisher = $value['publisher'];
            }elseif(in_array('organization',$arraykeys)){
                $publisher = $value['organization'];
            }
            /***********publisher*************/

            /***********Author*************/
            if(in_array('author',$arraykeys)){
                if(str_contains($value['author']," and "))
                {
                    $authors = array_map('trim', (explode(" and " , $value['author'])));
                    $authors = Str::replace(',', ' ', $authors);
                }
                else
                {
                    $authors = array_map('trim', (explode("," , $value['author'])));
                }
            }
            /***********Author*************/

            /***********Duplicate Title*************/
            $titledata =  Pubhdrs::where('title',$title)->where('deleted','0')->get(['title']);

            if (count($titledata) > 0){
                $titledata =  Pubhdrs::where('title',$title)->where('deleted','0')->first()->title;
            }
            else
            {
                $titledata = "";
            }
            /***********Duplicate Title*************/

            /***********Duplicate Conference*************/
            $conferencedata =  Pubhdrs::where('confname',$conference)->where('deleted','0')->get(['confname']);

            if (count($conferencedata) > 0){
                $conferencedata =  Pubhdrs::where('confname',$conference)->where('deleted','0')->first()->confname;
            }
            else
            {
                $conferencedata = "";
            }
            /***********Duplicate Conference*************/
                
            $obj = (object) array(
                        'categoryid' => $categoryid,
                        'category' => $category,
                        'dt' => $date,
                        'title' => $title === null ? "" : $title,
                        'conf' => $conference === null ? "" : $conference,
                        'place' => $place,
                        'volume' => $volume,
                        'issue' => $issue,
                        'pages' => $pages,
                        'doi' => $doi,
                        'publisher' => $publisher,
                        'author' => $authors,
                        'duplicatetitle' => $titledata === null ? "" : $titledata,
                        'duplicateconf' =>  $conferencedata === null ? "" : $conferencedata
            );

            if( $finaldata == '' ) {
                $finaldata = array($obj);
            }
            else
            {
                array_push($finaldata, $obj);
            }
        }

        echo json_encode($finaldata);
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
    