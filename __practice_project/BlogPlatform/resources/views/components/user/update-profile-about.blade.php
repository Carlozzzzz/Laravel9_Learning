@props(['user'])

@php
    // dd($user);
@endphp
<div class="text-dark my-3">
    <!-- Modal -->
    <div class="modal fade" id="updateProfileAboutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfileAboutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/user/profile/update3/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateProfileAboutModalLabel">Update Cover Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
							<label for="aboutName" class="form-label">Name</label>
							<div class="input-group">
								<input type="text" class="form-control" id="aboutName" name="name" placeholder="Your name here..." value="{{ old('name', $user->name) }}">
							</div>
							@error('name')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>
                        <div class="mb-3">
                            <label for="aboutGender" class="form-label">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="aboutMale" value="Male" {{ old('gender', $user->gender) == "Male" ? "checked" : ""}}>
                                <label class="form-check-label" for="aboutMale">
                                    Male
                                </label>
                                </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="aboutFemale" value="Female" {{ old('gender', $user->gender) == "Female" ? "checked" : ""}} >
                                <label class="form-check-label" for="aboutFemale">
                                    Female
                                </label>
                            </div>
							@error('email')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>
						<div class="mb-3">
							<label for="aboutIndustry" class="form-label">Industry</label>
							<div class="input-group">
								<input type="text" class="form-control" id="aboutIndustry" name="industry" placeholder="Industry here..." value="{{ old('industry', $user->industry) }}">
							</div>
							@error('industry')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>

                        <div class="mb-3">
							<label for="aboutOccupation" class="form-label">Occupation</label>
							<div class="input-group">
								<input type="text" class="form-control" id="aboutOccupation" name="occupation" placeholder="Occupation here..." value="{{ old('occupation', $user->occupation) }}">
							</div>
							@error('occupation')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>

                        <div class="mb-3">
							<label for="aboutCountry" class="form-label">Country</label>
							<select class="form-select" aria-label="Country" name="country_id">
                                <option selected>--Select country--</option>
                                @foreach ($user->countries as $country)
                                    <option value="{{$country->id}}" {{ old('country', $country->id) == $user->country_id ? "selected" : "" }}>{{$country->name}}</option>
                                @endforeach
                              </select>
							@error('occupation')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>

                        <div class="mb-3">
							<label for="aboutOccupation" class="form-label">Interests</label>
							<div class="input-group">
								<input type="text" class="form-control" id="aboutOccupation" name="occupation" placeholder="Occupation here..." value="{{ old('occupation', $user->occupation) }}">
							</div>
                            <button type="button" class="btn text-muted bg-white rounded border border-gray p-2 mt-2"><i class='bx bxs-plus-circle'></i> Add Interest</button>
							@error('occupation')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>