@props(['imagelink'])
@props(['userid'])

<div class="text-dark my-3">
    <!-- Modal -->
    <div class="modal fade" id="updateProfileCoverModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfileCoverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/user/profile/update1/{{ $userid }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateProfileCoverModalLabel">Update Cover Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="form-group mb-2" id="currentUserCoverImageDiv">
                            <img id="currentUserCoverImage" src="{{ $imagelink }}" class=" object-fit-cover" width="450px" height="220px">
                        </div>
                        <div class="custom-file form-group">
                            <input type="file" class="custom-file-input form-control" id="updateProfileCoverImage" name="user_cover_image" previewImage="currentUserCoverImage">
                        </div>
                        @error('user_cover_image')
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
    let updateProfileCoverImage = document.getElementById("updateProfileCoverImage");

    updateProfileCoverImage.addEventListener('change', function() {
        previewUpload(this);
    });

    
</script>