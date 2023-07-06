@extends('layouts.apphome')

@section('content')
    <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>
    <section id="homeSection1" class="container p-2">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          {{-- Bootstrap Accordion Start Templates --}}
        </div>
    </section>
@endsection
