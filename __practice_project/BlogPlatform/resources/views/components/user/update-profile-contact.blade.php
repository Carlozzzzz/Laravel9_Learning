@props(['user'])

@php
    // dd($user);
@endphp
<div class="text-dark my-3">
    <!-- Modal -->
    <div class="modal fade" id="updateProfileContactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfileContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/user/profile/update2/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateProfileContactModalLabel">Update Cover Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="contactEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="contactEmail" name="email" aria-describedby="emailHelp" placeholder="Email here..." value="{{ old('email', $user->email) }}">
							@error('email')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>
						<div class="mb-3">
							<label for="contactNumber" class="form-label">Contact number</label>
							<div class="input-group">
								<span class="input-group-text text-muted" id="exampleInputPassword1">+639</span>
								<input type="number" class="form-control" id="exampleInputPassword1" name="contact_number" placeholder="Contact number here..." value="{{ old('contact_number', $user->contact_number) }}">
							</div>
							@error('contact_number')
								<p class="text-danger m-2"> {{ $message }}</p>
							@enderror
						</div>
						<div class="border border-secondary border-opacity-25 rounded p-2 mb-2">
							<label for="websites" class="form-label">Websites</label>
							<div class="" id="websites">
								<input type="text" class="form-control mb-2" id="website_first" placeholder="First Website...">
								<input type="text" class="form-control" id="website_second" placeholder="Second Website...">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
                        
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
