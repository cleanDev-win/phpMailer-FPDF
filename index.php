<?php
    include_once('./header.php');
?>
    <div class="w-100 container mx-auto mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-6 border p-3">
                <form action="fileSave.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="fileType">File Type</label>
                        <select class="form-control" id="fileType" name="fileType" required>
                            <option disabled selected>--Select--</option>
                            <option>JPG</option>
                            <option>PNG</option>
                            <option>JPEG</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File :</label>
                        <input type="file" class="form-control-file" id="file" name="file" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Example textarea</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

<?php
    include_once('./footer.php');
?>