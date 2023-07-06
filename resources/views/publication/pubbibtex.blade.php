
@extends('layouts.main')


@section('pubbib')
<div class="container mt-5" id="pubbibcontainer">
  <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
  <input type="hidden" name="departmentid" id="departmentid" value={{ request()->id }}/>
   
  <form class="pubbibform" action="" method="POST" autocomplete="off">
    {{-- bibtex search card --}}
    <div class="card bibcard scroll">
      <div class="card-header sticky-top">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <header>Publication <small class="pubbibheadersmall">BibTex</small></header>
          </div>
          <div class="col-md-6 col-sm-12">
            <a class="pubbibrefresh float-end" type="button"><i class="fa fa-duotone fa-rotate"></i></a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-5 col-sm-12">
            <p class="pubbibparaonlybib">
                Please upload documents only in 'bib' format.
            </p>
          </div>
          <div class="col-md-5 col-sm-12">
            <div class='file-input float-start'>
                <input type='file' class="pubbibfile" accept=".bib">
                <span class='button pubbibbtnchoose'>Choose</span>
                <span class='label pubbiblabelnofile' data-js-label>No file selected</label>
            </div>
          </div>
          <div class="col-md-2 col-sm-12">
            <button type="submit" class="btn btn-primary btnpublication pubbibbtndownload float-end">DownLoad &nbsp;<i class="fa-solid fa-file-arrow-down"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="table-responsive pubbibsearchtablediv ps-2 pe-2 mt-4" data-mdb-perfect-scrollbar="true">
                <table class="table pubbibsearchtable">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" class="slno">Sl.No.</th>
                            <th scope="col" class="dt">Date</th>
                            <th scope="col" class="category">Category</th>
                            <th scope="col" class="title">Title</th>
                            <th scope="col" class="conf">Conference</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- first card --}}
    <div class="card first scroll">
      <div class="card-header sticky-top">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <header>Publication <small class="pubbibheadersmall">BibTex</small></header>
          </div>
          <div class="col-md-6 col-sm-12">
            
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-6 col-sm-12">
              <div class="row checkboxrow">
                  <div class="col-md-4 col-sm-12">
                      <div class="form-check pubbibformcheck">
                          <input class="form-check-input" type="checkbox" value="Submitted" id="pubbibchecksubmitted">
                          <label class="form-check-label" id="pubbiblabelsubmitted">
                              Submitted
                          </label>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                      <div class="form-check pubbibformcheck">
                          <input class="form-check-input" type="checkbox" value="Accepted" id="pubbibcheckaccepted">
                          <label class="form-check-label" id="pubbiblabelaccepted">
                              Accepted
                          </label>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                      <div class="form-check pubbibformcheck">
                          <input class="form-check-input" type="checkbox" value="Published" id="pubbibcheckpublished">
                          <label class="form-check-label" id="pubbiblabelpublished">
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
                  <label id="pubbiblabeldate">Date</label>
                  <input id="pubbibinputdate" type="date" max="<?php echo date("Y-m-d"); ?>" placeholder="Enter date" >
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelauthortype">Author Type</label>
                  <select id="pubbibselectauthortype">
                      <option value='0' selected></option>
                      @foreach($authortypeData['data'] as $authortype)
                          <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelcategory">Category</label>
                  <select id="pubbibselectcategory">
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
                  <label id="pubbiblabeldemography">Demography</label>
                  <select id="pubbibselectdemography">
                      <option value="0" selected></option>
                      <option value="1">National</option> 
                      <option value="2">International</option>
                  </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelarticle">Type of conference</label>
                  <select id="pubbibselectarticle">
                      <option value='0' selected></option>
                  </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelranking">Ranking</label>
                  <select id="pubbibselectranking">
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
                  <label id="pubbiblabelbroadarea">Broad Area</label>
                  <select id="pubbibselectbroadarea">
                      <option value='0' selected></option>
                      @foreach($broadareasData['data'] as $broadarea)
                          <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabeltitle">Title of the paper</label>
                  <textarea id="pubbibtextareatitle" rows="3" placeholder="Enter paper title"></textarea>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelnameofconference">Name of Conference/Journal</label>
                  <textarea id="pubbibtextareanameofconference" rows="3" placeholder="Enter conference/journal"></textarea>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelimpactfactor">Impact Factor</label>
                  <input id="pubbibinputimpactfactor" class="allow_numeric" type="text" placeholder="Enter impact factor"  maxlength="6" >
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabellocation">Location</label>
                  <input id="pubbibinputlocation" type="text" placeholder="Enter location" >
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelvolumeno">Volume No.</label>
                  <input id="pubbibinputvolumeno" type="text" placeholder="Enter volume number" />
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelissueno">Issue No.</label>
                  <input id="pubbibinputissueno" type="text" placeholder="Enter issue number" />
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelpageno">Page No.</label>
                  <input id="pubbibinputpageno" type="text" placeholder="Enter page number" />
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabeldoi">DOI</label>
                  <input id="pubbibinputdoi" type="text" placeholder="Enter doi" />
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="input-field">
                  <label id="pubbiblabelpublisher">Publisher</label>
                  <input id="pubbibinputpublisher" type="text" placeholder="Enter publisher"  />
              </div>
          </div>
      </div>

        <button  type="button" class="btn btn-primary btnpublication pubbibbtnbibback"><i class="fa fa-thin fa-hand-point-left"></i>&nbsp; BibTex Search</button>
        <button type="button" class="btn btn-primary btnpublication pubbibbtnnext">Next &nbsp;<i class="fa fa-thin fa-hand-point-right"></i></button>
      </div>
    </div>

    {{-- second card --}}
    <div class="card second scroll">
        <div class="card-header sticky-top">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <header>Publication <small class="pubbibheadersmall">New Record</small></header>
                </div>
                <div class="col-md-6 col-sm-12">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="table-wrapper pubbibtablewrapper">
                    <div class="table-title pubbibtabletitle ps-4 pe-4">
                    <div class="row">
                        <div class="col-md-10 col-sm-12 ">
                            <b id="pubbibtitledisplay"></b>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <button type="button" class="btn btn-info pubbibnew"><i class="fa fa-plus"></i> AddNew</button>
                        </div>
                    </div>
                </div>
                <div class="pubbibtablediv ps-4 pe-4">
                    <table class="table table-bordered pubbibtable">
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
                                    <a class="pubbibadd" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                    <a class="pubbibedit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a class="pubbibdelete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <button  type="button" class="btn btn-primary btnpublication pubbibbtnback"><i class="fa fa-thin fa-hand-point-left"></i>&nbsp; Back</button>
        <button type="submit" class="btn btn-primary btnpublication pubbibbtnsubmit">Submit &nbsp;<i class="fa-solid fa-floppy-disk"></i></button>
        </div>
    </div>
  </form>
</div>

@endsection