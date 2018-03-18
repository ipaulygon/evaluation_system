@extends('layouts.admin')

@section('title', 'Appraisers')
@section('content')
    <section class="content-header">
        <h1>
            Appraiser
            <small>Control panel</small>

        </h1>
        
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filters</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control selFilter">
                                <option value="0">Active Appraisers</option>
                                <option value="1">Suspended Appraisers</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-block addAppraiser" data-toggle="modal" data-target="#modalAddAppraiser" title="AddAppraiser">Add Appraiser</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="appraiserTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Appraiser</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblAppraiser" class="table table-bordered table-hover">
                            <thead>
                                <tr>  
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date Added</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appraisers as $appraiser)
                                    <tr>
                                        <td class="hide classAppraiserPrimaryKey">{{$appraiser->id_appraiser}}</td>
                                        <td class="hide classFirstname">{{$appraiser->first_name}}</td>
                                        <td class="hide classMiddlename">{{$appraiser->middle_name}}</td>
                                        <td class="hide classLastname">{{$appraiser->last_name}}</td>
                                        <td class="hide classUserID">{{$appraiser->id_user}}</td>
                                        <td style="cursor: pointer" class="clickable-row name" data-href="appraiser/show/{{$appraiser->id_appraiser}}">
                                            <img class="img-responsive" src="{{URL::asset($appraiser->profile_image)}}" alt="" style="max-width:150px; background-size: contain">
                                        </td>
                                        <td style="cursor: pointer" class="clickable-row name" data-href="appraiser/show/{{$appraiser->id_appraiser}}">
                                            {{$appraiser->first_name}} {{$appraiser->last_name}}
                                        </td>
                                        <td class="lastSignedIn">
                                            {{date('M j, Y',strtotime($appraiser->create_date))}}
                                        </td>
                                        <td width="150px">
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnResetPassword" data-toggle="tooltip" title="Reset Password">
                                                        <i class="fa fa-fw fa-unlock"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnRenameAppraiser" data-toggle="tooltip" title="Rename">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" class="btnSuspendAppraiser">Suspend Appraiser</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Last signed-in</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingAppraiser">
                        <i id="loadingAppraiserDesign"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL ADD APPRAISER -->
        <div class="modal fade" id="modalAddAppraiser" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create new Appraiser</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <center><img class="img-responsive" id="inputDisplayPicture" src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg')}}" style="max-width:150px; background-size: contain" /></center>
                                <div class="row">
                                    <center>
                                        <input type="file" class="btn btn-primary btn-sm" name="inputPicture" id="inputPicture" onchange="readURL(this)" >
                                    </center>
                                </div>
                                <br>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" name="strFirstname" id="inputFirstname" placeholder="First Name" size="45" required>
                                </div>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" name="strMiddlename" id="inputMiddlename" placeholder="Middle Name" size="45" >
                                </div>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" name="strLastname" id="inputLastname" placeholder="Last Name" size="45" required>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="email" class="form-control" name="strAppraiserEmail" id="inputAppraiserEmail" placeholder="Email" size="45" required>
                                </div>
                                <div class="form-group  col-sm-6">
                                    <input type="text" class="form-control" name="strAppraiserContact" id="inputAppraiserContact" placeholder="Contact" size="45" required>
                                </div>
                                <p class="help-block col-sm-12" id="setPasswordBlock">Temporary password will be assigned - 
                                    <a id="setPassword" style="cursor: pointer">
                                        Set Password
                                    </a>
                                </p>
                                <div class="form-group col-sm-12"></div>
                                <div class="passwordCredential">
                                    <div class="form-group col-sm-6">
                                        <input type="password" class="form-control" name="strPassword" id="inputPassword" data-minlength="6" placeholder="Password" size="35" required>
                                        <div class="help-block">Minimum of 6 characters</div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="password" class="form-control" name="strReEnterPassword" id="inputReEnterPassword" data-minlength="6" placeholder="Confirm password" size="35" data-match="#inputPassword" data-match-error="Whoops, these don't match" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <p class="help-block col-sm-12">
                                        <a id="autoGeneratePassword" style="cursor: pointer">
                                            Auto-generate password
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnCreateAppraiser" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD APPRAISER-->

        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a new Appraiser</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new appraiser named <span id="successFirstname"></span> <span id="successLastname"></span> has been created.
                        </p>
                        <div class="successMessage">
                            <p>Sign in to eValaution system using the following credential:</p>
                            <p>Email:</p>
                            <p id="successUsername" class="credentials"></p>
                            <p>Password:</p>
                            <p id="successPassword" class="credentials"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherAppraiser">CREATE ANOTHER APPRAISER</button>
                        <button type="button" id="btnPrint" class="btn btn-default">PRINT</button>
                        <button type="button" id="btnSendEmail" class="btn btn-success">SEND EMAIL</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <!-- MODAL RENAME Appraiser -->
        <div class="modal fade" id="modalRenameAppraiser" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Rename Appraiser</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formRename">
                        <div class="modal-body">
                            <div class="box-body">
                                <p>Before renaming this user, ask the appraiser to sign out of his or her account. After you rename this appraiser:</p>
                                <ul>
                                    <li>The rename operation can take up to 5 minutes.</li>
                                    <li>The new name might not be available for up to 5 minutes.</li>
                                </ul>
                                <p class="help-block col-sm-12" id="formErrorMessageRename" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" id="inputFirstnameRename" placeholder="First Name" size="45" required>
                                </div>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" id="inputMiddlenameRename" placeholder="Middle Name" size="45">
                                </div>
                                <div class="form-group  col-sm-4">
                                    <input type="text" class="form-control" id="inputLastnameRename" placeholder="Last Name" size="45" required>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputAppraiserPrimaryKey">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnRenameAppraiserSubmit" class="btn btn-success">Rename Appraiser</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL RENAME APPRAISER-->

        <!-- MODAL SUCCESSFUL RENAME -->
        <div class="modal fade" id="modalSuccessfulRename" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Rename Apppraiser</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Rename successful.
                        </p>
                        <div class="successMessage">
                            <p>The updated name is: <span id="updatedName" class="credentials"></span></p>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL RENAME -->

        <!-- MODAL RESET PASSWORD -->
        <div class="modal fade" id="modalResetPassword" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Reset password</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formResetPassword">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group col-sm-12"></div>
                                <div class="">
                                    <div class="form-group col-sm-6">
                                        <input type="password" class="form-control" id="inputPasswordReset" data-minlength="6" placeholder="Password" size="35" required>
                                        <div class="help-block">Minimum of 6 characters</div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="password" class="form-control" id="inputReEnterPasswordReset" data-minlength="6" placeholder="Confirm password" size="35" data-match="#inputPasswordReset" data-match-error="Whoops, these don't match" required>
                                        <div class="help-block with-errors"></div>
                                        <div class="form-group  col-sm-6">
                                            <input type="hidden" class="form-control" id="inputUserID">
                                        </div>
                                    </div>
                                    <p class="help-block col-sm-12">
                                        <a id="autoGeneratePasswordReset" style="cursor: pointer">
                                            Auto-generate password
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnResetPasswordSubmit" class="btn btn-success">Reset password</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL RESET PASSWORD -->

        <!-- MODAL SUCCESSFUL RESET -->
        <div class="modal fade" id="modalResetPasswordSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Reset password</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Reset password successful.
                        </p>
                        <div class="successMessage">
                            <p>The new password is: <span id="updatedPassword" class="credentials"></span></p>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL RESET -->

        <!-- MODAL SUCCESSFUL SUSPEND APPRAISER -->
        <div class="modal fade" id="modalSuspendAppraiserSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Suspend Appraiser</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Suspend appraiser success.
                        </p>
                        <div class="successMessage">
                            <p>Appraiser <span id="suspendedAppraiser" class="credentials"></span> is now suspended</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL SUSPEND APPRAISER -->

        <!-- MODAL SUCCESSFUL RESTORE APPRAISER -->
        <div class="modal fade" id="modalRestoredAppraiserSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore Appraiser</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore appraiser success.
                        </p>
                        <div class="successMessage">
                            <p>Appraiser <span id="restoredAppraiser" class="credentials"></span> is now restored</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL RESTORE APPRAISER -->

    </section>
@stop


@section('script')
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.numeric.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/js/appraiserIndex.js') }}"></script>
@stop