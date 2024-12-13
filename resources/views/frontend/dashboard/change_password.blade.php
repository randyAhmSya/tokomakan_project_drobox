@extends('frontend.dashboard.dashboard')
@section('dashboard')
@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<section class="pt-4 pb-4 section osahan-account-page">
    <div class="container">
       <div class="row">
         @include('frontend.dashboard.sidebar')

          <div class="col-md-9">
             <div class="p-4 bg-white rounded shadow-sm osahan-account-page-right h-100">
                <div class="tab-content" id="myTabContent">
                   <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                      <h4 class="mt-0 mb-4 font-weight-bold">Change Password Profile</h4>
                      <div class="mb-4 bg-white shadow-sm card order-list">
                         <div class="p-4 gold-members">

                            <form action="{{ route('user.password.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="mb-6">
                                                <label for="example-text-input" class="form-label">Old_Password</label>
                                                <input class="form-control @error('old_password')
                                                    is-invalid
                                                @enderror"  type="password" name="old_password" id="old_password">
                                                @error('old_password')
                                                    <span class="text-danger" >{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-6">
                                                <label for="example-text-input" class="form-label">New_Password</label>
                                                <input class="form-control @error('new_password')
                                                    is-invalid
                                                @enderror"  type="password" name="new_password" id="new_password">
                                                @error('new_password')
                                                    <span class="text-danger" >{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="pb-3 mb-6">
                                                <label for="example-text-input" class="form-label">Confirm New Password</label>
                                                <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation">
                                            </div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>

@endsection

