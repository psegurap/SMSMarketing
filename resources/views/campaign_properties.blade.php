@extends('layouts.main')
@section('title'){{$reachable_properties->name}} Properties @endsection
@section('styles')
    <link href="{{asset('cork/assets/css/pages/faq/faq.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{asset('cork\plugins\table\datatable\datatables.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cork\plugins\table\datatable\dt-global_style.css')}}" rel="stylesheet" type="text/css" />

    <style>
        #reachable-properties_wrapper .row:first-child,
        #reachable-properties_wrapper .row:last-child,
        #unreachable-properties_wrapper .row:first-child,
        #unreachable-properties_wrapper .row:last-child {
            padding: 1.5em 2em;
        }

        #reachable-properties_paginate,
        #unreachable-properties_paginate {
            float: right
        }
        
        .page-link {
            border-radius: 0;
        }

        .page-item.active .page-link {
            background-color: #2196f3;
            border-radius : 0;
        }

        #reachable-properties_previous a,
        #unreachable-properties_previous a,
        #reachable-properties_next a,
        #unreachable-properties_next a{
            border-radius: 0;
            height: 100%;
            display: flex;
            align-items: center;
        }
    </style>
@endsection
@section('page_name')
<li class="breadcrumb-item"><a href="{{route('campaigns')}}">Campaigns</a></li>
<li class="breadcrumb-item active" aria-current="page"><span>{{$reachable_properties->name}} (Properties)</span></li>
@endsection


@section('content')
<div class="layout-px-spacing">
    <div class="faq container">

        <div class="faq-layouting layout-spacing">
            <div class="fq-tab-section">
                <div class="row">
                    <div class="col-md-12 mb-5 mt-5">
                        <div class="accordion" id="faq">
                            <div class="card">
                                <div class="card-header" id="fqheadingOne">
                                    <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseOne" aria-expanded="false" aria-controls="fqcollapseOne">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> <span class="faq-q-title">Reachable properties ({{count($reachable_properties->contacts)}})</span>
                                    </div>
                                </div>
                                <div id="fqcollapseOne" class="collapse" aria-labelledby="fqheadingOne" data-parent="#faq">
                                    <div class="card-body">
                                        <div class="searchable-items list">
                                            <div class="table-responsive">
                                                <table id="reachable-properties" class="table table-bordered mb-4">
                                                    <thead class="mt-2">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Contact Name</th>
                                                            <th>Address</th>
                                                            <th class="text-center">Contacted</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reachable_properties->contacts as $contact)
                                                        <tr>
                                                            <td>{{$reachable_properties->name}}</td>
                                                            <td>{{$contact->first_name}} {{$contact->last_name}}</td>
                                                            @foreach ($contact->properties as $property)
                                                                <td>{{$property->property_street_address}} {{$property->property_city}}, {{$property->property_state}} {{$property->property_zip_code}}</td>
                                                            @endforeach
                                                            @if ($contact->conversations_count == 0)
                                                                <td class="text-center"><span class="shadow-none badge badge-warning">NO</span></td>
                                                            @else
                                                                <td class="text-center"><span class="shadow-none badge badge-info">YES</span></td>
                                                            @endif
                                                            <td class="text-center options">
                                                                <span class="property-option" data-campaignId="{{$reachable_properties->id}}" data-contactId="{{$contact->id}}" title="More Details">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="fqheadingTwo">
                                    <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseTwo" aria-expanded="false" aria-controls="fqcollapseTwo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> <span class="faq-q-title">Unreachable properties ({{count($unreachable_properties->contacts)}})</span>
                                    </div>
                                </div>
                                <div id="fqcollapseTwo" class="collapse" aria-labelledby="fqheadingTwo" data-parent="#faq">
                                    <div class="card-body">
                                        <div class="searchable-items list">
                                            <div class="table-responsive">
                                                <table id="unreachable-properties" class="table table-bordered mb-4">
                                                    <thead class="mt-2">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Contact Name</th>
                                                            <th>Address</th>
                                                            <th class="text-center">Contacted</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($unreachable_properties->contacts as $contact)
                                                        <tr>
                                                            <td>{{$unreachable_properties->name}}</td>
                                                            <td>{{$contact->first_name}} {{$contact->last_name}}</td>
                                                            @foreach ($contact->properties as $property)
                                                                <td>{{$property->property_street_address}} {{$property->property_city}}, {{$property->property_state}} {{$property->property_zip_code}}</td>
                                                            @endforeach
                                                            @if ($contact->conversations_count == 0)
                                                                <td class="text-center"><span class="shadow-none badge badge-warning">NO</span></td>
                                                            @else
                                                                <td class="text-center"><span class="shadow-none badge badge-info">YES</span></td>
                                                            @endif
                                                            <td class="text-center options">
                                                                <span class="property-option" data-campaignId="{{$unreachable_properties->id}}" data-contactId="{{$contact->id}}" title="More Details">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>                            
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    SetSidebarActiveOption('.campaigns-menu');
</script>
<script src="{{asset('cork\plugins\table\datatable\datatables.js')}}"></script>

<script src="{{asset('js/campaign_properties.js')}}"></script>
@endsection