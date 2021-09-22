@extends('layouts.main')
@section('title')Campaigns @endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('cork/assets/css/forms/theme-checkbox-radio.css')}}">
<link href="{{asset('cork/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork/assets/css/apps/contacts.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork\plugins\table\datatable\datatables.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork\plugins\table\datatable\dt-global_style.css')}}" rel="stylesheet" type="text/css" />


<style>
    .custom-file-container__image-preview{
        height: 150px;
        margin-bottom: 0;
        border: 2px dashed #bdccef;
        margin-top: 1em;
    }

    .custom-file-container__custom-file__custom-file-control{
        display: flex;
        border: 2px solid #bdccef;
    }

    .modal-footer{
        justify-content: space-between
    }

    #upload-next-btn{
        margin-left: auto
    }

    .wait-text, .spinner-upload{
        display: none;
    }

    .searchable-items.list{
        background-color: white;
        border-radius: 4px;
    }

    #campaigns-table_wrapper .row:first-child,
    #campaigns-table_wrapper .row:last-child{
        padding: 1.5em 2em;
    }

    #campaigns-table_wrapper .row:last-child #campaigns-table_paginate{
        width: 100%;
        text-align: right
    }

    #campaigns-table_wrapper tr td.options span{
        margin: 0 5px;
        cursor: pointer;
    }

    .filtered-list-search {
        visibility: hidden;
    }

</style>
@endsection

@section('page_name') 
    <li class="breadcrumb-item active" aria-current="page"><span>Campaigns</span></li>
@endsection

@section('content')
<div class="layout-px-spacing">                
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content searchable-container list">

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center pb-3">
                        <form class="form-inline my-2 my-lg-0">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" class="form-control product-search" id="input-search" placeholder="Search Contacts...">
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center pb-3">
                        <div class="d-flex justify-content-sm-end justify-content-center">
                            <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                        <div class="add-contact-box">
                                            <div class="add-contact-content">
                                                <form id="addContactModalTitle">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="custom-file-container" data-upload-id="csv_upload">
                                                                <label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                                <label class="custom-file-container__custom-file" >
                                                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept=".csv">
                                                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                                </label>
                                                                <div class="custom-file-container__image-preview"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <span class="wait-text font-weight-bold">Please wait...</span>
                                        <div class="spinner-upload align-self-center spinner-border text-info"></div>
                                        <button class="btn btn-info mb-2" id="upload-next-btn">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="searchable-items list">
                    <div class="table-responsive">
                        <table id="campaigns-table" class="table table-bordered mb-4">
                            <thead class="mt-2">
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Leads</th>
                                    <th >Contacted</th>
                                    <th class="text-center">Last Outreach</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaigns as $campaign)
                                <tr>
                                    <td>{{$campaign->name}}</td>
                                    <td>{{$campaign->created_at}}</td>
                                    <td>{{$campaign->contacts_count}}</td>
                                    <td>{{count($campaign->contacts)}}</td>
                                    <td class="text-center"><span>
                                        @if (count($campaign->contacts) > 0)
                                         {{$campaign->last_outreach->created_at}}
                                        @else
                                            <span class="shadow-none badge badge-warning">Not Contacted</span>
                                        @endif
                                    </span></td>
                                    <td class="text-center options">
                                        <span class="campaign-option" data-option="Chat" data-campaignId="{{$campaign->id}}" title="Campaign Chat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </span>
                                        <span class="campaign-option" data-option="Properties" data-campaignId="{{$campaign->id}}" title="Target Properties">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-info" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        </span>
                                        <span class="campaign-option" data-option="Delete" data-campaignId="{{$campaign->id}}" title="Delete Campaign">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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
@endsection

@section('scripts')
<script>
    SetSidebarActiveOption('.campaigns-menu');
    var campaigns = {!! json_encode($campaigns) !!};
</script>
<script src="{{asset('cork/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
<script src="{{asset('cork/assets/js/custom.js')}}"></script>
<script src="{{asset('cork\plugins\table\datatable\datatables.js')}}"></script>
<script src="{{asset('cork/assets/js/apps/contact.js')}}"></script>

<script src="{{asset('js/campaigns.js')}}"></script>
@endsection