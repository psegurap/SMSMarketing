@extends('layouts.main')
@section('title')Prepare Campaign @endsection
@section('styles')
    <style>
        #form-selects .single-select{
            width: 25%;
        }
        #form-selects .single-select .form-group{
            box-shadow: 0px 1px 3px 1px #757677;
            border-radius: 3px;
            background-color: #0e1726;
        }

        #form-selects .single-select .form-group select{
            border-radius: 2px
        }

        #form-selects .single-select .form-group select:focus{
            box-shadow: 0px 0px 3px 0px #757677;
        }

        #create-campaign-btn{
            margin-left: auto
        }

        .wait-text, .submit-contaier .spinner-upload{
            display: none;
        }
    </style>
@endsection
@section('page_name')
<li class="breadcrumb-item"><a href="javascript:void(0);">Campaigns</a></li>
<li class="breadcrumb-item active" aria-current="page"><span>Prepare Campaign</span></li>
@endsection


@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget widget-content-area br-4">
                <div class="row">
                    <div class="col-md-12 campaign form">
                        <div class="campaign-name">
                            <div class="form-group">
                                <label for="campaigns_name" class="font-weight-bold text-uppercase text-black">Campaign Name:</label>
                                <input type="text" class="form-control" id="campaign_name" placeholder="Type here...">
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="title mb-2">
                            <span class="font-italic font-weight-bold h6 text-body">Select and match the proper incoming column:</span>
                        </div>
                        <div id="form-selects" class="d-flex flex-wrap">
                            
                        </div>
                        <div class="pt-2 submit-contaier d-flex justify-content-between">
                            <span class="font-weight-bold wait-text">Please wait...</span>
                            <div class="spinner-upload align-self-center spinner-border text-info"></div>
                            <button id="create-campaign-btn" class="btn btn-info">Create Campaign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/prepare_campaign.js')}}"></script>
<script>
    SetSidebarActiveOption('.campaigns-menu');
    var columns_name = {!! json_encode($columns_name) !!};
    var db_columns = {!! json_encode($db_columns) !!};
</script>
@endsection