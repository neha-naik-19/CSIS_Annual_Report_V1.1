<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Dompdf\Dompdf;

use PDF; 

use DB;

use App\Models\Categories;
use App\Models\Authortypes;
use App\Models\Rankings;
use App\Models\Broadareas;
use App\Models\Articletypes;
use App\Models\Pubhdrs;
use App\Models\Pubdtls;

class PrintController extends Controller
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
        
        return view('publication.pubprint')->with('departmentId',request()->id)->with('department',request()->dept)
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

    //GET PUBLICATION PRINT FORM REQUEST
    public function getprintfromjs(Request $request){
        session()->put('dt', $request->dt);
        session()->put('authortype', $request->authortype);
        session()->put('category', $request->category);
        session()->put('nationality', $request->nationality);
        session()->put('submitted', $request->submitted);
        session()->put('accepted', $request->accepted);
        session()->put('published', $request->published);
        session()->put('title', $request->title);
        session()->put('conference', $request->conference);
        session()->put('author', $request->author);
        session()->put('ranking', $request->ranking);
    }


    //GET PUBLICATION PRINT REQUEST
    public function getprintdata($categoryname){

        $dt = session()->get('dt');
        $authortype = session()->get('authortype');
        $category = session()->get('category');
        $nationality = session()->get('nationality');
        $title = session()->get('title');
        $conference = session()->get('conference');
        $authors = session()->get('author');
        $rankingoptions = session()->get('ranking');

        $print_data = [];
        $type = 0; //no criteria selected
        $subtype = 0; //no sub criteria selected

        $rankingoption = '';
        $fullname = '';

        if($category == "0")
        {
            $category = null;
        }
        else
        {
            $categorydata = categories::select('category')
                        ->where('id',$category)
                        ->first();
        }

        if($authortype == "0"){$authortype = null;}
        if($nationality == "0"){$nationality = null;}

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

        if($dt != null && $category == null && $nationality == null && $authors == null) //only date
        {
            $type = 0;
        }

        else if($dt != null && $category != null && $nationality == null && $authors == null) // dates, category
        {
            $type = 2;
        }

        else if($dt != null && $category == null && $nationality != null && $authors == null) //dates, nationality
        {
            $type = 3;
        }


        else if($dt != null && $category != null && $nationality != null && $authors == null) //Date, Category, Nationality
        {
            $type = 7;
        }

        else if($authors != null){
            $type = 8;
        }

        
        $print_data = DB::select('call Print_Publication_Data (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', 
        array(session()->get('departmentid'),session()->get('dt'),session()->get('category'),session()->get('nationality'),
        $fullname,$type,$subtype,$category == null ? $categoryname : $categorydata->category,session()->get('authortype'),session()->get('title'),
        session()->get('conference'),$rankingoption,session()->get('submitted') === 'true' ? 1 : 0,
        session()->get('accepted') === 'true' ? 1 : 0, session()->get('published') === 'true' ? 1 : 0));

        
        return $print_data;
    }

    // CONVERT PRINT DATA TO HTML
    function convert_print_data_to_html(){
        $category = session()->get('category');

        if($category == "0"){$category = null;}

        if($category != null){
            $categorydata = categories::select('category')
            ->where('id',$category)
            ->first();
        }

        if($category == null){
            $print_journal_data = $this->getprintdata('journal');
            $print_conference_data = $this->getprintdata('conference/workshop');
        }
        else{
            if(strtolower($categorydata->category) == 'journal'){
                $print_journal_data = $this->getprintdata('journal');
                $print_conference_data = [];
            }

            if(strtolower($categorydata->category) == 'conference/workshop'){
                $print_journal_data = [];
                $print_conference_data = $this->getprintdata('conference/workshop');
            }
        }

        $mindate = '01/01/'. session()->get('dt');
        $maxdate = '31/12/'. session()->get('dt');

        $output = '';   
        $output = '<body>';

        $output .= '<style>
                    .pagenum:before {
                        content: counter(page);
                    }
                    </style>';

        $output .= '<div align="center" style="font-size: 14px; font-weight: bold; font-family: Calibri, Arial, sans-serif; margin-top:10px;">DEPARTMENT OF COMPUTER SCIENCE & INFORMATION SYSTEMS</div><br>';

        if($print_journal_data != []){

            $output .= '<div align="left" style="font-size: 12px; font-family: Calibri, Arial, sans-serif; margin-top:10px;">LIST OF RESEARCH PUBLICATIONS IN SCOPUS INDEXED JOURNALS : 
                '.$mindate. ' - '.$maxdate.'</div>
                <div align="left" style="font-size: 12px; margin-top:10px;">Papers Published by Faculty in Journals</div>
                <hr style="border-width: .2px; margin-bottom:20px;">
            ';

            $num = 0;
            foreach($print_journal_data as $print)
            {
                $num = $num + 1;

                $output .=
                '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 11px; font-family: Calibri, Arial, sans-serif;">
                    <tr>
                        <td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial,sans-serif;">'.$num.'.</td>
                        <td align="justify" style="border: 0px solid; padding-bottom:12px; font-family: Calibri, Arial,
                        sans-serif;">'.trim($print->authorname).'. '.trim($print->title);

                if($print->conf != ''){
                    $output .= ', '.trim($print->conf);
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim($print->Doi);
                }

                if($print->volume != ''){
                    $output .= ', '.trim($print->volume);
                }

                if($print->issue != ''){
                    $output .= ', '.trim($print->issue);
                }

                if($print->pages != ''){
                    $output .= ', '.trim($print->pages);
                }

                $output .= ', '.Carbon::parse($print->publicationdate)->year;

                if($print->article != ''){
                    $output .= ' ('.$print->article.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.' , ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->broadarea.')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' (ImpactFactor='.$print->impactfactor.')';
                }

                $output .= '</td></tr></table>';
            }
        }

        if($print_conference_data != []){

            $output .= '<br><br><div align="left" style="font-size: 12px; font-family: Calibri, Arial, sans-serif; margin-top:10px;">CONFERENCES/WORKSHOPS/SEMINAR ATTENDED/PAPERS PRESENTED : '.$mindate. ' - '.$maxdate.' </div>
                        <hr style="border-width: .2px; margin-bottom:20px;">
                    ';

            $num = 0;
            $nationality ='';
            $prenationality='';
            $checkrepeater = false;
            $type = '';  
            foreach($print_conference_data as $print)
            {
                if($print->nationality == 1){
                    $nationality ='i)  National';
                    $type = 'national';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 0;
                        $checkrepeater = false;
                    }
                    
                    $prenationality = $type;
                    
                }
                
                if($print->nationality == 2){
                    if($type <> 'national'){
                        $nationality ='i)  International';
                    }
                    elseif($type == 'national'){
                        $nationality ='ii)  International';
                    }
                    $type = 'international';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 0;
                        $checkrepeater = false;
                    }

                    $prenationality = $type;
                    
                }

                $num = $num + 1;

                if($checkrepeater == false){
                    $output .=
                    '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 12px; font-family: Calibri, Arial, sans-serif;">
                        <tr><td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial, sans-serif;"> '. $nationality .':</td></tr><br>
                    </table>';
                }

                $output .=
                '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 11px; font-family: Calibri, Arial, sans-serif;">
                    <tr>
                        <td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial, sans-serif;">'.$num.'.</td>
                        <td align="justify" style="border: 0px solid; padding-bottom:12px; font-family: Calibri, Arial,
                        sans-serif;">'.trim($print->authorname).'. '.trim($print->title);

                if($print->conf != ''){
                    $output .= ', '.trim($print->conf);
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim($print->Doi);
                }

                if($print->volume != ''){
                    $output .= ', '.trim($print->volume);
                }

                if($print->issue != ''){
                    $output .= ', '.trim($print->issue);
                }

                if($print->pages != ''){
                    $output .= ', '.trim($print->pages);
                }

                $output .= ', '.Carbon::parse($print->publicationdate)->year;

                $output .= ', '.trim($print->location);

                if($print->article != ''){
                    $output .= ' ('.$print->article.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->broadarea.')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ( ImpactFactor='.$print->impactfactor.')';
                }
                
                $output .= '</td></tr></table>';
            }  
        }

        $output .= '</body>';

        return $output;
    }


    // CREATE AND LOAD PDF
    function loadpdf(Request $request)
    {
        $pdf = new dompdf();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->setOptions(['isPhpEnabled' => true,'defaultFont' => 'arial']);

        // $options = new \Dompdf\Options();
        // $options->set('isPhpEnabled', true);
        // $options->set('defaultFont','Helvetica');
        // $dompdf->setOptions($options);

        $pdf->loadHtml($this->convert_print_data_to_html());
        $pdf->setPaper('A4');

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(270, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 7.5, array(0, 0, 0));
        
        return $pdf->stream('Publication.pdf',Array('Attachment'=>0));
    }


    //CONVERT TO WORD
    function createworddocx(){
        $word = new \PhpOffice\PhpWord\PhpWord();
        $textAlign = new \PhpOffice\PhpWord\SimpleType\TextAlignment();

        $word->getSettings()->setMirrorMargins(true);

        $word->getSettings()->setHideGrammaticalErrors(true);
        $word->getSettings()->setHideSpellingErrors(true);
        // $word->addParagraphStyle('p2Style', ['align'=> $textAlign ::CENTER]);

        $newsection = $word->addSection();

        $sectionStyle = $newsection->getStyle();

        //half inch top margin
        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));

        //half inch bottom margin
        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));
        
        //half inch left margin
        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));
        
        // half inch right margin
        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5)); //cmToTwip -> cm, inchToTwip -> inch
    
        $category = session()->get('category');

        if($category == "0"){$category = null;}

        if($category != null){
            $categorydata = categories::select('category')
            ->where('id',$category)
            ->first();
        }

        if($category == null){
            $print_journal_data = $this->getprintdata('journal');
            $print_conference_data = $this->getprintdata('conference/workshop');
        }
        else{
            if(strtolower($categorydata->category) == 'journal'){
                $print_journal_data = $this->getprintdata('journal');
                $print_conference_data = [];
            }

            if(strtolower($categorydata->category) == 'conference/workshop'){
                $print_journal_data = [];
                $print_conference_data = $this->getprintdata('conference/workshop');
            }
        }

        $mindate = '01/01/'. session()->get('dt');
        $maxdate = '31/12/'. session()->get('dt');

        $newline = "\n";

        $heading1 = htmlspecialchars('DEPARTMENT OF COMPUTER SCIENCE & INFORMATION SYSTEMS');
    
        $newsection->addText($heading1, array('bold'=>true, 'name'=> 'Arial', 'size'=>13,'spaceBefore' => 8, 'spaceAfter' => 10,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER), 
            ['align'=> $textAlign ::CENTER]);

        //Start ==> Only Journal data display
        if($print_journal_data != []){
            $journalheading = 'LIST OF RESEARCH PUBLICATIONS IN SCOPUS INDEXED JOURNALS : ' .$mindate. ' - '.$maxdate;

            $newsection->addText($newline);                                 
            $newsection->addText($journalheading, array('name'=> 'Arial','size'=>10));
    
            //$newsection->addText($newline);
            $newsection->addText('Papers Published by Faculty in Journals', array('name'=> 'Arial','size'=>9,'align' => 'end'));
            
            $newsection->addText('', [], ['borderBottomSize'=>1, 'borderBottomColor'=>'A9A9A9']);

            //$newsection->addText($newline);

            $fontStyle = array('size'=>8, 'name'=>'Arial' /*,'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 */);
            $noSpace = array('spaceAfter' => -1);
            $bold = array('bold'=> true);
            $aligncelltext = array('align'=> $textAlign ::BOTH);
            $table = $newsection->addTable();
            
            $num = 1;
            foreach($print_journal_data as $print){

                $output = trim(htmlspecialchars($print->authorname)).'. '.trim(htmlspecialchars($print->title)); //Author name , Title

                if($print->conf != ''){
                    $output .= ', '.trim(htmlspecialchars($print->conf)); //Conference
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim(htmlspecialchars($print->Doi)); //DOI
                }

                if($print->volume != ''){
                    $output .= ', '.trim(htmlspecialchars($print->volume)); //Volume
                }

                if($print->issue != ''){
                    $output .= ', '.trim(htmlspecialchars($print->issue)); //Issue
                }

                if($print->pages != ''){
                    $output .= ', '.trim(htmlspecialchars($print->pages)); //Pages
                }

                $output .= ', '.Carbon::parse($print->publicationdate)->year; //Year
 
                if($print->article != ''){
                    $output .= ' ('.htmlspecialchars($print->article).')'; //Article
                }

                //Start => Ranking, BroadArea, ImpactFactor
                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).' , ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->broadarea).')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' (ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }
                //End => Ranking, BroadArea, ImpactFactor

                $table->addRow();
                $table->addCell(550)->addText( $num ++ .'.',$fontStyle);
                $table->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
            }
        }
        //End ==> Only Journal data display
        
        //Start ==> Only Conference data display
        if($print_conference_data != []){
    
            $newsection->addText($newline);

            $conferenceheading = 'CONFERENCES/WORKSHOPS/SEMINAR ATTENDED/PAPERS PRESENTED : ' .$mindate. ' - '.$maxdate;

            //$newsection->addText($newline);
            $newsection->addText($conferenceheading, array('name'=> 'Arial','size'=>9,'align' => 'end'));
            
            $newsection->addText('', [], ['borderBottomSize'=>1, 'borderBottomColor'=>'A9A9A9']);

            //$newsection->addText($newline);

            $fontStyle = array('size'=>8, 'name'=>'Arial');
            $nationalityfontStyle = array('bold'=>true,'size'=>11, 'name'=>'Arial');
            $noSpace = array('spaceAfter' => 0);
            $aligncelltext = array('align'=> $textAlign ::BOTH);

            $table = $newsection->addTable();
            $table1 = $newsection->addTable();
            $table2 = $newsection->addTable();
            $table3 = $newsection->addTable();

            $num = 1;
            $nationality ='';
            $prenationality='';
            $checkrepeater = false;
            $type = ''; 
            $output = '';
            foreach($print_conference_data as $print){

                if($print->nationality == 1){
                    $nationality ='i)  National';
                    $type = 'national';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 1;
                        $checkrepeater = false;
                    }
                    
                    $prenationality = $type;
                }
                
                if($print->nationality == 2){
                    if($type <> 'national'){
                        $nationality ='i)  International';
                    }
                    elseif($type == 'national'){
                        $nationality ='ii)  International';
                    }
                    $type = 'international';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 1;
                        $checkrepeater = false;
                    }

                    $prenationality = $type;
                }

                if($checkrepeater == false){
                    if($type == 'national'){
                        $table->addRow();
                        $table->addCell(10000)->addText($nationality,array('bold'=>true),$aligncelltext,$nationalityfontStyle);
                    }

                    if($type == 'international'){
                        $table2->addRow();
                        $table2->addCell(10000)->addText($nationality,array('bold'=>true),$aligncelltext,$nationalityfontStyle);
                    }
                }

                $output = trim(htmlspecialchars($print->authorname)).'. '.trim(htmlspecialchars($print->title)); //Author name , Title

                if($print->conf != ''){
                    $output .= ', '.trim(htmlspecialchars($print->conf)); //Conference
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim(htmlspecialchars($print->Doi)); //DOI
                }

                if($print->volume != ''){
                    $output .= ', '.trim(htmlspecialchars($print->volume)); //Volume
                }

                if($print->issue != ''){
                    $output .= ', '.trim(htmlspecialchars($print->issue)); //Issue
                }

                if($print->pages != ''){
                    $output .= ', '.trim(htmlspecialchars($print->pages)); //Pages
                }

                $output .= ', '.Carbon::parse($print->publicationdate)->year; //Years

                $output .= ', '.trim(htmlspecialchars($print->location)); //Location

                if($print->article != ''){
                    $output .= ' ('.htmlspecialchars($print->article).')'; //Article
                }

                //Start => Ranking, BroadArea, ImpactFactor
                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->ranking).')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.htmlspecialchars($print->broadarea).')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ( ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                }
                //End => Ranking, BroadArea, ImpactFactor
                
                if($type == 'national'){
                    $table1->addRow();
                    $table1->addCell(200)->addText( '',$fontStyle);
                    $table1->addCell(550)->addText( $num ++ .'.',$fontStyle);
                    $table1->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
                }

                if($type == 'international'){
                    $table3->addRow();
                    $table3->addCell(200)->addText( '',$fontStyle);
                    $table3->addCell(550)->addText( $num ++ .'.',$fontStyle);
                    $table3->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
                }
            }
        }
        //End ==> Only Conference data display

        $footer = $newsection->addFooter();
            $footer->addPreserveText('Page {PAGE} of {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,'size'=>1));
            $newsection->addPageBreak();
    
            $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, "Word2007");
            try{
                $objectWriter->save(storage_path('PublicationWordExport.docx'));
            }
            catch(Exception $e){
    
            }
    
        return response()->download(storage_path('PublicationWordExport.docx'));
    }

}
