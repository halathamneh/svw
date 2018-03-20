@extends("layouts.app")

@section("content")
    <main style="margin-bottom: 6rem;">
        <div class="profile-header">
            <div class="profile-header__cover"
                 style="background-image: url({{ asset('/images/cover.jpg') }});">
                @if($view_mode === "self")
                    <a href="#" class="btn btn-secondary btn-change-cover"><i class="fa fa-camera"></i> Change Cover</a>
                @endif
            </div>
            <div class="container">
                <div class="profile-header__user">
                    <div class="profile-picture">
                        <img src="{{ asset("/images/default-avatar.jpg") }}" alt="{{ $volunteer->first_name }}">
                    </div>
                    <div class="profile-header__right">
                        <div class="user-full_name">
                            <h2>{{ $volunteer->full_name }}</h2>
                            <span>{{ "@".$user->username }}</span>
                        </div>
                        <div class="user-actions">
                            @if($view_mode === "self")
                                <a href="#" class="btn btn-light"><i class="fa fa-edit"></i> Edit Profile</a>
                            @elseif($view_mode === "other")
                                <a href="#" class="btn btn-primary btn-follow"><i class="fa fa-user"></i> Follow</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3 profile-sidebar">

                    <div class="sidebar-numbers">
                        <div class="sidebar-numbers_item followers">
                            <div class="item-number">1.2k</div>
                            <div>Follower</div>
                        </div>
                        <div class="sidebar-numbers_item followers">
                            <span class="item-number">852</span>
                            <div>Following</div>
                        </div>
                    </div>

                </div>
                <div class="col-md-7 profile-main">
                    <profile-tabs :user_id="{{ $user->id }}"></profile-tabs>
                </div>
                <div class="col-md-2">
                    <small class="text-muted"><b>Suggestions</b></small>
                    <div class="suggestion-item demo">

                    </div>
                    <div class="suggestion-item demo">

                    </div>
                    <hr>
                    <small style="font-size: 0.65rem;" class="text-muted"><b>All rights reserved &copy; SVW 2018</b></small>
                </div>
            </div>
        </div>
    </main>
@endsection