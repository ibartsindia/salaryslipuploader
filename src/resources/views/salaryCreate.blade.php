<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><i class="icon-note"></i> Create Slip</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
       
        {!! Form::open(['id'=>'createReport','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">

            <div class="row">
                <div class="col-xs-12 " id="member-list">
                    <div class="form-group">
                        <label>@lang("modules.messages.chooseMember")</label>
                        <select class="select2 form-control" data-placeholder="@lang("modules.messages.chooseMember")" name="user_id" id="user_id">
                                @foreach($data['employees'] as $employee)
                                <option value="{{$employee->id}}">{{ $employee->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <h6>Payments</h6>
                </div>
                <div class="col-xs-6">
                    <h6>Deductions</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="payment_basic">Basic Pay</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="payment_basic" name="payment_basic">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="deduct_absentee">Absentee</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="deduct_absentee" name="deduct_absentee">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="payment_bonus">Bonus</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="payment_bonus" name="payment_bonus">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="deduct_advance">Advance Payment</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="deduct_advance" name="deduct_advance">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="payment_overtime">Overtime</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="payment_overtime" name="payment_overtime">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="deduct_variable">Variable Pay</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="deduct_variable" name="deduct_variable">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="payment_variable">Variable Pay</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="payment_variable" name="payment_variable">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="deduct_misc">Misc. Deduction</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="deduct_misc" name="deduct_misc">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="payment_misc">Misc. Payment</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="payment_misc" name="payment_misc">
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="col-xs-6" for="total_salary"><strong>Total Salary</strong></label>
                        <div class="col-xs-6">
                            <input type="text" value="0" class="form-control" id="total_salary" name="total_salary" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">@lang("modules.messages.message")</label>
                        <textarea name="message" class="form-control" id="message" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions m-t-20">
            <button type="button" id="post-message" class="btn btn-success"><i class="fa fa-send-o"></i> @lang("modules.messages.send")</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

<script>

    $('.select2').select2();

    $("input[name=user_type]").click(function () {
        if($(this).val() == 'client'){
            $('#member-list').hide();
            $('#client-list').show();
        }
        else{
            $('#client-list').hide();
            $('#member-list').show();
        }
    })

    $('#post-message').click(function () {
        $.easyAjax({
            url: '{{route('member.user-chat.message-submit')}}',
            container: '#createChat',
            type: "POST",
            data: $('#createChat').serialize(),
            success: function (response) {
                if (response.status == 'success') {
                    var blank = "";
                    $('#submitTexts').val('');

                    //getting values by input fields
                    var dpID = $('#dpID').val();
                    var dpName = $('#dpName').val();


                    //set chat data
                    getChatData(dpID, dpName);

                    //set user list
                    $('.userList').html(response.userList);

                    //set active user
                    if (dpID) {
                        $('#dp_' + dpID + 'a').addClass('active');
                    }

                    $('#newReportModal').modal('hide');
                }
            }
        })
    });
</script>