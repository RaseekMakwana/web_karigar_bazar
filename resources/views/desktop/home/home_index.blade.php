@extends('desktop.layouts.default.default_layout')

@section("title", $data['metadata']['title'])
@section("description", $data['metadata']['description'])
@section("keywords", $data['metadata']['keyword'])

@section('page_style')
@stop

@section('content')
  <div class="container pt-5">
  @include("desktop.home.custom_group_with_ategory",["data",$data['category_data']])
  </div>
  <div class="">
      <div class="container p-3 border-top home_links_class">
          <?php // foreach($data['state_data'] as $key => $state_row){ ?>
              {{-- <a href="<?php // echo URL($state_row['state_slug']."/".Config::get('constant.web.custom_slug.home.state')); ?>">{{ $state_row['state_name'] }}</a> |  --}}
          <?php //} ?>
      </div>
  </div>
@stop

@section('page_javascript')
@stop
