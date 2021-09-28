@extends('layouts.main')
@section('title')Templates @endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('cork/assets/css/forms/theme-checkbox-radio.css')}}">
<link href="{{asset('cork/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork/assets/css/apps/contacts.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork\plugins\table\datatable\datatables.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('cork\plugins\table\datatable\dt-global_style.css')}}" rel="stylesheet" type="text/css" />
<style>

    .modal-footer{
        justify-content: space-between
    }

    #add-template{
        margin-left: auto
    }
    .wait-text, .spinner-upload{
        display: none;
    }

    .searchable-items.list{
        background-color: white;
        border-radius: 4px;
    }

    #templates-table_wrapper .row:first-child,
    #templates-table_wrapper .row:last-child {
        padding: 1.5em 2em;
    }

    #templates-table_paginate {
        float: right
    }
    
    .page-link {
        border-radius: 0;
    }

    .page-item.active .page-link {
        background-color: #2196f3;
        border-radius : 0;
    }

    #templates-table_previous a,
    #templates-table_next a{
        border-radius: 0;
        height: 100%;
        display: flex;
        align-items: center;
    }

    #templates-table_wrapper tr td.options span{
        margin: 0 5px;
        cursor: pointer;
    }
</style>

@endsection
@section('page_name')
<li class="breadcrumb-item active" aria-current="page"><span>Templates</span></li>
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
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="title">
                                            <span class="h5 text-dark modal-title">New template</span>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                        <div class="add-contact-box">
                                            <div class="add-contact-content">
                                                <form id="addContactModalTitle">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="notice text-left text-black">
                                                                <span class="h6 d-inline-block mb-3">Use the following label to sustitute dynamic values:</span>
                                                                <div class="name mb-1 font-italic">
                                                                    - <span class="title h6">Name:</span> <span class="label text-monospace">{name}</span>
                                                                </div>
                                                                <div class="contact_name mb-1 font-italic">
                                                                    - <span class="title h6">Contact name:</span> <span class="label text-monospace">{contact}</span>
                                                                </div>
                                                                <div class="address mb-1 font-italic">
                                                                    - <span class="title h6">Address:</span> <span class="label text-monospace">{address}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-left">
                                                            <div class="input-container mt-2">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                      <span class="input-group-text br-0" id="basic-addon5">Template</span>
                                                                    </div>
                                                                    <input id="template-input" type="text" class="form-control br-0" placeholder="type here..." aria-label="Username">
                                                                </div>
                                                            </div>
                                                            <span class="text-monospace d-inline-block mt-2 text-dark ml-3">
                                                                e.g. Hi {contact}, this is {name}. I am very interesting in your property on {address}.
                                                            </span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <span class="wait-text font-weight-bold">Please wait...</span>
                                        <div class="spinner-upload align-self-center spinner-border text-info"></div>
                                        <button class="btn btn-info mb-2" id="add-template">Add Template</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="searchable-items list">
                    <div class="table-responsive">
                        <table id="templates-table" class="table table-bordered mb-4">
                            <thead class="mt-2">
                                <tr>
                                    <th>ID</th>
                                    <th>Template</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $template)
                                <tr>
                                    <td>{{$template->id}}</td>
                                    <td class="template">{{$template->template}}</td>
                                    <td class="text-center options">
                                        <span class="template-option" data-option="Edit" data-templateid="{{$template->id}}" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-dark" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </span>
                                        <span class="template-option" data-option="Delete" data-templateid="{{$template->id}}" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-dark" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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
    SetSidebarActiveOption('.templates-menu')
</script>
<script src="{{asset('cork/assets/js/custom.js')}}"></script>
<script src="{{asset('cork\plugins\table\datatable\datatables.js')}}"></script>
<script src="{{asset('cork/assets/js/apps/contact.js')}}"></script>

<script src="{{asset('js/templates.js')}}"></script>
@endsection