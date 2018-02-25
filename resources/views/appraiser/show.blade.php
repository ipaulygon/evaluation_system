@extends('index')

@section('title', 'Appraiser Profile')
@section('content')
    <section class="content-header">
        <h1>
            Appraiser Profile
            <small>Control panel</small>

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('/dashboard') }}"><i class="fa fa-wrench"></i> Dashboard</a></li>
            <li><a href="{{ URL::to('/appraisers') }}"></i> Appraiser</a></li>
            <li class="active">{{$appraiser->first_name}} {{$appraiser->last_name}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-md-offset-2 col-md-8 col-sm-offset-2">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-aqua-active">
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ URL::asset('assets/image/avatar/officerAvatar.jpg') }}" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">{{$appraiser->first_name}} {{$appraiser->last_name}}</h3>
                    <h5 class="widget-user-desc">{{$user->email}}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li>
                            <a href="#">
                                <p class="credentials">Account Information</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">Status 
                                <span class="pull-right badge bg-green">
                                    @if(@ind_deleted == 0)
                                        Active
                                    @elseif(@ind_deleted == 1)
                                        Suspended
                                    @else
                                        Deleted
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">Last login <span class="pull-right">
                                <?php
                                $dateLastSignedin = ($appraiser->last_signedin == "0000-00-00 00:00:00") ? "Never logged in" :
                                    date('M j, Y',strtotime($appraiser->last_signedin));
                                ?>   
                                {{$dateLastSignedin}}
                            </span></a>
                        </li>
                        <li>
                            <!--<a href="#">Transactions<span class="pull-right badge bg-aqua">{{$transactionHeader}}</span></a>-->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@stop
