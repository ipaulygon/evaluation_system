@extends('index')

@section('title', 'Barangay Info')

@section('content')
    <section class="content-header">
        <h1>
            Barangay Info
            <small>Control panel</small>

        </h1> 
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-md-offset-2 col-md-8 col-sm-offset-2">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-aqua-active">
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ URL::asset('assets/image/icons/violationIcon.png') }}" alt="barangay_code">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">Barangay: {{$barangay->barangay_code}}</h3>
                    <h5 class="widget-user-desc">{{$barangay->barangay_description}}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li>
                            <a href="#">
                                <p class="credentials">Barangay Information</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">Status 
                                <span class="pull-right badge bg-green">
                                    @if(@ind_deleted == 0)
                                        Active
                                    @elseif(@ind_deleted == 1)
                                        Deleted
                                    @else
                                        Deleted
                                    @endif
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@stop
