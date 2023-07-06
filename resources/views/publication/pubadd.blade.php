
@extends('layouts.main')


@section('pubadd')
<div class="container mt-5" id="pubaddcontainer">
    <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
    <input type="hidden" name="departmentid" id="departmentid" value={{ request()->id }}/>
    <form class="pubaddform" action="" method="POST" autocomplete="off">
        
        {{-- card - first --}}
        <div class="card first scroll">
            <div class="card-header sticky-top">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <header>Publication <small class="pubaddheadersmall">New Record</small></header>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <a class="pubaddrefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="card-title">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <header>Publication <small class="pubaddheadersmall">New Record</small></header>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a class="pubaddrefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
                        </div>
                    </div>
                </div> --}}
                
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="row checkboxrow">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-check pubaddformcheck">
                                    <input class="form-check-input" type="checkbox" value="Submitted" id="pubaddchecksubmitted">
                                    <label class="form-check-label" id="pubaddlabelsubmitted">
                                        Submitted
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-check pubaddformcheck">
                                    <input class="form-check-input" type="checkbox" value="Accepted" id="pubaddcheckaccepted">
                                    <label class="form-check-label" id="pubaddlabelaccepted">
                                        Accepted
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-check pubaddformcheck">
                                    <input class="form-check-input" type="checkbox" value="Published" id="pubaddcheckpublished">
                                    <label class="form-check-label" id="pubaddlabelpublished">
                                        Published
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabeldate">Date</label>
                            <input id="pubaddinputdate" type="date" max="<?php echo date("Y-m-d"); ?>" placeholder="Enter date" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelauthortype">Author Type</label>
                            {{-- <select id="pubaddselectauthortype">
                                <option selected></option>
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                            </select> --}}

                            <select id="pubaddselectauthortype">
                                <option value='0' selected></option>
                                @foreach($authortypeData['data'] as $authortype)
                                    <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelcategory">Category</label>
                            <select id="pubaddselectcategory">
                                <option value='0' selected></option>
                                @foreach($categoryData['data'] as $category)
                                    <option value='{{ $category->id }}'>{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabeldemography">Demography</label>
                            <select id="pubaddselectdemography">
                                <option value="0" selected></option>
                                <option value="1">National</option> 
                                <option value="2">International</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelarticle">Type of conference</label>
                            <select id="pubaddselectarticle">
                                <option value='0' selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelranking">Ranking</label>
                            <select id="pubaddselectranking">
                                <option value='0' selected></option>
                                @foreach($rankingsData['data'] as $ranking)
                                    <option value='{{ $ranking->id }}'>{{ $ranking->ranking }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelbroadarea">Broad Area</label>
                            <select id="pubaddselectbroadarea">
                                <option value='0' selected></option>
                                @foreach($broadareasData['data'] as $broadarea)
                                    <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabeltitle">Title of the paper</label>
                            <textarea id="pubaddtextareatitle" rows="3" placeholder="Enter paper title"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelnameofconference">Name of Conference/Journal</label>
                            <textarea id="pubaddtextareanameofconference" rows="3" placeholder="Enter conference/journal"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelimpactfactor">Impact Factor</label>
                            <input id="pubaddinputimpactfactor" class="allow_numeric" type="text" placeholder="Enter impact factor"  maxlength="6" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabellocation">Location</label>
                            <input id="pubaddinputlocation" type="text" placeholder="Enter location" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelvolumeno">Volume No.</label>
                            <input id="pubaddinputvolumeno" type="text" placeholder="Enter volume number" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelissueno">Issue No.</label>
                            <input id="pubaddinputissueno" type="text" placeholder="Enter issue number" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelpageno">Page No.</label>
                            <input id="pubaddinputpageno" type="text" placeholder="Enter page number" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabeldoi">DOI</label>
                            <input id="pubaddinputdoi" type="text" placeholder="Enter doi" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-field">
                            <label id="pubaddlabelpublisher">Publisher</label>
                            <input id="pubaddinputpublisher" type="text" placeholder="Enter publisher"  />
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary btnpublication pubaddbtnnext">Next &nbsp;<i class="fa fa-thin fa-hand-point-right"></i></button>
            </div>
        </div>

        {{-- card - second --}}
        <div class="card second scroll">
            <div class="card-header sticky-top">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <header>Publication <small class="pubaddheadersmall">New Record</small></header>
                    </div>
                    <div class="col-md-6 col-sm-12">
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="card-title">
                    <header>Publication <small class="pubaddheadersmall">New Record</small></header>
                </div> --}}
                <div class="container">
                    <div class="table-wrapper pubaddtablewrapper">
                        <div class="table-title pubaddtabletitle ps-4 pe-4">
                            <div class="row">
                                <div class="col-md-10 col-sm-12 ">
                                    <b id="pubaddtitledisplay"></b>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="button" class="btn btn-info pubaddnew"><i class="fa fa-plus"></i> AddNew</button>
                                </div>
                            </div>
                        </div>
                        <div class="pubaddtablediv ps-4 pe-4">
                            <table class="table table-bordered pubaddtable">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>Administration</td>
                                        <td>
                                            <a class="pubaddadd" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                            <a class="pubaddedit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a class="pubadddelete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <button  type="button" class="btn btn-primary btnpublication pubaddbtnback"><i class="fa fa-thin fa-hand-point-left"></i>&nbsp; Back</button>
                <button type="submit" class="btn btn-primary btnpublication pubaddbtnsubmit">Submit &nbsp;<i class="fa-solid fa-floppy-disk"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection