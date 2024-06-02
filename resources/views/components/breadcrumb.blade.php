<div class="row">
    <div class="col-sm-6 page-titles">
        <ol class="breadcrumb">
            @if(isset($breadcrumb3))<li class="breadcrumb-item active"><a href="{{ @$breadcrumb3_link }}">{{ @$breadcrumb3 }}</a></li>@endif
            @if(isset($breadcrumb2))<li class="breadcrumb-item active"><a href="{{ @$breadcrumb2_link }}">{{ @$breadcrumb2 }}</a></li>@endif
            @if(isset($breadcrumb1))<li class="breadcrumb-item active"><a href="{{ @$breadcrumb1_link }}">{{ @$breadcrumb1 }}</a></li>@endif
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ @$title }}</a></li>
        </ol>
    </div>
    <div class="col-sm-6 p-1 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <div class="form-head d-flex align-items-start">
            {{-- TODO:: solve right alignment issue --}}
            @if(isset($action_button2))
                <div class="mr-auto mx-2 d-lg-block">
                    <a href="{{ @$action_button2_link }}" class="btn {{ @$action_button2_class }} btn-rounded">{{ @$action_button2 }}</a>
                </div>
            @endif
            @if(isset($action_button1))
                <div class="mr-auto mx-2 d-lg-block">
                    <a target="" href="{{ @$action_button1_link }}" class="btn {{ @$action_button1_class }} btn-rounded">{{ @$action_button1 }}</a>
                </div>
            @endif

            {{--<div class="input-group search-area ml-auto d-inline-flex mr-2">
                <input type="text" class="form-control" placeholder="Search here">
                <div class="input-group-append">
                    <button type="button" class="input-group-text"><i class="flaticon-381-search-2"></i></button>
                </div>
            </div>
            <a href="javascript:void(0);" class="settings-icon"><i class="flaticon-381-settings-2 mr-0"></i></a>--}}


        </div>
    </div>
</div>
