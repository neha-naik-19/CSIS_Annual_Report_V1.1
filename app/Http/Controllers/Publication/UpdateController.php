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

class UpdateController extends Controller
{
    public function index()
    {
        $headerid = base64_decode(request()->hdrid);

        session()->put('hdrid', $headerid);

        session()->get('hdrid');

        $departmentid = base64_decode(request()->id);

        $dept = base64_decode(request()->dept);

        $data =  DB::select('call Get_update_Data (?,?)',array((int)$headerid, (int)$departmentid));

        $authordata =  DB::select('call Get_Author_Data_For_Update (?)',array((int)$headerid));

        // Fetch Categories
        $categoryData['data'] = Categories::orderby("category","asc")
        ->select('id','category')
        ->get();

        // Fetch AuthorTypes
        $authortypeData['data'] = Authortypes::orderby("authortype","asc")
        ->select('id','authortype')
        ->get();

        // Fetch ArticleType
        $articletypeData['data'] = Articletypes::orderby("journalconfernce","asc")
            ->select('articleid','article')
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
                    
        // Fetch Broadareas
        $broadareasData['data'] = Broadareas::orderby("broadarea","asc")
                    ->select('id','broadarea')
                    ->get(); 
    
        return view('publication.pubupdate')->with('departmentId',$departmentid)->with('department',$dept)
        ->with('authortypeData', $authortypeData)->with("categoryData",$categoryData)
        ->with('rankingsData', $rankingsData)->with('broadareasData', $broadareasData)
        ->with('articletypeData',$articletypeData)->with('headerid',$headerid)->with('data',$data)->with('authordata',$authordata)
        ->with('type', base64_decode(request()->type));
    
    }

    //update to database
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            if($request->ajax()){

                $pubhdrs = new Pubhdrs();

                $data = Pubhdrs::whereId(session()->get('hdrid'))->first();

                // $userid = User::where('email',Auth::user()->email)->first()->id;

                $data->update([ //updateing to pubhdr table
                    'departmentID'  => (int)base64_decode($request->departmentid),
                    'categoryid'    => (int)$request->categoryid,
                    'authortypeid'  => (int)$request->authortypeid,
                    'articletypeid' => (int)$request->article,
                    'nationality'   => (int)$request->nationality,
                    'pubdate'       => $request->pubdate,
                    'submitted'     => $request->submitted === 'true' ? 1 : 0,
                    'accepted'      => $request->accepted === 'true' ? 1 : 0,
                    'published'     => $request->published === 'true' ? 1 : 0,
                    'title'         => $request->title,
                    'confname'      => $request->confname,
                    'place'         => $request->place,
                    'rankingid'     => (int)$request->rankingid,
                    'broadareaid'   => (int)$request->broadareaid,
                    'impactfactor'  => (int)$request->impactfactor,
                    'volume'        => $request->volume,
                    'issue'         => $request->issue,
                    'pp'            => $request->pp,
                    'digitallibrary'=> $request->digitallibrary,
                    'publisher'     => $request->publisher,
                    'userid'         => 7,
                    'updated_at'     => Carbon::now()->timezone('Asia/kolkata')
                ]);

                DB::delete('DELETE FROM pubdtls WHERE pubhdrid = ?', [session()->get('hdrid')]);
                
                for($count = 0; $count < count($request->tabledata); $count++ ){
                    $data = array(
                        'pubhdrid' => session()->get('hdrid'),
                        'slno' =>  $request->tabledata[$count]['slno'],
                        'fullname' => $request->tabledata[$count]['name'],
                        "created_at" => Carbon::now()->timezone('Asia/kolkata'),
                        'updated_at' => Carbon::now()->timezone('Asia/kolkata')
                    );

                    $inser_data[] = $data;
                }

                Pubdtls::insert($inser_data);

                DB::commit();
                return "{\"msg\":\"success\"}";
            }

        }
        catch (Exception $ex)
        {
            DB::rollback();
            return $ex->getMessage();
        }
    }

}
