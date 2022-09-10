@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Students</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                                @php
                                    Session::forget('success');
                                @endphp
                            </div>
                        @endif

                    <!-- Way 1: Display All Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label class="form-label" for="inputName">Name: *</label>
                            <input type="text" name="name" id="inputName"
                                   class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                   value="{{  !empty($student) ? $student->name : old('name') }}">

                            <!-- Way 2: Display Error Message -->
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="inputEmail">Email: *</label>
                            <input type="text" name="email" id="inputEmail"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                   value="{{ !empty($student) ? $student->email : old('email') }}">

                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputName">Phone: *</label>
                            <input type="text" name="phone" id="inputName"
                                   class="form-control @error('phone') is-invalid @enderror" placeholder="Phone"
                                   value="{{ !empty($student) ? $student->phone : old('phone') }}">

                            <!-- Way 2: Display Error Message -->
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Address: *</label>
                            <textarea name="address" id="address"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Address">{{ !empty($student) ? $student->address : old('address') }}</textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputName">City: *</label>
                            <input type="text" name="city" id="inputName"
                                   class="form-control @error('city') is-invalid @enderror" placeholder="City"
                                   value="{{ !empty($student) ? $student->city : old('city') }}">

                            <!-- Way 2: Display Error Message -->
                            @error('city')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputName">State: *</label>
                            <input type="text" name="state" id="inputName"
                                   class="form-control @error('city') is-invalid @enderror" placeholder="State"
                                   value="{{ !empty($student) ? $student->state : old('state') }}">

                            <!-- Way 2: Display Error Message -->
                            @error('state')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputName">Country: *</label>
                            <input type="text" name="country" id="inputName"
                                   class="form-control @error('country') is-invalid @enderror" placeholder="Country"
                                   value="{{ !empty($student) ? $student->country : old('country') }}">

                            <!-- Way 2: Display Error Message -->
                            @error('country')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label><b>Student Subject Feature</b></label>
                        </div>
                        <div class="mb-3 subject_block">
                            @if(!empty($student) && !empty($student->subjects))
                                @foreach($student->subjects as $sub)
                                    <div class="subject_group">
                                        <input type="text" class="form-control input_style" name="subjects[name][]"
                                               value="{{ $sub->name  }}" placeholder="Subject Name">
                                        <input type="text" class="form-control input_style" name="subjects[marks][]"
                                               value="{{ $sub->marks  }}" placeholder="Marks">
                                        <input type="text" class="form-control input_style" name="subjects[grade][]"
                                               value="{{ $sub->grade  }}" placeholder="Grade">


                                    </div>
                                @endforeach
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
