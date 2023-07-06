
@extends('layouts.main')

@section('pubeditview')
    <div class="container mt-5" id="pubeditviewcontainer">
        <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
        <input type="hidden" name="departmentid" id="departmentid" value={{ request()->id }}/>

        <div class="pubeditviewcard">
            <div class="card first scroll">        
                <div class="card-header sticky-top">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <header>Publication <small class="pubeditviewheadersmall">Edit/View Record</small></header>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a class="pubeditviewrefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabeldate">Year</label>
                                <input id="pubeditviewdate" type="text" placeholder="yyyy" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabelauthortype">Author Type</label>
                                <select id="pubeditviewselectauthortype">
                                    <option value='0' selected></option>
                                    @foreach($authortypeData['data'] as $authortype)
                                        <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabelcategory">Category</label>
                                <select id="pubeditviewselectcategory">
                                    <option value='0' selected></option>
                                    @foreach($categoryData['data'] as $category)
                                        <option value='{{ $category->id }}'>{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabeldemography">Demography</label>
                                <select id="pubeditviewselectdemography">
                                    <option value="0" selected></option>
                                    <option value="1">National</option> 
                                    <option value="2">International</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabeltitle">Title of the paper</label>
                                <textarea id="pubeditviewtextareatitle" rows="3" placeholder="Enter paper title"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubeditviewlabelnameofconference">Name of Conference/Journal</label>
                                <textarea id="pubeditviewtextareanameofconference" rows="3" placeholder="Enter conference/journal"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 col-sm-12">
                            <div class="select-field border rounded">
                                <div class="form-check pubeditviewformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Submitted" id="pubeditviewchecksubmitted">
                                        <label class="form-check-label" id="pubeditviewlabelsubmitted">
                                            Submitted
                                        </label>
                                    </span>
                                </div>

                                <div class="form-check pubeditviewformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Accepted" id="pubeditviewcheckaccepted">
                                        <label class="form-check-label" id="pubeditviewlabelaccepted">
                                            Accepted
                                        </label>
                                    </span>
                                </div>

                                <div class="form-check pubeditviewformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Published" id="pubeditviewcheckpublished">
                                        <label class="form-check-label" id="pubeditviewlabelpublished">
                                            Published
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="select-field-ranking">
                                <label id="pubeditviewlabelranking">Ranking</label>
                                <div class="pubeditviewdivul">
                                    <ul class="list-group list-group-light pubeditviewulranking">
                                        @foreach($rankingsData['data'] as $ranking)
                                            <li class="list-group-item" id="pubeditviewliranking">
                                                <span class="custom-checkbox">
                                                    <input class="form-check-input me-1 pubeditviewrankingcheckbox" id="pubeditviewinputranking{{ $ranking->id }}" type="checkbox" value="{{ $ranking->id }}" aria-label="..." />
                                                    <label class="form-check-label" id="pubeditviewlabelranking{{ $ranking->id }}">
                                                        {{ $ranking->ranking }}
                                                    </label>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="table-wrapper pubeditviewtablewrapper">
                                <div class="input-field">
                                    <label id="pubeditviewlabelauthorsearch">Author Search</label>
                                    <input id="pubeditviewinputauthorsearch" type="text" placeholder="Author"  />
                                </div>
                                <div class="pubeditviewtablediv ps-5 pe-5">
                                    <table class="table table-bordered table-striped pubeditviewtable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectall">
                                                        <label for="checkbox1"></label>
                                                    </span>
                                                </th>
                                                <th>Author</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btnpublication pubeditviewbtnsearch">Search &nbsp;<i class="fa fa-thin fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="card second scroll">
                <div class="card-body p-0">
                    <div class="table-responsive pubeditviewtabledivsearchresult ps-2 pe-2" data-mdb-perfect-scrollbar="true">
                        <table class="table table-striped pubeditviewtablesearchresult mb-0">
                            <thead>
                                <tr>
                                    <th class="pubhdrid" style="display: none;">Id</th>
                                    <th class="userid" style="display: none;">UserId</th>
                                    <th class="pubeditviewdate">Date</th>
                                    <th class="pubeditviewcategory" style="display: none;">Category</th>
                                    <th class="pubeditviewtitle">Title</th>
                                    <th class="pubeditviewconference">Conference</th>
                                    <th class="user">User</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                  <td>Like a butterfly</td>
                                  <td>Boxing</td>
                                  <td>9:00 AM - 11:00 AM</td>
                                  <td>Aaron Chapman</td>
                                  <td>
                                    <a class="pubeditviewview" title="View" data-toggle="tooltip"><i class="material-icons">&#xe8f4;</i></a>
                                    <a class="pubeditviewedit" title="Edit" data-toggle="pubeditviewtooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a class="pubeditviewdelete" title="Delete" data-toggle="pubeditviewtooltip"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr> --}}
                              </tbody>
                        </table>
                        <span class="pubeditviewspan">No records to display. Please check search criteria.</span>
                    </div>

                    <button  type="button" class="btn btn-primary btnpublication pubeditviewbtnback"><i class="fa fa-thin fa-hand-point-left"></i>&nbsp; Search Criteria</button>
                </div>
            </div>    
        </div>
    </div>
@endsection