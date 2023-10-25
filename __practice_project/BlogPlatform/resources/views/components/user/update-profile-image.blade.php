@props(['imagelink'])
@props(['id'])

<div class="text-dark my-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
        Update Profile
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/user/profile/update/{{ $id }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateProfileModalLabel">Update Profile Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2" id="currentUserImageDiv">
                            <img id="currentUserImage" src="{{ $imagelink }}" class="rounded-circle object-fit-cover" width="250px" height="250px">
                        </div>
                        <div class="custom-file form-group">
                            <input type="file" class="custom-file-input form-control" id="userProfileImage" name="user_image" previewImage="currentUserImage">
                        </div>
                        @error('user_image')
                            <p class="text-danger m-2"> {{ $message }}</p>
                        @enderror
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

<script>
     let userProfileImage = document.getElementById("userProfileImage");

    userProfileImage.addEventListener('change', function() {
        previewUpload(this);

    });
</script>