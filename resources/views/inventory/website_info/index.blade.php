@extends('layouts.master')

@section('content')
<div class="container-fluid">

    @component('components.breadcrumb')
        @slot('breadcrumb1') @lang('website_content.website_content') @endslot
        @slot('breadcrumb2') @lang('common.dashboard') @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('website_info.store')}}" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group row">
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>@lang('website_content.company_name')</label><span class="text-danger">*</span>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{$data->company_name}}">
                                @error('company_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>@lang('website_content.comapany_title')</label><span class="text-danger">*</span>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$data->title}}">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>@lang('website_content.phone1')</label><span class="text-danger">*</span>
                                <input type="text" class="form-control @error('phone1') is-invalid @enderror" name="phone1" value="{{$data->phone1}}">
                                @error('phone1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-single mt-2 col-md-6 col-12">
                                <label>@lang('website_content.phone2')</label>
                                <input type="text" class="form-control @error('phone2') is-invalid @enderror" name="phone2" value="">
                                @error('phone2')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>@lang('website_content.email')</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$data->email}}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-12">
                                <label>@lang('website_content.adress')</label>
                                <textarea id="" rows="15" name="adress" class="form-control @error('adress') is-invalid @enderror">{!! $data->adress !!}</textarea>
                                @error('adress')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Twitter Link</label>
                                <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" value="{{$data->twiiter}}">
                                @error('twitter')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Facenbook Link</label>
                                <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{$data->facebook}}">
                                @error('facebook')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Youtube Link</label>
                                <input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube" value="{{$data->youtube}}">
                                @error('youtube')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Instagram Link</label>
                                <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{$data->instagram}}">
                                @error('instagram')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Linkedin Link</label>
                                <input type="text" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" value="{{$data->linkedin}}">
                                @error('linkedin')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Logo</label>
                                <input type="file" class="form-control" name="logo">
                                <img src="{{asset('WebsiteInfo/img')}}/{{$data->logo}}" style="max-width:120px" class="img-fluid">
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Favicon</label>
                                <input type="file" class="form-control" name="favicon">
                                <img src="{{asset('WebsiteInfo/img')}}/{{$data->favicon}}" style="max-width:120px" class="img-fluid">
                            </div>
                            <div class="form-single mt-2 col-md-6 col-12">
                                <label>Banner</label>
                                <input type="file" class="form-control" name="banner">
                                <img src="{{asset('WebsiteInfo/img')}}/{{$data->banner}}" style="max-width:120px" class="img-fluid">
                            </div>
                            <div class="form-single mt-2">
                                <input type="submit" class="btn btn-sm btn-dark" value="@lang('about_us.submit')">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
