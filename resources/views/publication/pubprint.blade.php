
@extends('layouts.main')

@section('pubprint')
    <div class="container mt-5" id="pubprintcontainer">
        <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
        <input type="hidden" name="departmentid" id="departmentid" value={{ request()->id }}/>

        <div class="pubprintcard">
            <div class="card first scroll">        
                <div class="card-header sticky-top">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <header>Publication <small class="pubprintheadersmall">Print Record</small></header>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a class="pubprintrefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubprintlabeldate">Year</label>
                                <input id="pubprintdate" type="text" placeholder="yyyy" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubprintlabelauthortype">Author Type</label>
                                <select id="pubprintselectauthortype">
                                    <option value='0' selected></option>
                                    @foreach($authortypeData['data'] as $authortype)
                                        <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubprintlabelcategory">Category</label>
                                <select id="pubprintselectcategory">
                                    <option value='0' selected></option>
                                    @foreach($categoryData['data'] as $category)
                                        <option value='{{ $category->id }}'>{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="input-field">
                                <label id="pubprintlabeldemography">Demography</label>
                                <select id="pubprintselectdemography">
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
                                <label id="pubprintlabeltitle">Title of the paper</label>
                                <textarea id="pubprinttextareatitle" rows="3" placeholder="Enter paper title"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-field">
                                <label id="pubprintlabelnameofconference">Name of Conference/Journal</label>
                                <textarea id="pubprinttextareanameofconference" rows="3" placeholder="Enter conference/journal"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 col-sm-12">
                            <div class="select-field border rounded">
                                <div class="form-check pubprintformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Submitted" id="pubprintchecksubmitted">
                                        <label class="form-check-label" id="pubprintlabelsubmitted">
                                            Submitted
                                        </label>
                                    </span>
                                </div>

                                <div class="form-check pubprintformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Accepted" id="pubprintcheckaccepted">
                                        <label class="form-check-label" id="pubprintlabelaccepted">
                                            Accepted
                                        </label>
                                    </span>
                                </div>

                                <div class="form-check pubprintformcheck">
                                    <span class="custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="Published" id="pubprintcheckpublished">
                                        <label class="form-check-label" id="pubprintlabelpublished">
                                            Published
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="select-field-ranking">
                                <label id="pubprintlabelranking">Ranking</label>
                                <div class="pubprintdivul">
                                    <ul class="list-group list-group-light pubprintulranking">
                                        @foreach($rankingsData['data'] as $ranking)
                                            <li class="list-group-item" id="pubprintliranking">
                                                <span class="custom-checkbox">
                                                    <input class="form-check-input me-1 pubprintrankingcheckbox" id="pubprintinputranking{{ $ranking->id }}" type="checkbox" value="{{ $ranking->id }}" aria-label="..." />
                                                    <label class="form-check-label" id="pubprintlabelranking{{ $ranking->id }}">
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
                            <div class="table-wrapper pubprinttablewrapper">
                                <div class="input-field">
                                    <label id="pubprintlabelauthorsearch">Author Search</label>
                                    <input id="pubprintinputauthorsearch" type="text" placeholder="Author"  />
                                </div>
                                <div class="pubprinttablediv ps-5 pe-5">
                                    <table class="table table-bordered table-striped pubprinttable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectallprint">
                                                        <label></label>
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
                    <a href="{{url('dynamic_pdf/pdf')}}" target="_blank">
                        <button type="button" class="btn btn-primary btnpublication pubprintbtnprint">PDF &nbsp;<i class="fa fa-solid fa-file"></i></button>
                    </a>
                    <a href="{{url('dynamic_word/wordexport')}}" target="_blank">
                        <button type="button" class="btn btn-primary btnpublication pubprintbtnprint">Word File &nbsp;<i class="fa-solid fa-file-word"></i></button>
                    </a>
                </div>
            </div>    
        </div>
    </div>
@endsection