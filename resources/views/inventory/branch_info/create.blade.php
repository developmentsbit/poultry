@extends('layouts.master')
@section('content')

@component('components.breadcrumb')
	@slot('title')
		@lang('branch_info.index')
	@endslot
	@slot('breadcrumb1')
		@lang('common.dashboard')
	@endslot
	@slot('breadcrumb1_link')
		{{ route('dashboard') }}
	@endslot
	@if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('role', 'create'))
		@slot('action_button1')
			@lang('common.view')
		@endslot
		@slot('action_button1_link')
			{{ route('branch_info.index') }}
		@endslot
	@endif
	@slot('action_button1_class')
		btn-dark
	@endslot
@endcomponent

<div class="container mt-2">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h3>@lang('branch_info.add_title')</h3><br>
				<form method="post" class="btn-submit" action="{{ route('branch_info.store') }}">
					@csrf
					<div class="row myinput">
						<div class="form-group col-md-6 mb-2">
							<label for="company_id">@lang('branch_info.company_name'): <span class="text-danger" style="font-size: 15px;">*</span></label>
							<select class="form-control" name="company_id" required id="company_id">
                                <option>@lang('common.select_one') </option>
                                @if($company_name)
                                @foreach($company_name as $v)
                                <option value="{{$v->id}}">@if(config('app.locale') == 'en'){{$v->company_name_en}}
                                    @elseif(config('app.locale') == 'bn'){{$v->company_name_bn}}@endif</option>
                                @endforeach
                                @endif
                            </select>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_name_en'):</label>
							<div class="input-group">
								<input class="form-control" type="text" name="branch_name_en" id="branch_name_en" placeholder="@lang('branch_info.branch_name_en')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_name_bn'):</label>
							<div class="input-group">
								<input class="form-control" type="text" name="branch_name_bn" id="branch_name_bn" placeholder="@lang('branch_info.branch_name_bn')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_mobile'):</label>
							<div class="input-group">
								<input class="form-control" type="number" name="branch_mobile" id="branch_mobile" placeholder="@lang('branch_info.branch_mobile')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_address_en'):</label>
							<div class="input-group">
                                <textarea id="summernote" type="text" name="branch_address_en" class="form-control" id="branch_address_en" placeholder="@lang('branch_info.branch_address_en')"></textarea>
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_address_bn'):</label>
							<div class="input-group">
                                <textarea id="summernote" type="text" name="branch_address_bn" class="form-control" id="branch_address_bn" placeholder="@lang('branch_info.branch_address_bn')"></textarea>
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.branch_email'):</label>
							<div class="input-group">
								<input class="form-control" type="text" name="branch_email" id="branch_email" placeholder="@lang('branch_info.branch_email')">
							</div>
						</div>
						<div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.official_contact'):</label>
							<div class="input-group">
								<input class="form-control" type="number" name="official_contact_no" id="official_contact_no" placeholder="@lang('branch_info.official_contact')">
							</div>
						</div>
                        <div class="form-group col-md-6 mb-2">
							<label>@lang('branch_info.status'):</label>
							<div class="input-group">
								<select class="form-control" name="status">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						<div class="modal-footer border-0 col-12">
							<button type="submit" class="btn btn-success button border-0">@lang('item.add_button')</button>
						</div>
					</div>
				</form>
			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>



@endsection
