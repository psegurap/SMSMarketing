@extends('layouts.main')
@section('title')Property Info @endsection
@section('styles')
    <link href="{{asset('cork/assets/css/apps/invoice-preview.css')}}" rel="stylesheet" type="text/css" />

    
@endsection
@section('page_name')
<li class="breadcrumb-item"><a href="javascript:void(0);">Campaigns</a></li>
<li class="breadcrumb-item active" aria-current="page"><span>Property Info</span></li>
@endsection


@section('content')
    <div class="layout-px-spacing">
        <div class="row invoice layout-top-spacing layout-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                
                <div class="doc-container">

                    <div class="row">

                        <div class="col-xl-9">

                            <div class="invoice-container">
                                <div class="invoice-inbox">
                                    
                                    <div id="ct" class="">
                                        
                                        <div class="invoice-00001">
                                            @for ($i = 0; $i < 1; $i++)
                                            <div class="content-section">
                                                <div class="inv--head-section inv--detail-section">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12 mr-auto">
                                                        </div>
                                                        <div class="col-sm-6 text-sm-right">
                                                            <p class="inv-list-number"><span class="inv-title"></span> <span class="inv-number">{{$campaign->name}}</span></p>
                                                        </div>
                                                        <div class="col-sm-6 align-self-center mt-3">
                                                            <p class="inv-street-addr campaign-contact-name">{{$campaign->contacts[$i]['first_name']}} {{$campaign->contacts[$i]['last_name']}}</p>
                                                            <p class="inv-email-address text-lowercase campaign-contact-email">{{$campaign->contacts[$i]['email_address']}}</p>
                                                            <p class="inv-email-address campaign-contact-phone">{{$campaign->contacts[$i]['phone_number']}}</p>
                                                        </div>
                                                        <div class="col-sm-6 align-self-center mt-3 text-sm-right">
                                                            <p class="inv-created-date"><span class="inv-title">Created Date : </span> <span class="inv-date campaign-contact-created">{{$campaign->created_at}}</span></p>
                                                            <p class="inv-due-date"><span class="inv-title">Updated Date : </span> <span class="inv-date campaign-contact-updated">{{$campaign->updated_at}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="inv--detail-section inv--customer-detail-section">

                                                    <div class="row">

                                                        <div class="col-xl-6 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                            <p class="inv-to">Mail Address</p>
                                                        </div>

                                                        <div class="col-xl-6 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 inv--payment-info">
                                                            <h6 class=" inv-title">Target Property:</h6>
                                                        </div>
                                                        
                                                        @foreach ($campaign->contacts[$i]['mail_addresses'] as $mail_address)
                                                        <div class="col-xl-6 col-lg-7 col-md-6 col-sm-4">
                                                            <p class="inv-street-addr campaign-mail-street">{{$mail_address['mail_street_address']}}</p>
                                                            <p class="inv-email-address campaign-mail-city-state">{{$mail_address['mail_city']}}, {{$mail_address['mail_state']}}</p>
                                                            <p class="inv-email-address campaign-mail-zip">{{$mail_address['mail_zip_code']}}</p>
                                                        </div>
                                                        @endforeach
                                                        
                                                        <div class="col-xl-6 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1">
                                                            @foreach ($campaign->contacts[$i]['properties'] as $property)
                                                            <div class="inv--payment-info">
                                                                <p><span class="inv-subtitle">Street:</span> <span class="campaign-property-street">{{$property['property_street_address']}}</span></p>
                                                                <p><span class="inv-subtitle">City: </span> <span class="campaign-property-city">{{$property['property_city']}}</span></p>
                                                                <p><span class="inv-subtitle">State:</span> <span class="campaign-property-state">{{$property['property_state']}}</span></p>
                                                                <p><span class="inv-subtitle">Zip Code: </span> <span class="campaign-property-zip">{{$property['property_zip_code']}}</span></p>
                                                            </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    
                                                </div>

                                                

                                            </div>
                                            @endfor
                                        </div> 
                                        
                                    </div>


                                </div>

                            </div>

                        </div>

                        {{-- <div class="col-xl-3">

                            <div class="invoice-actions-btn">

                                <div class="invoice-action-btn">

                                    <div class="row">
                                        <div class="col-xl-12 col-md-3 col-sm-6">
                                            <a href="javascript:void(0);" id="send-message" class="btn btn-primary btn-send mb-0">Send Message</a>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div> --}}

                        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="alertModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="exampleModalLabel">Important:</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p class="font-italic h6 mb-0 modal-text"> </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="return-to-campaigns" type="button" class="btn btn-primary">OK</button>
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
    var campaign = {!! json_encode($campaign) !!};
</script>

<script src="{{asset('js/contact_campaign.js')}}"></script>

@endsection