<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks{{--comments--}} fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$data['jobs_count']}}</div>
                        <div>Jobs!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <a href="{{ url('/company/jobs') }}" class="stats_blue">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$data['applications_count']}}</div>
                        <div>Application letters!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <a href="{{ url('/company/jobs') }}" class="stats_green" >
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks{{--support--}} fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$data['invitations_count']}}</div>
                        <div>Invitations!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <a href="{{ url('/company/invitations') }}" class="stats_red" >
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>