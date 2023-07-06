
@extends('layouts.main')


@section('pubupdate')
<div class="container mt-5" id="pubupdatecontainer">
    <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
    <input type="hidden" name="departmentid" id="departmentid" value={{ request()->id }}/>
    <input type="hidden" id="updatetype" value={{ $type }}/>
    <form class="pubupdateform" action="" method="POST" autocomplete="off">
        
        @foreach($data as $publicationdata)
            <div class="card first scroll">
                <div class="card-header sticky-top">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <header>Publication <small class="pubupdateheadersmall">{{ $type }} Record</small></header>
                        </div>
                        {{-- <div class="col-md-6 col-sm-12">
                            <a class="pubupdaterefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
                        </div> --}}
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row checkboxrow">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-check pubupdateformcheck">
                                        @if($publicationdata->submitted == 1)         
                                            <input class="form-check-input" type="checkbox" value="Submitted" id="pubupdatechecksubmitted" checked>        
                                        @else
                                            <input class="form-check-input" type="checkbox" value="Submitted" id="pubupdatechecksubmitted">         
                                        @endif
                                        <label class="form-check-label" id="pubupdatelabelsubmitted">
                                            Submitted
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-check pubupdateformcheck">
                                        @if($publicationdata->accepted == 1)         
                                            <input class="form-check-input" type="checkbox" value="Accepted" id="pubupdatecheckaccepted" checked>        
                                        @else
                                            <input class="form-check-input" type="checkbox" value="Accepted" id="pubupdatecheckaccepted">         
                                        @endif
                                        <label class="form-check-label" id="pubupdatelabelaccepted">
                                            Accepted
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-check pubupdateformcheck">
                                        @if($publicationdata->published == 1)         
                                            <input class="form-check-input" type="checkbox" value="Published" id="pubupdatecheckpublished" checked>        
                                        @else
                                            <input class="form-check-input" type="checkbox" value="Published" id="pubupdatecheckpublished">         
                                        @endif
                                        <label class="form-check-label" id="pubupdatelabelpublished">
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
                                <label id="pubupdatelabeldate">Date</label>
                                <input id="pubupdateinputdate" type="date" max="<?php echo date("Y-m-d"); ?>" placeholder="Enter date" value="{{ $publicationdata->pubdate }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelauthortype">Author Type</label>
                                <select id="pubupdateselectauthortype" >
                                    <option value='{{ $publicationdata->authortypeid }}' selected value="{{ $publicationdata->authortypeid }}">{{ $publicationdata->authortype }}</option>
                                    @foreach($authortypeData['data'] as $authortype)
                                        @if($publicationdata->authortypeid != $authortype->id)
                                            <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelcategory">Category</label>
                                <select id="pubupdateselectcategory">
                                    <option value='{{ $publicationdata->categoryid }}' selected value="{{ $publicationdata->categoryid }}">{{ $publicationdata->category }}</option>
                                    @foreach($categoryData['data'] as $category)
                                        @if($publicationdata->categoryid != $category->id)
                                            <option value='{{ $category->id }}'>{{ $category->category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabeldemography">Demography</label>
                                <select id="pubupdateselectdemography">
                                    @if($publicationdata->nationality =='1')
                                        <option value='1' selected>National</option>
                                        <option value="2">International</option>
                                    @endif
                                    @if($publicationdata->nationality =='2')
                                        <option value='2' selected>International</option>
                                        <option value="1">National</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelarticle">Type of conference</label>
                                <select id="pubupdateselectarticle">
                                    @if(is_null($publicationdata->articletypeid))
                                        @foreach($articletypeData['data'] as $article)
                                            <option value='{{ $article->articleid }}'>{{ $article->article }}</option>        
                                        @endforeach
                                    @else
                                        <option value='{{ $publicationdata->articletypeid }}' selected>{{ $publicationdata->article }}</option>
                                        @foreach($articletypeData['data'] as $article)
                                            @if($publicationdata->articletypeid != $article->articleid)
                                                <option value='{{ $article->articleid }}'>{{ $article->article }}</option>
                                            @endif 
                                        @endforeach 
                                    @endif      
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelranking">Ranking</label>
                                <select id="pubupdateselectranking">
                                    <option value='{{ $publicationdata->rankingid }}' selected>{{ $publicationdata->ranking }}</option>
                                    @foreach($rankingsData['data'] as $ranking)
                                        @if($publicationdata->rankingid != $ranking->id)
                                            <option value='{{ $ranking->id }}'>{{ $ranking->ranking }}</option>
                                        @endif 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelbroadarea">Broad Area</label>
                                <select id="pubupdateselectbroadarea">
                                    <option value='{{ $publicationdata->broadareaid }}' selected>{{ $publicationdata->broadarea }}</option>
                                    @foreach($broadareasData['data'] as $broadarea)
                                        @if($publicationdata->broadareaid != $broadarea->id)
                                            <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>
                                        @endif 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabeltitle">Title of the paper</label>
                                <textarea id="pubupdatetextareatitle" rows="3" placeholder="Enter paper title">{{ $publicationdata->title }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelnameofconference">Name of Conference/Journal</label>
                                <textarea id="pubupdatetextareanameofconference" rows="3" placeholder="Enter conference/journal">{{ $publicationdata->confname }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelimpactfactor">Impact Factor</label>
                                <input id="pubupdateinputimpactfactor" class="allow_numeric" type="text" placeholder="Enter impact factor"  maxlength="6" value="{{ $publicationdata->impactfactor }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabellocation">Location</label>
                                <input id="pubupdateinputlocation" type="text" placeholder="Enter location" value="{{ $publicationdata->location }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelvolumeno">Volume No.</label>
                                <input id="pubupdateinputvolumeno" type="text" placeholder="Enter volume number" value="{{ $publicationdata->volume }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelissueno">Issue No.</label>
                                <input id="pubupdateinputissueno" type="text" placeholder="Enter issue number" value="{{ $publicationdata->issue }}"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelpageno">Page No.</label>
                                <input id="pubupdateinputpageno" type="text" placeholder="Enter page number" value="{{ $publicationdata->pp }}"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabeldoi">DOI</label>
                                <input id="pubupdateinputdoi" type="text" placeholder="Enter doi" value="{{ $publicationdata->doi }}"/>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubupdatelabelpublisher">Publisher</label>
                                <input id="pubupdateinputpublisher" type="text" placeholder="Enter publisher" value="{{ $publicationdata->publisher }}"/>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-primary btnpublication pubupdatebtnnext">Next &nbsp;<i class="fa fa-thin fa-hand-point-right"></i></button>
                </div>
            </div>

            <div class="card second scroll">
                <div class="card-header sticky-top">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <header>Publication <small class="pubupdateheadersmall">{{ $type }} Record</small></header>
                        </div>
                        <div class="col-md-6 col-sm-12">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="table-wrapper pubupdatetablewrapper">
                            <div class="table-title pubupdatetabletitle ps-4 pe-4">
                                <div class="row">
                                    <div class="col-md-10 col-sm-12 ">
                                        <b id="pubupdatetitledisplay"></b>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="button" class="btn btn-info pubupdatenew"><i class="fa fa-plus"></i> AddNew</button>
                                    </div>
                                </div>
                            </div>
                            <div class="pubupdatetablediv ps-4 pe-4">
                                <table class="table table-bordered pubupdatetable">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style='display: none;'>
                                            <td>0</td>
                                            <td></td>
                                            <td>
                                                <a class="pubupdateadd" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                                <a class="pubupdateedit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                                <a class="pubupdatedelete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                            </td>
                                        </tr>
                                        @foreach($authordata as $publicationauthordata)
                                            <tr>
                                                <td>{{ $publicationauthordata->slno }}</td>
                                                <td>{{ $publicationauthordata->fullname }}</td>
                                                <td>
                                                    <a class="pubupdateadd" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                                    <a class="pubupdateedit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                                    <a class="pubupdatedelete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    
                    <button  type="button" class="btn btn-primary btnpublication pubupdatebtnback"><i class="fa fa-thin fa-hand-point-left"></i>&nbsp; Back</button>
                    <button type="submit" class="btn btn-primary btnpublication pubupdatebtnupdate">Update &nbsp;<i class="fa-solid fa-pen-to-square"></i></button>
                </div>
            </div>
        @endforeach
    </form>
</div>
@endsection