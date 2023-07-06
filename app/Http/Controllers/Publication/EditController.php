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

class EditController extends Controller
{
    public function index()
    {
        //Date Format
        date_default_timezone_set("Asia/kolkata");

        // Fetch AuthorTypes
        $authortypeData['data'] = authortypes::orderby("authortype","asc")
        ->select('id','authortype')
        ->get();

        // Fetch Categories
        $categoryData['data'] = Categories::orderby("category","asc")
        ->select('id','category')
        ->get();

        // Fetch only Rankings -> Others
        $rankingsOnlyAstarData = rankings::select('id','ranking')
        ->where('ranking','=','Core A*')
        ->get();                        
        
        // Fetch w/o Rankings -> Others
        $rankingsNoOthersData = rankings::orderby("ranking","asc")
        ->select('id','ranking')
        ->whereNotIn('ranking', ['Core A*','Others'])
        ->get();                         

        // Fetch only Rankings -> Others
        $rankingsOnlyOthersData = rankings::select('id','ranking')
        ->where('ranking','=','Others')
        ->get();

        //Fetch all rankings in
        $rankingsData['data'] = $rankingsOnlyAstarData->merge($rankingsNoOthersData)->merge($rankingsOnlyOthersData);

        // Session::forget('departmentid');
        session()->put('departmentid', request()->id);

        // Session::forget('department');
        session()->put('department', request()->dept);
        
        return view('publication.pubedit')->with('departmentId',request()->id)->with('department',request()->dept)
        ->with('authortypeData', $authortypeData)->with("categoryData",$categoryData)->with('rankingsData', $rankingsData);
    }

    public function showauthor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';

            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('pubdtls')
                    ->select('fullname')
                    ->join("pubhdrs",function($join){
                        $join->on("pubhdrs.id","=","pubdtls.pubhdrid")
                            ->where('pubhdrs.deleted','=','0');
                    })
                    ->where('fullname','like','%' .$query. '%')
                    ->distinct()
                    ->get();
            }
            else
            {
                $data = '';
            }

            if($data != '')
            { 
                $total_row = $data->count();
            }
            else{
                $total_row = 0;
            }

            if($total_row > 0)
            {
                foreach($data as  $row)
                {
                    $output .= '<tr>' .
                    '<td>' .
                    '<span class="custom-checkbox">' .
                    '<input type="checkbox" id="tblcheck" name="options[]" value="1">' .
                    '<label for="checkbox1"></label>' .
                    '</span>' .
                    '</td>' .
                    '<td id="pubeditviewfullname" name="pubeditviewfullname[]">' . $row->fullname . '</td></tr>'; 
                }

                $data = array(
                    'table_data' => $output
                );
            }
            else
            {
                $output .= '';
                $data = [];
            }

            echo json_encode($data);
        }
    }


    //GET PUBLICATION SEARCH RESULT
    public function getsearchresult(Request $request){
        $rankingoptions = $request->get('ranking');
        $authors = $request->get('author');
        $rankingoption = '';
        $fullname = '';
        $data = array();

        if($rankingoptions != null){
            foreach ($rankingoptions as $key => $value) {
                if( $rankingoption == '' ) {
                    $rankingoption = array($value['checked']);
                }
                else
                {
                    array_push($rankingoption, ($value['checked']));
                }
            }

            $rankingoption = implode (',', $rankingoption);
        }
        else{
            $rankingoption = '0';
        }

        if($authors != null){
            foreach ($authors as $key => $value) {
                if( $fullname == '' ) {
                    $fullname = array($value['fullname']);
                }
                else
                {
                    array_push($fullname, $value['fullname']);
                }
            }

            $fullname = implode (',', $fullname);
        }


        $data =  DB::select('call Get_Search_Data_View_Edit (?,?,?,?,?,?,?,?,?,?,?,?)', 
        array(session()->get('departmentid'),$request->get('dt'),$request->get('submitted') === 'true' ? 1 : 0,
        $request->get('accepted') === 'true' ? 1 : 0, $request->get('published') === 'true' ? 1 : 0,
        $request->get('authortype'),$request->get('category'),$request->get('nationality'),
        $request->get('title'),$request->get('conference'),$rankingoption,$fullname));

        $output = '';

        if(!empty($data))
        {
            foreach($data as $row){
                $output .= '<tr>
                <td style="display:none;">' . $row->headerid . '</td>
                <td style="display:none;">' . $row->userid . '</td>
                <td>' . $row->publicationdate . '</td>
                <td style="display:none;">' . $row->category . '</td>
                <td>' . $row->title . '</td>
                <td>' . $row->conf . '</td>
                <td>' . $row->user . '</td>
                <td id="pubeditviewlastchildtd">
                    <a class="pubeditviewview" target="_blank" href='. route("publication.update", ['id' => base64_encode(session()->get('departmentid')),'dept' => base64_encode(session()->get('department')), 'hdrid' => base64_encode($row->headerid), 'type' => base64_encode('View')] ) .' title="View" data-toggle="tooltip"><i class="material-icons">&#xe8f4;</i></a>
                    <a class="pubeditviewedit" target="_blank" href='. route("publication.update", ['id' => base64_encode(session()->get('departmentid')),'dept' => base64_encode(session()->get('department')), 'hdrid' => base64_encode($row->headerid), 'type' => base64_encode('Edit')] ) .' title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                    <a class="pubeditviewdelete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                </td>
                </tr>';
            }
        }

        // return response()->json(['searchresult' => $data, 'departmentid' => base64_encode(session()->get('departmentid')), 'department' => base64_encode(session()->get('department'))]);

        return $output;
    }

    public function deleterecord($id)
    {
        DB::beginTransaction();
        
        try{
            DB::table('pubhdrs')->where('id', [$id])->update(['deleted' => 1,'updated_at' => Carbon::now()->timezone('Asia/kolkata')]);

            DB::commit();
            return "{\"msg\":\"success\"}";
        }
        catch (Exception $ex)
        {
            DB::rollback();
            return $ex->getMessage();
        }
    }
}
